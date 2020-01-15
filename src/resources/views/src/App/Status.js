import React from 'react'
import { connect } from 'react-redux'

import { withStyles } from '@material-ui/core/styles';
import Grid  from '@material-ui/core/Grid';
import Typography  from '@material-ui/core/Typography';

const style = theme => ({
    container: {
        'border-radius': 0,
        'height': '100%'
    }
})

class NotFound extends React.Component {
    render() {
        const { classes } = this.props

        return (
            <Grid container direction='row' justify='center' alignItems='center' className={classes.container}>
                <Grid item>
                    <Grid container direction='row' justify='center' alignItems='flex-start' className={classes.container} spacing={4}>
                        <Grid item>
                            <Typography variant="h1" component="h2" gutterBottom>404</Typography>
                        </Grid>
                        <Grid item>
                            <Grid container direction='column' justify='flex-start' alignItems='flex-start' className={classes.container}>
                                <Grid item>
                                    <Typography variant="h3" gutterBottom>Страница не найдена</Typography>
                                </Grid>
                                <Grid item>
                                    <Typography variant="body1" gutterBottom>К сожалению, страница не найдена</Typography>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                </Grid>
            </Grid>
        )
    }
}

NotFound = withStyles(style)(NotFound)

class Forbidden extends React.Component {
    render() {
        const { classes } = this.props

        return (
            <Grid container direction='row' justify='center' alignItems='center' className={classes.container}>
                <Grid item>
                    <Grid container direction='row' justify='center' alignItems='flex-start' className={classes.container} spacing={4}>
                        <Grid item>
                            <Typography variant="h1" component="h2" gutterBottom>401</Typography>
                        </Grid>
                        <Grid item>
                            <Grid container direction='column' justify='flex-start' alignItems='flex-start' className={classes.container}>
                                <Grid item>
                                    <Typography variant="h3" gutterBottom>Доступ запрещён</Typography>
                                </Grid>
                                <Grid item>
                                    <Typography variant="body1" gutterBottom>К сожалению, у Вас нет доступ к выбранной странице</Typography>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                </Grid>
            </Grid>
        )
    }
}

Forbidden = withStyles(style)(Forbidden)

class Error extends React.Component {
    render() {
        const { classes } = this.props

        return (
            <Grid container direction='row' justify='center' alignItems='center' className={classes.container}>
                <Grid item>
                    <Grid container direction='row' justify='center' alignItems='flex-start' className={classes.container} spacing={4}>
                        <Grid item>
                            <Typography variant="h1" component="h2" gutterBottom>500</Typography>
                        </Grid>
                        <Grid item>
                            <Grid container direction='column' justify='flex-start' alignItems='flex-start' className={classes.container}>
                                <Grid item>
                                    <Typography variant="h3" gutterBottom>Ошибка</Typography>
                                </Grid>
                                <Grid item>
                                    <Typography variant="body1" gutterBottom>Произошла ошибка, повторите попытку</Typography>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Grid>
                </Grid>
            </Grid>
        )
    }
}

Error = withStyles(style)(Error)

function mapStateToProps(state) {
    return {}
}

const connectedNotFound = connect(mapStateToProps)(NotFound)
const connectedForbidden = connect(mapStateToProps)(Forbidden)
const connectedError = connect(mapStateToProps)(Error)

export { connectedNotFound as NotFound, connectedForbidden as Forbidden, connectedError as Error}
