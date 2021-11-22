import store from './index'
import filterNotes from '../helpers/filterNotes'

export default {
    // Authorization
    isAuthorized: (state, getters) => {
        if (getters.apiToken) {
            store.dispatch('setAuthorizationHeader')

            return true
        }

        return false
    },
    apiToken: (state) => {
        if (!state.apiToken) state.apiToken = localStorage.getItem('apiToken') || null

        return state.apiToken
    },
    user: state => state.user || {},

    // Notes
    notesLoaded: state => state.notes !== null,
    notes: (state, getters) => {
        if (!getters.notesLoaded && getters.apiToken) store.dispatch('loadNotes')

        if (state.searchQuery) return filterNotes(state.notes, state.searchQuery)

        return state.notes || []
    },
    notesInFolder: (getters) => (folder_id) => {
        return getters.notes?.filter(note => {
            if (!note['folder']) return false

            return note['folder'] === +folder_id
        }) || []
    },
    sharedNotesLoaded: state => state.sharedNotes !== null,
    sharedNotes: (state, getters) => {
        if (!getters.sharedNotesLoaded && getters.apiToken) store.dispatch('loadSharedNotes')

        if (state.searchQuery) return filterNotes(state.sharedNotes, state.searchQuery)

        return state.sharedNotes || []
    },
    isShared: (getters) => (note_id) => {
        return !!getters.sharedNotes?.find(note => note.id === +note_id)
    },

    // Folders
    foldersLoaded: state => state.folders !== null,
    folders: (state, getters) => {
        if (!getters.foldersLoaded && getters.apiToken) store.dispatch('loadFolders')

        return state.folders || []
    },
    folder: (getters) => (folder_id) => {
        if (getters.folders) return getters.folders.find(folder => folder.id === +folder_id)
    },

    // Categories
    categoriesLoaded: state => state.categories !== null,
    categories: (state, getters) => {
        if (!getters.categoriesLoaded && getters.apiToken) store.dispatch('loadCategories')

        return state.categories || []
    },
    categoryColor: (state, getters) => (category_id) => {
        if (!getters.categories) return 'transparent'

        const foundCategory = getters.categories.find(category => {
            return category.id === category_id
        })

        return foundCategory ? foundCategory.color : 'transparent'
    },
}