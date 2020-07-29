import { HttpService } from '../../App/services/http'

export const ItemService = {
    items,
    count,
    offers,
    add,
    save,
    remove
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

function count (params = null) {
    const options = {
        method: 'GET',
        params: params
    }

    return HttpService.http(`/items/count`, options, true)
        .then(response => {
            return response
        })
}

function offers (params = null) {
    const options = {
        method: 'GET',
        params: params
    }

    return HttpService.http(`/items/offers`, options, true)
        .then(response => {
            return response
        })
}

function add (values) {
    const options = {
        method: 'POST',
        body: JSON.stringify(values)
    }

    return HttpService.http(`/item`, options, true)
        .then(response => {
            return response.data
        })
}

function save (id, values) {
    const options = {
        method: 'PUT',
        body: JSON.stringify(values)
    }

    return HttpService.http(`/item/${id}`, options, true)
        .then(response => {
            return response.data
        })
}

function remove (id) {
    const options = {
        method: 'DELETE'
    }

    return HttpService.http(`/item/${id}`, options, true)
        .then(response => {
            return response
        })
}
