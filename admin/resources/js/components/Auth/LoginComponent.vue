<template>
  <div class="content-wrpper">
    <div
      class="row justify-content-end remove-padding remove-margin login-wrapper"
      style="
        background-image: url('../../img/bg.svg?v=1620469277'),
          linear-gradient(141deg, #1781d0 0%, #1f81b6 51%, #2d7cb0 100%) !important;
      "
    >
      <div class="col-md-5 remove-padding">
        <div class="card" style="border-radius: 0px !important">
          <div class="card-wrapper">
            <el-form ref="form" :model="form" label-width="120px">
              <el-form-item label="">
                <i class="far fa-envelope"></i>
                <el-input v-model="form.email" clearable></el-input>
              </el-form-item>
              <el-form-item label="">
                <i class="fas fa-lock"></i>
                <el-input
                  v-model="form.password"
                  clearable
                  show-password
                ></el-input>
              </el-form-item>

              <el-form-item>
                <el-button type="primary" @click="handleSubmit()"
                  >Signin</el-button
                >
                <!-- <el-button>Cancel</el-button> -->
              </el-form-item>
            </el-form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "LoginComponent",
  data() {
    return {
      form: {
        email: "mFWtYzXQB4@gmail.com",
        password: "password",
      },
      loading: true,
    };
  },
  computed: {
    my_user() {
      return this.$store.getters.this_user;
    },
    my_token() {
      return this.$store.getters.this_token;
    },
  },
  created() {},
  methods: {
    ...mapActions({
      signIn: "api/v1/user/login",
    }),
    handleSubmit() {
      this.$store.dispatch("signIn", this.form);
    },
  },
};
</script>

<style scoped>
.content-wrpper {
  display: block !important;
  width: 100% !important;
  height: 100vh !important;
}

.remove-padding {
  padding: 0px !important;
}

.remove-margin {
  margin: 0px !important;
}

.login-wrapper {
  display: inline-flex !important;
  width: 100% !important;
  position: relative !important;
  height: inherit !important;
  background-size: cover;
}

.card {
  height: 100% !important;
  display: inline-block !important;
  width: 100% !important;
}

.card-wrapper {
  padding: 5%;
  display: inline-block !important;
  width: 100%;
  /* display: table-cell; */
  vertical-align: middle !important;
  position: inherit !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  -ms-transform: translateY(-50%) !important;
  -moz-transform: translateY(-50%) !important;
  -webkit-transform: translateY(-50%) !important;
  -o-transform: translateY(-50%) !important;
}
</style>