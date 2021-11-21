import axios from 'axios'

export default {
    // Authorization
    async login(context, data) {
        try {
            const response = (await axios.post('login', data)).data.data
            context.commit('setApiToken', response['api_token'])
            context.commit('setUser', response)
            await context.dispatch('setAuthorizationHeader')

            return Promise.resolve()
        } catch (error) {
            return Promise.reject(error.response.data)
        }
    },
    setAuthorizationHeader({ getters }) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${getters.apiToken}`
    },
    async verifyToken(context) {
        await axios.get('user/verify')
        context.dispatch('identify')
    },
    async identify(context) {
        context.commit('setUser', (await axios.get('user/identify')).data.data)
    },
    async logout(context) {
        context.commit('removeUser')
        context.commit('removeApiToken')
    },










    async loadNotes({ state }) {
        axios
            .get('notes')
            .then(response => {
                state.notes = response.data.data
            })
            .catch(() => {
                state.notes = []
            })
    },
    removeUser({ state }) {
        state.user = null
        state.notes = null
        localStorage.removeItem('user')
    },
    getNote({ state }, id) {
        return state.notes.find(note => note.id === id)
    },
    async deleteNote({ state }, id) {
        let noteIndex = state.notes.findIndex(note => note.id === id)
        if (noteIndex === -1) return

        await axios.delete(`notes/${id}`)
        state.notes.splice(noteIndex, 1)
    },
    async loadFolders({ state }) {
        axios
            .get('folders')
            .then(response => {
                state.folders = response.data.data
            })
            .catch(() => {
                state.folders = []
            })
    },
    async deleteFolder({ state }, id) {
        let folderIndex = state.folders.findIndex(folder => folder.id === id)
        if (folderIndex === -1) return

        await axios.delete(`folders/${id}`)
        state.notes.forEach(note => {
            if (note.folder_id === id) note.folder_id = null
        })
        state.folders.splice(folderIndex, 1)
    },
    async loadCategories({ state }) {
        axios
            .get('categories')
            .then(response => {
                state.categories = response.data.data
            })
            .catch(() => {
                state.categories = []
            })
    },
}