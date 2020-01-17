import { HttpService } from '../../App/services/http'

export const CategoryService = {
    categories
}

function categories (params = null) {
    const options = {
        method: 'GET',
        params: params
    }

    return HttpService.http(`/product/categories`, options, true)
        .then(response => {
            return response
        })
}
