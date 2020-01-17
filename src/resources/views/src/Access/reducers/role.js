export default function role (state = { roles: { data: [], meta: {}, search: null, limit: 10, page: 1 } }, action) {
    switch (action.type) {
        case 'ROLES_REQUEST':
            return {
                roles: state.roles
            }
        case 'ROLES_SUCCESS':
            return {
                roles: action.payload
            }
        case 'ROLES_FAILURE':
            return {
                roles: { data: [], meta: {}, search: state.roles.search, limit: state.roles.limit, page: state.roles.page }
            }
        case 'ROLES_CLEAR':
            return {
                roles: { data: [], meta: {}, search: null, limit: 10, page: 1 }
            }
        case 'ROLE_DELETE_REQUEST':
            return {
                roles: state.roles
            }
        case 'ROLE_DELETE_SUCCESS':
            return {
                roles: { data: state.roles.data.filter(role => role.id !== action.payload), meta: state.roles.meta }
            }
        case 'ROLE_DELETE_FAILURE':
            return {
                roles: state.roles
            }
        case 'ROLE_ADD_REQUEST':
            return {
                roles: state.roles
            }
        case 'ROLE_ADD_SUCCESS':
            return {
                roles: state.roles
            }
        case 'ROLE_ADD_FAILURE':
            return {
                roles: state.roles
            }
        case 'ROLE_SAVE_REQUEST':
            return {
                roles: state.roles
            }
        case 'ROLE_SAVE_SUCCESS':
            state.roles.data.forEach(function (role, key) {
                if (role.id === action.payload.id) {
                    state.roles.data[key] = action.payload
                }
            })
            return {
                roles: state.roles
            }
        case 'ROLE_SAVE_FAILURE':
            return {
                roles: state.roles
            }
        default:
            return state
    }
}
