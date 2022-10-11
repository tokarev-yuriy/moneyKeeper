<template></template>

<script>
import MaterialSnackbar from "../md2/components/MaterialSnackbar.vue";

export default {
  name: "LoadingMixin",
  components: {
    MaterialSnackbar,
  },
  data() {
    return {
      errors: {},
      error: '',
      success: '',
      messages: [],
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
    },
    readMessages() {
      let messages = this.$store.getters['messages/get'];
      this.messages = [...messages];
      this.$store.dispatch('messages/clean');
      setTimeout(() => {
        this.closeMessage();
      }, 2000)
    },
    closeMessage() {
      this.messages = [];
    }
  },
};
</script>
