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

class ProductForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            delete: false
        };
    }

    render() {
        const { handleClose, handleDelete, handleSave, open, product, categories, classes, dispatch } = this.props

        return (
            <Formik
                initialValues = {{
                    standard: product ? product.standard : '',
                    name: product ? product.name : '',
                    volume: product ? (product.volume ? product.volume : 0.00) : 0.00,
                    unit: product ? (product.unit ? product.unit.name : '') : '',
                    packing: product ? (product.packing ? product.packing : '') : '',
                    quantity: product ? (product.quantity ? product.quantity : 0) : 0,
                    generic: product ? (product.generic ? product.generic.name : '') : '',
                    form: product ? (product.form ? product.form.name : '') : '',
                    category: product ? (product.category ? product.category.id : '') : ''
                }}
                validate = {values => {
                    const errors = {};

                    if (!values.standard) {
                        errors.standard = 'Введите эталонное наименование';
                    }

                    if (!values.name) {
                        errors.name = 'Введите имя';
                    }

                    return errors;
                }}
                onSubmit = {(values, { setSubmitting }) => {
                    handleSave(values, product ? product.id : null).then(
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
                            <DialogTitle>{ product ? 'Редактировать' : 'Добавить' }</DialogTitle>
                            <DialogContent>
                                <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="standard"
                                            type="text"
                                            label="Эталонное наименование"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="name"
                                            type="text"
                                            label="Имя"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="volume"
                                            type="number"
                                            label="Объем, вес и дозы"
                                            component={ TextField }
                                            inputProps={{ step: "0.01" }}
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="unit"
                                            type="number"
                                            label="Единица измерения"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="packing"
                                            type="text"
                                            label="Фасовка"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="quantity"
                                            type="number"
                                            step="1"
                                            label="Количество единиц с учетом фасовки"
                                            component={ TextField }
                                            inputProps={{ step: "1" }}
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="generic"
                                            type="text"
                                            label="Международного непатентованного наименования"
                                            component={ TextField }
                                        />
                                    </Grid>
                                    <Grid item sm={8} className={classes.fullWidth}>
                                        <Field
                                            fullWidth
                                            name="form"
                                            type="text"
                                            label="Форма"
                                            component={ TextField }
                                        />
                                    </Grid>
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
                                    product
                                        ? (
                                            <DialogActions>
                                                <Button
                                                    disabled={ isSubmitting || this.state.delete }
                                                    onClick={() => {
                                                        this.setState({ delete: true })
                                                        handleDelete(product.id).then(
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

ProductForm = withStyles(style)(ProductForm)

const connectedProductForm = connect(mapStateToProps, mapDispatchToProps)(ProductForm)
export { connectedProductForm as ProductForm }
