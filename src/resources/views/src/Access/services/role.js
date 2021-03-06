import { HttpService } from '../../App/services/http'

export const RoleService = {
    roles,
    add,
    save,
    remove
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

function add (values) {
    const options = {
        method: 'POST',
        body: JSON.stringify(values)
    }

    return HttpService.http(`/user/role`, options, true)
        .then(response => {
            return response.data
        })
}

function save (id, values) {
    const options = {
        method: 'PUT',
        body: JSON.stringify(values)
    }

    return HttpService.http(`/user/role/${id}`, options, true)
        .then(response => {
            return response.data
        })
}

function remove (id) {
    const options = {
        method: 'DELETE'
    }

    return HttpService.http(`/user/role/${id}`, options, true)
        .then(response => {
            return response
        })
}
