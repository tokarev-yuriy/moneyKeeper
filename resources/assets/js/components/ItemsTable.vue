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
            <h6 class="text-sm ps-3" v-html="item[th.key]"></h6>
          </td>
          <td class="align-middle w-10">
            <a 
              v-if="item['actions'] && item['actions']['edit']"
              @click="editItem(item)"
              rel="tooltip" 
              class="btn btn-success btn-link" 
              href="javascript: void(0);"
            >
              <i class="material-icons">edit</i>
              <div class="ripple-container"></div>
            </a>
            <button 
              v-if="item['actions'] && item['actions']['delete']" 
              type="button" 
              class="btn btn-danger btn-link ms-1"
              @click="deleteItem(item)"
            >
              <i class="material-icons">close</i>
              <div class="ripple-container"></div>
            </button>
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
