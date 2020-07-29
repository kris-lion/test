export default function unit (state = { units: [] }, action) {
    switch (action.type) {
        case 'UNITS_REQUEST':
            return {
                units: state.units
            }
        case 'UNITS_SUCCESS':
            return {
                units: action.payload
            }
        case 'UNITS_FAILURE':
            return {
                units: []
            }
        case 'UNITS_CLEAR':
            return {
                units: []
            }
        default:
            return state
    }
}
