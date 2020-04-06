export default {
  setSingleDestination(state, destination) {
    state.selectedDestination = destination
  },
  destinationDataCollected(state, data) {
    state.destinationData = data.destinations;
  },
  updateDestinationState(state, data) {
    state.selectedDestination.enabled = data.enabledState;
  },
  addNewDestinationToState(state, data) {
    state.destinationData.push(data[0]);
  }
};
