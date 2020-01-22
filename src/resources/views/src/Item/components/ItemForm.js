import React from 'react'
import { connect } from 'react-redux'
import { Formik, Field, Form } from 'formik'

import { withStyles } from '@material-ui/core/styles'
import {
    Button, CircularProgress, MenuItem,
    Dialog, DialogTitle, DialogContent, DialogActions, Grid
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

class ItemForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            delete: false
        };
    }

    render() {
        const { handleClose, handleDelete, handleSave, open, item, category, categories, classes, dispatch } = this.props

        let values = {}

        if (item) {
            item.category.attributes.forEach((attribute) => {
                values[attribute.name] = ''
            })

            item.values.map(value => {
                values[value.attribute.name] = value.value
            })
        }

        return (

            <Formik
                initialValues = {{...{
                    category: item ? item.category.id : (category ? category.id : 0)
                }, ...values}}
                validate = {values => {
                    const errors = {};

                    if (!values.category) {
                        errors.category = 'Выберите категорию'
                    }

                    if (item) {
                        item.category.attributes.forEach((attribute) => {
                            if (!values[attribute.id] && !!attribute.required) {
                                errors[attribute.id] = `Введите ${attribute.name.toLowerCase()}`
                            }
                        })
                    }

                    return errors;
                }}
                onSubmit = {(values, { setSubmitting }) => {
                    handleSave(values, item ? item.id : null).then(
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
                            aria-labelledby="Эталон"
                            classes={{
                                paper: classes.dialog
                            }}
                        >
                            <DialogTitle>{ item ? 'Редактировать' : 'Добавить' }</DialogTitle>
                            <DialogContent>
                                <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            type="text"
                                            name="category"
                                            label="Тип"
                                            select
                                            variant="standard"
                                            disabled={ !!item }
                                            component={ TextField }
                                            InputLabelProps={{
                                                shrink: true,
                                            }}
                                        >
                                            {categories.map(option => (
                                                <MenuItem key={option.id} value={option.id}>
                                                    {option.name}
                                                </MenuItem>
                                            ))}
                                        </Field>
                                    </Grid>
                                </Grid>
                            </DialogContent>
                            <DialogActions>
                                {
                                    item
                                        ? (
                                            <DialogActions>
                                                <Button
                                                    disabled={ isSubmitting || this.state.delete }
                                                    onClick={() => {
                                                        this.setState({ delete: true })
                                                        handleDelete(item.id).then(
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
    const { categories } = state.category

    return {
        categories: categories.data
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch
    }
}

ItemForm = withStyles(style)(ItemForm)

const connectedItemForm = connect(mapStateToProps, mapDispatchToProps)(ItemForm)
export { connectedItemForm as ItemForm }
