<template>
  <div>
    <div :class="'dropdown ' + selectClass">
      <a href="#" class="btn bg-gradient-light dropdown-toggle " data-bs-toggle="dropdown" id="dropdownColors">
          <span v-html="selected"></span>
      </a>
      <div class="dropdown-menu" aria-labelledby="dropdownColors">
          <a class="dropdown-item" href="javascript: void(0);" 
            v-for="item in items" :key="item.id" 
            @click="$emit('change', item.id)">
            <span v-html="item.option"></span>
          </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Dropdown",
  props: ['options', 'selectClass', 'value'],
  data() {
    return {
      items: this.options,
      selected: this.value,
    }
  },
  watch: {
    options(value) {
      this.items = value;
    },
    value(value) {
      this.selected = value;
    }
  },
  mounted() {},
  methods: {},
};
</script>


<style scoped>
  /* Columns */
  div.dropdown-icons .dropdown-menu {
    width: 10em;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
  }
  div.dropdown-icons .dropdown-menu > .dropdown-item{
    display:inline-block;
    width: 3rem;
  }
  div.dropdown-icons .dropdown-toggle i {
    position: absolute;
    margin-left: 0.3rem;
  }
  div.dropdown-icons .dropdown-toggle::after {
    margin-left: 2rem;
  }

  /* Columns */
  div.dropdown-colors .dropdown-menu {
    width: 10em;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
  }
  div.dropdown-colors .dropdown-menu > .dropdown-item{
    display:inline-block;
    width: 3rem;
  }
  div.dropdown-colors .dropdown-toggle i {
    position: absolute;
    margin-left: 0.3rem;
  }
  div.dropdown-colors .dropdown-toggle::after {
    margin-left: 2rem;
  }
  div.w100 .dropdown-toggle {
    width: 100%;
  }
  div.error-field .dropdown-toggle {
    outline: 2px solid var(--bs-danger);
  }
</style>