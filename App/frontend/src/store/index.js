import { createStore } from 'vuex'

export default createStore({
  state: {
    //
  },
  mutations: {
    //
  },
  actions: {
    checkToken() {
      let token = localStorage.getItem('api_token')
      return !!token
    }
  },
  modules: {
    //
  },
  getters: {
    //
  },
})
