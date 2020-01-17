export default function product (state = { products: { data: [], meta: {}, search: null, limit: 10, page: 1 } }, action) {
    switch (action.type) {
        case 'PRODUCTS_REQUEST':
            return {
                products: state.products
            }
        case 'PRODUCTS_SUCCESS':
            return {
                products: action.payload
            }
        case 'PRODUCTS_FAILURE':
            return {
                products: { data: [], meta: {}, search: state.products.search, limit: state.products.limit, page: state.products.page }
            }
        case 'PRODUCTS_CLEAR':
            return {
                products: { data: [], meta: {}, search: null, limit: 10, page: 1 }
            }
        default:
            return state
    }
}
