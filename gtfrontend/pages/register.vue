<template>
  <section class="section">
    <h2 class="title is-3 has-text-grey">Register</h2>

    <div class="columns is-touch">
      <div class="column">
        <b-field label="Name">
          <b-input type="text" v-model="userForm.name"> </b-input>
        </b-field>

        <b-field label="Email">
          <b-input type="email" v-model="userForm.email"> </b-input>
        </b-field>

        <b-field label="Password">
          <b-input type="password" v-model="userForm.password" password-reveal>
          </b-input>
        </b-field>

        <b-button @click="registerUser" class="button is-success"
          >Register</b-button
        >
      </div>
    </div>
  </section>
</template>
<script>
export default {
  data() {
    return {
      userForm: {
        name: "",
        email: "",
        password: ""
      }
    };
  },
  methods: {
    async registerUser() {
      await this.$axios.post("register", this.userForm);
      this.$auth.login({
        data: {
          email: this.userForm.email,
          password: this.userForm.password
        }
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
