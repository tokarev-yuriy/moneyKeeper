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
        data: function () {
            return {
                plan: 0,
                spend: 0,
                income: 0,
                max: 0,
                plan_percent: 0,
                spend_percent: 0,
                income_percent: 0,
            };
        },
        mounted() {
            this.load()
        },
        methods: {
            /**
             *  Загрузка зон
             */
            load: function () {
                axios
                    .get('/account/stat/totals')
                    .then((response) => {
                        this.plan = response.data['plan'];
                        this.spend = response.data['spend'];
                        this.income = response.data['income'];
                        this.max = response.data['max'];
                        this.plan_percent = response.data['plan_percent'];
                        this.spend_percent = response.data['spend_percent'];
                        this.income_percent = response.data['income_percent'];
                        
                    })
            }
        }
    }
</script>
