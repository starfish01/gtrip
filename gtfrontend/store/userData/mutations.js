export default {
  setSingleDestination(state, destinationId) {
    const destination = _.find(state.destinationData, function (o) {
      return o.id === parseInt(destinationId);
    });
    state.selectedDestination = destination
  },
  destinationDataCollected(state, data) {
    state.destinationData = data.destinations;
  },

  updateDestinationState(state, data) {

    const indexId = _.findIndex(state.destinationData, function (o) {
      return o.id === data.destinationId;
    });

    state.destinationData[indexId].enabled = data.enabledState;
    state.selectedDestination.enabled = data.enabledState;

  },

  addNewDestinationToState(state, data) {
    state.destinationData.push(data[0]);
  }

};
