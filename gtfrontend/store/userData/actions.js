export default {
    getUserDestinationData(context) {
        this.$axios.get("/user/destinationdata").then(data => {
            context.commit('destinationDataCollected', data.data)
        });
    },
    enabledDisableDestination(context) {
        const destinationId = context.state.selectedDestination.id;
        const destinationState = context.state.selectedDestination.enabled === 1 ? 0 : 1;

        this.$axios.post("/user/destinationdata/" + destinationId + "/enableddisable", { enabledPosition: destinationState }).then(data => {
            context.commit('updateDestinationState', { enabledState: data.data, destinationId: context.state.selectedDestination.id })
        });
    }
}