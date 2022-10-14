<template>
  <div>
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Account Groups</h6>
              </div>
              <div class="row mt-3">
                <div class="col-12 text-end">
                  <button class="btn mb-0 bg-gradient-dark btn-md" @click="addItem">
                    <i class="fas fa-plus me-2" aria-hidden="true"></i> Add New Account Group
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
import { accountGroupListService } from "../../api/accountGroup.js";
import ItemsTable from '../../components/ItemsTable.vue';
import LoadingMixin from "../../mixins/LoadingMixin.vue";
import ErrorsMixin from "../../mixins/ErrorsMixin.vue"

export default {
  name: "AccountGroupIndex",
  components: {
    ItemsTable,
  },
  mixins: [LoadingMixin, ErrorsMixin],
  data() {
    return {
      items: [],
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
            title: 'Sort',
            key: 'sort'
          },
        ],
        items: []
      };
      for (let item of this.items) {
        data.items.push({
          ...item,
          actions: {edit: 'edit', delete: 'delete'} 
        });
      }
      return data;
    }
  },
  mounted() {
    this.getData();
    this.readMessages();
  },
  methods: {
    async getData() {
      try {
        let data = await accountGroupListService();
        this.items = data.items;
      } catch (e) {
        this.parseException(e);
      }
    },
    deleteItem(item) {
      this.$router.push({path: '/account/groups/' + item.id + '/delete'});
    },
    editItem(item) {
      this.$router.push({path: '/account/groups/' + item.id});
    },
    addItem() {
      this.$router.push({path: '/account/groups/new'});
    }
  },
};
</script>
