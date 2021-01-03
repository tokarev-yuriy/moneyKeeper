<template>
    <div>
        <div class="d-flex justify-content-center" v-if="!hideyear">
            <div class="btn-group" role="group">
              <a :class="{'btn': true, 'btn-dark': type=='month', 'btn-secondary': type!='month'}" href="javascript: void(0);" @click="setType('month')">{{ 'mkeep.per_month' | trans }}</a>
              <a :class="{'btn': true, 'btn-dark': type=='year', 'btn-secondary': type!='year'}" href="javascript: void(0);" @click="setType('year')">{{ 'mkeep.per_year' | trans }}</a>
            </div>
        </div>

        <ul class="nav nav-pills justify-content-center mt-3 mb-3">
          <li class="nav-item">
            <a class="nav-link text-secondary" href="javascript: void(0);" @click="prevPeriod"><i class="fa fa-arrow-left fa-lg" aria-hidden="true"></i></a>
          </li>
           <li class="nav-item">
            <a class="nav-link active" href="javascript: void(0);">{{ periodLbl }}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary" href="javascript: void(0);" @click="nextPeriod"><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
          </li>
        </ul>
        
        <plancategories-component :period="period" :type="type"></plancategories-component>

        <planstat-component :period="period" :type="type"></planstat-component>
    </div>
</template>

<script>
    export default {
        props: ['hideyear'],
        data: function () {
            return {
                type: false,
                period: false
            };
        },
        computed: {
            // геттер вычисляемого значения
            periodLbl: function () {
              if (this.period) {
                if (this.type=='month') {
                    return this.period.toLocaleString('ru', {month: 'long', year: 'numeric'});
                } else {
                    return this.period.getFullYear();
                }
              }
            }
        },
        mounted() {
            this.type='month';
            let d = new Date();
            d.setDate(1);
            this.period = d;
        },
        methods: {
            /**
             *  Change stat type
             */
            setType: function(type) {
                if (type!=this.type) {
                    this.type = type;
                    let d = new Date();
                    d.setTime(this.period.getTime())
                    this.period = d;
                }
            },
            /**
             *  Prev Period
             */
            prevPeriod: function() {
                let d = new Date();
                d.setTime(this.period.getTime())
                if (this.type=='month') {
                    d.setMonth(d.getMonth()-1);
                } else {
                    d.setFullYear(d.getFullYear()-1);
                }
                this.period = d;
            },
            /**
             *  Next Period
             */
            nextPeriod: function() {
                let d = new Date();
                d.setTime(this.period.getTime())
                if (this.type=='month') {
                    d.setMonth(d.getMonth()+1);
                } else {
                    d.setFullYear(d.getFullYear()+1);
                }
                this.period = d;
            }
        }
    }
</script>
