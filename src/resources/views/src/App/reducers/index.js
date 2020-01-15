import { combineReducers } from 'redux'

import application from './application'
import alert from './alert'
import authentication from  '../../Auth/reducers/authentication'
import account from '../../Account/reducers/account'
import product from '../../Product/reducers/product'
import category from '../../Product/reducers/category'

const AppReducers = combineReducers({
    application,
    alert,
    authentication,
    account,
    product,
    category
})

export default AppReducers
