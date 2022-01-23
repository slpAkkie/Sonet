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
    async deleteUser() {
        try {
            await axios.delete('user')

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
            context.commit('removeNote', id)

            return Promise.resolve()
        } catch (error) {
            return Promise.reject(error)
        }
    },
    async saveAttachment(context, { note_id, attachment }) {
        try {
            let formData = new FormData()
            formData.append('attachment', attachment)

            let response = (await axios.post(`notes/${note_id}/attachments`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })).data.data

            return Promise.resolve(response)
        } catch (error) {
            return Promise.reject(error)
        }
    },
    async deleteAttachment(context, attachment_id) {
        try {
            await axios.delete(`attachments/${attachment_id}`)

            return Promise.resolve()
        } catch (error) {
            return Promise.reject(error)
        }
    },
    async loadComments(context, note_id) {
        try {
            return Promise.resolve((await axios.get(`notes/${note_id}/comments`)).data.data)
        } catch (error) {
            return Promise.reject(error)
        }
    },
    async addComment(context, { commentBody, note_id }) {
        try {
            return (await axios.post(`notes/${note_id}/comments`, { body: commentBody })).data.data
        } catch (error) {
            return Promise.reject(error)
        }
    },

    // Folders
    async createFolder(context, folderData) {
        try {
            context.commit('pushFolder', (await axios.post('folders', folderData)).data.data)

            return Promise.resolve()
        } catch(error) {
            return Promise.reject(error)
        }
    },
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
            context.commit('removeFolder', id)

            return Promise.resolve()
        } catch (e) {
            return Promise.reject()
        }
    },

    // Categories
    async createCategory(context, categoryData) {
        try {
            context.commit('pushCategory', (await axios.post('categories', categoryData)).data.data)

            return Promise.resolve()
        } catch(error) {
            return Promise.reject(error)
        }
    },
    async updateCategory(context, categoryData) {
        try {
            context.commit('updateCategory', (await axios.put(`categories/${categoryData.id}`, categoryData)).data.data)

            return Promise.resolve()
        } catch(error) {
            return Promise.reject(error)
        }
    },
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
    async deleteCategory(context, id) {
        try {
            await axios.delete(`categories/${id}`)
            context.commit('removeCategory', id)

            return Promise.resolve()
        } catch (e) {
            return Promise.reject()
        }
    },

    // Access Levels
    async loadAccessLevels(context) {
        if (context.getters.accessLevelsLoaded || context.state.accessLevelsLoading) return

        try {
            context.state.accessLevelsLoading = true
            context.commit('setAccessLevels', (await axios.get('access_levels')).data.data)
        } catch (e) {
            context.commit('setAccessLevels', [])
        } finally {
            context.state.accessLevelsLoading = false
        }
    },
    async findUserByEmail(context, email) {
        try {
            return (await axios.get(`users?email=${email}`)).data.data
        } catch (e) {
            return []
        }
    },
    async loadContributors(context, note_id) {
        try {
            return Promise.resolve((await axios.get(`/notes/${note_id}/contributors`)).data.data)
        } catch (error) {
            return Promise.reject(error)
        }
    },
    async addContributor(context, { note_id, email, access_level_id }) {
        try {
            return Promise.resolve((await axios
                .put(`/notes/${note_id}/contributors`, {
                    email,
                    access_level_id,
                })).data.data)
        } catch (error) {
            return Promise.reject(error)
        }
    },
    async deleteContributor(context, { note_id, contributor_id }) {
        try {
            await axios.delete(`notes/${note_id}/contributors/${contributor_id}`)

            return Promise.resolve()
        } catch (e) {
            return Promise.reject()
        }
    }
}