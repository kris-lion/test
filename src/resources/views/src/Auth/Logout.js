import React from 'react'
import { bindActionCreators } from 'redux'
import { connect } from 'react-redux'

import { AuthActions } from './actions/authentication'

class Logout extends React.Component {
  componentDidMount() {
    const { actions } = this.props

    actions.logout()
  }

  render() {
    return null
  }
}

function mapStateToProps(state) {
  return {}
}

function mapDispatchToProps(dispatch) {
  return {
    actions: bindActionCreators(AuthActions, dispatch)
  }
}

const connectedLogout = connect(mapStateToProps, mapDispatchToProps)(Logout)
export { connectedLogout as Logout }
