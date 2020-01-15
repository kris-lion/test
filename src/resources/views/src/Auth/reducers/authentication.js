export default function authentication(state = {}, action) {
    switch (action.type) {
        case 'AUTH_LOGIN_REQUEST':
            return {}
        case 'AUTH_LOGIN_SUCCESS':
            return {}
        case 'AUTH_LOGIN_FAILURE':
            return {}
        case 'AUTH_LOGOUT_REQUEST':
            return {}
        case 'AUTH_LOGOUT_SUCCESS':
            return {}
        default:
            return state
    }
}
