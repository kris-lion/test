import { HttpService } from '../../App/services/http'

export const PermissionService = {
    permissions
}

function permissions (l) {
    const options = {
        method: 'GET'
    }

    return HttpService.http(`/user/role/permissions`, options, true)
        .then(response => {
            return response.data
        })
}
