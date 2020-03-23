<template>
  <section class="section">
    <h2 class="title is-3 has-text-grey">Home</h2>

    <div class="columns is-touch">
      <div class="column">
        Homepage
      </div>
    </div>
  </section>
</template>

<script>
export default {};
</script>

<script>
export default {
  middleware: "guest",
  data() {
    return {
      destinationData: []
    };
  },
  components: {},
  methods: {
    getData() {
      this.$axios.get("/user/destinationdata").then(data => {
        // console.log(data.data);
        this.destinationData = data.data;
      });
    }
  }
};
</script>

<style scoped></style>
