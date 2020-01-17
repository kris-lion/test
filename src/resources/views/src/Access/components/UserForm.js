import React from 'react'
import { connect } from 'react-redux'
import { Formik, Field, Form } from 'formik'

import { withStyles } from '@material-ui/core/styles'
import {
    Button, CircularProgress, MenuItem,
    Dialog, DialogTitle, DialogContent, DialogActions, Grid,
    FormControl, InputLabel
} from '@material-ui/core'
import {
    TextField, Select,
} from 'formik-material-ui';

const style = theme => ({
    dialog: {
        'border-radius': 0
    },
    fullWidth: {
        'width': '100%'
    }
})

class UserForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            delete: false
        };
    }

    render() {
        const { handleClose, handleDelete, handleSave, open, user, roles, classes, dispatch } = this.props

        return (
            <Formik
                initialValues = {{
                    login: user ? user.login : '',
                    password: '',
                    roles: user ? user.roles.map(role => { return role.id }) : []
                }}
                validate = {values => {
                    const errors = {};

                    if (!values.login) {
                        errors.login = 'Введите имя пользователя';
                    }

                    if (!values.roles) {
                        errors.roles = 'Выберит роли';
                    }

                    return errors;
                }}
                onSubmit = {(values, { setSubmitting }) => {
                    handleSave(values, user ? user.id : null).then(
                        () => {
                            setSubmitting(false)
                            dispatch(handleClose)
                        },
                        () => {
                            setSubmitting(false)
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
                        <Dialog
                            fullWidth={ true }
                            maxWidth="sm"
                            open={ open }
                            onClose={ handleClose }
                            aria-labelledby="Пользователь"
                            classes={{
                                paper: classes.dialog
                            }}
                        >
                            <DialogTitle>{ user ? 'Редактировать' : 'Добавить' }</DialogTitle>
                            <DialogContent>
                                <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="login"
                                            type="text"
                                            label="Имя пользователя"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    { !user &&
                                        <Grid item sm={8} className={classes.fullWidth}>
                                            <Field
                                                fullWidth
                                                type="password"
                                                name="password"
                                                label="Пароль"
                                                component={ TextField }
                                            />
                                        </Grid>
                                    }
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <FormControl className={classes.fullWidth}>
                                            <InputLabel shrink={ true } htmlFor="roles">
                                                Роли
                                            </InputLabel>
                                            <Field
                                                fullWidth
                                                type="text"
                                                name="roles"
                                                label="Роли"
                                                component={ Select }
                                                multiple={ true }
                                            >
                                                {roles.map(option => (
                                                    <MenuItem key={option.id} value={option.id}>
                                                        {option.description}
                                                    </MenuItem>
                                                ))}
                                            </Field>
                                        </FormControl>
                                    </Grid>
                                </Grid>
                            </DialogContent>
                            <DialogActions>
                                {
                                    user
                                        ? (
                                            <DialogActions>
                                                <Button
                                                    disabled={ isSubmitting || this.state.delete }
                                                    onClick={() => {
                                                        this.setState({ delete: true })
                                                        handleDelete(user.id).then(
                                                            () => {
                                                                handleClose()
                                                            }
                                                        )
                                                    }}
                                                    color="secondary"
                                                    type="submit"
                                                >
                                                    { this.state.delete ? <CircularProgress size={24} /> : 'Удалить' }
                                                </Button>
                                                < Button
                                                    disabled={ isSubmitting || this.state.delete }
                                                    onClick={ handleSubmit }
                                                    color="primary"
                                                    type="submit"
                                                >
                                                    { isSubmitting ? <CircularProgress size={24} /> : 'Сохранить' }
                                                </Button>
                                            </DialogActions>
                                        )
                                        : (
                                            <DialogActions>
                                                < Button
                                                    disabled={ isSubmitting }
                                                    onClick={ handleSubmit }
                                                    color="primary"
                                                    type="submit"
                                                >
                                                    { isSubmitting ? <CircularProgress size={24} /> : 'Добавить' }
                                                </Button>
                                            </DialogActions>
                                        )
                                }
                            </DialogActions>
                        </Dialog>
                    </Form>
                )}
            </Formik>
        )
    }
}

function mapStateToProps(state) {
    const { roles } = state.role

    return {
        roles: roles.data
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch
    }
}

UserForm = withStyles(style)(UserForm)

const connectedUserForm = connect(mapStateToProps, mapDispatchToProps)(UserForm)
export { connectedUserForm as UserForm }
