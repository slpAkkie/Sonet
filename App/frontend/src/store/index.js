import { createStore } from 'vuex'

export default createStore({
  state: {
    user: null,
    notes: null,
  },
  mutations: {
    setToken(state, api_token) {
      state.api_token = api_token
      api_token
        ? localStorage.setItem('api_token', api_token)
        : localStorage.removeItem('api_token')
    },
    setUser(state, user) {
      state.user = user
      localStorage.setItem('user', JSON.stringify(user))
    },
  },
  actions: {
    checkToken({ state }) {
      return state.api_token
        ? true
        : !!(state.api_token = localStorage.getItem('api_token'))
    },
    removeToken(context) {
      context.commit('setToken', null)
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
        return !!JSON.parse(userSerialized).api_token
      } catch (e) {
        return false
      }
    },
    token: (state, getters) => getters.isUser ? state.user.api_token : null,
    // USER
    user: state => state.user,
    userLoaded: state => state.user !== null,
    // NOTES
    notes: state => state.notes,
    notesLoaded: state => state.notes !== null,
  },
})
