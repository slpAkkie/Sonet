import { createStore } from 'vuex'

export default createStore({
  state: {
    user: {},
    api_token: null,
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
    api_token: state => state.api_token,
    user: state => state.user,
    isUserLoaded: state => !!state.user.api_token,
  },
})
