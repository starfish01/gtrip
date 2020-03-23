export default {
    getDestinationData(state) {
        return state.destinationData
    },
    getEnabledDestinations(state) {
        return  _.filter(state.destinationData, function(o) { if (o.enabled) return o }).length;
    },

    getSingleDestinationData(state) {
        return state.selectedDestination
    }
}