export default function permission (state = { permissions: [] }, action) {
    switch (action.type) {
        case 'PERMISSIONS_REQUEST':
            return {
                permissions: state.permissions
            }
        case 'PERMISSIONS_SUCCESS':
            return {
                permissions: action.payload
            }
        case 'PERMISSIONS_FAILURE':
            return {
                permissions: []
            }
        case 'PERMISSIONS_CLEAR':
            return {
                permissions: []
            }
        default:
            return state
    }
}
