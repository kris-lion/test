import { HttpService } from '../../../App/services/http'

export const TypeService = {
    types
}

function types (l) {
    const options = {
        method: 'GET'
    }

    return HttpService.http(`/category/attribute/types`, options, true)
        .then(response => {
            return response.data
        })
}
