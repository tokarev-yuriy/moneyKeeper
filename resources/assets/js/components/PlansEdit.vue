<template>
    <div>
    <div class="modal fade" id="editModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" v-if="plan.id">{{ 'mkeep_tablegrid.edit' | trans }}</h4>    
                <h4 class="modal-title" v-else="">{{ 'mkeep_tablegrid.add' | trans }}</h4>
                <button type="button" class="close" data-dismiss="modal" :aria-label="'mkeep_tablegrid.close'|trans">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="value" class="mb-0 form-label" :class="{'is-invalid': errors && errors.value}">{{ 'mkeep.summ' | trans }}</label>
                            <input type="text" v-model="plan.value" class="form-control" :class="{'is-invalid': errors && errors.value}" :placeholder="'mkeep.summ'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.value"><strong>{{ errors.value }}</strong></span>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="mb-0 form-label" :class="{'is-invalid': errors && errors.category_id}">{{ 'mkeep.category' | trans }}</label>
                            <dropdown-items v-model="plan.category_id" :items="categories"/>
                            <span class="invalid-feedback" v-if="errors && errors.category_id"><strong>{{ errors.category_id }}</strong></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="active_from" class="mb-0 form-label" :class="{'is-invalid': errors && errors.active_from}">{{ 'mkeep.active_from' | trans }}</label>
                            <input type="date" v-model="plan.active_from" class="form-control" :class="{'is-invalid': errors && errors.active_from}" :placeholder="'mkeep.active_from'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.active_from"><strong>{{ errors.active_from }}</strong></span>
                        </div>
                        <div class="col-md-6">
                            <label for="active_to" class="mb-0 form-label" :class="{'is-invalid': errors && errors.active_to}">{{ 'mkeep.active_to' | trans }}</label>
                            <input type="date" v-model="plan.active_to" class="form-control" :class="{'is-invalid': errors && errors.active_to}" :placeholder="'mkeep.active_to'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.active_to"><strong>{{ errors.active_to }}</strong></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <label for="comment" class="mb-0 form-label" :class="{'is-invalid': errors && errors.comment}">{{ 'mkeep.comment' | trans }}</label>
                            <input type="text" v-model="plan.comment" class="form-control" :class="{'is-invalid': errors && errors.comment}" :placeholder="'mkeep.comment'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.comment"><strong>{{ errors.comment }}</strong></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 pt-3">
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
                plan: [],
                categories: [],
                errors: false
            };
        },
        mounted() {},
        methods: {
            /**
             * Load the plan and prepare the edit form
             */
            edit: function (id) {
                this.errors = false;
                axios
                    .get('/account/plans/edit/'+id)
                    .then((response) => {
                        this.plan = response.data['plan'];
                        this.categories = response.data['categories'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * prepare the add form
             */
            add: function () {
                this.errors = false;
                var url = '/account/plans/edit/0';
                axios
                    .get(url)
                    .then((response) => {
                        this.plan = response.data['plan'];
                        this.categories = response.data['categories'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * Save plan
             */
            save: function() {
                let url = '/account/plans/';
                if (this.plan.id) {
                    url = url + 'update/' + this.plan.id;
                } else {
                    url = url + 'add';
                }
                axios
                    .post(url, this.plan)
                    .then((response) => {
                        if (response.data['errors']) {
                            this.errors = response.data['errors'];
                        } else {
                            this.$root.$emit('plan.changed');
                            $('#editModalBlock').modal('hide');
                        }
                    })
            }
        }
    }
</script>
