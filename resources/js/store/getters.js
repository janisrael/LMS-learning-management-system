const getters = {
    roles: state => { return state.user.roles },
    permissions: state => { return state.user.permissions },
    data: state => { return state.user.data },
    username: state => { return state.user.username },
    // allCourses: state => state.v_courses,
}
export default getters
