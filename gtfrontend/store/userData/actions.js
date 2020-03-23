export default {
    getUserDestinationData(context) {
        this.$axios.get("/user/destinationdata").then(data => {
            context.commit('destinationDataCollected', data.data)
        });
    },
}