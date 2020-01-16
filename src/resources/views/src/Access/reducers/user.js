export default function user (state = { users: { data: [], meta: {}, search: null, limit: 10, page: 1 } }, action) {
    switch (action.type) {
        case 'USERS_REQUEST':
            return {
                users: state.users
            }
        case 'USERS_SUCCESS':
            return {
                users: action.payload
            }
        case 'USERS_FAILURE':
            return {
                users: { data: [], meta: {}, search: state.users.search, limit: state.users.limit, page: state.users.page }
            }
        case 'USERS_CLEAR':
            return {
                users: { data: [], meta: {}, search: null, limit: 10, page: 1 }
            }
        default:
            return state
    }
}
