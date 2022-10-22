<template>
  <div class="card card-body mx-3 mx-md-4 mt-3">
    <div class="pb-0 card-header bg-transparent mb-4">
      <h4 class="font-weight-bolder">Account</h4>
    </div>
    <div class="card-body">
      <form role="form" v-if="!isLoading">
        <div class="row">
          <div class="mb-3 col-md-6">
            <material-input
              id="name"
              type="text"
              label="Name"
              v-model="item.name"
              size="lg"
              :error="errors && errors['name']"
            />
          </div>
          <div class="mb-2 col-md-3">
            <material-input
              id="startBalance"
              type="number"
              label="Opening balance"
              v-model="item.startBalance"
              size="lg"
            />
          </div>
          <div class="mb-1 col-md-3">
            <material-input
              id="sort"
              type="number"
              label="Sort"
              v-model="item.sort"
              size="lg"
            />
          </div>
        </div>
        <div class="row">
          <div class="mb-3 col-md-6" :class="{'error-field': errors && errors['groupId']}">
            <dropdown :value="selectedGroup" @change="selectGroup" :options="groupOptions" select-class="w100" />
          </div>
          <div class="mb-1 col-md-3" :class="{'error-field': errors && errors['icon']}">
            <dropdown select-class="dropdown-icons w100" :value="selectedIcon" @change="selectIcon" :options="iconOptions" />
          </div>
          <div class="mb-2 col-md-3" :class="{'error-field': errors && errors['color']}">
            <dropdown select-class="dropdown-colors w100" :value="selectedColor" @change="selectColor" :options="colorOptions" />
          </div>
        </div>
        <div v-if="error">
          <material-alert color="danger"><span v-html="error"></span></material-alert>
        </div>
        <div class="text-end">
          <material-button
            class="mt-4"
            variant="gradient"
            color="dark"
            size="lg"
            @click="saveData"
            >Save</material-button
          >
        </div>
      </form>
    </div>
    <div class="position-fixed top-2 end-2 z-index-2">
      <material-snackbar
        v-if="success"
        :title="success"
        date=""
        description=""
        :icon="{ component: 'done', color: 'white' }"
        color="success"
        :closeHandler="closeSuccess"
      />
    </div>
  </div>
</template>

<script>
import { accountDetailService, accountAddService, accountUpdateService } from "../../api/account.js";
import { accountGroupListService } from "../../api/accountGroup.js";
import LoadingMixin from "../../mixins/LoadingMixin.vue";
import ErrorsMixin from "../../mixins/ErrorsMixin.vue";
import MaterialInput from "../../md2/components/MaterialInput.vue";
import MaterialCheckbox from "../../md2/components/MaterialCheckbox.vue";
import MaterialButton from "../../md2/components/MaterialButton.vue";
import MaterialAlert from "../../md2/components/MaterialAlert.vue";
import MaterialSnackbar from "../../md2/components/MaterialSnackbar.vue";
import Dropdown from "../../components/Dropdown.vue";

export default {
  name: "AccountEdit",
  mixins: [LoadingMixin, ErrorsMixin],
  data() {
    return {
      item: {
        name: '',
        color: '',
        groupId: false,
        sort: '10',
        startBalance: 0
      },
      id: this.$route.params['id'],
      groups: [],
    }
  },
  computed: {
    icons() {
      return this.$store.getters['registry/getIcons'];
    },
    colors() {
      return this.$store.getters['registry/getColors'];
    },
    groupOptions() {
      let options = [];
      for(let x in this.groups) {
        let group = this.groups[x];
        options.push({
          id: group.id,
          option: group.name,
        });
      }
      return options;
    },
    selectedGroup() {
      if (this.item.groupId) {
        for(let x in this.groups) {
          let group = this.groups[x];
          if (group.id == this.item.groupId) {
            return 'Group: ' + group.name;
          }
        }
      }
      return 'Group: No group';
    },
    iconOptions() {
      let options = [];
      for(let x in this.icons) {
        let icon = this.icons[x];
        options.push({
          id: icon,
          option: '<i class="material-icons-round opacity-10 fs-5">' + icon + '</i>',
        });
      }
      return options;
    },
    selectedIcon() {
      if (this.item.icon) {
        return 'Icon: <i class="material-icons-round opacity-10 fs-5" ' + 
               'style="position: absolute; margin-left: 0.3rem;">' + this.item.icon + '</i>';
      }
      return 'Icon: ';
    },
    colorOptions() {
      let options = [];
      for(let x in this.colors) {
        let color = this.colors[x];
        options.push({
          id: color,
          option: '<i class="material-icons-round opacity-10 fs-5" style="color: #' + color + '">circle</i>',
        });
      }
      return options;
    },
    selectedColor() {
      if (this.item.color) {
        return 'Color: <i class="material-icons-round opacity-10 fs-5" ' + 
              'style="color: #' + this.item.color + '; position: absolute; margin-left: 0.3rem;">circle</i>';
      }

      return 'Color: ';
    }
  },
  components: {
    MaterialInput,
    MaterialCheckbox,
    MaterialButton,
    MaterialAlert,
    MaterialSnackbar,
    Dropdown,
  },
  mounted() {
    this.getData();
  },
  methods: {
    selectIcon(value) {
      this.item.icon = value;
    },
    selectColor(value) {
      this.item.color = value;
    },
    selectGroup(value) {
      this.item.groupId = value;
    },
    async getData() {
      this.isLoading = true;
      try {
        if (this.id != 'new') {
          let data = await accountDetailService(this.id);
          this.item = data.item;
        }
        let groups = await accountGroupListService();
        this.groups = groups.items;
      } catch (e) {
        this.parseException(e);
      }
      this.isLoading = false;
    },
    async saveData() {
      this.clearErrors();
      this.isLoading = true;
      try {
        let data;
        if (this.id == 'new') {
          data = await accountAddService(this.item);
          this.$store.dispatch('messages/add', {
            type: 'info',
            message: 'Account has been added'
          });
          this.$router.push({path: '/accounts'});
        } else {
          data = await accountUpdateService(this.id, this.item);
          this.$store.dispatch('messages/add', {
            type: 'info',
            message: 'Account has been updated'
          });
          this.$router.push({path: '/accounts'});
        }
        this.item = data.item;
      } catch (e) {
        this.parseException(e);
      }
      this.isLoading = false;
    }
  },
};
</script>