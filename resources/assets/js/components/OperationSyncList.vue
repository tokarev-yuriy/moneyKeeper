<template>
    <div>
        <div class="clearfix mb-2"></div>
        <div class="card" style="border-radius: 0;" v-if="!transactions">
            <div class="card-header" v-if="transactions===false"><h3>{{ 'mkeep.loading' | trans }}</h3></div>
            <div class="card-header" v-else=""><h3>{{ 'mkeep.no_data' | trans }}</h3></div>
        </div>
        <div v-for="operation in transactions" :class="{'mt-0': !operation.unique_date}" class="card mb-0" style="border-radius: 0;">
          <div class="card-header card-header-info" style="width: auto;" v-if="operation.unique_date">
            <h4 class="card-title" style="width: auto;">{{ operation.date }}</h4>
          </div>
            <div class="card-body p-2" :class="'bg-'+operation.type">
              <div class="col-12">
                <div class="card-btns pl-2">
                        <button  class="btn btn-info" @click="edit(operation)"><i class="material-icons">edit</i></button>
                        <button  class="btn btn-dark" @click="delDialog(operation.ext_id)"><i class="material-icons">close</i></button>
                </div>
                <div class="row">
                  <div class="col-8">
                        <div v-if="categories[operation.category_id]" class="category-icon"
                            :class="{'bg-danger': operation.type=='spend', 'bg-success': operation.type=='income', 'bg-secondary': operation.type=='transfer'}">
                            <img v-if="categories[operation.category_id].icon_src" :src="categories[operation.category_id].icon_src" :alt="categories[operation.category_id].name">
                        </div>
                        <h4 v-if="categories[operation.category_id]">{{ categories[operation.category_id].name }}</h4>
                        
                        <span v-if="operation.type=='spend'">{{ wallets[wallet].name }}</span>
                        <span v-else-if="operation.type=='income'">{{ wallets[wallet].name }}</span>
                    </div>                    
                    <div class="col-4  text-right">
                      <span class="h3"
                        :class="{'text-danger': operation.type=='spend', 'text-success': operation.type=='income', 'text-secondary': operation.type=='transfer'}">
                          <span v-if="operation.type=='spend'">-</span>
                          <span v-else-if="operation.type=='income'">-</span>
                          {{operation.value | numberf}}
                      </span>
                      <div class="text-secondary card-comment">{{ operation.comment }}</div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <operation-edit ref="transactionEdit" mode="transaction" v-on:savetransaction="add($event)"></operation-edit>
        <div class="clearfix mb-2"></div>
        
        <div class="modal fade" id="deleteModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{ 'mkeep_tablegrid.delete_item' | trans }}</h4>
                <button type="button" class="close" data-dismiss="modal" :aria-label="'mkeep_tablegrid.close' | trans">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">{{ 'mkeep_tablegrid.sure' | trans }}</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ 'mkeep_tablegrid.no' | trans }}</button>
                <button class="btn btn-danger delete-btn" @click="del">{{ 'mkeep_tablegrid.delete' | trans }}</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'wallet'],
        data: function () {
            return {
                transactions: false,
                delOperationId: false,
                wallets: [],
                categories: []
            };
        },
        mounted() {
            this.wallets = window.dictionary['wallets'];
            this.categories = window.dictionary['categories'];
            this.load();
        },
        methods: {
            /**
             *  Load transactions
             */
            load: function () {
                var url = '/account/import/integration/sync';
                if (this.id) {
                    url = url + "/" + this.id;
                }
                axios
                    .get(url)
                    .then((response) => {
                        this.transactions = response.data['transactions'];
                        if (this.transactions) {
                            let date = false;
                            let x = false;
                            for(x in this.transactions) {
                                if (this.transactions[x].date && this.transactions[x].date!=date) {
                                    this.transactions[x].unique_date = true;
                                    date = this.transactions[x].date;
                                }
                            }
                        }
                        this.data = false;
                    })
            },
            /**
             * open the edit form
             */
            edit: function (transaction) {
                this.$refs.transactionEdit.editTransaction(transaction, []);
            },
            /**
             *  open the delete dialog
             */
            delDialog: function (id) {
                this.delOperationId = id;
                $('#deleteModalBlock').modal('show');
            },
            /**
             *  execute the delete action
             */
            del: function () {
                $('#deleteModalBlock').modal('hide');
                if (!this.delOperationId) return false;
                
                let x = false;
                for(x in this.transactions) {
                    if (this.transactions[x].ext_id==this.delOperationId) {
                        this.transactions.splice(x, 1);
                        break;
                    }
                }
            },
        }
    }
</script>
