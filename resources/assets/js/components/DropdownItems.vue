<template>
    <div class="dropdown show dropdown-with-icons">
      <a class="btn btn-secondary dropdown-toggle" href="javascipt:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span v-if="item">
			<i v-if="item.icon" :class="'fas fa-'+item.icon" :alt="item.name"></i> {{ item.name }}
		</span>
      </a>

      <div class="dropdown-menu">
        <span v-for="dropItem in items">
            <h6 v-if="dropItem.is_group" class="dropdown-header">{{dropItem.name}}</h6>
            <a v-if="!dropItem.is_group" class="dropdown-item" href="javascript: void(0);" @click="updateValue(dropItem.id)">
                <i v-if="dropItem.icon" :class="'fas fa-'+dropItem.icon" :alt="dropItem.name"></i> {{ dropItem.name }}
            </a>
		</span>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['items', 'value', 'size'],
        data: function () {
            return {
                itemId: false,
                item: false,
            };
        },
        watch: {
            value: function () {
              this.setValue(this.value);
            }
        },
        mounted() {
            this.setValue(this.value);
		},
        methods: {
            /**
             *  Set value
             */
            setValue: function (val) {
                this.itemId = val;
                for (var x in this.items) {
                    if (this.items[x] && this.items[x].id == this.itemId) {
                        this.item = this.items[x];
                    }
                }                
			},
            /**
             *  Update value for "v-model" compability
             */
            updateValue: function (value) {
                this.setValue(value);
				this.$emit('input', value);
			}
        }
    }
</script>