export default function category (state = { categories: { data: [], meta: {}, search: null, limit: 10, page: 1 } }, action) {
    switch (action.type) {
        case 'CATEGORIES_REQUEST':
            return {
                categories: state.categories
            }
        case 'CATEGORIES_SUCCESS':
            return {
                categories: action.payload
            }
        case 'CATEGORIES_FAILURE':
            return {
                categories: { data: [], meta: {}, search: state.categories.search, limit: state.categories.limit, page: state.categories.page }
            }
        case 'CATEGORIES_CLEAR':
            return {
                categories: { data: [], meta: {}, search: null, limit: 10, page: 1 }
            }
        default:
            return state
    }
}
