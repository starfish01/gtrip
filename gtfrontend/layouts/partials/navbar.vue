<template>
  <b-navbar type="is-black">
    <template slot="brand">
      <b-navbar-item tag="router-link" :to="{ path: '/' }">
        GT Rip
      </b-navbar-item>
    </template>
    <template slot="start">
      <!-- <b-navbar-item href="#">
                Home
            </b-navbar-item>
            <b-navbar-item href="#">
                Documentation
            </b-navbar-item>
            <b-navbar-dropdown label="Info">
                <b-navbar-item href="#">
                    About
                </b-navbar-item>
                <b-navbar-item href="#">
                    Contact
                </b-navbar-item>
            </b-navbar-dropdown> -->
    </template>

    <template slot="end">
      <b-navbar-item tag="div">
        <div class="buttons">
          <template v-if="!loggedIn">
            <nuxt-link :to="{ name: 'login' }" class="button is-light">
              Login
            </nuxt-link>
            <nuxt-link :to="{ name: 'register' }" class="button is-light">
              Register
            </nuxt-link>
          </template>
          <template v-else>
            <b-navbar-dropdown :label="user.name">
              <b-navbar-item @click.prevent="logout">
                Logout
              </b-navbar-item>

              <b-navbar-item href='/dashboard/user/'>
                Update Details
              </b-navbar-item>
            </b-navbar-dropdown>
          </template>
        </div>
      </b-navbar-item>
    </template>
  </b-navbar>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$auth.logout();
    }
  }
};
</script>

<style scoped>
.navbar {
  /* max-height: 50px; */
  padding: 0 69px;
}
</style>
