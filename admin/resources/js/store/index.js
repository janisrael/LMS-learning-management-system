import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
// import { attempt } from 'lodash'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    token: '',
    user: '',
    login_in_state: false,
    v_courses: [],
    v_chapters: [],
    v_lessons: [],
    v_authors: [],
    v_categories: [],
    v_subscriptions: [],
    v_component_name: 'LoginComponent',
    v_component_state: false,
    v_selected: {}
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
    },
    GET_COURSES: (state, authors) => {
      state.v_courses = authors
    },
    GET_COMPONENT_NAME: (state, name) => {
      state.v_component_name = name
    },
    GET_COMPONENT_STATE: (state, value) => {
      state.v_component_state = value
    },
    GET_AUTHORS: (state, authors) => {
      state.v_authors = authors
    },
    GET_SUBSCRIPTIONS: (state, subscriptions) => {
      state.v_subscriptions = subscriptions
    },
    Add_COURSE: (state, course) => {
      state.v_courses.push(course)
    },
    UPDATE_COURSE: (state, data) => {
      let collection = state.v_courses
      collection[data.index] = data.course
      state.v_courses = collection
    },
    SET_SELECTED: (state, value) => {
      state.v_selected = value
    },
    GET_CATEGORIES: (state, value) => {
      state.v_categories = value
    }
  },
  actions: {
    async signIn({ dispatch }, credentials) {
      let response = await axios.post('api/v1/user/login', credentials)
      let new_token = response.data.access_token
      localStorage.setItem('user_token', new_token)
      dispatch('attempt', new_token)
    },
    async attempt({ commit, dispatch }, new_token) {
      commit('SET_TOKEN', new_token)
      let stored_token = ''
      const has_local_token = localStorage.getItem('user_token') || 'new'
      if (has_local_token !== 'new') {
        stored_token = new_token

        // stored_token = localStorage.setItem('user_token', new_token)
      } else {
        stored_token = localStorage.setItem('user_token', stored_token)
      }
      let res = await axios.get('api/v1/user/auth', {
        headers: {
          'Authorization': 'Bearer ' + stored_token
        }
      })
        .then(response => {
          localStorage.setItem('user_token', stored_token)
          dispatch('GetCourses', stored_token)
          dispatch('GetAuthors', stored_token)
          dispatch('GetSubscriptions', stored_token)
          dispatch('GetCategories', stored_token)
          commit('SET_USER', response.data)
          commit('SET_LOGIN_STATE', true)
          commit('SET_LOGOUT_COMPONENT', 'MainWrapperComponent')
        }).catch(error => {
          localStorage.removeItem('user_token')
          commit('SET_LOGOUT_COMPONENT', 'LoginComponent')
        })
    },
    async handleLogout({ commit }, value) {
      let res = await axios.post('logout').then(response => {
        localStorage.removeItem('user_token');
        commit('SET_LOGOUT_COMPONENT', 'LoginComponent')
      })
    },
    async handleCheckState({ commit , dispatch }, value) {
      // let res = await axios.post('logout').then(response => {
      // localStorage.removeItem('user_token');
      let mytoken = localStorage.getItem('user_token')
      commit('SET_TOKEN', mytoken)
      commit('SET_LOGOUT_COMPONENT', 'MainWrapperComponent')
      dispatch('attempt', mytoken)
      // })
    },
    async GetCourses({ commit, state }, value) {
      return new Promise((resolve, reject) => {
        axios.get('/api/v1/courses', {
          headers: {
            'Authorization': 'Bearer ' + value
          },
          params: {
            term: '',
            author_id: 1
          }
        }).then(response => {
          commit('GET_COURSES', response.data.course)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    GetComponentName({ commit, state }, value) {
      console.log(value, 'GET_COMPONENT_NAME')
      return commit('GET_COMPONENT_NAME', value)
    },
    GetComponmentState({ commit, state }, value) {
      return commit('GET_COMPONENT_STATE', value)
    },
    GetAuthors({ commit, state }, value) {
      return new Promise((resolve, reject) => {
        var AjaxUrl = "/api/v1/authors";
        axios.get(AjaxUrl, {
          headers: {
            'Authorization': 'Bearer ' + value
          },
        })
          .then(response => {
            commit('GET_AUTHORS', response.data.authors)
            resolve(response)
          }).catch(error => {
            reject(error)
          })
      })
    },
    GetCategories({commit,state}, value) {
      return new Promise((resolve, reject) => {
        axios.get('/api/v1/category', {
          headers: {
            'Authorization': 'Bearer ' + value
          },
        }).then(response => {
          commit('GET_CATEGORIES', response.data.category)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    GetSubscriptions({ commit, state }, value) {
      return new Promise((resolve, reject) => {
        axios.get('/api/v1/subscriptions', {
          headers: {
            'Authorization': 'Bearer ' + value
          },
        }).then(response => {
          commit('GET_SUBSCRIPTIONS', response.data.subscription_product)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    AddCourse({ commit, state }, value) {
      console.log(localStorage.getItem('user_token'),'aksdhkajsd')
      return new Promise((resolve, reject) => {
        axios.post('/api/v1/courses', value, {
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('user_token'),
            'Accept': '*/*'
          }
          
        }).then(response => {
          let res = response.data.data
          res.attachment_absolute_path = window.ENV.APP_URL + '/storage/' + res.course_image_url
          commit('Add_COURSE', res)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    EditCourse({ commit, state }, value) {
      let index = value.index
      let data = {
        course: '',
        index: ''
      }
      return new Promise((resolve, reject) => {
        axios.put('/api/v1/courses/edit/' + value.id, value, {
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('user_token'),
            'Accept': '*/*'
          }
          
        }).then(response => {
          let res = response.data.data
          
          res.attachment_absolute_path = window.ENV.APP_URL + '/storage/' + res.course_image_url
          data.course = res
          data.index = index
          commit('UPDATE_COURSE', data)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    SetSelected({ commit, state }, value) {
      commit('SET_SELECTED', value)
    }
  },
  getters: {
    this_token: state => state.token,
    this_user: state => state.user,
    this_login_state: state => state.login_in_state,
    this_component_name: state => state.v_component_name,
    allCourses: state => state.v_courses,
    componentName: state => state.v_component_name,
    componentState: state => state.v_component_state,
    allAuthors: state => state.v_authors,
    allSubscriptions: state => state.v_subscriptions,
    this_selected: state => state.v_selected,
    this_categories: state => state.v_categories,
  },
  modules: {
    // dataStore
  }
})

export default store
