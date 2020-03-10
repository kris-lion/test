import React from 'react'
import { connect } from 'react-redux'
import { Formik, Field, Form } from 'formik'

import { withStyles } from '@material-ui/core/styles'
import {
    Button, CircularProgress, MenuItem, Typography, Grid
} from '@material-ui/core'
import {
    TextField
} from 'formik-material-ui';
import { FieldString } from "../../Category/components/Attribute/FieldString";
import { FieldInteger } from "../../Category/components/Attribute/FieldInteger";
import { FieldDouble } from "../../Category/components/Attribute/FieldDouble";
import { FieldBoolean } from "../../Category/components/Attribute/FieldBoolean";
import { FieldSelect } from "../../Category/components/Attribute/FieldSelect";
import { FieldMultiselect } from "../../Category/components/Attribute/FieldMultiselect";
import { FieldGeneric } from "../../Category/components/Attribute/FieldGeneric";
import { FieldDictionary } from "../../Category/components/Attribute/FieldDictionary";
import { FieldUnit } from "../../Category/components/Attribute/FieldUnit";

const style = theme => ({
    dialog: {
        'border-radius': 0
    },
    item: {
        'padding': '8px',
        'width': '100%'
    },
    fullWidth: {
        'width': '100%'
    }
})

class OfferForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            delete: false,
            category: {},
            attributes: [],
            values: {}
        };
    }

    componentWillUnmount() {
        this.setState({ category: {}, attributes: [], values: {} })
    }

    render() {
        const { handleSave, categories, classes } = this.props
        const { category } = this.state

        const attribute = (item, items = [], values = [], errors = [], setFieldValue, setTouched, isSubmitting = false) => {
            const { Field, attribute } = item

            return <Field id={ attribute.id } label={ attribute.name } items = { items } values = { values } errors = { errors } setFieldValue = { setFieldValue } setTouched = { setTouched } isSubmitting = { isSubmitting } />
        }

        const getItems = (attribute) => {
            const { dictionaries, units } = this.props

            let items = []

            switch (attribute.type.key) {
                case 'select':
                    items = category.attribute.options.map(option => { return { id: option.id, name: option.option } })
                    break
                case 'multiselect':
                    items = category.attribute.options.map(option => { return { id: option.id, name: option.option } })
                    break
                case 'dictionary':
                    switch (attribute.value) {
                        case 'generics':
                            items = dictionaries.generics
                            break
                        default:
                            break
                    }
                    break
                case 'unit':
                    items = units
                    break
                default:
                    break
            }

            return items
        }

        const assembly = (categories, parent = 0, level = 0) => {
            let result = []

            if (categories.hasOwnProperty(parent)) {
                categories[parent].forEach(category => {
                    result.push(<MenuItem key={ category.id } value={ category.id }>{ '\u00A0\u00A0\u00A0\u00A0'.repeat(level) + category.name }</MenuItem>)

                    result = result.concat(assembly(categories, category.id, level + 1))
                })
            }

            return result
        }

        const getCategoriesTree = categories => {
            let tmp = {}
            categories.forEach(category => {
                if (!tmp.hasOwnProperty((category.category !== null) ? category.category.id : 0)) {
                    tmp[(category.category !== null) ? category.category.id : 0] = []
                }

                tmp[(category.category !== null) ? category.category.id : 0].push(category)
            })

            return assembly(tmp)
        }

        return (
            <Formik
                enableReinitialize={ true }
                initialValues = {{
                    ...{ category: Object.keys(category).length ? category.id : '' },
                    ...{ attributes: this.state.values }
                }}
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

                            if (attribute.type.key === 'multiselect') {
                                if (!!attribute.required && !values.attributes[`${attribute.id}`].length) {
                                    errors.attributes[`${attribute.id}`] = `Выберите ${attribute.name.toLowerCase()}`
                                }
                            }

                            if (attribute.type.key === 'select') {
                                if (!!attribute.required && !values.attributes.hasOwnProperty(`${attribute.id}`)) {
                                    errors.attributes[`${attribute.id}`] = `Выберите ${attribute.name.toLowerCase()}`
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
                    handleSave(values).then(
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
                      setTouched,
                      isSubmitting
                  }) => (
                    <Form>
                        <Grid container direction='column' justify='center' alignItems='center'>
                            <Grid item sm={8} className={classes.item}>
                                <Typography variant="h6">
                                    Предложить эталон
                                </Typography>
                            </Grid>
                            <Grid item sm={8} className={classes.item}>
                                <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            type="text"
                                            name="category"
                                            label="Категория"
                                            select
                                            variant="standard"
                                            component={ TextField }
                                            InputLabelProps={{
                                                shrink: true,
                                            }}
                                            InputProps={{
                                                onChange: (e) => {
                                                    let id = e.target.value
                                                    let attributes = []
                                                    let items = this.state.values

                                                    let current = categories.find((element) => {
                                                        return element.id === id
                                                    })

                                                    current.attributes.forEach((attribute) => {
                                                        switch(attribute.type.key) {
                                                            case 'string':
                                                                attributes.push({ Field: FieldString, attribute: attribute })
                                                                items[`${attribute.id}`] = ''
                                                                break
                                                            case 'integer':
                                                                attributes.push({ Field: FieldInteger, attribute: attribute })
                                                                items[`${attribute.id}`] = 0
                                                                break
                                                            case 'double':
                                                                items[`${attribute.id}`] = 0.00000
                                                                break
                                                            case 'boolean':
                                                                attributes.push({ Field: FieldBoolean, attribute: attribute })
                                                                items[`${attribute.id}`] = false
                                                                break
                                                            case 'select':
                                                                attributes.push({ Field: FieldSelect, attribute: attribute })
                                                                items[`${attribute.id}`] = 0
                                                                break
                                                            case 'multiselect':
                                                                attributes.push({ Field: FieldMultiselect, attribute: attribute })
                                                                items[`${attribute.id}`] = []
                                                                break
                                                            case 'generic':
                                                                attributes.push({ Field: FieldGeneric, attribute: attribute })
                                                                items[`${attribute.id}`] = []
                                                                break
                                                            case 'dictionary':
                                                                attributes.push({ Field: FieldDictionary, attribute: attribute })
                                                                items[`${attribute.id}`] = ''
                                                                break
                                                            case 'unit':
                                                                attributes.push({ Field: FieldUnit, attribute: attribute })
                                                                items[`${attribute.id}`] = ''
                                                                break
                                                            default:
                                                                break
                                                        }
                                                    })

                                                    setFieldValue('category', id)
                                                    this.setState({ category: current, attributes: attributes, values: items })
                                                }
                                            }}
                                        >
                                            {
                                                getCategoriesTree(categories).map(el => el)
                                            }
                                        </Field>
                                    </Grid>
                                    {
                                        this.state.attributes.map((item, index) => (
                                            <Grid item sm={8} key={index} className={classes.fullWidth}>
                                                {attribute(
                                                    item,
                                                    getItems(item.attribute),
                                                    this.state.values,
                                                    errors,
                                                    setFieldValue,
                                                    setTouched,
                                                    (isSubmitting || this.state.delete)
                                                )}
                                            </Grid>
                                        ))
                                    }
                                </Grid>
                            </Grid>
                            <Grid item sm={8} className={classes.item}>
                                <Grid container direction='row' justify='flex-end' alignItems='center'>
                                    <Grid item>
                                        <Button
                                            color="primary"
                                            disabled={ isSubmitting }
                                            onClick={ handleSubmit }
                                            type="submit"
                                        >
                                            { isSubmitting ? <CircularProgress size={24} /> : 'Предложить' }
                                        </Button>
                                    </Grid>
                                </Grid>
                            </Grid>
                        </Grid>
                    </Form>
                )}
            </Formik>
        )
    }
}

function mapStateToProps(state) {
    const { categories } = state.system
    const { units } = state.unit

    return {
        categories, dictionaries: state.dictionary, units
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch
    }
}

OfferForm = withStyles(style)(OfferForm)

const connectedOfferForm = connect(mapStateToProps, mapDispatchToProps)(OfferForm)
export { connectedOfferForm as OfferForm }
