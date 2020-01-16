import { HttpService } from '../../App/services/http'

export const RoleService = {
    roles
}

function roles (params = null) {
    const options = {
        method: 'GET',
        params: params
    }

    return HttpService.http(`/user/roles`, options, true)
        .then(response => {
            return response
        })
}
