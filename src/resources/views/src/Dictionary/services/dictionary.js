import { HttpService } from '../../App/services/http'

export const DictionaryService = {
    generics
}

function generics (l) {
    const options = {
        method: 'GET'
    }

    return HttpService.http(`/dictionary/generics`, options, true)
        .then(response => {
            return response.data
        })
}
