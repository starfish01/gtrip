<template>
  <div>
    <Navbar />

    <section class="main-content columns">
      <aside class="column is-2 section"></aside>
      <div class="container column is-8">
        <nuxt />
      </div>

      <aside class="column is-2 section"></aside>
    </section>
  </div>
</template>

<script>
import Navbar from "./partials/navbar";
export default {
  components: {
    Navbar
  }
};
</script>

<style lang="scss">
</style>
