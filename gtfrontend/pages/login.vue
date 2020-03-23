<template>
  <section class="section">
    <h2 class="title is-3 has-text-grey">Login</h2>

    <div class="columns is-touch">
      <div class="column">
        <b-field label="Email">
          <b-input type="email" v-model="userForm.email" >
          </b-input>
        </b-field>

        <b-field label="Password">
          <b-input type="password" v-model="userForm.password" password-reveal>
          </b-input>
        </b-field>

        <b-button @click="loginUser" class="button is-success">Login</b-button>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  middleware: "auth",
  data() {
    return {
      userForm: {
        email: "",
        password: ""
      }
    };
  },
  methods: {
    async loginUser() {
      await this.$auth.login({
        data: this.userForm
      });
      this.$router.push({
        path: "/"
      });
    }
  }
};
</script>

<style>
.top {
  margin-top: 80px;
}
</style>
