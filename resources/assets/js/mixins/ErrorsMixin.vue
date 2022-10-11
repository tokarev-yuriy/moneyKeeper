<template></template>

<script>
export default {
  name: "LoadingMixin",
  data() {
    return {
      errors: {},
      error: '',
      success: '',
    }
  },
  methods: {
    clearErrors() {
      this.errors = {};
      this.error = '';
    },
    parseException(e) {
      if (e.code==401) {
        this.$router.push({path: '/auth/login'});
      }
      this.clearErrors();
      if (e['errors']) {
        this.errors = e.errors;
        this.error = Object.values(e.errors).join('<br>');
      } else if(e['error']) {
        this.error = e.error;
      } else {
        this.error = 'Unexpected error';
      }

      if (!this.errors && this.error) {
        this.errors = {unknown: this.error};
      }
    },
    showSuccess(success, interval) {
      if (!interval) {
        interval = 2000;
      }
      this.success = success;
      setTimeout(() => {
        this.closeSuccess();
      }, interval)
    },
    closeSuccess() {
      this.success = '';
    }
  },
};
</script>
