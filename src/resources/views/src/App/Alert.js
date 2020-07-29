import React from 'react'
import { bindActionCreators } from 'redux'
import { connect } from 'react-redux'

import { withStyles } from '@material-ui/core/styles'
import { Snackbar, Fade, Typography } from '@material-ui/core'

import { AlertActions } from './actions/alert'

const style = theme => ({
  alert: {
    'border-radius': 0,
    'background': 'rgba(0, 0, 0, 0.75)',
    'color': '#FFFFFF'
  },
  text: {
    'margin-bottom': 0
  }
})

class Alert extends React.Component {
  handleCloseAlert = () => {
    const { actions } = this.props

    actions.clear()
  }

  render() {
    const { classes, alert } = this.props

    if (alert.message) {
      return (
        <Snackbar
          ContentProps={{
            classes: {
              root: classes.alert
            }
          }}
          anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
          open={ true }
          TransitionComponent={ Fade }
          onClose={ this.handleCloseAlert }
          message={ <Typography className={ classes.text } gutterBottom color='inherit'>{ alert.message }</Typography> }
        />
      )
    } else {
      return null
    }
  }
}

function mapStateToProps(state) {
  const { alert } = state

  return {
    alert
  }
}

function mapDispatchToProps(dispatch) {
  return {
    actions: bindActionCreators(AlertActions, dispatch)
  }
}

Alert = withStyles(style)(Alert)

const connectedAlert = connect(mapStateToProps, mapDispatchToProps)(Alert)
export { connectedAlert as Alert }
