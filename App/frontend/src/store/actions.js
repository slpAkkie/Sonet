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
        if (context.state.verified || context.state.verifying) return

        context.state.verifying = true
        await axios.get('user/verify')
        context.state.verified = true
        context.state.verifying = false
        await context.dispatch('identify')
    },
    async identify(context) {
        if (context.state.user || context.state.identifying) return

        context.state.identifying = true
        context.commit('setUser', (await axios.get('user/identify')).data.data)
        context.state.identifying = false
    },
    async logout(context) {
        try {
            context.state.logout = true
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
            context.commit('pushNote', note)

            return Promise.resolve(note.id)
        } catch (error) {
            return Promise.reject(error.response.data)
        }
    },
    async loadNote(context, note_id) {
        try {
            return (await axios.get(`/notes/${note_id}`)).data.data
        } catch (e) {
            return Promise.reject()
        }
    },
    async loadNotes(context) {
        if (context.getters.notesLoaded || context.state.notesLoading) return

        try {
            context.state.notesLoading = true
            context.commit('setNotes', (await axios.get('notes')).data.data)
        } catch (e) {
            context.commit('setNotes', [])
        } finally {
            context.state.notesLoading = false
        }
    },
    async loadSharedNotes(context) {
        if (context.getters.sharedNotesLoaded || context.state.sharedNotesLoading) return

        try {
            context.state.sharedNotesLoading = true
            context.commit('setSharedNotes', (await axios.get('notes/shared')).data.data)
        } catch (e) {
            context.commit('setSharedNotes', [])
        } finally {
            context.state.sharedNotesLoading = false
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
            // TODO: Just splice according array don't erase all of them
            context.commit('setNotes', null)
            context.commit('setSharedNotes', null)
        }
    },

    // Folders
    async loadFolders(context) {
        if (context.getters.foldersLoaded || context.state.foldersLoading) return

        try {
            context.state.foldersLoading = true
            context.commit('setFolders', (await axios.get('folders')).data.data)
        } catch (e) {
            context.commit('setFolders', [])
        } finally {
            context.state.foldersLoading = false
        }
    },
    async deleteFolder(context, id) {
        try {
            await axios.delete(`folders/${id}`)

            return Promise.resolve()
        } catch (e) {
            return Promise.reject()
        } finally {
            // TODO: Map notes and remove info about folder
            context.commit('setNotes', null)
            // TODO: Just splice folders array don't erase
            context.commit('setFolders', null)
        }
    },

    // Categories
    async loadCategories(context) {
        if (context.getters.categoriesLoaded || context.state.categoriesLoading) return

        try {
            context.state.categoriesLoading = true
            context.commit('setCategories', (await axios.get('categories')).data.data)
        } catch (e) {
            context.commit('setCategories', [])
        } finally {
            context.state.categoriesLoading = false
        }
    },
}