export default {
  getUserDestinationData(context) {
    this.$axios.get("/user/destinationdata").then(data => {
      context.commit('destinationDataCollected', data.data)
    });
  },

  getSingleDestination(context, payload) {
    return this.$axios.get("/user/destinationdata/" + payload)
      .then(data => {
        return data.data;
      }).catch(error => {
        return Promise.reject(error);
      });
  },

  enabledDisableDestination(context) {
    const destinationId = context.state.selectedDestination.id;
    const destinationState = context.state.selectedDestination.enabled === 1 ? 0 : 1;

    this.$axios.post("/user/destinationdata/" + destinationId + "/enableddisable", {
      enabledPosition: destinationState
    }).then(data => {
      context.commit('updateDestinationState', {
        enabledState: data.data,
        destinationId: context.state.selectedDestination.id
      })
    });
  },

  addNewDestination(context, payload) {
    return this.$axios.post("/user/destinationdata/", payload).then(data => {
      context.commit('addNewDestinationToState', data.data);
      return data.data[0].id;
    }).catch(error => {
        return Promise.reject(error);
    });
  }
}
