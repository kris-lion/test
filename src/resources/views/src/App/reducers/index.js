import { combineReducers } from 'redux'

import application from './application'
import alert from './alert'
import authentication from  '../../Auth/reducers/authentication'
import account from '../../Account/reducers/account'
import item from '../../Item/reducers/item'
import category from '../../Category/reducers/category'
import attribute_type from '../../Category/reducers/Attribute/type'
import role from '../../Access/reducers/role'
import permission from '../../Access/reducers/permission'
import user from '../../Access/reducers/user'

const AppReducers = combineReducers({
    application,
    alert,
    authentication,
    account,
    item,
    category,
    attribute_type,
    role,
    permission,
    user
})

export default AppReducers
