<template>
    <div id="operationsFilter">
        <div v-if="fields" class="card container p-2 rounded-top mt-2">
            <form class="form-inline">
				<div class="row justify-content-between w-100 pl-4">
					<div v-for="field in fields" :class="{'col-12 col-md-6': field.type=='period', 'col-6 col-md-3': field.type!='period'}">
						<span v-if="field.type=='period'">
							<input type="date" v-model="filter[field.code].from" class="form-control">&nbsp;&mdash;&nbsp;<input type="date" v-model="filter[field.code].to" class="form-control mr-2">
						</span>
						<span v-else-if="field.type=='list'">
							<dropdown-items v-model="filter[field.code]" :items="field.values"/>
						</span>
						<span v-else>
							<input type="text" v-model="filter[field.code]" class="form-control mr-2">
						</span>
					</div>
					<div class="col-6 col-md-3 text-right">
						<button type="submit" class="btn btn-info">
							<i class="fa fa-btn fa-filter"></i> {{ 'mkeep_tablegrid.filter' | trans }}
						</button>
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
        }        
    }
</script>
