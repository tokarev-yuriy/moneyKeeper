<template>
    <div class="row  justify-content-center" id="progressWidget">
      <div
        v-for="category in categories" 
        class="categories-widget card" 
        @click="addSpend(category.id)">
          <div class="categories-icon" v-if="category.icon"><i :class="'fas fa-'+category.icon"></i></div>
          <div class="categories-info">
            <span class="text-dark">{{ category.name | cuttext}}</span>
            <br/>
            <span :class="{'text-success': (category.sum <= category.plan),'text-danger': (category.sum > category.plan)}">{{ category.sum }} / <span class="text-secondary">{{ category.plan }}</span></span>
          </div>
          
          <div class="progress total">
            <div class="progress-bar" :class="{'bg-success': (category.sum <= category.plan),'bg-danger': (category.sum > category.plan)}" role="progressbar" :aria-valuenow="category.sum" aria-valuemin="0" :aria-valuemax="category.plan"   :style="{width: category.progress + '%'}">                                
            </div>                
          </div>
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
                categories: [],
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
            this.categories = [];
            this.load();
            this.$root.$on('operation.changed', data => {this.load();});
            this.$root.$on('category.changed', data => {this.load();});
        },
        methods: {
            /**
             *  Загрузка зон
             */
            load: function () {
                let url = '/account/stat/progress';
                if (this.statType) url = url + '/'+this.statType;
                if (this.statPeriod) {
                    let m = this.statPeriod.getMonth() + 1;
                    m = (m<10?"0":"") + m;
                    url = url + '/'+this.statPeriod.getFullYear()+"-"+m+"-"+this.statPeriod.getDate();
                }
                axios
                    .get(url)
                    .then((response) => {
                        this.categories = response.data['categories'];
                    })
            },
            /**
             *  Добавляем новый расход
             */
            addSpend: function(categoryId) {
                this.$root.$emit('categoryclick', categoryId);
            }
        }
    }
</script>
