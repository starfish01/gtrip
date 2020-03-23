export default {
  setSingleDestination(state, destinationId) {
    const destination = _.find(state.destinationData, function(o) {
      return o.id === parseInt(destinationId);
    });
    console.log(state.selectedDestination.name);
    state.selectedDestination = destination

    console.log(state.selectedDestination.name);
}
};
