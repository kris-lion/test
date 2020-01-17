import { HttpService } from '../../App/services/http'

export const UserService = {
    users,
    add,
    save,
    remove
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

function add (values) {
    const options = {
        method: 'POST',
        body: JSON.stringify(values)
    }

    return HttpService.http(`/user`, options, true)
        .then(response => {
            return response.data
        })
}

function save (id, values) {
    const options = {
        method: 'PUT',
        body: JSON.stringify(values)
    }

    return HttpService.http(`/user/${id}`, options, true)
        .then(response => {
            return response.data
        })
}

function remove (id) {
    const options = {
        method: 'DELETE'
    }

    return HttpService.http(`/user/${id}`, options, true)
        .then(response => {
            return response
        })
}
