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
        default:
            return state
    }
}
