<template>
  <div class="container">
    <p v-if="loggedIn">
      Hello {{ user.name }}
      <hr>
      {{user}}
    </p>
    <p v-if="!loggedIn">
      Please sign in
    </p>
  </div>
</template>

<script>

export default {
  
}
</script>


<script>

export default {
  components: {
  }
}
</script>

<style scoped>

</style>
