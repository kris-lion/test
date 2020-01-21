import React from 'react'
import { connect } from 'react-redux'
import { Link } from 'react-router-dom';

import { fade, withStyles } from '@material-ui/core/styles';
import {
    AppBar,
    Container,
    Toolbar,
    Grid, Collapse, Paper, List, ListItem, ListItemText,
    Typography,
    Button, LinearProgress
} from '@material-ui/core';
import { ExpandLess, ExpandMore }from '@material-ui/icons';
import { bindActionCreators } from "redux";

import { AuthorizationService } from '../Auth/services/authorization'

const style = theme => ({
    container: {
        'height': 'calc(100% - 64px)',
        'margin-top': '64px'
    },
    body: {
        'height': '100%'
    },
    item: {
        'height': '100%',
        'padding': theme.spacing(1, 1)
    },
    content: {
        'height': '100%'
    },
    title: {
        'flex-grow': 1
    },
    nested: {
        paddingLeft: theme.spacing(4)
    },
    paper: {
        'height': 'calc(100% - 112px)',
        'border-radius': 0,
        'padding': theme.spacing(3, 2),
        'margin': theme.spacing(3, 2)
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
    constructor(props) {
        super(props);

        this.state = {
            open: (props.location.pathname.indexOf('access') >= 0) ? true : false
        };
    }

    render() {
        const { location, application, account, content, classes } = this.props
        const { open } = this.state

        let access = AuthorizationService.permissions(account, ['role', 'user'])

        const handleClick = () => {
            this.setState({ open: !open })
        }

        return (
            <Grid container direction='column' justify='flex-start' alignItems='stretch' className={classes.content}>
                <AppBar>
                    <Toolbar>
                        <Typography variant="h5" className={classes.title}>
                            Эталонный номенклатор
                        </Typography>
                        <Button
                            color="inherit"
                            component={ Link }
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
                            <Grid item md={ 3 }>
                                <List aria-label="contacts">
                                    { AuthorizationService.permissions(account, 'reference') &&
                                        <ListItem selected={location.pathname === '/items'} button component={Link} to={'/items'}>
                                            <ListItemText primary={'Эталоны'}/>
                                        </ListItem>
                                    }
                                    { AuthorizationService.permissions(account, 'category') &&
                                        <ListItem selected={location.pathname === '/categories'} button component={Link} to={'/categories'}>
                                            <ListItemText primary={'Категории'}/>
                                        </ListItem>
                                    }
                                    { access &&
                                        <ListItem button onClick={handleClick}>
                                            <ListItemText primary={'Управление доступом'}/>
                                            {open ? <ExpandLess/> : <ExpandMore/>}
                                        </ListItem>
                                    }
                                    { access &&
                                        <Collapse in={ open } timeout="auto" unmountOnExit>
                                            <List component="div" disablePadding>
                                                { AuthorizationService.permissions(account, 'user') &&
                                                    <ListItem selected={location.pathname === '/access/users'} button component={Link} to={'/access/users'} className={classes.nested}>
                                                        <ListItemText primary={'Пользователи'}/>
                                                    </ListItem>
                                                }
                                                { AuthorizationService.permissions(account, 'role') &&
                                                    <ListItem selected={location.pathname === '/access/roles'} button component={Link} to={'/access/roles'} className={classes.nested}>
                                                        <ListItemText primary={'Роли'}/>
                                                    </ListItem>
                                                }
                                            </List>
                                        </Collapse>
                                    }
                                </List>
                            </Grid>
                            <Grid item md={9} className={ classes.item }>
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
    const { account } = state.account

    return {
        application,
        account
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
