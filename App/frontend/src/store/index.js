import { createStore } from 'vuex'
import axios from 'axios'

export default createStore({
  state: {
    user: null,
    notes: null,
    searchQuery: '',
    displayModeId: null,
  },
  mutations: {
    setUser(state, user) {
      state.user = user
      localStorage.setItem('user', JSON.stringify(user))
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
  },
  actions: {
    loadNotes({ state }) {
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
  },
  modules: {
    //
  },
  getters: {
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
    token: (state, getters) => getters.isUser ? state.user.api_token : null,
    // USER
    user: state => state.user || {},
    userLoaded: state => state.user !== null,
    // NOTES
    notes: (state, getters) => {
      if (getters.notesLoaded) {
        let regexp = new RegExp(state.searchQuery.toLowerCase(), 'g')
        return state.notes.filter(note => note.title.toLowerCase().match(regexp) || note.body.toLowerCase().match(regexp) || note.created_at.toLowerCase().match(regexp) )
      }
      else return []
    },
    notesLoaded: state => state.notes !== null,
    displayModeId: state => {
      return state.displayModeId || (state.displayModeId = localStorage.getItem('displayModeId') || 0)
    },
  },
})
