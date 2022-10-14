<template></template>

<script>
import { mapMutations } from "vuex";

export default {
  name: "LoadingMixin",
  data() {
    return {
      isLoading: false,
      qTimeout: false,
    }
  },
  beforeMount() {
    this.toggleEveryDisplay();
  },
  beforeUnmount() {
    this.toggleEveryDisplay();
  },
  methods: {
    ...mapMutations(["toggleEveryDisplay"]),
  },
};
</script>
