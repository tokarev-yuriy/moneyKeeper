<template>
    <div class="container-fluid" id="totals-sum">
        План: {{plan | numberf}}
        <div class="progress total mb-2 mt-2" style="height: 2px;">
          <div class="progress-bar bg-info" role="progressbar" :aria-valuenow="plan" aria-valuemin="0" :aria-valuemax="max" :style="{width: plan_percent + '%'}"></div>
        </div>
        Расходы: {{spend | numberf}}
        <div class="progress total mb-2 mt-2" style="height: 2px;">
          <div class="progress-bar bg-danger" role="progressbar" :aria-valuenow="spend" aria-valuemin="0" :aria-valuemax="max" :style="{width: spend_percent + '%'}"></div>
        </div>
        Доход: {{income | numberf}}
        <div class="progress total mb-2 mt-2" style="height: 2px;">
          <div class="progress-bar bg-success" role="progressbar" :aria-valuenow="income" aria-valuemin="0" :aria-valuemax="max" :style="{width: income_percent + '%'}"></div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'period', 
            'type'
        ],
        data: function () {
            return {
                plan: 0,
                spend: 0,
                income: 0,
                max: 0,
                plan_percent: 0,
                spend_percent: 0,
                income_percent: 0,
                statType: false,
                statPeriod: false
            };
        },
        watch: {
            type: function () {
              this.statType = this.type;
            },
            period: function () {
              this.statPeriod = this.period;
              this.load();
            }
        },
        mounted() {
            this.load();
            this.$root.$on('operation.changed', data => {this.load();});
            this.$root.$on('category.changed', data => {this.load();});
        },
        methods: {
            /**
             *  Загрузка зон
             */
            load: function () {
                let url = '/account/stat/totals';
                if (this.statType) url = url + '/'+this.statType;
                if (this.statPeriod) {
                    let m = this.statPeriod.getMonth() + 1;
                    m = (m<10?"0":"") + m;
                    url = url + '/'+this.statPeriod.getFullYear()+"-"+m+"-"+this.statPeriod.getDate();
                }
                axios
                    .get(url)
                    .then((response) => {
                        this.plan = response.data['plan'];
                        this.spend = response.data['spend'];
                        this.income = response.data['income'];
                        this.max = response.data['max'];
                        this.plan_percent = response.data['plan_percent'];
                        this.spend_percent = response.data['spend_percent'];
                        this.income_percent = response.data['income_percent'];
                        if (!this.plan_percent) this.plan_percent = 0;
                        if (!this.spend_percent) this.spend_percent = 0;
                        if (!this.income_percent) this.income_percent = 0;
                    })
            }
        }
    }
</script>
