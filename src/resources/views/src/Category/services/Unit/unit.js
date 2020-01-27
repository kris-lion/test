import { HttpService } from '../../../App/services/http'

export const UnitService = {
    units
}

function types (l) {
    const options = {
        method: 'GET'
    }

    return HttpService.http(`/units`, options, true)
        .then(response => {
            return response.data
        })
}
