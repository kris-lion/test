export default function alert(state = {}, action) {
    switch (action.type) {
        case 'ALERT_SUCCESS':
            return {
                message: action.payload
            }
        case 'ALERT_ERROR':
            return {
                message: action.payload
            }
        case 'ALERT_CLEAR':
            return {}
        default:
            return state
    }
}
