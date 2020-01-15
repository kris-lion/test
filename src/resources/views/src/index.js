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
import { Product } from "./Product/Product";
import { Category } from "./Product/Category";

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
                        <Route exact component={ Authorization(['user'])(Product) } path='/products' />
                        <Route exact component={ Authorization(['user'])(Category) } path='/product/categories' />
                        <Route exact component={ Authorization(['user'])(Category) } path='/access' />
                        <Route component={ Authorization()(Login) } path='/login' />
                        <Route component={ Authorization(['user'])(Logout) } path='/logout' />
                        <Redirect from='/' to='/products' />
                        <Route component={ NotFound } />
                    </Switch>
                </Router>
            </Grid>
        </Provider>
    </MuiThemeProvider>,
    document.getElementById('app')
)
