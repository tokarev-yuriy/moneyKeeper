<template>
    <div>
        <operation-btns v-on:addbtnclick="add($event)"></operation-btns>
        <div class="clearfix"></div>
        <operation-filter :filters="filters"></operation-filter>
        <div class="clearfix mb-2"></div>
        <div class="card" style="border-radius: 0;" v-if="!operations">
            <div class="card-header" v-if="operations===false"><h3>{{ 'mkeep.loading' | trans }}</h3></div>
            <div class="card-header" v-else=""><h3>{{ 'mkeep.no_data' | trans }}</h3></div>
        </div>
        <div v-for="operation in operations" :class="{'mt-0': !operation.unique_date}" class="card mb-0" style="border-radius: 0;">
          <div class="card-header card-header-info" style="width: auto;" v-if="operation.unique_date">
            <h4 class="card-title" style="width: auto;">{{ operation.date }}</h4>
          </div>
            <div class="card-body p-2" :class="'bg-'+operation.type">
              <div class="col-12">
                <div class="card-btns pl-2">
                        <button  v-if="actions.indexOf('edit')>=0" class="btn btn-info" @click="edit(operation.id)"><i class="material-icons">edit</i></button>
                        <button  v-if="actions.indexOf('delete')>=0" class="btn btn-dark" @click="delDialog(operation.id)"><i class="material-icons">close</i></button>
                </div>
                <div class="row">
                  <div class="col-8">
                        <div v-if="header.category_id && categories[operation.category_id]" class="category-icon"
                            :class="{'bg-danger': operation.type=='spend', 'bg-success': operation.type=='income', 'bg-secondary': operation.type=='transfer'}">
                            <img v-if="categoryIcons[operation.category_id]" :src="categoryIcons[operation.category_id]" :alt="categories[operation.category_id]">
                        </div>
                        <h4 v-if="header.category_id && categories[operation.category_id]">{{ categories[operation.category_id] }}</h4>
                        <span v-if="header.wallet" v-html="operation.wallet"></span>
                        <span v-else-if="header.wallet_from_id && walletsFrom[operation.wallet_from_id]">{{ walletsFrom[operation.wallet_from_id] }}</span>
                        <span v-else-if="header.wallet_to_id && walletsTo[operation.wallet_to_id]">{{ walletsTo[operation.wallet_to_id] }}</span>
                    </div>                    
                    <div class="col-4  text-right">
                      <span v-if="header.value" class="h3"
                        :class="{'text-danger': operation.type=='spend', 'text-success': operation.type=='income', 'text-secondary': operation.type=='transfer'}">
                          <span v-if="operation.type=='spend'">-</span>
                          <span v-else-if="operation.type=='income'">-</span>
                          {{operation.value | numberf}}
                      </span>
                      <div v-if="header.comment" class="text-secondary card-comment">{{ operation.comment }}</div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <operation-edit ref="operationEdit"></operation-edit>
        <div class="clearfix mb-2"></div>
        <operation-btns v-on:addbtnclick="add($event)"></operation-btns>
        
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
        props: ['type'],
        data: function () {
            return {
                operations: false,
                delOperationId: false,
                date: false,
                header: [],
                actions: [],
                filters: {},
                walletsTo: [],
                walletsFrom: [],
                categories: [],
                categoryIcons: []
            };
        },
        mounted() {
            this.load();
            this.$root.$on('operationchanged', data => {
                this.load();
            });
        },
        methods: {
            /**
             *  Load operations
             */
            load: function () {
                var url = '/account/operations';
                if (this.type) {
                    url = url + "/" + this.type;
                }
                axios
                    .get(url)
                    .then((response) => {
                        this.operations = response.data['operations'].data;
                        if (this.operations) {
                            let date = false;
                            let x = false;
                            for(x in this.operations) {
                                if (this.operations[x].date && this.operations[x].date!=date) {
                                    this.operations[x].unique_date = true;
                                    date = this.operations[x].date;
                                }
                            }
                        }
                        this.header = response.data['header'];
                        this.actions = response.data['actions'];
                        this.filters = response.data['filters'];
                        this.walletsTo = response.data['dicts']['wallet_to_id'];
                        this.walletsFrom = response.data['dicts']['wallet_from_id'];
                        this.categories = response.data['dicts']['category_id'];
                        this.categoryIcons = response.data['dicts']['category_icon'];
                        this.data = false;
                    })
            },
            /**
             * open the edit form
             */
            edit: function (id) {
                this.$refs.operationEdit.edit(id);
            },
            /**
             *  open the add form
             */
            add: function (type) {
                this.$refs.operationEdit.add(type);
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
                
                let url = '/account/operations/delete/'+ this.delOperationId;
                axios
                    .get(url)
                    .then((response) => {
                        if (!response.data['errors']) {
                            this.$root.$emit('operationchanged');
                        }
                    })
            },
        }
    }
</script>
