import React from 'react'
import { connect } from 'react-redux'
import { Formik, Field, Form } from 'formik'

import { withStyles } from '@material-ui/core/styles'
import {
    Button, CircularProgress, MenuItem,
    Dialog, DialogTitle, DialogContent, DialogActions, Grid
} from '@material-ui/core'
import {
    TextField
} from 'formik-material-ui';
import { FieldString } from "../../Category/components/Attribute/FieldString";
import { FieldInteger } from "../../Category/components/Attribute/FieldInteger";
import { FieldDouble } from "../../Category/components/Attribute/FieldDouble";
import { FieldBoolean } from "../../Category/components/Attribute/FieldBoolean";
import { FieldGeneric } from "../../Category/components/Attribute/FieldGeneric";

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

        const { item, category } = props

        let attributes = []
        let values = {}

        const current = item ? item.category : category

        if (Object.keys(current).length) {
            current.attributes.forEach((attribute) => {
                switch(attribute.type.key) {
                    case 'string':
                        attributes.push({ Field: FieldString, attribute: attribute })
                        values[`${attribute.id}`] = ''
                        break
                    case 'integer':
                        attributes.push({ Field: FieldInteger, attribute: attribute })
                        values[`${attribute.id}`] = 0
                        break
                    case 'double':
                        attributes.push({ Field: FieldDouble, attribute: attribute })
                        values[`${attribute.id}`] = 0.00000
                        break
                    case 'boolean':
                        attributes.push({ Field: FieldBoolean, attribute: attribute })
                        values[`${attribute.id}`] = false
                        break
                    case 'generic':
                        attributes.push({ Field: FieldGeneric, attribute: attribute })
                        values[`${attribute.id}`] = []
                        break
                    default:
                        break
                }
            })

            if (item) {
                item.values.forEach(value => {
                    switch(value.attribute.type.key) {
                        case 'generic':
                            values[`${value.attribute.id}`] = JSON.parse(value.value.replace(new RegExp('null', 'g'), '""'))
                            break
                        case 'boolean':
                            values[`${value.attribute.id}`] = !!value.value
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

        const attribute = (item, items = [], errors = []) => {
            const { Field, attribute } = item

            return <Field id={ attribute.id } label={ attribute.name } items = { items } errors = { errors }/>
        }

        return (

            <Formik
                enableReinitialize={ true }
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

                            if (attribute.type.key === 'generic') {
                                if (!!attribute.required && !values.attributes[`${attribute.id}`].length) {
                                    errors.attributes[`${attribute.id}`] = `Укажите ${attribute.name.toLowerCase()}`
                                }

                                if (values.attributes[`${attribute.id}`].length) {
                                    values.attributes[`${attribute.id}`].forEach((val, key) => {
                                        if (!val.name) {
                                            if (!errors.attributes.hasOwnProperty(`${attribute.id}`)) {
                                                errors.attributes[`${attribute.id}`] = {}
                                            }

                                            if (!errors.attributes[`${attribute.id}`].hasOwnProperty(key)) {
                                                errors.attributes[`${attribute.id}`][key] = {}
                                            }

                                            errors.attributes[`${attribute.id}`][key].name = `Введите наименование`
                                        }
                                    })
                                }
                            }
                        })
                    }

                    if (!Object.keys(errors.attributes).length) {
                        delete errors.attributes
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
                                        this.state.attributes.map((item, index) => (
                                            <Grid item sm={8} key={index} className={classes.fullWidth}>
                                                { attribute(item, values.attributes[item.attribute.id], errors) }
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
