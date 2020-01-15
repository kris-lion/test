import React from 'react'
import { connect } from 'react-redux'
import { Link } from 'react-router-dom';

import { fade, withStyles } from '@material-ui/core/styles';
import {
    AppBar,
    Container,
    Toolbar,
    Grid,  Paper, List, ListItem, ListItemText,
    Typography,
    Button, LinearProgress
} from '@material-ui/core';
import { bindActionCreators } from "redux";

const style = theme => ({
    container: {
        'height': 'calc(100% - 64px)',
        'margin-top': '64px'
    },
    body: {
        'height': '100%'
    },
    field: {
        'height': '100%',
        'padding': theme.spacing(1, 1)
    },
    content: {
        'height': '100%'
    },
    title: {
        'flex-grow': 1
    },
    search: {
        position: 'relative',
        borderRadius: theme.shape.borderRadius,
        backgroundColor: fade(theme.palette.common.white, 0.15),
        '&:hover': {
            backgroundColor: fade(theme.palette.common.white, 0.25),
        },
        marginRight: theme.spacing(2),
        marginLeft: 0,
        width: '100%',
        [theme.breakpoints.up('sm')]: {
            marginLeft: theme.spacing(3),
            width: 'auto',
        },
    },
    searchIcon: {
        width: theme.spacing(7),
        height: '100%',
        position: 'absolute',
        pointerEvents: 'none',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
    },
    inputRoot: {
        color: 'inherit',
    },
    inputInput: {
        padding: theme.spacing(1, 1, 1, 7),
        transition: theme.transitions.create('width'),
        width: '100%',
        [theme.breakpoints.up('md')]: {
            width: 200,
        },
    }
})

class App extends React.Component {
    constructor (props) {
        super(props)

        this.state = {
            list: [
                {
                    path: '/products',
                    name: 'Эталоны'
                },
                {
                    path: '/product/categories',
                    name: 'Категории эталонов'
                },
                {
                    path: '/access',
                    name: 'Управление доступом'
                }
            ]
        }
    }

    render() {
        const { location, application, content, classes } = this.props
        const { list } = this.state

        return (
            <Grid container direction='column' justify='flex-start' alignItems='stretch' className={classes.content}>
                <AppBar>
                    <Toolbar>
                        <Typography variant="h5" className={classes.title}>
                            Эталонный номенклатор
                        </Typography>
                        <Button
                            color="inherit"
                            component={Link}
                            to='/logout'
                        >
                            Выйти
                        </Button>
                    </Toolbar>
                    { application.filling && <LinearProgress /> }
                </AppBar>
                <Container fixed className={ classes.container }>
                    <Paper className={ classes.paper }>
                        <Grid container direction="row" justify="flex-start" alignItems="flex-start" className={ classes.body }>
                            <Grid item md={3}>
                                <List aria-label="contacts">
                                    {list.map(obj => {
                                        return (
                                            <ListItem key={ obj.path } selected={ location.pathname === obj.path } button component={ Link } to={ obj.path }>
                                                <ListItemText primary={ obj.name } />
                                            </ListItem>
                                        )
                                    })}
                                </List>
                            </Grid>
                            <Grid item md={9} className={ classes.field }>
                                { content }
                            </Grid>
                        </Grid>
                    </Paper>
                </Container>
            </Grid>
        )
    }
}

function mapStateToProps(state) {
    const { application } = state

    return {
        application,
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch
    }
}

App = withStyles(style)(App)

const connectedApp = connect(mapStateToProps, mapDispatchToProps)(App)
export { connectedApp as App }
