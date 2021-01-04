<template>
    <div class="container-fluid" id="wallets-sum">
    <slick ref="slick" :options="slickOptions" @setPosition="setPosition">
        <div class="card" v-for="group in groups">
            <h3 class="group-title text-nowrap">
                {{group.name}} 
                <span class="group-summ" :class="{'text-info': (group.summ==0), 'text-success': (group.summ>0), 'text-danger': (group.summ<0)}">{{group.summ | numberf}}</span>
            </h3>
            <div class="wallet" v-for="item in group.items" @click="editItem(item.id)">
              <div class="wallet-img" v-if="item.icon">
                  <i :class="item.icon" :alt="item.name" :style="'color: #'+item.color"></i>
              </div>
              <span class="wallet-title text-nowrap">{{item.name}}</span>
              <span class="wallet-summ" :class="{'text-info': (item.value==0), 'text-success': (item.value>0), 'text-danger': (item.value<0)}">{{item.value | numberf}}</span>
            </div>
        </div>
    </slick>
    </div>
</template>

<script>
    import Slick from 'vue-slick';
    
    export default {
        components: {
           Slick
        },
        data: function () {
            return {
                slickOptions: {
                  speed: 300,
                  arrows: false,
                  infinite: false,
                  slidesToShow: 1,
                  variableWidth: true,
                  
                },
                groups:[]
            };
        },
        mounted() {
            this.load();
            this.$root.$on('operation.changed', data => {this.load();});
            this.$root.$on('wallet.changed', data => {this.load();});
        },
        methods: {
            /**
             *  Загрузка зон
             */
            load: function () {
            
                axios
                    .get('/account/stat/wallets')
                    .then((response) => {
                        if (this.$refs.slick) {
                            this.$refs.slick.destroy();
                        }
                        this.groups = response.data['groups'];
                        this.$nextTick(function () {
                            if (this.$refs.slick) {
                                this.$refs.slick.create(this.slickOptions);
                                this.$refs.slick
                            }
                        });
                    })
            },
            /**
             *  Редактирование записи
             */
            editItem: function (id) {
                
            },
            /**
             *  SetPosition handle
             */
            setPosition: function(event, slick) {
                var slickTrack = $(slick.$slideTrack);
                var slickTrackHeight = 0;
                $(slickTrack).find('.slick-slide .card').each(function(){
                    if ($(this).height()>slickTrackHeight) {
                        slickTrackHeight = $(this).height();
                    }
                });
                
                $(slickTrack).find('.slick-slide .card').css('height', slickTrackHeight + 'px');
            }
        }
    }
</script>
