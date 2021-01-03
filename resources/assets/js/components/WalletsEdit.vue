<template>
    <div>
    <div class="modal fade" id="editModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" v-if="wallet.id">{{ 'mkeep_tablegrid.edit' | trans }}</h4>    
                <h4 class="modal-title" v-else="">{{ 'mkeep_tablegrid.add' | trans }}</h4>
                <button type="button" class="close" data-dismiss="modal" :aria-label="'mkeep_tablegrid.close'|trans">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name" class="mb-0 form-label" :class="{'is-invalid': errors && errors.name}">{{ 'mkeep.name' | trans }}</label>
                            <input type="text" v-model="wallet.name" class="form-control" :class="{'is-invalid': errors && errors.name}" :placeholder="'mkeep.name'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.name"><strong>{{ errors.name }}</strong></span>
                        </div>
                        <div class="col-md-6">
                            <label for="group_id" class="mb-0 form-label" :class="{'is-invalid': errors && errors.group_id}">{{ 'mkeep.wallet_group' | trans }}</label>
                            <dropdown-items v-model="wallet.group_id" :items="groups"/>
                            <span class="invalid-feedback" v-if="errors && errors.group_id"><strong>{{ errors.group_id }}</strong></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="icon" class="mb-0 form-label" :class="{'is-invalid': errors && errors.icon}">{{ 'mkeep.icon' | trans }}</label>
                            <dropdown-items v-model="wallet.icon" :items="icons"/>
                            <span class="invalid-feedback" v-if="errors && errors.icon"><strong>{{ errors.icon }}</strong></span>
                        </div>
                        <div class="col-md-6">
                            <label for="color" class="mb-0 form-label" :class="{'is-invalid': errors && errors.color}">{{ 'mkeep.color' | trans }}</label>
                            <dropdown-items v-model="wallet.color" :items="colors"/>
                            <span class="invalid-feedback" v-if="errors && errors.color"><strong>{{ errors.color }}</strong></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sort" class="mb-0 form-label" :class="{'is-invalid': errors && errors.sort}">{{ 'mkeep.sort' | trans }}</label>
                            <input type="text" v-model="wallet.sort" class="form-control" :class="{'is-invalid': errors && errors.sort}" :placeholder="'mkeep.sort'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.sort"><strong>{{ errors.sort }}</strong></span>
                        </div>
                        <div class="col-md-6">
                            <label for="start" class="mb-0 form-label" :class="{'is-invalid': errors && errors.start}">{{ 'mkeep.start' | trans }}</label>
                            <input type="text" v-model="wallet.start" class="form-control" :class="{'is-invalid': errors && errors.start}" :placeholder="'mkeep.start'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.start"><strong>{{ errors.start }}</strong></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 pt-3">
                            <input type="checkbox" id="walletActive" v-model="wallet.active"/>
                            <label for="walletActive" class="mb-0 form-label">
                                {{ 'mkeep.active' | trans }}
                            </label>
                        </div>
                        <div class="col-md-6">
                            <div class="pull-right">
                                <button type="button" class="btn btn-success" @click="save()">
                                    <i class="fa fa-btn fa-save"></i> {{ 'mkeep.save' | trans }}
                                </button>
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
        props: [],
        data: function () {
            return {
                wallet: [],
                groups: [],
                icons: [],
                colors: [],
                errors: false
            };
        },
        mounted() {},
        methods: {
            /**
             * Load the wallet and prepare the edit form
             */
            edit: function (id) {
                this.errors = false;
                axios
                    .get('/account/wallets/edit/'+id)
                    .then((response) => {
                        this.wallet = response.data['wallet'];
                        this.groups = response.data['groups'];
                        this.icons = response.data['icons'];
                        this.colors = response.data['colors'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * prepare the add form
             */
            add: function () {
                this.errors = false;
                var url = '/account/wallets/edit/0';
                axios
                    .get(url)
                    .then((response) => {
                        this.wallet = response.data['wallet'];
                        this.groups = response.data['groups'];
                        this.icons = response.data['icons'];
                        this.colors = response.data['colors'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * Save wallet
             */
            save: function() {
                let url = '/account/wallets/';
                if (this.wallet.id) {
                    url = url + 'update/' + this.wallet.id;
                } else {
                    url = url + 'add';
                }
                axios
                    .post(url, this.wallet)
                    .then((response) => {
                        if (response.data['errors']) {
                            this.errors = response.data['errors'];
                        } else {
                            this.$root.$emit('wallet.changed');
                            $('#editModalBlock').modal('hide');
                        }
                    })
            }
        }
    }
</script>
