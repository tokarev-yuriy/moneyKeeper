<template>
    <div>
    <div class="modal fade" id="editModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" v-if="operation.id">{{ 'mkeep_tablegrid.edit' | trans }}</h4>    
                <h4 class="modal-title" v-else="">{{ 'mkeep_tablegrid.add' | trans }}</h4>
                <button type="button" class="close" data-dismiss="modal" :aria-label="'mkeep_tablegrid.close'|trans">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post">
                  <div class="form-row">
                    <div class="form-group col-6">
                        <input type="date" v-model="operation.date" class="form-control" :class="{'is-invalid': errors && errors.date}" :placeholder="'mkeep.date'|trans" />
                        <span class="invalid-feedback" v-if="errors && errors.date"><strong>{{ errors.date }}</strong></span>
                    </div>  

                    <div class="col-6 form-group">
                        <input type="number" v-model="operation.value" class="form-control" :class="{'is-invalid': errors && errors.value}" :placeholder="'mkeep.summ'|trans" />
                        <span class="invalid-feedback" v-if="errors && errors.value"><strong>{{ errors.value }}</strong></span>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-6 form-group">
                        <label for="category_id" class="mb-0 form-label" :class="{'is-invalid': errors && errors.category_id}">{{ 'mkeep.category' | trans }}</label>
                        <dropdown-items v-model="operation.category_id" :items="categories" :type="operation.type"/>
                        <span class="invalid-feedback" v-if="errors && errors.category_id"><strong>{{ errors.category_id }}</strong></span>
                    </div>
                    <div class="col-6 form-group" v-if="operation.type=='spend' && mode!='transaction'">
                        <label for="wallet_from_id" class="mb-0 form-label" :class="{'is-invalid': errors && errors.wallet_from_id}">{{ 'mkeep.wallet' | trans }}</label>
                        <dropdown-items v-model="operation.wallet_from_id" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.wallet_from_id"><strong>{{ errors.wallet_from_id }}</strong></span>
                    </div>
                    <div class="col-6 form-group" v-if="operation.type=='income' && mode!='transaction'">
                        <label for="wallet_to_id" class="mb-0 form-label" :class="{'is-invalid': errors && errors.wallet_to_id}">{{ 'mkeep.wallet' | trans }}</label>
                        <dropdown-items v-model="operation.wallet_to_id" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.wallet_to_id"><strong>{{ errors.wallet_to_id }}</strong></span>
                    </div>
                    <div class="col-6 form-group" v-if="mode=='transaction'">
                        <label for="wallet_to_id" class="mb-0">{{ 'mkeep.wallet' | trans }}</label>
                        <div>
                            <a class="btn btn-secondary disabled" href="javascipt:void(0);">
                                <span v-if="walletid && walletsList[walletid]">
                                    <i v-if="walletsList[walletid].icon" :class="'fas fa-'+walletsList[walletid].icon" :alt="walletsList[walletid].name"></i> {{ walletsList[walletid].name }}
                                </span>
                            </a>
                        </div>
                    </div>
                  </div>
                  <div class="form-row" v-if="operation.type=='transfer' && mode!='transaction'">
                    <div class="col-6 form-group">
                        <label for="wallet_from_id" class="mb-0 form-label" :class="{'is-invalid': errors && errors.wallet_from_id}">{{ 'mkeep.src_wallet' | trans }}</label>
                        <dropdown-items v-model="operation.wallet_from_id" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.wallet_from_id"><strong>{{ errors.wallet_from_id }}</strong></span>
                    </div>
                    <div class="col-6 form-group">
                        <label for="wallet_to_id" class="mb-0 form-label" :class="{'is-invalid': errors && errors.wallet_to_id}">{{ 'mkeep.dest_wallet' | trans }}</label>
                        <dropdown-items v-model="operation.wallet_to_id" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.wallet_to_id"><strong>{{ errors.wallet_to_id }}</strong></span>
                    </div>
                  </div>

                     <div class="row form-group">
                        <input type="text" v-model="operation.comment" class="form-control" :class="{'is-invalid': errors && errors.comment}" :placeholder="'mkeep.comment'|trans">
                        <span class="invalid-feedback" v-if="errors && errors.comment"><strong>{{ errors.comment }}</strong></span>
                     </div>

                     <div class="row form-group">
                        <div class="col-6 pl-0">
                            <button v-if="mode=='transaction'" type="button" class="btn btn-success" @click="saveTransaction()">
                                <i class="fa fa-btn fa-save"></i> {{ 'mkeep.save' | trans }}
                            </button>
                            <button v-else="" type="button" class="btn btn-success" @click="save()">
                                <i class="fa fa-btn fa-save"></i> {{ 'mkeep.save' | trans }}
                            </button>
                        </div>
                        <div class="col-6 pr-0">
                            <button id="btn-type-drop" type="button" class="btn pull-right dropdown-toggle" :class="{'btn-danger': operation.type=='spend', 'btn-success': operation.type=='income', 'btn-secondary': operation.type=='transfer'}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span v-if="operation.type=='spend'"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;{{ 'mkeep.add_spend' | trans }}</span>
                              <span v-else-if="operation.type=='income'"><i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;{{ 'mkeep.add_income' | trans }}</span>
                              <span v-else=""><i class="fa fa-exchange"></i>&nbsp;&nbsp;{{ 'mkeep.add_transfer' | trans }}</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">              
                              <a v-if="operation.type!='spend'" class="dropdown-item text-danger" @click="operation.type='spend'"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;{{ 'mkeep.add_spend' | trans }}</a>
                              <a v-if="operation.type!='income'" class="dropdown-item text-success" @click="operation.type='income'"><i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;{{ 'mkeep.add_income' | trans }}</a>
                              <a v-if="operation.type!='transfer' && this.mode!='transaction'" class="dropdown-item" @click="operation.type='transfer'"><i class="fa fa-exchange"></i>&nbsp;&nbsp;{{ 'mkeep.add_transfer' | trans }}</a>
                            </div>
                        </div>
                     </div>
                 </form>
               </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['mode', 'walletid'],
        data: function () {
            return {
                operation: [],
                categories: [],
                wallets: [],
                walletsList: [],
                errors: false
            };
        },
        mounted() {
            //this.load()
            this.categories = window.dictionary['categories'];
            this.walletsList = window.dictionary['wallets'];
            
            let x, k;
            for (x in window.dictionary['walletGroups']) {
                let group = window.dictionary['walletGroups'][x];
                this.wallets.push({'is_group':true, 'name': group.name});
                for (k in window.dictionary['wallets']) {
                    let wallet = window.dictionary['wallets'][k];
                    if (wallet.group_id==group.id || (!group['id'] && !wallet.group_id)) {
                        this.wallets.push(wallet);
                    }
                }
            }
            
            
            var self = this;
            this.$root.$on('categoryclick', function($categoryId) {
                self.add('spend', $categoryId);
            });
        },
        methods: {
            /**
             * Load the operation and prepare the edit form
             */
            edit: function (id) {
                this.errors = false;
                axios
                    .get('/account/operations/edit/'+id)
                    .then((response) => {
                        this.operation = response.data['operation'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * prepare the add form
             */
            add: function (type, categoryId) {
                this.errors = false;
                var url = '/account/operations/edit/0?type='+type;
                if (categoryId) {
                    url = url + "&category_id=" + categoryId;
                }
                axios
                    .get(url)
                    .then((response) => {
                        this.operation = response.data['operation'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * Save opeartion
             */
            save: function() {
                let url = '/account/operations/';
                if (this.operation.id) {
                    url = url + 'update/' + this.operation.id;
                } else {
                    url = url + 'add';
                }
                axios
                    .post(url, this.operation)
                    .then((response) => {
                        if (response.data['errors']) {
                            this.errors = response.data['errors'];
                        } else {
                            this.$root.$emit('operationchanged');
                            $('#editModalBlock').modal('hide');
                        }
                    })
            },
            /**
             * Load the transaction and prepare the edit form
             */
            editTransaction: function (transaction) {
                this.errors = false;
                this.operation = transaction;
                $('#editModalBlock').modal();
            },
            /**
             * Save transaction
             */
            saveTransaction: function() {
                this.$emit('savetransaction', this.operation);
                $('#editModalBlock').modal('hide');
            }
        }
    }
</script>
