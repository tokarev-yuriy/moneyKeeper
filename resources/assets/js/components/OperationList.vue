<template>
    <div>
    
        <div class="card" style="border-radius: 0;" v-if="!operations">
            <div class="card-header" v-if="operations===false"><h3>mkeep.loading</h3></div>
            <div class="card-header" v-else=""><h3>mkeep.no_data</h3></div>
        </div>
        <div v-for="operation in operations" :class="{'mt-0': operation.date && operation.date!=date}" class="card mb-0" style="border-radius: 0;">
          <div class="card-header card-header-info" style="width: auto;" v-if="operation.date && operation.date!=date">
            <h4 class="card-title" style="width: auto;" :set="date = operation.date">{{ operation.date }}</h4>
          </div>
            <div class="card-body p-2" :class="'bg-'+operation.type">
              <div class="col-12">
                <div class="card-btns pl-2">
                        <a  v-if="actions.indexOf('edit')>=0 && operation.editPath"
                            class="btn btn-info" data-btn-type="edit" :href="operation.editPath" :data-title="operation.editTitle"><i class="material-icons">edit</i></a>
                        <a  v-if="actions.indexOf('delete')>=0 && operation.deletePath"
                            class="btn btn-dark" data-btn-type="edit" :href="operation.deletePath" :data-title="operation.deleteTitle"><i class="material-icons">close</i></a>
                </div>
                <div class="row">
                  <div class="col-8">
                        <div v-if="header.category_id && categories[operation.category_id]" class="category-icon"
                            :class="{'bg-danger': operation.type=='spend', 'bg-success': operation.type=='income', 'bg-secondary': operation.type=='transfer'}">
                            <img v-if="categoryIcons[operation.category_id]" :src="categoryIcons[operation.category_id]" :alt="categories[operation.category_id]">
                        </div>
                        <h4 v-if="header.category_id && categories[operation.category_id]">{{ categories[operation.category_id] }}</h4>
                        <span v-if="header.wallet">{{ operation.wallet }}</span>
                        <span v-else-if="header.wallet_from_id && walletsFrom[operation.wallet_from_id]">{{ walletsFrom[operation.wallet_from_id] }}</span>
                        <span v-else-if="header.wallet_to_id && walletsTo[operation.wallet_to_id]">{{ walletsTo[operation.wallet_to_id] }}</span>
                    </div>                    
                    <div class="col-4  text-right">
                      <span v-if="header.value" class="h3"
                        :class="{'text-danger': operation.type=='spend', 'text-success': operation.type=='income', 'text-secondary': operation.type=='transfer'}">
                          <span v-if="operation.type=='spend'">-</span>
                          <span v-else-if="operation.type=='income'">-</span>
                          {{operation.value | numberf}}
                      </span>
                      <div v-if="header.comment" class="text-secondary card-comment">{{ operation.comment }}</div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                operations: false,
                date: false,
                header: [],
                actions: [],
                walletsTo: [],
                walletsFrom: [],
                categories: [],
                categoryIcons: [],
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
                    .get('/account/operations')
                    .then((response) => {
                        this.operations = response.data['operations'].data;
                        this.header = response.data['header'];
                        this.actions = response.data['actions'];
                        this.walletsTo = response.data['dicts']['wallet_to_id'];
                        this.walletsFrom = response.data['dicts']['wallet_from_id'];
                        this.categories = response.data['dicts']['category_id'];
                        this.categoryIcons = response.data['dicts']['category_icon'];
                        this.data = false;
                    })
            }
        }
    }
</script>
