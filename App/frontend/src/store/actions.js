import axios from 'axios'

export default {
    // Authorization
    async register(context, data) {
        try {
            await axios.post('register', data)

            return Promise.resolve()
        } catch (error) {
            return Promise.reject(error.response.data)
        }
    },
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
        axios.defaults.headers.common['Authorization'] = getters.apiToken ? `Bearer ${getters.apiToken}` : null
    },
    async verifyToken(context) {
        if (context.state.verified) return

        await axios.get('user/verify')
        context.state.verified = true
        context.dispatch('identify')
    },
    async identify(context) {
        if (!context.state.user) context.commit('setUser', (await axios.get('user/identify')).data.data)
    },
    async logout(context) {
        try {
            context.commit('logout')
            await axios.delete('user/logout')

            return Promise.resolve()
        } catch (error) {
            return Promise.reject(error)
        }
    },

    // Notes
    async createNote(context, noteData) {
        try {
            const note = (await axios.post('notes', noteData)).data.data

            return Promise.resolve(note.id)
        } catch (error) {
            return Promise.reject(error.response.data)
        } finally {
            context.commit('setNotes', null)
        }
    },
    async loadNotes(context) {
        if (context.getters.notesLoaded) return

        try {
            context.commit('setNotes', (await axios.get('notes')).data.data)
        } catch (e) {
            context.commit('setNotes', [])
        }
    },
    async loadSharedNotes(context) {
        if (context.getters.sharedNotesLoaded) return

        try {
            context.commit('setSharedNotes', (await axios.get('notes/shared')).data.data)
        } catch (e) {
            context.commit('setSharedNotes', [])
        }
    },
    async updateNote(context, postData) {
        try {
            const updatedNote = (await axios.put(`notes/${postData.id}`, postData)).data.data

            context.commit('updateNote', updatedNote)

            return Promise.resolve()
        } catch (error) {
            return Promise.reject(error)
        }
    },
    async deleteNote(context, id) {
        try {
            await axios.delete(`notes/${id}`)

            return Promise.resolve()
        } catch (e) {
            return Promise.reject()
        } finally {
            context.commit('setNotes', null)
            context.state.sharedNotes = null
        }
    },

    // Folders
    async loadFolders(context) {
        if (context.getters.foldersLoaded) return

        try {
            context.commit('setFolders', (await axios.get('folders')).data.data)
        } catch (e) {
            context.commit('setFolders', [])
        }
    },
    async deleteFolder(context, id) {
        try {
            await axios.delete(`folders/${id}`)

            return Promise.resolve()
        } catch (e) {
            return Promise.reject()
        } finally {
            context.commit('setNotes', null)
            context.commit('setFolders', null)
        }
    },

    // Categories
    async loadCategories(context) {
        if (context.getters.categoriesLoaded) return

        try {
            context.commit('setCategories', (await axios.get('categories')).data.data)
        } catch (e) {
            context.commit('setCategories', [])
        }
    },
}