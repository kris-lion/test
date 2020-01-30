import React from 'react'
import { connect } from 'react-redux'
import { Formik, Field, Form, FieldArray } from 'formik'

import { withStyles } from '@material-ui/core/styles'
import {
    Button, CircularProgress, MenuItem,
    Dialog, DialogTitle, DialogContent, DialogActions, Grid,
    FormControlLabel, IconButton,
    Card, CardContent, Select, FormHelperText, FormControl
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
            confirmation: false,
            category: false,
            options: props.types.filter(type => ((type.key === 'select') || (type.key === 'multiselect')) ).map(type => type.id)
        };
    }

    render() {
        const { handleClose, handleDelete, handleSave, open, category, categories, types, classes, dispatch } = this.props

        const assembly = (options, parent = 0, level = 0, disabled = false) => {
            let result = []

            if (options.hasOwnProperty(parent)) {
                options[parent].forEach(option => {
                    result.push(<MenuItem key={ option.id } disabled={ disabled || (category ? (option.id === category.id) : false) } value={ option.id }>{ '\u00A0\u00A0\u00A0\u00A0'.repeat(level) + option.name }</MenuItem>)

                    result = result.concat(assembly(options, option.id, level + 1, disabled ? disabled : (category ? (option.id === category.id) : false)))
                })
            }

            return result
        }

        const getCategoriesTree = (options, full = true) => {
            let tmp = {}

            options.forEach(option => {
                if (!tmp.hasOwnProperty((option.category !== null) ? option.category.id : 0)) {
                    tmp[(option.category !== null) ? option.category.id : 0] = []
                }

                tmp[(option.category !== null) ? option.category.id : 0].push(option)
            })

            if (full) {
                return [<MenuItem key={0} value="">{'\u00A0\u00A0\u00A0\u00A0'}</MenuItem>].concat(assembly(tmp))
            } else {
                return assembly(tmp)
            }
        }

        return (
            <Formik
                initialValues = {{
                    name: category ? category.name : '',
                    attributes: category ? category.attributes.map((category) => { return { id: category.id, name: category.name, type: category.type.id, required: !!category.required, options: category.options } }) : [],
                    category: category ? (category.category ? category.category.id : '') : ''
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
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            type="text"
                                            name="category"
                                            label="Родительская категория"
                                            select
                                            variant="standard"
                                            component={ TextField }
                                            InputLabelProps={{
                                                shrink: true
                                            }}
                                        >
                                            { getCategoriesTree(categories).map(el => el) }
                                        </Field>
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
                            {
                                category
                                    ? (
                                        <DialogActions>
                                            {
                                                this.state.confirmation
                                                    ?
                                                        this.state.category
                                                            ? <FormControl className={classes.fullWidth} error>
                                                                <Select fullWidth value={0} error
                                                                    onChange={event => {
                                                                        this.setState({confirmation: false, category: false})
                                                                        handleDelete(category.id, { type: 'category', category: event.target.value}).then(
                                                                            () => {
                                                                                handleClose()
                                                                            }
                                                                        )
                                                                    }}
                                                                >
                                                                    { getCategoriesTree(categories, false).map(el => el) }
                                                                </Select>
                                                                <FormHelperText>Выберите категорию для переноса эталонов</FormHelperText>
                                                            </FormControl>
                                                            : <FormControl className={classes.fullWidth} error>
                                                                <Select fullWidth value="" error
                                                                        onChange={event => {
                                                                            const type = event.target.value

                                                                            if (type === 'category') {
                                                                                this.setState({ category: true })
                                                                            } else {
                                                                                this.setState({confirmation: false})
                                                                                handleDelete(category.id, { type: type }).then(
                                                                                    () => {
                                                                                        handleClose()
                                                                                    }
                                                                                )
                                                                            }
                                                                        }}
                                                                >
                                                                    <MenuItem value="category">Выбрать категорию для переноса эталонов</MenuItem>
                                                                    <MenuItem value="connect">Оставить связь эталонов с удалённой категорией</MenuItem>
                                                                    <MenuItem value="empty">Оставить эталоны без категории</MenuItem>
                                                                </Select>
                                                                <FormHelperText>В категории присутствуют эталоны, необходимо выбрать тип удаления</FormHelperText>
                                                            </FormControl>
                                                    : <Button
                                                        disabled={isSubmitting || this.state.delete}
                                                        onClick={() => {
                                                            this.setState({delete: true})
                                                            handleDelete(category.id).then(
                                                                val => {
                                                                    if (val) {
                                                                        this.setState({confirmation: true})
                                                                    } else {
                                                                        handleClose()
                                                                    }
                                                                }
                                                            )
                                                        }}
                                                        color="secondary"
                                                        type="submit"
                                                    >
                                                        {
                                                            this.state.delete
                                                                ? <CircularProgress size={24}/>
                                                                : 'Удалить'
                                                        }
                                                    </Button>
                                            }
                                            {
                                                this.state.confirmation
                                                    ? < Button
                                                        onClick={() => {
                                                            if (this.state.category) {
                                                                this.setState({ category: false })
                                                            } else {
                                                                this.setState({ delete: false, confirmation: false })
                                                            }
                                                        }}
                                                        color="primary"
                                                        type="button"
                                                    >
                                                        Отменить
                                                    </Button>
                                                    : < Button
                                                        disabled={isSubmitting || this.state.delete}
                                                        onClick={handleSubmit}
                                                        color="primary"
                                                        type="submit"
                                                    >
                                                        {isSubmitting ? <CircularProgress size={24}/> : 'Сохранить'}
                                                    </Button>
                                            }
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
