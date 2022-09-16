<template>
  <div
    class="page-header align-items-start min-vh-100"
  >
  </div>
</template>

<script>
import { logoutService } from "../api/auth.js";

export default {
  name: "log-out",
  mounted() {
    this.logout();
  },
  methods: {
    async logout() {
      this.errors = false;
      try {
        await logoutService();
        this.$router.push({path: '/auth/login'});
      } catch(error) {
        this.errors = error.errors;
      }
    },
  },
};
</script>
