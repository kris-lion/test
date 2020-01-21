import { HttpService } from '../../App/services/http'

export const ItemService = {
    items
}

function items (params = null) {
    const options = {
        method: 'GET',
        params: params
    }

    return HttpService.http(`/items`, options, true)
        .then(response => {
            return response
        })
}
