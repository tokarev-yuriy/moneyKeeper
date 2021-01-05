<template>
    <div>
        <a href="javascript: void(0);" class="btn btn-success pull-right" @click="add()"><i class="fa fa-plus-square fa-lg"></i> {{ 'mkeep.add_plan' | trans }}</a>
        <div class="clearfix"></div>
        
        <div class="clearfix mb-2"></div>
        <div class="card" style="border-radius: 0;" v-if="!plans">
            <div class="card-header" v-if="plans===false"><h3>{{ 'mkeep.loading' | trans }}</h3></div>
            <div class="card-header" v-else=""><h3>{{ 'mkeep.no_data' | trans }}</h3></div>
        </div>
        
        <table class="table mt-3 table-striped table-sm">
            <thead>
                <tr>
                    <th>{{ 'mkeep.category' | trans }}</th>
                    <th>{{ 'mkeep.summ' | trans }}</th>
                    <th>{{ 'mkeep.comment' | trans }}</th>
                    <th>{{ 'mkeep.active_from' | trans }}</th>
                    <th>{{ 'mkeep.active_to' | trans }}</th>
                    <th colspan="2" width="1%">{{ 'mkeep_tablegrid.actions' | trans }}</th>
                </tr>
            </thead> 
            <tbody>
                <tr v-for="plan in plans">
                    <td>
                        <div v-if="categories[plan.category_id]" class="category-icon">
                            <i v-if="categories[plan.category_id].icon" :class="'fas fa-'+categories[plan.category_id].icon" :alt="categories[plan.category_id].name"></i>
                        </div>
                    </td>
                    <td>{{plan.value}}</td>
                    <td>{{plan.comment}}</td>
                    <td>
                        <span v-if="plan.active_from">{{plan.active_from}}</span>
                        <span v-else>-</span>
                    </td>
                    <td>
                        <span v-if="plan.active_to">{{plan.active_to}}</span>
                        <span v-else>-</span>
                    </td>
                    <td>
                        <a data-btn-type="edit" href="javascript: void(0);" :data-title="'mkeep.edit_plan' | trans" class="btn btn-info d-none d-md-block" @click="edit(plan.id)">
                            <i aria-hidden="true" class="fa fa-pencil fa-lg"></i> {{ 'mkeep_tablegrid.edit' | trans }}
                        </a>
                        <a data-btn-type="edit" href="javascript: void(0);" :data-title="'mkeep.edit_plan' | trans" class="btn btn-info d-md-none" @click="edit(plan.id)">
                            <i aria-hidden="true" class="fa fa-pencil fa-lg"></i></a>
                    </td> 
                    <td>
                        <a data-btn-type="delete" href="javascript: void(0);" :data-title="'mkeep.delete_plan' | trans" class="btn btn-dark d-none d-md-block" @click="delDialog(plan.id)">
                            <i aria-hidden="true" class="fa fa-remove fa-lg"></i> {{ 'mkeep_tablegrid.delete' | trans }}
                        </a> 
                        <a data-btn-type="delete" href="javascript: void(0);" :data-title="'mkeep.delete_plan' | trans" class="btn btn-dark d-md-none" @click="delDialog(plan.id)">
                            <i aria-hidden="true" class="fa fa-remove fa-lg"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <plans-edit ref="plansEdit"></plans-edit>
        <div class="clearfix mb-2"></div>
        
        <a href="javascript: void(0);" class="btn btn-success pull-right" @click="add()"><i class="fa fa-plus-square fa-lg"></i> {{ 'mkeep.add_plan' | trans }}</a>
        
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
                plans: false,
                categories: [],
                delItemId: false,
            };
        },
        mounted() {
            this.load();
            this.$root.$on('plan.changed', data => {
                this.load();
            });
        },
        methods: {
            /**
             *  Load plans
             */
            load: function () {
                var url = '/account/plans';
                axios
                    .get(url)
                    .then((response) => {
                        this.plans = response.data['plans']['data'];
                        this.categories = response.data['categories'];
                    })
            },
            /**
             * open the edit form
             */
            edit: function (id) {
                this.$refs.plansEdit.edit(id);
            },
            /**
             *  open the add form
             */
            add: function () {
                this.$refs.plansEdit.add();
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
                
                let url = '/account/plans/delete/'+ this.delItemId;
                axios
                    .get(url)
                    .then((response) => {
                        if (!response.data['errors']) {
                            this.$root.$emit('plan.changed');
                        }
                    })
            },
        }
    }
</script>
