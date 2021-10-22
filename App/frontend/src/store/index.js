import { createStore } from 'vuex'
import axios from 'axios'

export default createStore({
  state: {
    user: null,
    notes: null,
  },
  mutations: {
    setUser(state, user) {
      state.user = user
      localStorage.setItem('user', JSON.stringify(user))
    },
  },
  actions: {
    loadNotes({ state }) {
      axios
        .get('notes')
        .then(response => {
          state.notes = response.data.data
        })
        .catch(error => {
          state.notes = []

          alert('Произошла не предвиденная ошибка ошибка (Более подробное описание ошибки смотрите в консоли)')
          console.log(error)
        })
    },
    removeUser({ state }) {
      state.user = null
      state.notes = null
      localStorage.removeItem('user')
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
    notes: state => state.notes || [],
    notesLoaded: state => state.notes !== null,
  },
})
