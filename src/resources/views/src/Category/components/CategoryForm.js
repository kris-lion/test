import React from 'react'
import { connect } from 'react-redux'
import { Formik, Field, Form, FieldArray } from 'formik'

import { withStyles } from '@material-ui/core/styles'
import {
    Button, CircularProgress, MenuItem,
    Dialog, DialogTitle, DialogContent, DialogActions, Grid,
    FormControlLabel, IconButton,
    Card, CardContent
} from '@material-ui/core'
import { PlaylistAdd, DeleteSweep, Add, Clear } from '@material-ui/icons';
import {
    TextField, Switch
} from 'formik-material-ui';

const style = theme => ({
    dialog: {
        'border-radius': 0
    },
    fullWidth: {
        'width': '100%'
    }
})

class CategoryForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            delete: false,
            options: props.types.filter(type => ((type.key === 'select') || (type.key === 'multiselect')) ).map(type => type.id)
        };
    }

    render() {
        const { handleClose, handleDelete, handleSave, open, category, types, classes, dispatch } = this.props

        return (
            <Formik
                initialValues = {{
                    name: category ? category.name : '',
                    attributes: category ? category.attributes.map((category) => { return { id: category.id, name: category.name, type: category.type.id, required: !!category.required, options: category.options } }) : []
                }}
                validate = {values => {
                    const errors = {};

                    if (!values.name) {
                        errors.name = 'Введите наименование'
                    }

                    errors.attributes = {}

                    values.attributes.forEach((item, key) => {
                        let error = {}

                        if (!item.name) {
                            error.name = 'Введите наименование'
                        }

                        if (!item.type) {
                            error.type = 'Выберите тип'
                        }

                        if (this.state.options.includes(item.type)) {
                            if (!item.hasOwnProperty('options') || (item.options.length === 0)) {
                                error.option = true
                            } else {
                                item.options.forEach((val, index) => {
                                    if (!val.option.length) {
                                        if (!error.hasOwnProperty('options')) {
                                            error.options = {}
                                        }

                                        if (!error.options.hasOwnProperty(index)) {
                                            error.options[index] = {}
                                        }

                                        error.options[index].option = `Введите наименование`
                                    }
                                })
                            }
                        }

                        if (!!Object.keys(error).length) {
                            errors.attributes[key] = error
                        }
                    })

                    if (!Object.keys(errors.attributes).length) {
                        delete errors.attributes
                    }

                    return errors
                }}
                onSubmit = {(values, { setSubmitting }) => {
                    handleSave(values, category ? category.id : null).then(
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
                            aria-labelledby="Категория"
                            classes={{
                                paper: classes.dialog
                            }}
                        >
                            <DialogTitle>{ category ? 'Редактировать' : 'Добавить' }</DialogTitle>
                            <DialogContent>
                                <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="name"
                                            type="text"
                                            label="Наименование"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    <FieldArray
                                        name="attributes"
                                        render={ arrayHelpers => (
                                            <Grid item sm={8} className={classes.fullWidth}>
                                                <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                                    {values.attributes && values.attributes.length > 0 && (
                                                        values.attributes.map((attribute, index) => (
                                                            <Grid item key={index} className={classes.fullWidth}>
                                                                <Card className={classes.fullWidth}>
                                                                    <CardContent>
                                                                        <Grid item className={classes.fullWidth}>
                                                                            <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                                                                <Grid item className={classes.fullWidth}>
                                                                                    <Grid container direction='row' justify='space-between' alignItems='center' spacing={2}>
                                                                                        <Grid item sm={9} className={classes.fullWidth}>
                                                                                            <Field
                                                                                                fullWidth
                                                                                                name={`attributes.${index}.name`}
                                                                                                type="text"
                                                                                                label="Наименование"
                                                                                                component={ TextField }
                                                                                            />
                                                                                        </Grid>
                                                                                        <Grid item>
                                                                                            <IconButton
                                                                                                aria-label="Удалить"
                                                                                                onClick={() => { arrayHelpers.remove(index) }}
                                                                                            >
                                                                                                <DeleteSweep />
                                                                                            </IconButton>
                                                                                        </Grid>
                                                                                    </Grid>
                                                                                </Grid>
                                                                                <Grid item className={classes.fullWidth}>
                                                                                    <Field
                                                                                        fullWidth
                                                                                        type="text"
                                                                                        name={`attributes.${index}.type`}
                                                                                        label="Тип"
                                                                                        select
                                                                                        variant="standard"
                                                                                        disabled={ attribute.hasOwnProperty('id') }
                                                                                        component={ TextField }
                                                                                        InputLabelProps={{
                                                                                            shrink: true,
                                                                                        }}
                                                                                    >
                                                                                        {types.map(option => (
                                                                                            <MenuItem key={option.id} value={option.id}>
                                                                                                {option.name}
                                                                                            </MenuItem>
                                                                                        ))}
                                                                                    </Field>
                                                                                </Grid>
                                                                                <Grid item className={classes.fullWidth}>
                                                                                    <FieldArray
                                                                                        name={`attributes.${index}.options`}
                                                                                        render={ arrayOptions => (
                                                                                            <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                                                                                {(values.attributes[`${index}`].hasOwnProperty('type') && !!values.attributes[`${index}`].type) && (this.state.options.includes(values.attributes[`${index}`].type)) && (values.attributes[`${index}`].hasOwnProperty('options') && values.attributes[`${index}`].options.length > 0) && (
                                                                                                    values.attributes[`${index}`].options.map((option, key) => (
                                                                                                        <Grid item key={key} className={classes.fullWidth}>
                                                                                                            <Grid container direction='row' justify='space-between' alignItems='center' spacing={2}>
                                                                                                                <Grid item sm={9} className={classes.fullWidth}>
                                                                                                                    <Field
                                                                                                                        fullWidth
                                                                                                                        name={`attributes.${index}.options.${key}.option`}
                                                                                                                        type="text"
                                                                                                                        label="Вариант"
                                                                                                                        component={ TextField }
                                                                                                                    />
                                                                                                                </Grid>
                                                                                                                <Grid item>
                                                                                                                    <IconButton
                                                                                                                        onClick={() => arrayOptions.remove(key) }
                                                                                                                        color="primary"
                                                                                                                        aria-label="Удалить"
                                                                                                                        component="span"
                                                                                                                    >
                                                                                                                        <Clear />
                                                                                                                    </IconButton>
                                                                                                                </Grid>
                                                                                                            </Grid>
                                                                                                        </Grid>
                                                                                                    ))
                                                                                                )}
                                                                                                {(values.attributes[`${index}`].hasOwnProperty('type') && !!values.attributes[`${index}`].type) && (this.state.options.includes(values.attributes[`${index}`].type)) && (
                                                                                                    <Grid item className={classes.fullWidth}>
                                                                                                        <IconButton
                                                                                                            onClick={() => arrayOptions.push({ option: '' })}
                                                                                                            color={(errors.hasOwnProperty('attributes') && (errors.attributes.hasOwnProperty(`${index}`) && errors.attributes[`${index}`] !== undefined) && errors.attributes[`${index}`].option) ? 'secondary' : 'primary'}
                                                                                                            aria-label="Добавить"
                                                                                                            component="span"
                                                                                                        >
                                                                                                            <Add />
                                                                                                        </IconButton>
                                                                                                    </Grid>
                                                                                                )}
                                                                                            </Grid>
                                                                                        )}
                                                                                    />
                                                                                </Grid>
                                                                                <Grid item className={classes.fullWidth}>
                                                                                    <FormControlLabel
                                                                                        control={
                                                                                            <Field label="Обязательный" name={`attributes.${index}.required`} component={ Switch } />
                                                                                        }
                                                                                        label="Обязательный"
                                                                                    />
                                                                                </Grid>
                                                                            </Grid>
                                                                        </Grid>
                                                                    </CardContent>
                                                                </Card>
                                                            </Grid>
                                                        ))
                                                    )}
                                                    <Grid item className={classes.fullWidth}>
                                                        <Button
                                                            onClick={() => arrayHelpers.push({ name: '', type: '', required: false})}
                                                            aria-label={`Добавить`}
                                                            color="primary"
                                                            endIcon={<PlaylistAdd />}
                                                        >
                                                            Добавить атрибут
                                                        </Button>
                                                    </Grid>
                                                </Grid>
                                            </Grid>
                                        )}
                                    />
                                </Grid>
                            </DialogContent>
                            <DialogActions>
                                {
                                    category
                                        ? (
                                            <DialogActions>
                                                <Button
                                                    disabled={ isSubmitting || this.state.delete }
                                                    onClick={() => {
                                                        this.setState({ delete: true })
                                                        handleDelete(category.id).then(
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
    const { types } = state.attribute_type

    return {
        types
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch
    }
}

CategoryForm = withStyles(style)(CategoryForm)

const connectedCategoryForm = connect(mapStateToProps, mapDispatchToProps)(CategoryForm)
export { connectedCategoryForm as CategoryForm }
