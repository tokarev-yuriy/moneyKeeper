<template>
    <div id="operationsFilter">
        <div v-if="fields" class="card container p-2 rounded-top mt-2">
            <form class="form-inline">
                <div class="row w-100 pl-4">
                    <div v-for="field in fields">
                        <div v-if="field.type=='period'">
                            <input type="date" v-model="filter[field.code].from" class="form-control" @change="applyFilter()">&nbsp;&mdash;&nbsp;<input type="date" v-model="filter[field.code].to" class="form-control mr-2" @change="applyFilter()">
                        </div>
                        <div v-else-if="field.type=='list'">
                            <multi-select v-model="filter[field.code]" :items="field.values" @change="applyFilter()"/>
                        </div>
                        <div v-else>
                            <input type="text" v-model="filter[field.code]" class="form-control mr-2" @change="applyFilter()">
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
                fields: {},
                filter: {}
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
                this.fields = values;
                let x;
                for (x in values) {
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
                        this.$root.$emit('operationchanged');
                    })
                return false;
            },
        }
    }
</script>
