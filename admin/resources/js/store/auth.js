import Vue from 'vue'
import axios from 'axios'
import Vuex from 'vuex'
Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    token: null,
    user: null
  },
  mutations: {
   
  },
  actions: {
    async signIn({ commit, state }, credentials) {
      console.log(credentials)
      let response = await axios.post('api/v1/user/login', credentials)
      console.log(response)
      // return response
    }
  },
  getters: {
  
  },

})

export default store
