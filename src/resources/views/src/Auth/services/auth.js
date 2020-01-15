import { HttpService } from '../../App/services/http'

export const AuthService = {
    login,
    logout
}

function login(values) {
    const options = {
        method: 'POST',
        body: JSON.stringify(values)
    }

    return HttpService.http('/auth/login', options)
        .then(response => {
            if (response.account) {
                localStorage.setItem('account', JSON.stringify(response.account))
            }

            return response.account
        })
}

function logout() {
    const options = {
        method: 'GET'
    }

    return HttpService.http('/auth/logout', options, true)
}
