<template>
  <div class="card card-body mx-3 mx-md-4 mt-3">
    <div class="pb-0 card-header bg-transparent mb-4">
      <h4 class="font-weight-bolder">Account group</h4>
    </div>
    <div class="card-body">
      <form role="form" v-if="!isLoading">
        <div class="row">
          <div class="mb-3 col-md-6">
            <material-input
              id="name"
              type="text"
              label="Name"
              v-model="item.name"
              size="lg"
              :error="errors && errors['name']"
            />
          </div>
          <div class="mb-3 col-md-6">
            <material-input
              id="sort"
              type="number"
              label="Sort"
              v-model="item.sort"
              size="lg"
            />
          </div>
        </div>
        <div v-if="error">
          <material-alert color="danger"><span v-html="error"></span></material-alert>
        </div>
        <div class="text-end">
          <material-button
            class="mt-4"
            variant="gradient"
            color="dark"
            size="lg"
            @click="saveData"
            >Save</material-button
          >
        </div>
      </form>
    </div>
    <div class="position-fixed top-2 end-2 z-index-2">
      <material-snackbar
        v-if="success"
        :title="success"
        date=""
        description=""
        :icon="{ component: 'done', color: 'white' }"
        color="success"
        :closeHandler="closeSuccess"
      />
    </div>
  </div>
</template>

<script>
import { accountGroupDetailService, accountGroupAddService, accountGroupUpdateService } from "../../api/accountGroup.js";
import LoadingMixin from "../../mixins/LoadingMixin.vue";
import ErrorsMixin from "../../mixins/ErrorsMixin.vue";
import MaterialInput from "../../md2/components/MaterialInput.vue";
import MaterialCheckbox from "../../md2/components/MaterialCheckbox.vue";
import MaterialButton from "../../md2/components/MaterialButton.vue";
import MaterialAlert from "../../md2/components/MaterialAlert.vue";
import MaterialSnackbar from "../../md2/components/MaterialSnackbar.vue";

export default {
  name: "AccountGroupEdit",
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
  components: {
    MaterialInput,
    MaterialCheckbox,
    MaterialButton,
    MaterialAlert,
    MaterialSnackbar,
  },
  mounted() {
    this.getData();
  },
  methods: {
    async getData() {
      this.isLoading = true;
      try {
        if (this.id != 'new') {
          let data = await accountGroupDetailService(this.id);
          this.item = data.item;
        }
      } catch (e) {
        this.parseException(e);
      }
      this.isLoading = false;
    },
    async saveData() {
      this.clearErrors();
      this.isLoading = true;
      try {
        let data;
        if (this.id == 'new') {
          data = await accountGroupAddService(this.item);
          this.showSuccess('Account group has been added');
        } else {
          data = await accountGroupUpdateService(this.id, this.item);
          this.showSuccess('Account group has been updated');
        }
        this.item = data.item;
      } catch (e) {
        this.parseException(e);
      }
      this.isLoading = false;
    }
  },
};
</script>
