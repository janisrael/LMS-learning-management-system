import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
import { attempt } from 'lodash'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
      token: '',
      user: '',
      login_in_state: false,
      v_component_name: ''
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
      SET_LOGOUT_COMPONENT: (state, component) => {
        state.v_component_name = component
      }
    },
    actions: {
      async signIn({ dispatch}, credentials) {
        let response = await axios.post('api/v1/user/login', credentials)
        let new_token = response.data.access_token   
        dispatch('attempt', new_token)
      },
      async attempt({commit}, new_token) {
        commit('SET_TOKEN', new_token)
        let stored_token = ''
        if(localStorage.getItem("user_token") === null) {
          stored_token = new_token
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
          commit('SET_LOGOUT_COMPONENT', 'MainWrapperComponent')
        }).catch(error => {
          commit('SET_LOGOUT_COMPONENT', 'LoginComponent')
      })
      },
      async handleLogout({commit, state}, value) {
        let res = await axios.post('logout').then(response => {
          localStorage.removeItem('user_token');
          commit('SET_LOGOUT_COMPONENT', 'LoginComponent')    
        })
      }
    },
    getters: {
      this_token: state => state.token,
      this_user: state => state.user,
      this_login_state: state => state.login_in_state,
      this_component_name: state => state.v_component_name
    },
    modules: {
      // dataStore
    }
})

export default store
