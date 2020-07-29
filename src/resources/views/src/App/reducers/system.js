export default function system (state = { categories: [] }, action) {
    switch (action.type) {
        case 'SYSTEM_CATEGORIES_REQUEST':
            return {
                categories: state.categories
            }
        case 'SYSTEM_CATEGORIES_SUCCESS':
            return {
                categories: action.payload
            }
        case 'SYSTEM_CATEGORIES_FAILURE':
            return {
                categories: []
            }
        case 'SYSTEM_CATEGORIES_CLEAR':
            return {
                categories: []
            }
        default:
            return state
    }
}
