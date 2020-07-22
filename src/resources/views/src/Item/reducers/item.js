export default function item (state = { items: { data: [], meta: {}, category: null, limit: 100, page: 1 } }, action) {
    switch (action.type) {
        case 'ITEMS_REQUEST':
            return {
                items: state.items
            }
        case 'ITEMS_SUCCESS':
            return {
                items: action.payload
            }
        case 'ITEMS_FAILURE':
            return {
                items: { data: [], meta: {}, category: state.items.category, limit: state.items.limit, page: state.items.page }
            }
        case 'ITEMS_CLEAR':
            return {
                items: { data: [], meta: {}, category: null, limit: 10, page: 1 }
            }
        case 'ITEM_DELETE_REQUEST':
            return {
                items: state.items
            }
        case 'ITEM_DELETE_SUCCESS':
            return {
                items: { data: state.items.data.filter(item => item.id !== action.payload), meta: state.items.meta }
            }
        case 'ITEM_DELETE_FAILURE':
            return {
                items: state.items
            }
        case 'ITEM_ADD_REQUEST':
            return {
                items: state.items
            }
        case 'ITEM_ADD_SUCCESS':
            return {
                items: state.items
            }
        case 'ITEM_ADD_FAILURE':
            return {
                items: state.items
            }
        case 'ITEM_SAVE_REQUEST':
            return {
                items: state.items
            }
        case 'ITEM_SAVE_SUCCESS':
            state.items.data.forEach(function (item, key) {
                if (item.id === action.payload.id) {
                    state.items.data[key] = action.payload
                }
            })
            return {
                items: state.items
            }
        case 'ITEM_SAVE_FAILURE':
            return {
                items: state.items
            }
        default:
            return state
    }
}
