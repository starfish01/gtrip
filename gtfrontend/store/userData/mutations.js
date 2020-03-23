export default {
  setSingleDestination(state, destinationId) {
    const destination = _.find(state.destinationData, function (o) {
      return o.id === parseInt(destinationId);
    });
    state.selectedDestination = destination
  },
  destinationDataCollected(state, data) {

    state.destinationData = data.destinations;

  }

};
