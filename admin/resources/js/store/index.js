import Vue from 'vue'
import Vuex from 'vuex'
import * as lesson from './modules/lessons.js'
// import VueRouter from 'vue-router';
// import { attempt } from 'lodash'

Vue.use(Vuex)

const store = new Vuex.Store({
  namespaced: true,
  modules: {
    lesson
  },
  state: {
    token: '',
    user: '',
    login_in_state: false,
    v_courses: [],
    v_chapters: [],
    v_lessons: [],
    v_authors: [],
    v_chapters: [],
    v_categories: [],
    v_subscriptions: [],
    v_component_name: 'LoginComponent',
    v_component_state: false,
    v_selected: {},
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
    },
    GET_CHAPTERS: (state, chapters) => {
      state.v_chapters = chapters
    }
  },
  actions: {
    async changeRoute(to, from, next) {
      try {
          let user = await store.dispatch('Auth/getUser');

          if (!user.email_verified_at) {
              return _user.mustBeVerified(user, next);
          }

          if (
              !user.profile.finished_enrolment &&
              !user.hasActiveSubscription
          ) {
              return _user.mustHaveFinishedEnrolment(user, next);
          }

          next({ name: 'landing' });
      } catch (err) {
          next();
      }
    },
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
          console.log(response)
          localStorage.removeItem('user_token')
          localStorage.setItem('user_token', response.data.access_token)
          stored_token = localStorage.getItem('user_token')
          
          commit('SET_TOKEN', stored_token)
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
        localStorage.clear()
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
            'Authorization': 'Bearer ' + state.token,
          },
          params: {
            term: '',
            author_id: 1
          }
        }).then(response => {
          let arr = response.data.course
          arr.forEach((value, i) => {
            // if(value.hasOwnProperty.call(value.is_active)) {
              let x = null
              x = parseInt(value.is_active)
              value.is_active = !!x
            // }
            // if(value.hasOwnProperty(value.is_featured)) {
               x = parseInt(value.is_featured)
              value.is_featured = !!x
            // }
            // if(value.hasOwnProperty(value.is_global)) {
               x = parseInt(value.is_global)
              value.is_global = !!x
              
              x = parseInt(value.is_live)
              value.is_live = !!x
            // }
         
          })
          
          console.log(arr,'boolean')
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
            'Authorization': 'Bearer ' + state.token,
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
            'Authorization': 'Bearer ' + state.token,
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
            'Authorization': 'Bearer ' + state.token,
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
            'Authorization': 'Bearer ' + state.token,
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
            'Authorization': 'Bearer ' + state.token,
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
    DeleteFunction({ commit, state }, value) {
      let index = value.index
      let data = {
        course: value.data,
        index: value.index
      }
      return new Promise((resolve, reject) => {
        axios.get('/api/v1/courses/delete/' + value.data.id, {
          headers: {
            'Authorization': 'Bearer ' + state.token,
            'Accept': '*/*'
          }
        }).then(response => {
          let res = response 
          // res.attachment_absolute_path = window.ENV.APP_URL + '/storage/' + res.course_image_url
          // data.course = res
          // data.index = index
          // commit('UPDATE_COURSE', data)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
    SetSelected({ commit, state }, value) {
      commit('SET_SELECTED', value)
    },
    GetChapters({ commit, state }, id) {
      return new Promise((resolve, reject) => {
        var AjaxUrl = "/api/v1/chapters";
        axios.get(AjaxUrl, {
          headers: {
            'Authorization': 'Bearer ' + state.token,
          },
          params: {
            term: '',
            id: id
          }
        })
        .then(response => {
          commit('GET_CHAPTERS', response.data.chapter)
          console.log(response.data.chapter)
          resolve(response)
        }).catch(error => {
          reject(error)
        })
      })
    },
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
    this_chapters: state => state.v_chapters,
    // lesson.js
    this_lessons: state => state.lesson.v_lessons,
    this_lessons_by_chapter: state => state.lesson.v_lessons_by_chapter
  }

})

export default store
