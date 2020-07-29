import React from 'react'
import { connect } from 'react-redux'

import { withStyles } from '@material-ui/core/styles';
import { Grid, CircularProgress }  from '@material-ui/core';

const style = theme => ({
    root: {
        'height': '100%',
        'width': '100%',
        'display': 'flex',
        'z-index': 1600,
        'position': 'fixed',
        'opacity': 1,
        'background': '#ffffff'
    }
})

class Loading extends React.Component {
    render() {
        const { application, classes } = this.props

        if (application.loading) {
            return (
                <Grid item className={ classes.root }>
                    <Grid container alignItems='center' direction='column' justify='center'>
                        <Grid item>
                            <CircularProgress />
                        </Grid>
                    </Grid>
                </Grid>
            )
        } else {
            return null
        }
    }
}

function mapStateToProps(state) {
    const { application } = state

    return {
        application
    }
}

Loading = withStyles(style)(Loading)

const connectedLoading = connect(mapStateToProps)(Loading)
export { connectedLoading as Loading }
