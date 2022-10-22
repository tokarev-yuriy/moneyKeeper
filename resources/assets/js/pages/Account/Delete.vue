<template>
<div class="container vh-100">
  <div class="row">
    <div class="col-lg-6 col-md-10 col-12 mx-auto">
      <div class="card card-body mx-3 mx-md-4 mt-3">
        <div class="bg-gradient-success shadow-success border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">{{item.name}}</h6>
        </div>
        <div class="card-body">
          Do you want to remove the "{{item.name}}" account?
          <div class="text-center">
            <button class="btn mb-0 bg-gradient-secondary btn-md my-4 mb-2" @click="$router.push({path: '/accounts'})">Cancel</button>
            <button class="btn mb-0 bg-gradient-danger btn-md my-4 mb-2 ms-4" @click="deleteItem">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  
</template>

<script>
import { accountDetailService, accountDeleteService } from "../../api/account.js";
import LoadingMixin from "../../mixins/LoadingMixin.vue";
import ErrorsMixin from "../../mixins/ErrorsMixin.vue";

export default {
  name: "AccountEdit",
  mixins: [LoadingMixin, ErrorsMixin],
  data() {
    return {
      item: {
        name: '',
        sort: '10'
      },
      id: this.$route.params['id']
    }
  },
  mounted() {
    this.getData();
  },
  methods: {
    async getData() {
      this.isLoading = true;
      try {
        if (this.id != 'new') {
          let data = await accountDetailService(this.id);
          this.item = data.item;
        }
      } catch (e) {
        this.parseException(e);
      }
      this.isLoading = false;
    },
    async deleteItem() {
      this.clearErrors();
      this.isLoading = true;
      try {
        let data;
        data = await accountDeleteService(this.id);
        this.$store.dispatch('messages/add', {
          type: 'info',
          message: 'Account has ben deleted'
        });
        this.$router.push({path: '/accounts'});
      } catch (e) {
        this.parseException(e);
      }
      this.isLoading = false;
    }
  },
};
</script>
