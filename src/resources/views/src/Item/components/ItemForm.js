import React from 'react'
import { connect } from 'react-redux'
import { Formik, Field, Form } from 'formik'

import { withStyles } from '@material-ui/core/styles'
import {
    Button, CircularProgress, MenuItem,
    Dialog, DialogTitle, DialogContent, DialogActions, Grid, FormControlLabel
} from '@material-ui/core'
import {
    TextField, Select, Switch,
} from 'formik-material-ui';

const style = theme => ({
    dialog: {
        'border-radius': 0
    },
    fullWidth: {
        'width': '100%'
    }
})


class FieldString extends React.Component {
    render () {
        const { id, label } = this.props

        return (
            <Field
                fullWidth
                name={ `attributes.${id}` }
                type="text"
                label={ `${label}` }
                component={ TextField }
            />
        )
    }
}

class FieldInteger extends React.Component {
    render () {
        const { id, label } = this.props

        return (
            <Field
                fullWidth
                name={ `attributes.${id}` }
                type="number"
                label={ `${label}` }
                inputProps={{ step: 1 }}
                component={ TextField }
            />
        )
    }
}

class FieldDouble extends React.Component {
    render () {
        const { id, label } = this.props

        return (
            <Field
                fullWidth
                name={ `attributes.${id}` }
                type="number"
                label={ `${label}` }
                inputProps={{ step: 0.00001 }}
                component={ TextField }
            />
        )
    }
}

class FieldBoolean extends React.Component {
    render () {
        const { id, label } = this.props

        return (
            <FormControlLabel
                control={
                    <Field
                        name={ `attributes.${id}` }
                        label={ label }
                        component={ Switch }
                    />
                }
                label={ label }
            />
        )
    }
}

class ItemForm extends React.Component {
    constructor(props) {
        super(props);

        const { item, category } = props

        let attributes = []
        let values = {}

        const current = item ? item.category : category

        if (Object.keys(current).length) {
            current.attributes.forEach((attribute) => {
                switch(attribute.type.key) {
                    case 'string':
                        attributes.push(<FieldString id={ attribute.id } label={ attribute.name }/>)
                        values[`${attribute.id}`] = ''
                        break
                    case 'integer':
                        attributes.push(<FieldInteger id={ attribute.id } label={ attribute.name }/>)
                        values[`${attribute.id}`] = 0
                        break
                    case 'double':
                        attributes.push(<FieldDouble id={ attribute.id } label={ attribute.name }/>)
                        values[`${attribute.id}`] = 0.00000
                        break
                    case 'boolean':
                        attributes.push(<FieldBoolean id={ attribute.id } label={ attribute.name }/>)
                        values[`${attribute.id}`] = false
                        break
                    case 'generic':
                        break
                }
            })

            if (item) {
                item.values.map(value => {
                    switch(value.attribute.type.key) {
                        case 'boolean':
                            values[`${value.attribute.id}`] = !!value.value
                            break
                        case 'generic':
                            break
                        default:
                            values[`${value.attribute.id}`] = value.value
                    }
                })
            }
        }

        this.state = {
            delete: false,
            category: current,
            attributes: attributes,
            values: values
        };
    }

    componentWillUnmount() {
        this.setState({ category: {}, attributes: [], values: {} })
    }

    render() {
        const { handleClose, handleDelete, handleSave, open, item, categories, classes, dispatch } = this.props
        const { category } = this.state

        return (

            <Formik
                enableReinitialize
                initialValues = {{...{
                    category: Object.keys(category).length ? category.id : 0
                }, ...{ attributes: this.state.values }}}
                validate = {values => {
                    const errors = {};

                    if (!values.category) {
                        errors.category = 'Выберите категорию'
                    }

                    errors.attributes = {}

                    if (Object.keys(category).length) {
                        category.attributes.forEach((attribute) => {
                            if ((attribute.type.key !== 'boolean') && !values.attributes[`${attribute.id}`] && !!attribute.required) {
                                errors.attributes[`${attribute.id}`] = `Введите ${attribute.name.toLowerCase()}`
                            }
                        })
                    }

                    if (!Object.keys(errors.attributes).length) {
                        delete errors.attributes
                    }

                    return errors;
                }}
                onSubmit = {(values, { setSubmitting }) => {
                    console.log(values)

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
                      handleReset,
                      handleSubmit,
                      setFieldValue,
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
                                            disabled={ !!Object.keys(category).length }
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
                                    {
                                        this.state.attributes.map((attribute, index) => (
                                            <Grid item sm={8} key={index} className={classes.fullWidth}>
                                                { attribute }
                                            </Grid>
                                        ))
                                    }
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
