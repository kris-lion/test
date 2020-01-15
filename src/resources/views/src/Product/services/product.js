import { HttpService } from '../../App/services/http'

export const ProductService = {
    products
}

function products (params = null) {
    const options = {
        method: 'GET',
        params: params
    }

    return HttpService.http(`/products`, options, true)
        .then(response => {
            return response
        })
}
