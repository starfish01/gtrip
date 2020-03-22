<template>
  <div class="container">
    <p v-if="loggedIn">
      Hello {{ user.name }}
      
      {{user}}

      <button @click="getData()">click</button>
      {{destinationData}}

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
    data() {
    return {
      destinationData: [],
    };
  },
  components: {
  },
  methods: {
    getData() {
      this.$axios.get('/user/destinationdata').then((data)=>{
        // console.log(data.data);
        this.destinationData = data.data;
      })
    }
  }
}
</script>

<style scoped>

</style>
