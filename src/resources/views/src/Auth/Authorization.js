import React from 'react'
import { bindActionCreators } from 'redux'
import { Redirect } from 'react-router'
import { connect } from 'react-redux'

import Grid from '@material-ui/core/Grid';

import { Forbidden } from '../App/Status'
import { AuthorizationService } from './services/authorization'
import { App } from '../App/App'
import { AccountActions } from '../Account/actions/account'

export default function Authorization(Roles = [], Permissions = [], require = false, base = true) {
    return Component => {
        class WithAuthorization extends React.Component {
            constructor (props) {
                super(props)

                this.state = {
                    loading: false
                }
            }

            componentDidMount () {
                const { actions, account } = this.props

                const token = localStorage.getItem('token')

                if (token && ((account.account && !account.load) || !account.account)) {
                    return actions.account().then(() => {
                        this.setState({ loading: true })
                    }, () => {
                        this.setState({ loading: true })
                    })
                } else {
                    this.setState({ loading: true })
                }
            }

            render() {
                const { location } = this.props
                const { account } = this.props.account
                const { loading } = this.state

                if (loading) {
                    if (account) {
                        if (AuthorizationService.access(account, Roles, Permissions, require)) {
                            if (base) {
                                return (
                                    <Grid item style={{height: '100%'}}>
                                        <App content={<Component {...this.props} />} {...this.props}/>
                                    </Grid>
                                )
                            } else {
                                return <Component {...this.props} />
                            }
                        } else {
                            return <Forbidden/>
                        }
                    } else {
                        if (!Roles.length && !Permissions.length) {
                            return <Component {...this.props} />
                        } else {
                            localStorage.setItem('redirect', `${location.pathname}${location.search}`)

                            return <Redirect to='/login'/>
                        }
                    }
                }

                return null
            }
        }

        function mapStateToProps(state) {
            const { account } = state

            return {
                account
            }
        }

        function mapDispatchToProps(dispatch) {
            return {
                actions: bindActionCreators(AccountActions, dispatch)
            }
        }

        return connect(mapStateToProps, mapDispatchToProps)(WithAuthorization)
    }
}
