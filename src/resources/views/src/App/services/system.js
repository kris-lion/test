import { HttpService } from '../../App/services/http'

export const SystemService = {
    categories
}

function categories () {
    const options = {
        method: 'GET'
    }

    return HttpService.http(`/categories`, options, true)
        .then(response => {
            return response.data
        })
}
