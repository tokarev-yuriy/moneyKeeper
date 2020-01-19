<template>
    <div class="row  justify-content-center" id="progressWidget">
      <div 
        v-for="category in categories" 
        class="categories-widget card" 
        @click="addSpend(category.id)">
          <div class="categories-icon" v-if="category.icon"><img :src="category.icon"></div>
          <div class="categories-info">
            <span class="text-dark">{{ category.name }}</span>
            <br/>
            <span :class="{'text-success': (category.sum <= category.plan),'text-danger': (category.sum > category.plan)}">{{ category.sum }} / <span class="text-secondary">{{ category.plan }}</span></span>
          </div>
          
          <div class="progress total mb-2 mt-2" style="height: 2px;">
            <div class="progress-bar" :class="{'bg-success': (category.sum <= category.plan),'bg-danger': (category.sum > category.plan)}" role="progressbar" :aria-valuenow="category.sum" aria-valuemin="0" :aria-valuemax="category.plan"   :style="{width: category.progress + '%'}">                                
            </div>                
          </div>
      </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                categories: []
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
                    .get('/account/stat/progress')
                    .then((response) => {
                        this.categories = response.data['categories'];
                    })
            },
            /**
             *  Добавляем новый расход
             */
            addSpend: function(categoryId) {
                let url = '/account/operations/spend/add?category_id=' + categoryId;
            }
        }
    }
</script>
