import { history } from '../../App/helpers/history'

export const HttpService = {
    http
}

function http(path, options = {}, authorization = false) {
    options.headers = Object.assign({
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    }, options.headers ? options.headers : {})

    if (authorization) {
        options.headers.Authorization = localStorage.getItem('token')
    }

    if (options.params && Object.keys(options.params).length) {
        path = `${path}?`

        let paramPath = false
        for (let name in options.params) {
            if (paramPath) {
                path = `${path}&`
            }

            if (options.params.hasOwnProperty(name)) {
                path = `${path}${name}=${options.params[name]}`
            }

            paramPath = true
        }
    }

    return fetch(`${process.env.REACT_APP_HOST_API}${path}`, options)
        .then(handleResponse)
}

function handleResponse(response) {
    let data
    let headers = response.headers

    if (headers.has('Authorization')) {
        localStorage.removeItem('token')
        localStorage.setItem('token', headers.get('Authorization'))
    }

    switch (response.status) {
        case 204:
            return response
        case 304:
            return response
        case 401:
            localStorage.removeItem('account')
            localStorage.removeItem('token')
            history.push('/logout')
            break
        default:
            data = response.json()
    }

    if (!response.ok) {
        return data.then(Promise.reject.bind(Promise))
    }

    return data
}
