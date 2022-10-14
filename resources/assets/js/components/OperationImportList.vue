<template>
    <div>
    <div class="row justify-content-center" v-if="!transactions">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title">{{ 'mkeep.import' | trans }}</h4>
                </div>
                <div class="card-body">
                     <div class="form-group">
                        <label for="walletId" class="mb-0 form-label" :class="{'is-invalid': errors && errors.walletId}">{{ 'mkeep.wallet' | trans }}</label>
                        <dropdown-items v-model="walletId" :items="wallets"/>
                        <span class="invalid-feedback" v-if="errors && errors.walletId"><strong>{{ errors.walletId }}</strong></span>
                      </div>
                      
                      <div class="form-group">
                        <label  :class="{'is-invalid': errors && errors.importFile, 'btn': true}" for="importFile">
                            {{ 'mkeep.import_file' | trans }}
                            <input type="file" id="importFile" ref="importFile" v-on:change="handleFileUpload()" :class="{'is-invalid': errors && errors.importFile}"/>
                        </label>
                        <span class="invalid-feedback" v-if="errors && errors.importFile"><strong>{{ errors.importFile }}</strong></span>
                      </div>

                      <div class="form-group">
                          <label for="round" class="bmd-label-floating">{{ 'mkeep.round' | trans }}</label>
                          <select v-model="round" class="form-control">
                            <option value="2">0,00</option>
                            <option value="1">0,10</option>
                            <option value="0">1</option>
                            <option value="-10">10</option>
                            <option value="-50">50</option>
                            <option value="-100">100</option>
                          </select>
                          <span class="invalid-feedback" v-if="errors && errors.round"><strong>{{ errors.round }}</strong></span>
                      </div>
                      
                      <div class="form-group">
                          <button type="submit" class="btn btn-success" @click="load">
                              <i class="fa fa-btn fa-upload"></i> {{ 'mkeep.import' | trans }}
                          </button>
                      </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="transactions">
        <h4>{{ 'mkeep.import_check_items' | trans }}</h4>
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
                        <span v-if="operation.type=='spend'">{{ wallets[walletId].name }}</span>
                        <span v-else-if="operation.type=='income'">{{ wallets[walletId].name }}</span>
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
        <div class="clearfix mb-2"></div>
        
        <div class="float-right">
            <a href="javascript: void(0);" class="btn btn-success" @click="save"><i class="fa fa-save fa-lg"></i>&nbsp; {{ 'mkeep.save' | trans }}</a>
        </div>
    </div>
    <operation-edit ref="transactionEdit" mode="transaction" :walletid="walletId" v-on:savetransaction="update($event)"></operation-edit>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                transactions: false,
                walletId: false,
                round: -50,
                importFile: '',
                wallets: [],
                categories: [],
                errors: {}
            };
        },
        mounted() {
            this.wallets = window.dictionary['wallets'];
            this.categories = window.dictionary['categories'];
        },
        methods: {
            /**
             *  Load transactions
             */
            load: function () {            
                var url = '/account/import';
                let formData = new FormData();
                formData.append('importFile', this.importFile);
                formData.append('walletId', this.walletId);
                formData.append('round', this.round);
                axios
                    .post(
                        url,
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    )
                    .then((response) => {
                        if (response.data['transactions']) {
                            this.transactions = response.data['transactions'];
                        } else {
                            this.errors = response.data['errors'];
                        }
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
             *  upload file
             */
            handleFileUpload(){
                this.importFile = this.$refs.importFile.files[0];
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
                var url = '/account/import';
                axios
                    .post(url, {'walletId': this.walletId, 'importTransaction': this.transactions, 'mode': 'save'})
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
