<template>
    <div>
      <a class="btn btn-secondary" href="javascript:void(0);" role="button" @click="select()">
        {{ this.title }}
        <span class="badge badge-info">{{ this.selected.length }}</span>
      </a>
      
      <div class="modal fade" :id="'multiSelectModalBlock-'+code" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">{{ this.title }}</h4>    
                <button type="button" class="close" data-dismiss="modal" :aria-label="'mkeep_tablegrid.close'|trans">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">                
                <span v-for="dropItem in items">
                    <a v-if="!dropItem.is_group" :class="{'btn': true, 'btn-outline-secondary': !isSelected(dropItem.id), 'btn-info': isSelected(dropItem.id)}" href="javascript: void(0);" @click="toggleItem(dropItem.id)">
                        <i v-if="dropItem.icon" :class="'fas fa-'+dropItem.icon" :alt="dropItem.name"></i> {{ dropItem.name }}
                    </a>
                </span>
                <div class="row form-group">
                    <div class="col-6 pl-0">
                        <button type="button" class="btn btn-primary" @click="clear()">
                            <i class="fa fa-btn fa-remove"></i> {{ 'mkeep.all_items' | trans }}
                        </button>
                    </div>
                    <div class="col-6 pr-0">
                        <button type="button" class="btn btn-success  pull-right" @click="apply()">
                            <i class="fa fa-btn fa-filter"></i> {{ 'mkeep_tablegrid.filter' | trans }}
                        </button>
                    </div>
                 </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['items', 'value', 'code', 'title'],
        data: function () {
            return {
                selected: []
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
                if (Array.isArray(val)) {
                    this.selected = val;
                } else {
                    if (val) {
                        this.selected = [val];
                    }
                }
			},
            /**
             *  Update value for "v-model" compability
             */
            toggleItem: function (itemId) {
                if (this.isSelected(itemId)) {
                    this.selected = this.selected.filter(function(value){ return value != itemId;});
                } else {
                    this.selected.push(itemId);
                }
				this.$emit('input', this.selected);
			},
            /**
             *  Open popup
             */
            select: function() {
                $('#multiSelectModalBlock-'+this.code).modal('show');
            },
            /**
             *  Check if item is selected
             */
            isSelected: function (itemId) {
                if (this.selected && this.selected.indexOf(itemId)>=0) return true;
                return false;
            },
            /**
             *  Clear Multiselect
             */
            clear: function () {
                this.selected = [];
                this.apply();
            },
            /**
             *  Apply multiselecct
             */
            apply: function() {
                this.$emit('input', this.selected);
                this.$emit('change');
                $('#multiSelectModalBlock-'+this.code).modal('hide');
            }
        }
    }
</script>