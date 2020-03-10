import React from 'react';
import { render } from 'react-dom'
import { Provider } from 'react-redux'
import { createStore, applyMiddleware } from 'redux'
import thunk from 'redux-thunk'
import logger from 'redux-logger'
import { Redirect } from 'react-router'
import { Router, Route, Switch } from 'react-router-dom'

import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';
import { Grid } from '@material-ui/core';

import './index.css'

import Authorization from './Auth/Authorization'
import AppReducers from './App/reducers/index'
import { history } from './App/helpers/history'
import { NotFound } from './App/Status'
import { Loading } from './App/Loading'
import { Alert } from './App/Alert'
import { Login } from './Auth/Login'
import { Logout } from './Auth/Logout'
import { Item } from "./Item/Item";
import { Offer } from "./Item/Offer";
import { Category } from "./Category/Category";
import { Role } from "./Access/Role";
import { User } from "./Access/User";

const store = createStore(
    AppReducers,
    applyMiddleware(thunk, logger)
)

const theme = createMuiTheme({})

render(
    <MuiThemeProvider theme={ theme }>
        <Provider store={ store }>
            <Loading />
            <Grid container direction='column' justify='center' alignItems='stretch' style={{ height: '100%' }}>
                <Alert />
                <Router history={ history }>
                    <Switch>
                        <Route exact component={ Authorization([], ['reference'])(Item) } path='/items' />
                        <Route exact component={ Offer } path='/item/offer' />
                        <Route exact component={ Authorization([], ['category'])(Category) } path='/categories' />
                        <Route exact component={ Authorization([], ['role'])(Role) } path='/access/roles' />
                        <Route exact component={ Authorization([], ['user'])(User) } path='/access/users' />
                        <Route component={ Authorization()(Login) } path='/login' />
                        <Route component={ Authorization(['user'])(Logout) } path='/logout' />
                        <Redirect from='/' to='/items' />
                        <Route component={ NotFound } />
                    </Switch>
                </Router>
            </Grid>
        </Provider>
    </MuiThemeProvider>,
    document.getElementById('app')
)
