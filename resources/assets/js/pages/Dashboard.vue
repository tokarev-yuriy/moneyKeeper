<template>
  <div>
  </div>
</template>

<script>
import { mapMutations } from "vuex";

export default {
  name: "dashboard",
  data() {
    return {
    }
  },
  computed: {
    isLoggedIn: function() {
      return this.$store.getters['auth/isLoggedIn'];
    }
  },
  beforeMount() {
    this.toggleEveryDisplay();
    if (!this.isLoggedIn) {
      //this.$router.push({path: '/auth/login'});
    }
  },
  beforeUnmount() {
    this.toggleEveryDisplay();
  },
  methods: {
    ...mapMutations(["toggleEveryDisplay"]),
  },
};
</script>
