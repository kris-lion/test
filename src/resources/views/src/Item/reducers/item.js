export default function item (state = { items: { data: [], meta: {}, search: null, limit: 10, page: 1 } }, action) {
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
                items: { data: [], meta: {}, search: state.items.search, limit: state.items.limit, page: state.items.page }
            }
        case 'ITEMS_CLEAR':
            return {
                items: { data: [], meta: {}, search: null, limit: 10, page: 1 }
            }
        default:
            return state
    }
}
