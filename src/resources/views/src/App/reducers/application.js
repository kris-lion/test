export default function application(state = { loading: false, filling: false, process: 0 }, action) {
    switch (action.type) {
        case 'LOADING':
            return {
                loading: action.payload ? action.payload : (!!(state.process - 1)),
                filling: state.filling,
                process: action.payload ? state.process + 1 : state.process - 1
            }
        case 'FILLING':
            return {
                loading: state.loading,
                filling: action.payload
            }
        default:
            return state
    }
}
