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
    removeNote(state, note_id) {
        state.notes = state.notes.filter(note => note.id !== +note_id)
        state.sharedNotes = state.sharedNotes.filter(note => note.id !== +note_id)
    },

    // Folders
    setFolders(state, folders) {
        state.folders = folders
    },
    pushFolder(state, folder) {
        state.folders.push(folder)
    },
    removeFolder(state, folder_id) {
        state.folders = state.folders.filter(folder => folder.id !== folder_id)
        state.notes = state.notes.map(note => {
            if (note.folder === folder_id)
            note.folder = null
            return note
        })
    },

    // Categories
    setCategories(state, categories) {
        state.categories = categories || null
    },
    pushCategory(state, category) {
        state.categories.push(category)
    },
    updateCategory(state, category) {
        state.categories[state.categories.findIndex(cat => cat.id === category.id)] = category
    },
    removeCategory(state, category_id) {
        state.categories = state.categories.filter(category => category.id !== category_id)
        state.notes = state.notes.map(note => {
            if (note.category === category_id)
            note.category = null
            return note
        })
    },

    // Access Levels
    setAccessLevels(state, accessLevels) {
        state.accessLevels = accessLevels
    },
}
