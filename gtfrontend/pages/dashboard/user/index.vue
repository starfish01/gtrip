<template>
  <div>
    <h1>User</h1>
    {{user}}
  </div>
</template>
<script>
export default {
    middleware: "auth",

  data() {
    return {
      id: ""
    };
  },
  methods: {
    loadUser() {
      this.$router.push(`/dashboard/users/${this.id}`);
    }
  }
};
</script>