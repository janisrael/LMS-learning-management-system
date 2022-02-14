import Vue from 'vue'
import axios from 'axios'
import Vuex from 'vuex'
Vue.use(Vuex)

// const lesson = new Vuex.Store({
  // namespaced: true,
  export const state = {
    v_lessons: [],
    v_lessons_by_chapter: {}
  }
  export const mutations = {
    GET_LESSONS: (state, lessons) => {
      state.v_lessons = lessons
    },
    GET_LESSONS_BY_CHAPTER: (state, lessons_by_chapter) => {
      state.v_lessons_by_chapter = lessons_by_chapter
    },
    ADD_LESSON: (state, lesson) => {
      // state.v_lessons = lessons
    },
    EDIT_LESSON: (state, lesson) => {

    },
    DELETE_LESSON: (state, lesson) => {

    }
  }
  export const actions = {
    getLessons({ commit, dispatch, rootState }, id) {
      console.log(rootState,'root')
        return new Promise((resolve, reject) => {
          var AjaxUrl = "/api/v1/lessons";
          axios.get(AjaxUrl, {
            headers: {
              'Authorization': 'Bearer ' + rootState.token
            },
            params: {
              term: '',
              id: id
            }
          })
          .then(response => {
            console.log(response,'ress')
            commit('GET_LESSONS', response.data.lesson)
            
            resolve(response)
          }).catch(error => {
            reject(error)
          })
        })
    },
    addtLesson({ commit, dispatch, rootState }, value) {
      console.log(rootState,'root')
        return new Promise((resolve, reject) => {
          var AjaxUrl = "/api/v1/lessons";
          axios.post(AjaxUrl, value, {
            headers: {
              'Authorization': 'Bearer ' + rootState.token
            }
          })
          .then(response => {
            console.log(response,'ress')
            commit('GET_LESSONS', response.data.lesson)
            
            resolve(response)
          }).catch(error => {
            reject(error)
          })
        })
    },
    edittLesson({ commit, dispatch, rootState }, value) {
        let index = value.index
        let data = {
          course: '',
          index: ''
        }
        return new Promise((resolve, reject) => {
          var AjaxUrl = "/api/v1/lessons/edit" + value.id
          axios.get(AjaxUrl, value, {
            headers: {
              'Authorization': 'Bearer ' + rootState.token
            }
          })
          .then(response => {
            data.course = res
            data.index = index
            commit('UPDATE_COURSE', data)
            resolve(response)
          }).catch(error => {
            reject(error)
          })
        })
    },
    DeleteLesson({ commit, state }, value) {
      let index = value.index
      let data = {
        course: value.data,
        index: value.index
      }
      return new Promise((resolve, reject) => {
        axios.get('/api/v1/lessons/delete/' + value.data.id, {
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('user_token'),
            'Accept': '*/*'
          }
        }).then(response => {
          let res = response
          console.log(res)          
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
    getLessonsByChapter({ commit, dispatch, rootState }, course_id) {
        return new Promise((resolve, reject) => {
          var AjaxUrl = "/api/v1/lessons/by-chapter"
          axios.get(AjaxUrl, {
            headers: {
              'Authorization': 'Bearer ' + rootState.token
            },
            params: {
              term: '',
              course_id: course_id
            }
          })
          .then(response => {
            console.log(response.data.data,'ress')
            commit('GET_LESSONS_BY_CHAPTER', response.data)
            
            resolve(response)
          }).catch(error => {
            reject(error)
          })
        })
    },
  }


// })

// export default lesson
