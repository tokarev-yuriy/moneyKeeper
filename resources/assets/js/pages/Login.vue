<template>
  <div
    class="page-header align-items-start min-vh-100"
  >
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container my-auto">
      <div class="row">
        <div class="col-lg-4 col-md-8 col-12 mx-auto">
          <div class="card z-index-0 fadeIn3 fadeInBottom">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div
                class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1"
              >
                <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">
                  Log in
                </h4>
              </div>
            </div>
            <div class="card-body">
              <form role="form" class="text-start mt-3">
                <div class="mb-3">
                  <material-input
                    id="email"
                    type="email"
                    label="Email"
                    v-model="email"
                  />
                </div>
                <div class="mb-3">
                  <material-input
                    id="password"
                    type="password"
                    label="Password"
                    v-model="password"
                  />
                </div>
                <div v-if="errors">
                  <material-alert color="danger"><span v-html="error"></span></material-alert>
                </div>
                <div class="text-center">
                  <material-button
                    class="my-4 mb-2"
                    variant="gradient"
                    color="success"
                    @click="login"
                    fullWidth
                    >Log in</material-button
                  >
                </div>
                <p class="mt-4 text-sm text-center">
                  Don't have an account?
                  <router-link
                    :to="{ name: 'Register' }"
                    class="text-success text-gradient font-weight-bold"
                    >Register</router-link
                  >
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import MaterialInput from "../md2/components/MaterialInput.vue";
import MaterialSwitch from "../md2/components/MaterialSwitch.vue";
import MaterialButton from "../md2/components/MaterialButton.vue";
import MaterialAlert from "../md2/components/MaterialAlert.vue";
import { mapMutations } from "vuex";
import { loginService } from "../api/auth.js";

export default {
  name: "log-in",
  components: {
    MaterialInput,
    MaterialSwitch,
    MaterialButton,
    MaterialAlert,
  },
  data() {
    return {
      email: '',
      password: '',
      errors: false
    }
  },
  computed: {
    error: function() {
      let errors = [];
      for (let code in this.errors) {
        errors.push(this.errors[code]);
      }

      return errors.join('<br>');
    },
    isLoggedIn: function() {
      return this.$store.getters['auth/isLoggedIn'];
    }
  },
  beforeMount() {
    this.toggleEveryDisplay();
    if (this.isLoggedIn) {
      this.$router.push({path: '/'});
    }
  },
  beforeUnmount() {
    this.toggleEveryDisplay();
  },
  methods: {
    ...mapMutations(["toggleEveryDisplay"]),
    async login() {
      this.errors = false;
      try {
        await loginService({
          email: this.email,
          password: this.password
        });
        await this.$store.dispatch('auth/init');
        this.$router.push({path: '/'});
      } catch(error) {
        this.errors = error.errors;
      }
    },
  },
};
</script>
