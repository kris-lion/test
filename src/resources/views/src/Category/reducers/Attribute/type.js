export default function type (state = { types: [] }, action) {
    switch (action.type) {
        case 'CATEGORY_ATTRIBUTE_TYPES_REQUEST':
            return {
                types: state.types
            }
        case 'CATEGORY_ATTRIBUTE_TYPES_SUCCESS':
            return {
                types: action.payload
            }
        case 'CATEGORY_ATTRIBUTE_TYPES_FAILURE':
            return {
                types: []
            }
        case 'CATEGORY_ATTRIBUTE_TYPES_CLEAR':
            return {
                types: []
            }
        default:
            return state
    }
}
