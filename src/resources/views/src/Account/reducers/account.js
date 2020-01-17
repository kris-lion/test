export default function account(state = { account: JSON.parse(localStorage.getItem('account')) }, action) {
    switch (action.type) {
        case 'ACCOUNT_REQUEST':
            return {
                account: state.account
            }
        case 'ACCOUNT':
            return {
                account: action.payload,
                load: true
            }
        case 'ACCOUNT_FAILURE':
            return {
                account: state.account
            }
        default:
            return state
    }
}
