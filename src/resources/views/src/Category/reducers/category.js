<<<<<<< HEAD
export default function category (state = { categories: { data: [], meta: {}, search: null, limit: 10, page: 1 } }, action) {
=======
export default function category (state = { categories: { data: [], meta: {}, search: null, limit: 100, page: 1 } }, action) {
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
        case 'CATEGORY_DELETE_REQUEST':
            return {
                categories: state.categories
            }
        case 'CATEGORY_DELETE_SUCCESS':
            return {
                categories: { data: state.categories.data.filter(category => category.id !== action.payload), meta: state.categories.meta }
            }
        case 'CATEGORY_DELETE_FAILURE':
            return {
                categories: state.categories
            }
        case 'CATEGORY_ADD_REQUEST':
            return {
                categories: state.categories
            }
        case 'CATEGORY_ADD_SUCCESS':
            return {
                categories: state.categories
            }
        case 'CATEGORY_ADD_FAILURE':
            return {
                categories: state.categories
            }
        case 'CATEGORY_SAVE_REQUEST':
            return {
                categories: state.categories
            }
        case 'CATEGORY_SAVE_SUCCESS':
            state.categories.data.forEach(function (category, key) {
                if (category.id === action.payload.id) {
                    state.categories.data[key] = action.payload
                }
            })
            return {
                categories: state.categories
            }
        case 'CATEGORY_SAVE_FAILURE':
            return {
                categories: state.categories
            }
        default:
            return state
    }
}
