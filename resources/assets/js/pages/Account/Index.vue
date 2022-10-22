<template>
  <div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Accounts</h6>
              </div>
              <div class="row mt-3">
                <div class="col-12 text-end">
                  <button class="btn mb-0 bg-gradient-dark btn-md" @click="addItem">
                    <i class="fas fa-plus me-2" aria-hidden="true"></i> Add New Account
                  </button>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2" v-if="items">
              <div class="table-responsive p-0">
                <items-table :data="itemsData" @edit="editItem" @delete="deleteItem"></items-table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="position-fixed top-2 end-2 z-index-2" v-if="messages">
      <material-snackbar
        v-for="message in messages"
        :key="message.message"
        :title="message.message"
        date=""
        description=""
        :icon="{ component: 'done', color: 'white' }"
        :color="message.type"
        :closeHandler="closeMessage"
      />
    </div>
  </div>
</template>

<script>
import { accountListService } from "../../api/account.js";
import { accountGroupListService } from "../../api/accountGroup.js";
import ItemsTable from '../../components/ItemsTable.vue';
import LoadingMixin from "../../mixins/LoadingMixin.vue";
import ErrorsMixin from "../../mixins/ErrorsMixin.vue"

export default {
  name: "AccountIndex",
  components: {
    ItemsTable,
  },
  mixins: [LoadingMixin, ErrorsMixin],
  data() {
    return {
      items: [],
      groups: [],
    }
  },
  computed: {
    itemsData() {
      let data = {
        head: [
          {
            title: 'Name',
            key: 'name'
          },
          {
            title: 'Group',
            key: 'groupHtml'
          },
          {
            title: 'Color',
            key: 'colorHtml'
          },
          {
            title: 'Icon',
            key: 'iconHtml'
          },
          {
            title: 'Opening balance',
            key: 'startBalance'
          },
          {
            title: 'Sort',
            key: 'sort'
          },
        ],
        items: []
      };
      for (let item of this.items) {
        console.log([item.groupId, this.getGroupName(item.groupId)]);
        item['groupHtml'] = this.getGroupName(item.groupId);
        item['iconHtml'] = this.getIcon(item.icon);
        item['colorHtml'] = this.getColor(item.color);
        data.items.push({
          ...item,
          actions: {edit: 'edit', delete: 'delete'} 
        });
      }
      return data;
    },
    icons() {
      return this.$store.getters['registry/getIcons'];
    },
    colors() {
      return this.$store.getters['registry/getColors'];
    },
  },
  mounted() {
    this.getData();
    this.readMessages();
  },
  methods: {
    async getData() {
      try {
        let groups = await accountGroupListService();
        this.groups = groups.items;
        let data = await accountListService();
        this.items = data.items;
      } catch (e) {
        this.parseException(e);
      }
    },
    deleteItem(item) {
      this.$router.push({path: '/accounts/' + item.id + '/delete'});
    },
    editItem(item) {
      this.$router.push({path: '/accounts/' + item.id});
    },
    addItem() {
      this.$router.push({path: '/accounts/new'});
    },
    getIcon(icon) {
      if (!icon) {
        return '';
      }
      return '<i class="material-icons-round opacity-10 fs-5" ' + 
            'style="position: absolute; margin-left: 0.3rem;">' + icon + '</i>';
    },
    getColor(color) {
      if (!color) {
        return '';
      }
      return '<i class="material-icons-round opacity-10 fs-5" ' + 
              'style="color: #' + color + '; position: absolute; margin-left: 0.3rem;">circle</i>';
    },
    getGroupName(groupId) {
      for (let x in this.groups) {
        if (groupId == this.groups[x].id) {
          return this.groups[x].name;
        }
      }
      return '&mdash;';
    }
  },
};
</script>
