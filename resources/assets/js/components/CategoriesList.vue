<template>
    <div>
        <a href="javascript: void(0);" class="btn btn-success pull-right" @click="add()"><i class="fa fa-plus-square fa-lg"></i> {{ 'mkeep.add_category' | trans }}</a>
        <div class="clearfix"></div>
        
        <div class="clearfix mb-2"></div>
        <div class="card" style="border-radius: 0;" v-if="!categories">
            <div class="card-header" v-if="categories===false"><h3>{{ 'mkeep.loading' | trans }}</h3></div>
            <div class="card-header" v-else=""><h3>{{ 'mkeep.no_data' | trans }}</h3></div>
        </div>
        
        <table class="table mt-3 table-striped table-sm">
            <thead>
                <tr>
                    <th>{{ 'mkeep.name' | trans }}</th>
                    <th>{{ 'mkeep.sort' | trans }}</th>
                    <th>{{ 'mkeep.type' | trans }}</th>
                    <th>{{ 'mkeep.icon' | trans }}</th>
                    <th>{{ 'mkeep.active' | trans }}</th>
                    <th colspan="2" width="1%">{{ 'mkeep_tablegrid.actions' | trans }}</th>
                </tr>
            </thead> 
            <tbody>
                <tr v-for="category in categories">
                    <td>{{category.name}}</td>
                    <td>{{category.sort}}</td>
                    <td>{{types[category.type]}}</td>
                    <td><i aria-hidden="true" :class="'fas fa-' + category.icon"></i></td>
                    <td>
                        <span v-if="category.active">Да</span>
                        <span v-else>Нет</span>
                    </td>
                    <td>
                        <a data-btn-type="edit" href="javascript: void(0);" :data-title="'mkeep.edit_category' | trans" class="btn btn-info d-none d-md-block" @click="edit(category.id)">
                            <i aria-hidden="true" class="fa fa-pencil fa-lg"></i> {{ 'mkeep_tablegrid.edit' | trans }}
                        </a>
                        <a data-btn-type="edit" href="javascript: void(0);" :data-title="'mkeep.edit_category' | trans" class="btn btn-info d-md-none" @click="edit(category.id)">
                            <i aria-hidden="true" class="fa fa-pencil fa-lg"></i></a>
                    </td> 
                    <td>
                        <a data-btn-type="delete" href="javascript: void(0);" :data-title="'mkeep.delete_category' | trans" class="btn btn-dark d-none d-md-block" @click="delDialog(category.id)">
                            <i aria-hidden="true" class="fa fa-remove fa-lg"></i> {{ 'mkeep_tablegrid.delete' | trans }}
                        </a> 
                        <a data-btn-type="delete" href="javascript: void(0);" :data-title="'mkeep.delete_category' | trans" class="btn btn-dark d-md-none" @click="delDialog(category.id)">
                            <i aria-hidden="true" class="fa fa-remove fa-lg"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <categories-edit ref="categoriesEdit"></categories-edit>
        <div class="clearfix mb-2"></div>
        
        <a href="javascript: void(0);" class="btn btn-success pull-right" @click="add()"><i class="fa fa-plus-square fa-lg"></i> {{ 'mkeep.add_category' | trans }}</a>
        
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
        data: function () {
            return {
                categories: false,
                types: [],
                delItemId: false,
            };
        },
        mounted() {
            this.load();
            this.$root.$on('category.changed', data => {
                this.load();
            });
        },
        methods: {
            /**
             *  Load categories
             */
            load: function () {
                var url = '/account/categories';
                axios
                    .get(url)
                    .then((response) => {
                        this.categories = response.data['categories'];
                        this.types = response.data['types'];
                    })
            },
            /**
             * open the edit form
             */
            edit: function (id) {
                this.$refs.categoriesEdit.edit(id);
            },
            /**
             *  open the add form
             */
            add: function () {
                this.$refs.categoriesEdit.add();
            },
            /**
             *  open the delete dialog
             */
            delDialog: function (id) {
                this.delItemId = id;
                $('#deleteModalBlock').modal('show');
            },
            /**
             *  execute the delete action
             */
            del: function () {
                $('#deleteModalBlock').modal('hide');
                if (!this.delItemId) return false;
                
                let url = '/account/categories/delete/'+ this.delItemId;
                axios
                    .get(url)
                    .then((response) => {
                        if (!response.data['errors']) {
                            this.$root.$emit('category.changed');
                        }
                    })
            },
        }
    }
</script>
