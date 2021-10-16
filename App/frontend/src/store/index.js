import { createStore } from 'vuex'

export default createStore({
  state: {
    api_token: null
  },
  mutations: {
    setToken(state, api_token) {
      state.api_token = api_token
      localStorage.setItem('api_token', api_token)
    }
  },
  actions: {
    checkToken({ state }) {
      return state.api_token
        ? true
        : !!(state.api_token = localStorage.getItem('api_token'))
    }
  },
  modules: {
    //
  },
  getters: {
    //
  },
})
