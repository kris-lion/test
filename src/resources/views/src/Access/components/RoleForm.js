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

class RoleForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            delete: false
        };
    }

    render() {
        const { handleClose, handleDelete, handleSave, open, role, permissions, classes, dispatch } = this.props

        return (
            <Formik
                initialValues = {{
                    name: role ? role.name : '',
                    description: role ? role.description: '',
                    permissions: role ? role.permissions.map(permission => { return permission.id }) : []
                }}
                validate = {values => {
                    const errors = {};

                    if (!values.name) {
                        errors.name = 'Введите уникальный ключ';
                    }

                    if (!values.description) {
                        errors.description = 'Ввведите название';
                    }

                    if (!values.permissions) {
                        errors.permissions = 'Выберите полномочия';
                    }

                    return errors;
                }}
                onSubmit = {(values, { setSubmitting }) => {
                    handleSave(values, role ? role.id : null).then(
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
                            aria-labelledby="Роль"
                            classes={{
                                paper: classes.dialog
                            }}
                        >
                            <DialogTitle>{ role ? 'Редактировать' : 'Добавить' }</DialogTitle>
                            <DialogContent>
                                <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="description"
                                            type="text"
                                            label="Название"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="name"
                                            type="text"
                                            label="Уникальный ключ"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <FormControl className={classes.fullWidth}>
                                            <InputLabel shrink={ true } htmlFor="permissions">
                                                Полномочия
                                            </InputLabel>
                                            <Field
                                                fullWidth
                                                type="text"
                                                name="permissions"
                                                label="Полномочия"
                                                component={ Select }
                                                multiple={ true }
                                            >
                                                {permissions.map(option => (
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
                                    role
                                        ? (
                                            <DialogActions>
                                                <Button
                                                    disabled={ isSubmitting || this.state.delete }
                                                    onClick={() => {
                                                        this.setState({ delete: true })
                                                        handleDelete(role.id).then(
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
    const { permissions } = state.permission

    return {
        permissions
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch
    }
}

RoleForm = withStyles(style)(RoleForm)

const connectedRoleForm = connect(mapStateToProps, mapDispatchToProps)(RoleForm)
export { connectedRoleForm as RoleForm }
