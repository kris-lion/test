export default function dictionary (state = { generics: [] }, action) {
    switch (action.type) {
        case 'DICTIONARY_GENERICS_REQUEST':
            return {
                generics: state.generics
            }
        case 'DICTIONARY_GENERICS_SUCCESS':
            return {
                generics: action.payload
            }
        case 'DICTIONARY_GENERICS_FAILURE':
            return {
                generics: []
            }
        case 'DICTIONARY_GENERICS_CLEAR':
            return {
                generics: []
            }
        default:
            return state
    }
}
