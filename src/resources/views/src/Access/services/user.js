import { HttpService } from '../../App/services/http'

export const UserService = {
    users
}

function users (params = null) {
    const options = {
        method: 'GET',
        params: params
    }

    return HttpService.http(`/users`, options, true)
        .then(response => {
            return response
        })
}
