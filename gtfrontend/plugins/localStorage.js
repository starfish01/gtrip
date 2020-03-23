import createPersistedState from 'vuex-persistedstate'


export default ({ store }) => {
    createPersistedState({
        key: 'gtRip',
        paths: []
    })(store)
}
