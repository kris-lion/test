import { HttpService } from '../../App/services/http'

export const CategoryService = {
    categories,
    add,
    save,
    remove
}

function categories (params = null) {
    const options = {
        method: 'GET',
        params: params
    }

    return HttpService.http(`/categories`, options, true)
        .then(response => {
            return response
        })
}

function add (values) {
    const options = {
        method: 'POST',
        body: JSON.stringify(values)
    }

    return HttpService.http(`/category`, options, true)
        .then(response => {
            return response.data
        })
}

function save (id, values) {
    const options = {
        method: 'PUT',
        body: JSON.stringify(values)
    }

    return HttpService.http(`/category/${id}`, options, true)
        .then(response => {
            return response.data
        })
}

function remove (id) {
    const options = {
        method: 'DELETE'
    }

    return HttpService.http(`/category/${id}`, options, true)
        .then(response => {
            return response
        })
}
