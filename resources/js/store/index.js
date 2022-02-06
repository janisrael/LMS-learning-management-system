import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        permissions: [],
        data: [],
        username: '',
        v_authors: [],
        v_courses: [],
        v_chapters: [],
        v_lessons: [],
        v_subscriptions: [],
        roles: [],
        v_component_name: '',
        idleVue: false,
        v_component_state: false
    },
    mutations: {
        increment (state) {
            state.count++
        },
        SET_NAME: (state, name) => {
            state.name = name
        },
        SET_USER: (state, user) => {
            state.currentUser = user
            state.allowedViews = user.allowed_views
        },
        SET_ROLES: (state, roles) => {
            state.roles = roles
        },
        SET_PERMISSION: (state, permissions) => {
            state.permissions = permissions
        },
        SET_DATA: (state, data) => {
            state.data = data
        },
        SET_USERNAME: (state, username) => {
            state.username = username
        },
        GET_AUTHORS: (state, authors) => {
            state.v_authors = authors
        },
        GET_COURSES: (state, authors) => {
            state.v_courses = authors
        },
        GET_SUBSCRIPTIONS: (state, subscriptions) => {
            state.v_subscriptions = subscriptions
        },
        GET_COMPONENT_NAME: (state, name) => {
            state.v_component_name = name
        },
        GET_COMPONENT_STATE: (state, value) => {
            state.v_component_state = value
        }
    },
    actions: {
        increment () {
            // context.commit('increment')
            this.$store.commit('increment')
        },
        async GetInfo({ commit, state }) {
            return new Promise((resolve, reject) => {
                axios.get('/user-info')
                    .then(response => {
                        commit('SET_DATA', response.data)
                        commit('SET_PERMISSION', response.data.permissions)
                        commit('SET_ROLES', response.data.roles)
                        commit('SET_USERNAME', response.data.username)
                        resolve(response)
                    }).catch(error => {
                    reject(error)
                })
            })
        },
        GetAuthors({commit, state}, value) {
            return new Promise((resolve, reject) => {
                var AjaxUrl = "/authors";
                axios.get(AjaxUrl)
                    .then(response => {
                        commit('GET_AUTHORS', response.data.authors)
                        resolve(response)
                    }).catch(error => {
                    reject(error)
                })
            })
        },
        async GetCourses({commit, state}, value) {
            return new Promise((resolve, reject) => {
               axios.get('/courses', {
                    params: {
                        term: value.search,
                        author_id: value.author_id
                    }
                }).then(response => {
                    commit('GET_COURSES', response.data.course)
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        },
        GetSubscriptions({commit, state}, value) {
            return new Promise((resolve, reject) => {
               axios.get('/subscriptions').then(response => {
                    commit('GET_SUBSCRIPTIONS', response.data.subscription_products)
                    resolve(response)
                }).catch(error => {
                    reject(error)
                })
            })
        },
        GetComponentName({commit, state}, value) {
            return commit('GET_COMPONENT_NAME', value)
        },
        GetComponmentState({commit, state}, value) {
            return commit('GET_COMPONENT_STATE', value)
        }
    },
    getters: {
        userInfo: state => state.data,
        userPermissions: state => state.permissions,
        userRoles: state => state.roles,
        allCourses: state => state.v_courses,
        allAuthors: state => state.v_authors,
        allSubscriptions: state => state.v_subscriptions,
        componentName: state => state.v_component_name,
        componentState: state => state.v_component_state
    }
})

export default store
