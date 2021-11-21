import store from './index'

export default {
    // Authorization
    isAuthorized: (state, getters) => {
        if (getters.apiToken) {
            store.dispatch('setAuthorizationHeader')

            return true
        }

        return false
    },










    // TOKEN
    isUser: (state, getters) => {
        if (getters.userLoaded) return true

        let userSerialized = localStorage.getItem('user')
        if (!userSerialized) return false

        try {
            let user = JSON.parse(userSerialized)
            if (!user.api_token) return false
            state.user = user

            return true
        } catch (e) {
            return false
        }
    },
    apiToken: (state) => {
        if (!state.apiToken) state.apiToken = localStorage.getItem('apiToken') || null

        return state.apiToken
    },
    // USER
    user: state => state.user || {},
    userLoaded: state => state.user !== null,
    // NOTES
    notes: (state, getters) => {
        if (getters.notesLoaded) {
            let regexp = new RegExp(state.searchQuery.toLowerCase(), 'g')
            return state.notes.filter(
                note =>
                    (note.title.toLowerCase().match(regexp)
                        || note.body.toLowerCase().match(regexp)
                        || note.created_at.toLowerCase().match(regexp))
                    && (state.folderQuery !== null ? (
                        state.folderQuery === -1
                            ? !note.folder?.id
                            : note.folder?.id === state.folderQuery
                    ) : true)
            )
        }
        else return []
    },
    notesLoaded: state => state.notes !== null,
    displayModeId: state => {
        return state.displayModeId || (state.displayModeId = +localStorage.getItem('displayModeId') || 0)
    },
    // FOLDERS
    folders: state => state.folders || [],
    foldersLoaded: state => state.folders !== null,
    openedFolder: state => state.folderQuery,
    // CATEGORIES
    categories: state => state.categories || [],
    categoriesLoaded: state => state.categories !== null,
}