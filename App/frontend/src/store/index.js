import { createStore } from 'vuex'

export default createStore({
  state: {
    api_token: null
  },
  mutations: {
    //
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
