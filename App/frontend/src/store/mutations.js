export default {
    // Authorization
    setApiToken(state, apiToken) {
        state.apiToken = apiToken
        localStorage.setItem('apiToken', apiToken)
    },
    setUser(state, user) {
        state.user = user
    },
    clearStore(state) {
        state.apiToken = null
        localStorage.removeItem('apiToken')

        state.logout = false
        state.verified = false
        state.user = null

        state.notes = null
        state.sharedNotes = null
        state.searchQuery = ''

        state.folders = null
        state.categories = null
    },

    // Notes
    setNotes(state, notes) {
        state.notes = notes
    },
    pushNote(state, note) {
        state.notes.unshift(note)
    },
    setSharedNotes(state, sharedNotes) {
        state.sharedNotes = sharedNotes},
    updateSearchQuery(state, searchQuery) {
        state.searchQuery = searchQuery
    },
    updateNote(state, updatedNote) {
        const noteIndex = state.notes.findIndex(note => note.id === updatedNote.id)
        state.notes[noteIndex] = updatedNote
    },

    // Folders
    setFolders(state, folders) {
        state.folders = folders
    },
    pushFolder(state, folder) {
        state.folders.push(folder)
    },

    // Categories
    setCategories(state, categories) {
        state.categories = categories
    },
}