export default {
    // Authorization
    setApiToken(state, apiToken) {
        state.apiToken = apiToken
        localStorage.setItem('apiToken', apiToken)
    },
    removeApiToken(state) {
        state.apiToken = null
        localStorage.removeItem('apiToken')
    },
    setUser(state, user) {
        state.user = user
    },
    removeUser(state) {
        state.user = null
    },










    pushNote(state, note) {
        state.notes.push(note)
    },
    setSearchQuery(state, query) {
        state.searchQuery = query
    },
    setDisplayModeId(state, id) {
        state.displayModeId = id
        localStorage.setItem('displayModeId', id)
    },
    pushFolder(state, folder) {
        state.folders.push(folder)
    },
    folderQuery(state, id) {
        state.folderQuery = id
    },
}