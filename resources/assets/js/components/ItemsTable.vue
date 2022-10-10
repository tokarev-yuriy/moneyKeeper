<template>
  <div>
    <table class="table align-items-center mb-0" v-if="items">
      <thead>
        <tr>
          <th 
            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" 
            v-for="th in head" :key="th.key"> 
            {{ th.title }}
          </th>
          <th class="text-secondary opacity-7"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td class="align-middle" v-for="th in head" :key="item.id + '|' + th.key">
            <h6 class="text-sm ps-3">{{item[th.key]}}</h6>
          </td>
          <td class="align-middle w-10">
            <a 
              v-if="item['actions'] && item['actions']['edit']"
              class="btn btn-link text-white px-3 mb-0 py-0" 
              href="javascript:;" @click="editItem(item)">
              <i class="fas fa-pencil-alt text-white me-2" aria-hidden="true"></i>Edit 
            </a>
            <br>
            <a
              v-if="item['actions'] && item['actions']['delete']" 
              class="btn btn-link text-danger text-gradient px-3 mb-0 py-0" 
              href="javascript:;" @click="deleteItem(item)">
              <i class="far fa-trash-alt me-2" aria-hidden="true"></i>Delete 
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "ItemsTable",
  props: ['data'],
  data() {
    return {
      items: [],
      head: [],
    }
  },
  watch: {
    data(value) {
      this.items = value.items;
      this.head = value.head;
    }
  },
  mounted() {
    this.items = this.data.items;
    this.head = this.data.head;
  },
  methods: {
    deleteItem(item) {
      this.$emit(item.actions.delete, item);
    },
    editItem(item) {
      this.$emit(item.actions.edit, item);
    },
  },
};
</script>
