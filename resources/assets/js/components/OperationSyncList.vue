<template>
    <div>
        <div class="clearfix mb-2"></div>
        <div class="card" style="border-radius: 0;" v-if="!transactions">
            <div class="card-header" v-if="transactions===false"><h3>{{ 'mkeep.loading' | trans }}</h3></div>
            <div class="card-header" v-else=""><h3>{{ 'mkeep.no_data' | trans }}</h3></div>
        </div>
        <div v-for="operation in transactions" :class="{'mt-0': !showOperationDate(operation)}" class="card mb-0" style="border-radius: 0;">
          <div class="card-header card-header-info" style="width: auto;" v-if="showOperationDate(operation)">
            <h4 class="card-title" style="width: auto;">{{ operation.date }}</h4>
          </div>
            <div class="card-body p-2" :class="'bg-'+operation.type">
              <div class="col-12">
                <div class="card-btns pl-2">
                        <button  class="btn btn-info" @click="edit(operation)"><i class="material-icons">edit</i></button>
                        <button  class="btn btn-dark" @click="del(operation.ext_id)"><i class="material-icons">close</i></button>
                </div>
                <div class="row">
                  <div class="col-7">
                        <div v-if="categories[operation.category_id]" class="category-icon"
                            :class="{'bg-danger': operation.type=='spend', 'bg-success': operation.type=='income', 'bg-secondary': operation.type=='transfer'}">
                            <i v-if="categories[operation.category_id].icon" :class="'fas fa-'+categories[operation.category_id].icon" :alt="categories[operation.category_id].name" style="color: #fff;"></i>
                        </div>
                        <h4 v-if="categories[operation.category_id]">{{ categories[operation.category_id].name }}</h4>
                        
                        <span v-if="operation.type=='spend'">{{ wallets[wallet].name }}</span>
                        <span v-else-if="operation.type=='income'">{{ wallets[wallet].name }}</span>
                    </div>                    
                    <div class="col-5 text-right">
                      <span class="h3"
                        :class="{'text-danger': operation.type=='spend', 'text-success': operation.type=='income', 'text-secondary': operation.type=='transfer', 'text-nowrap': true}">
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
        <operation-edit ref="transactionEdit" mode="transaction" :walletid="wallet" v-on:savetransaction="update($event)"></operation-edit>
        <div class="clearfix mb-2"></div>
        
        <div class="float-right">
            <a href="javascript: void(0);" class="btn btn-success" @click="save()"><i class="fa fa-save fa-lg"></i>&nbsp; {{ 'mkeep.save' | trans }}</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id', 'wallet'],
        data: function () {
            return {
                transactions: false,
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
                    })
            },
            /**
             *  Проверяем нужно ли показывать дату
             */
            showOperationDate: function (operation) {
                let prevDate = false;
                for (let op of this.transactions) {
                    if (op.ext_id==operation.ext_id) {
                        if (prevDate!=op.date) {
                            return true;
                        }
                        return false;
                    }
                    prevDate=op.date;
                }
                return false;
            },
            /**
             * open the edit form
             */
            edit: function (transaction) {
                this.$refs.transactionEdit.editTransaction(transaction);
            },
            /**
             * update transaction
             */
            update: function (transaction) {
               let x;
               for(x in this.transactions) {
                    if (this.transactions[x].ext_id == transaction.ext_id) {
                        this.transactions[x] = transaction;
                    }
               }
            },
            /**
             *  Сохраняем транзакции
             */
            save: function() {
                var url = '/account/import/integration/sync';
                if (this.id) {
                    url = url + "/" + this.id;
                }
                axios
                    .post(url, {'walletId': this.wallet, 'importTransaction': this.transactions})
                    .then((response) => {
                        document.location = '/';
                    })
            },
            /**
             *  execute the delete action
             */
            del: function (id) {
                let x = false;
                for(x in this.transactions) {
                    if (this.transactions[x].ext_id==id) {
                        this.transactions.splice(x, 1);
                        break;
                    }
                }
            },
        }
    }
</script>
