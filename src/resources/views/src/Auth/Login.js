import React from 'react'
import { bindActionCreators } from 'redux'
import { connect } from 'react-redux'
import { Formik, Field, Form } from 'formik'
import { TextField } from 'formik-material-ui';

import { withStyles } from '@material-ui/core/styles';
import {
    Grid,
    Paper,
    Button,
    CircularProgress
} from '@material-ui/core';

import { AuthActions } from './actions/authentication'

const style = theme => ({
    container: {
        'border-radius': 0,
        'height': '100%'
    },
    content: {
        'border-radius': 0,
        'padding': theme.spacing(3, 2),
    },
    fullWidth: {
        'width': '100%'
    }
})

class Login extends React.Component {
  render() {
    const { classes } = this.props

    return (

      <Grid container direction='row' justify='center' alignItems='center' className={classes.container}>
          <Grid item xs={9} sm={6} md={3}>
              <Paper className={classes.content}>
                  <Formik
                      initialValues = {{ login: '', password: '' }}
                      validate = {values => {
                          const errors = {};

                          if (!values.login) {
                              errors.login = 'Введите имя пользователя';
                          }

                          if (!values.password) {
                              errors.password = 'Ввведите пароль';
                          }

                          return errors;
                      }}
                      onSubmit = {(values, { setSubmitting }) => {
                          const { actions } = this.props

                          return actions.login(values).then(
                              () => {
                                  setSubmitting(false);
                              },
                              errors => {
                                  if (errors) { }
                                  setSubmitting(false);
                              }
                          )
                      }}
                  >
                      {({
                            values,
                            errors,
                            touched,
                            handleChange,
                            handleBlur,
                            handleSubmit,
                            isSubmitting
                        }) => (
                          <Form>
                              <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                  <Grid item xs={10} className={classes.fullWidth}>
                                      <Grid container direction='column' justify='center' alignItems='stretch' spacing={2}>
                                          <Grid item className={classes.fullWidth}>
                                              <Field
                                                  fullWidth
                                                  name="login"
                                                  type="text"
                                                  label="Имя пользователя"
                                                  component={ TextField }
                                              />
                                          </Grid>
                                          <Grid item className={classes.fullWidth}>
                                              <Field
                                                  fullWidth
                                                  type="password"
                                                  name="password"
                                                  label="Пароль"
                                                  component={ TextField }
                                              />
                                          </Grid>
                                          <Grid item className={classes.fullWidth}>
                                              <Grid container direction='row' justify='flex-end' alignItems='center'>
                                                  <Grid item>
                                                      <Button
                                                          variant="contained"
                                                          color="primary"
                                                          disabled={ isSubmitting }
                                                          onClick={ handleSubmit }
                                                          type="submit"
                                                      >
                                                          { isSubmitting ? <CircularProgress size={24} /> : 'Войти' }
                                                      </Button>
                                                  </Grid>
                                              </Grid>
                                          </Grid>
                                      </Grid>
                                  </Grid>
                              </Grid>
                          </Form>
                      )}
                  </Formik>
              </Paper>
          </Grid>
      </Grid>
    )
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

Login = withStyles(style)(Login)

const connectedLogin = connect(mapStateToProps, mapDispatchToProps)(Login)
export { connectedLogin as Login }
