import { Commit, createStore } from 'vuex'

export default createStore({
  state: {
    authenticated: false,
    username: ''
  },
  getters: {
  },
  mutations: {
    SET_AUTH: (state: { authenticated: boolean }, auth: boolean) => state.authenticated = auth,
    SET_USERNAME: (state: {username: string}, name: string) => state.username = name
  },
  actions: {
    setAuth: ({commit}: { commit: Commit}, auth: boolean) => commit('SET_AUTH', auth),
    setUsername: ({commit}: {commit: Commit}, name: string) => commit('SET_USERNAME', name)
  },
  modules: {
  }
})
