import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
import { attempt } from 'lodash'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
      token: '',
      user: '',
      login_in_state: false
    },
    mutations: {
      SET_TOKEN: (state, token) => {
        state.token = token
      },
      SET_USER: (state, user) => {
        state.user = user
      },
      SET_LOGIN_STATE: (state, value) => {
        state.login_in_state = value
      },
    },
    actions: {
      async signIn({ dispatch}, credentials) {
        // console.log(credentials)
        let response = await axios.post('api/v1/user/login', credentials)
     
        let new_token = response.data.access_token   
  
        dispatch('attempt', new_token)
        // console.log(response.data)
        // return response
      },
      async attempt({commit}, new_token) {
       
        commit('SET_TOKEN', new_token)
        let stored_token = ''
        if(localStorage.getItem("user_token") === null) {
          stored_token = new_token
          console.log('wala')
        } else {
          
          stored_token = localStorage.user_token
        }
        console.log(stored_token)
        let res = await axios.get('api/v1/user/auth', {
          headers: {
            'Authorization': 'Bearer ' + stored_token
          }
        })
        .then(response => {
          localStorage.setItem('user_token', stored_token)
          localStorage.setItem('key', 123)
          commit('SET_USER', response.data)
          commit('SET_LOGIN_STATE', true)
        })
      }
    },
    getters: {
      this_token: state => state.token,
      this_user: state => state.user,
      this_login_state: state => state.login_in_state
    },
    modules: {
      // dataStore
    },
    // plugins: [dataState]
})

export default store
