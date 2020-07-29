import React from "react";
import { connect } from "react-redux";
import { Field, FieldArray } from "formik";

import { withStyles } from '@material-ui/core/styles'

import { Card, CardContent, Grid, IconButton, Button } from "@material-ui/core";
import { TextField } from "formik-material-ui";
import { DeleteSweep, PlaylistAdd } from "@material-ui/icons";
import Autocomplete from '@material-ui/lab/Autocomplete';

const style = theme => ({
    fullWidth: {
        'width': '100%'
    }
})

class FieldGeneric extends React.Component {
    render () {
        const { id, label, items, errors, units, classes } = this.props

        return (
            <FieldArray
                name={ `attributes.${id}` }
                render={ arrayHelpers => (
                    <Grid item className={classes.fullWidth}>
                        <Grid container direction='column' justify='center' alignItems='center' spacing={2}>
                            {items && items.length > 0 && (
                                items.map((item, index) => (
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
                                                                        name={`attributes.${id}.${index}.name`}
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
                                                            <Grid container direction='row' justify='space-between' alignItems='center' spacing={2}>
                                                                <Grid item sm={5} className={classes.fullWidth}>
                                                                    <Field
                                                                        fullWidth
                                                                        name={`attributes.${id}.${index}.numerator.quantity`}
                                                                        type="number"
                                                                        label="Количество"
                                                                        inputProps={{ step: 0.00001 }}
                                                                        component={ TextField }
                                                                    />
                                                                </Grid>
                                                                <Grid item sm={7} className={classes.fullWidth}>
                                                                    <Autocomplete
                                                                        options={ units }
                                                                        getOptionLabel={option => option.short}
                                                                        renderInput={params => (
                                                                            <Field
                                                                                fullWidth
                                                                                {...params}
                                                                                name={`attributes.${id}.${index}.numerator.unit`}
                                                                                type="text"
                                                                                label="Ед. изм."
                                                                                component={ TextField }
                                                                            />
                                                                        )}
                                                                    />
                                                                </Grid>
                                                            </Grid>
                                                            <Grid container direction='row' justify='space-between' alignItems='center' spacing={2}>
                                                                <Grid item sm={5} className={classes.fullWidth}>
                                                                    <Field
                                                                        fullWidth
                                                                        name={`attributes.${id}.${index}.denominator.quantity`}
                                                                        type="number"
                                                                        label="Количество"
                                                                        inputProps={{ step: 0.00001 }}
                                                                        component={ TextField }
                                                                    />
                                                                </Grid>
                                                                <Grid item sm={7} className={classes.fullWidth}>
                                                                    <Autocomplete
                                                                        options={ units }
                                                                        getOptionLabel={option => option.short}
                                                                        renderInput={params => (
                                                                            <Field
                                                                                fullWidth
                                                                                {...params}
                                                                                name={`attributes.${id}.${index}.denominator.unit`}
                                                                                type="text"
                                                                                label="Ед. изм."
                                                                                component={ TextField }
                                                                            />
                                                                        )}
                                                                    />
                                                                </Grid>
                                                            </Grid>
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
                                    onClick={() => arrayHelpers.push({
                                        'name': '',
                                        'numerator': {
                                            quantity: 0.00000,
                                            unit: ''
                                        },
                                        'denominator': {
                                            quantity: 0.00000,
                                            unit: ''
                                        }
                                    })}
                                    aria-label={`Добавить ${label}`}
                                    color={(errors.attributes && errors.attributes.hasOwnProperty(`${id}`)) && !items.length ? 'secondary' : 'primary'}
                                    endIcon={<PlaylistAdd />}
                                >
                                    { label }
                                </Button>
                            </Grid>
                        </Grid>
                    </Grid>
                )}
            />
        )
    }
}

function mapStateToProps(state) {
    const { units } = state.unit

    return {
        units
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch
    }
}

FieldGeneric = withStyles(style)(FieldGeneric)

const connectedFieldGeneric = connect(mapStateToProps, mapDispatchToProps)(FieldGeneric)
export { connectedFieldGeneric as FieldGeneric }
