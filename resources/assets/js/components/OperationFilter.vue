<template>
    <div id="operationsFilter">
        <div v-if="fields" class="card container p-2 rounded-top mt-2">
            <form class="form-inline">
                <div class="row w-100 pl-4">
                    <div class="col-6">
                        <input type="date" v-model="filter['date']['from']" class="form-control" @change="applyFilter()">&nbsp;&mdash;&nbsp;<input type="date" v-model="filter['date']['to']" class="form-control mr-2" @change="applyFilter()">
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <multi-select v-model="filter['category_id']" :items="fields['category_id']['values']" :code="fields['category_id'].code" :title="fields['category_id'].title"  @change="applyFilter()"/>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <multi-select v-model="filter['wallet_id']" :items="fields['wallet_id']['values']" @change="applyFilter()" :code="fields['wallet_id'].code" :title="fields['wallet_id'].title"/>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['filters'],
        data: function () {
            return {
                fields: {
                    'date': {},
                    'category_id': {
                        'code': false,
                        'title': false,
                        'values': [],
                    },
                    'wallet_id': {
                        'code': false,
                        'title': false,
                        'values': [],
                    },
                },
                filter: {
                    'date': {'from':false, 'to': false},
                    'category_id': false,
                    'wallet_id': false,
                }
            };
        },
        watch: {
            filters: function (newVal, oldVal) {
                this.setFields(this.filters);
            }
        },
        mounted() {
            this.setFields(this.filters);
        },
        methods: {
            /**
             *  Set filters
             */
            setFields: function (values) {
                let x;
                for (x in values) {
                    this.fields[x] = values[x];
                    this.filter[values[x].code] = values[x].value;
                    if (!this.filter[values[x].code] && values[x].type=='period') {
                        this.filter[values[x].code] = {'from':false, 'to': false};
                    }
                }
            },
            /**
             *  Apply Filter
             */
            applyFilter: function () {
                axios
                    .post('/account/operations/filter', this.filter)
                    .then((response) => {
                        this.$root.$emit('operation.changed');
                    })
                return false;
            },
        }
    }
</script>
