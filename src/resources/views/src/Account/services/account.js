import { HttpService } from '../../App/services/http'

export const AccountService = {
  account
}

function account() {
  const options = {
      method: 'GET'
  }

  return HttpService.http('/account?include=roles.permissions', options, true)
    .then(response => {
      if (response.account) {
        localStorage.setItem('account', JSON.stringify(response.account))
      }

      return response.account
    })
}
