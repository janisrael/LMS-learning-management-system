import Vue from 'vue'
import axios from 'axios'
import Vuex from 'vuex'
Vue.use(Vuex)

// const lesson = new Vuex.Store({
  // namespaced: true,
  export const state = {
    v_lessons: []
    
  }
  export const mutations = {
    GET_LESSONS: (state, lessons) => {
      state.v_lessons = lessons
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
  
      // return response
    }
  }


// })

// export default lesson
