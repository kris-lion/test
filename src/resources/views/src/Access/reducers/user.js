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
        case 'USER_DELETE_REQUEST':
            return {
                users: state.users
            }
        case 'USER_DELETE_SUCCESS':
            return {
                users: { data: state.users.data.filter(user => user.id !== action.payload), meta: state.users.meta }
            }
        case 'USER_DELETE_FAILURE':
            return {
                users: state.users
            }
        case 'USER_ADD_REQUEST':
            return {
                users: state.users
            }
        case 'USER_ADD_SUCCESS':
            return {
                users: state.users
            }
        case 'USER_ADD_FAILURE':
            return {
                users: state.users
            }
        case 'USER_SAVE_REQUEST':
            return {
                users: state.users
            }
        case 'USER_SAVE_SUCCESS':
            state.users.data.forEach(function (user, key) {
                if (user.id === action.payload.id) {
                    state.users.data[key] = action.payload
                }
            })
            return {
                users: state.users
            }
        case 'USER_SAVE_FAILURE':
            return {
                users: state.users
            }
        default:
            return state
    }
}
