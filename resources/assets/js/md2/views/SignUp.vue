<template>
  <section>
    <div class="page-header min-vh-100">
      <div class="container my-auto">
        <div class="row">
          <div
            class="col-lg-4 col-md-8 col-12 mx-auto"
          >
            <div class="card card-plain">
              <div class="pb-0 card-header bg-transparent mb-4">
                <h4 class="font-weight-bolder">Sign In</h4>
                <p class="mb-0">
                  Enter your email and password to register
                </p>
              </div>
              <div class="card-body">
                <form role="form">
                  <div class="mb-3">
                    <material-input
                      id="name"
                      type="text"
                      label="Name"
                      name="name"
                      size="lg"
                    />
                  </div>
                  <div class="mb-3">
                    <material-input
                      id="email"
                      type="email"
                      label="Email"
                      name="email"
                      size="lg"
                    />
                  </div>
                  <div class="mb-3">
                    <material-input
                      id="password"
                      type="password"
                      label="Password"
                      name="password"
                      size="lg"
                    />
                  </div>
                  <material-checkbox
                    id="flexCheckDefault"
                    class="font-weight-light"
                    checked
                  >
                    I agree the
                    <a
                      href="../../../pages/privacy.html"
                      class="text-dark font-weight-bolder"
                      >Terms and Conditions</a
                    >
                  </material-checkbox>
                  <div class="text-center">
                    <material-button
                      class="mt-4"
                      variant="gradient"
                      color="success"
                      fullWidth
                      size="lg"
                      >Sign Up</material-button
                    >
                  </div>
                </form>
              </div>
              <div class="px-1 pt-0 text-center card-footer px-lg-2">
                <p class="mx-auto mb-4 text-sm">
                  Don't have an account?
                  <router-link
                    :to="{ name: 'SignIn' }"
                    class="text-success text-gradient font-weight-bold"
                    >Sign In</router-link
                  >
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import MaterialInput from "../components/MaterialInput.vue";
import MaterialCheckbox from "../components/MaterialCheckbox.vue";
import MaterialButton from "../components/MaterialButton.vue";
const body = document.getElementsByTagName("body")[0];
import { mapMutations } from "vuex";

export default {
  name: "sign-up",
  components: {
    MaterialInput,
    MaterialCheckbox,
    MaterialButton,
  },
  beforeMount() {
    this.toggleEveryDisplay();
    this.toggleHideConfig();
    body.classList.remove("bg-gray-100");
  },
  beforeUnmount() {
    this.toggleEveryDisplay();
    this.toggleHideConfig();
    body.classList.add("bg-gray-100");
  },
  methods: {
    ...mapMutations(["toggleEveryDisplay", "toggleHideConfig"]),
  },
};
</script>
