<template>
    <div class="dropdown show dropdown-with-icons" id="operationFilterDrop">
      <a class="btn btn-secondary dropdown-toggle" href="javascipt:void(0);" role="button" data-toggle="dropdown" :data-boundary="boundary" aria-haspopup="true" aria-expanded="false">
		<span v-if="item">
			<i v-if="item.icon" :class="'fas fa-'+item.icon" :alt="item.name"></i> {{ item.name }}
		</span>
      </a>

      <div class="dropdown-menu">
        <span v-for="dropItem in items">
            <h6 v-if="dropItem.is_group" class="dropdown-header">{{dropItem.name}}</h6>
            <a v-if="!dropItem.is_group && (!typeFilter || !dropItem['type'] || dropItem.type=='any' || typeFilter==dropItem.type)" class="dropdown-item" href="javascript: void(0);" @click="updateValue(dropItem.id)">
                <i v-if="dropItem.icon" :class="'fas fa-'+dropItem.icon" :alt="dropItem.name"></i> {{ dropItem.name }}
            </a>
		</span>
      </div>
    </div>
</template>

<script>
    export default {
        props: ['items', 'value', 'size', 'boundary', 'type'],
        data: function () {
            return {
                itemId: false,
                item: false,
                typeFilter: false,
            };
        },
        watch: {
            value: function () {
              this.setValue(this.value);
            },
            type: function () {
              this.setType(this.type);
            },
            items: function () {
              this.setValue(this.value);
            },
        },
        mounted() {
            this.setValue(this.value);
            this.setType(this.type);
		},
        methods: {
            /**
             *  Set value
             */
            setValue: function (val) {
                if (!val) return this.setDefault();
            
                this.itemId = val;
                for (var x in this.items) {
                    if (this.items[x] && this.items[x].id == this.itemId) {
                        this.item = this.items[x];
                    }
                }
                
                if (!this.item) this.setDefault();
			},
            /**
             *  Set Type
             */
            setType: function (type) {
                if (type!=this.typeFilter) {
                    this.typeFilter = type;
                    if (type && this.item.type && this.item.type!='any' && this.item.type!=type) {
                        this.setValue(false);
                    }
                }
			},
            /**
             *  Set default value
             */
            setDefault: function () {
                this.itemId = false;
                this.item = false;
                for (var x in this.items) {
                    let _item = this.items[x];
                    if (this.typeFilter && _item.type && _item.type!='any' && _item.type!=this.typeFilter) continue;
                    if (_item.is_group) continue;
                    this.itemId = _item.id;
                    this.item = _item;
                    break;
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