<template>
    <div>
    <div class="modal fade" id="editModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="mkeep_tablegrid.close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h1 v-if="operation.id">mkeep.edit</h1>    
                <h1 v-else="">mkeep.add</h1>
                <form method="post">
                  <div class="form-row">
                    <div class="form-group col-6">
                        <input type="date" v-model="operation.date" class="form-control" :class="{'is-invalid': errors && errors.date}" placeholder="mkeep.date" />
                        <span class="invalid-feedback" v-if="errors && errors.date"><strong>{{ errors.date }}</strong></span>
                    </div>  

                    <div class="col-6 form-group">
                        <input type="number" v-model="operation.value" class="form-control" :class="{'is-invalid': errors && errors.value}" placeholder="mkeep.summ" />
                        <span class="invalid-feedback" v-if="errors && errors.value"><strong>{{ errors.value }}</strong></span>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-6 form-group">
                        <label for="category_id" class="mb-0">mkeep.category </label>
                        <dropdown-items v-model="operation.category_id" :items="categories"/>
                        <span class="invalid-feedback" v-if="errors && errors.category_id"><strong>{{ errors.category_id }}</strong></span>
                    </div>
                    <div class="col-6 form-group" v-if="operation.type=='spend'">
                        <label for="wallet_from_id" class="mb-0">mkeep.wallet</label>
                        <dropdown-items v-model="operation.wallet_from_id" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.wallet_from_id"><strong>{{ errors.wallet_from_id }}</strong></span>
                    </div>
                    <div class="col-6 form-group" v-if="operation.type=='income'">
                        <label for="wallet_to_id" class="mb-0">mkeep.wallet</label>
                        <dropdown-items v-model="operation.wallet_to_id" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.wallet_to_id"><strong>{{ errors.wallet_to_id }}</strong></span>
                    </div>
                  </div>
                  <div class="form-row" v-if="operation.type=='transfer'">
                    <div class="col-6 form-group">
                        <label for="wallet_from_id" class="mb-0">mkeep.src_wallet</label>
                        <dropdown-items v-model="operation.wallet_from_id" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.wallet_from_id"><strong>{{ errors.wallet_from_id }}</strong></span>
                    </div>
                    <div class="col-6 form-group">
                        <label for="wallet_to_id" class="mb-0">mkeep.dest_wallet</label>
                        <dropdown-items v-model="operation.wallet_to_id" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.wallet_to_id"><strong>{{ errors.wallet_to_id }}</strong></span>
                    </div>
                  </div>

                     <div class="row form-group">
                        <input type="text" v-model="operation.comment" class="form-control" :class="{'is-invalid': errors && errors.comment}" placeholder="mkeep.comment">
                        <span class="invalid-feedback" v-if="errors && errors.comment"><strong>{{ errors.comment }}</strong></span>
                     </div>

                     <div class="row form-group">
                        <div class="col-6 pl-0">
                            <button type="button" class="btn btn-success" @click="save()">
                                <i class="fa fa-btn fa-save"></i> mkeep.save
                            </button>
                        </div>
                        <div class="col-6 pr-0">
                            <button id="btn-type-drop" type="button" class="btn pull-right dropdown-toggle" :class="{'btn-danger': operation.type=='spend', 'btn-success': operation.type=='income', 'btn-secondary': operation.type=='transfer'}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span v-if="operation.type=='spend'"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;mkeep.add_spend</span>
                              <span v-else-if="operation.type=='income'"><i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;mkeep.add_income</span>
                              <span v-else=""><i class="fa fa-exchange"></i>&nbsp;&nbsp;mkeep.add_transfer</span>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">              
                              <a v-if="operation.type!='spend'" class="dropdown-item text-danger" @click="operation.type='spend'"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;mkeep.add_spend</a>
                              <a v-if="operation.type!='income'" class="dropdown-item text-success" @click="operation.type='income'"><i class="fa fa-long-arrow-right"></i>&nbsp;&nbsp;mkeep.add_income</a>
                              <a v-if="operation.type!='transfer'" class="dropdown-item" @click="operation.type='transfer'"><i class="fa fa-exchange"></i>&nbsp;&nbsp;mkeep.add_transfer</a>
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
        data: function () {
            return {
                operation: [],
                categories: [],
                wallets: [],
                errors: false
            };
        },
        mounted() {
            //this.load()
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
                        this.categories = response.data['categories'][this.operation.type];
                        this.wallets = response.data['wallets'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * prepare the add form
             */
            add: function (type) {
                this.errors = false;
                axios
                    .get('/account/operations/edit/0?type='+type)
                    .then((response) => {
                        this.operation = response.data['operation'];
                        this.categories = response.data['categories'][this.operation.type];
                        this.wallets = response.data['wallets'];
                        
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * Save opeartion
             */
            save: function() {
                let url = '/account/operations/'+this.operation.type+'/';
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
            }
        }
    }
</script>
