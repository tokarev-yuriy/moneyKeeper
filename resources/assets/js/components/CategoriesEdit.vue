<template>
    <div>
    <div class="modal fade" id="editModalBlock" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" v-if="category.id">{{ 'mkeep_tablegrid.edit' | trans }}</h4>    
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
                            <input type="text" v-model="category.name" class="form-control" :class="{'is-invalid': errors && errors.name}" :placeholder="'mkeep.name'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.name"><strong>{{ errors.name }}</strong></span>
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="mb-0 form-label" :class="{'is-invalid': errors && errors.type}">{{ 'mkeep.category_type' | trans }}</label>
                            <dropdown-items v-model="category.type" :items="types"/>
                            <span class="invalid-feedback" v-if="errors && errors.type"><strong>{{ errors.type }}</strong></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sort" class="mb-0 form-label" :class="{'is-invalid': errors && errors.sort}">{{ 'mkeep.sort' | trans }}</label>
                            <input type="text" v-model="category.sort" class="form-control" :class="{'is-invalid': errors && errors.sort}" :placeholder="'mkeep.sort'|trans" />
                            <span class="invalid-feedback" v-if="errors && errors.sort"><strong>{{ errors.sort }}</strong></span>
                        </div>
                        <div class="col-md-6">
                            <label for="icon" class="mb-0 form-label" :class="{'is-invalid': errors && errors.icon}">{{ 'mkeep.icon' | trans }}</label>
                            <dropdown-items v-model="category.icon" :items="icons"/>
                            <span class="invalid-feedback" v-if="errors && errors.icon"><strong>{{ errors.icon }}</strong></span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 pt-3">
                            <input type="checkbox" id="categoryActive" v-model="category.active"/>
                            <label for="categoryActive" class="mb-0 form-label">
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
                category: [],
                types: [],
                icons: [],
                errors: false
            };
        },
        mounted() {},
        methods: {
            /**
             * Load the category and prepare the edit form
             */
            edit: function (id) {
                this.errors = false;
                axios
                    .get('/account/categories/edit/'+id)
                    .then((response) => {
                        this.category = response.data['category'];
                        this.types = response.data['types'];
                        this.icons = response.data['icons'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * prepare the add form
             */
            add: function () {
                this.errors = false;
                var url = '/account/categories/edit/0';
                axios
                    .get(url)
                    .then((response) => {
                        this.category = response.data['category'];
                        this.types = response.data['types'];
                        this.icons = response.data['icons'];
                        $('#editModalBlock').modal();
                    })
            },
            /**
             * Save category
             */
            save: function() {
                let url = '/account/categories/';
                if (this.category.id) {
                    url = url + 'update/' + this.category.id;
                } else {
                    url = url + 'add';
                }
                axios
                    .post(url, this.category)
                    .then((response) => {
                        if (response.data['errors']) {
                            this.errors = response.data['errors'];
                        } else {
                            this.$root.$emit('category.changed');
                            $('#editModalBlock').modal('hide');
                        }
                    })
            }
        }
    }
</script>
