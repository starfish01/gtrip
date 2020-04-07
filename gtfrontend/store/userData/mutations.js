export default {
  setSingleDestination(state, destination) {
    destination.keys.keys = destination.keys.keys.length ? destination.keys.keys.split(",") : [];
    destination.keys.skipKeys = destination.keys.skip_keys.length ? destination.keys.skip_keys.split(",") : [];

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
  },
  updateKeys(state, data) {

    if (state.selectedDestination.id !== data.id) {
      return;
    }

    const updateData = data.newData.data;

    if (data.keyType === 'key') {
      state.selectedDestination.keys.keys = updateData.length !== 0 ? updateData.split(",") : [];
    } else {
      state.selectedDestination.keys.skipKeys = updateData.length !== 0 ? updateData.split(",") : [];
    }

  }
};
