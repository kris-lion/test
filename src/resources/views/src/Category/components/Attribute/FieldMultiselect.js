import React from "react";
import { Field } from "formik";

import { withStyles } from '@material-ui/core/styles'

import { Select } from "formik-material-ui";
import { FormControl, FormHelperText, InputLabel, MenuItem } from "@material-ui/core";

const style = theme => ({
    fullWidth: {
        'width': '100%'
    }
})

class FieldMultiselect extends React.Component {
    render () {
        const { id, label, items, errors, classes } = this.props

        return (
            <FormControl className={classes.fullWidth} error={ !!(errors.attributes && errors.attributes.hasOwnProperty(`${id}`)) }>
                <InputLabel shrink={ true } htmlFor="roles">
                    { label }
                </InputLabel>
                <Field
                    fullWidth
                    type="text"
                    name={`attributes.${id}`}
                    label={ label }
                    component={ Select }
                    multiple={ true }
                >
                    {items.map(option => (
                        <MenuItem key={option.id} value={option.id}>
                            {option.name}
                        </MenuItem>
                    ))}
                </Field>
                {!!(errors.attributes && errors.attributes.hasOwnProperty(`${id}`)) &&
                    <FormHelperText>{ errors.attributes[`${id}`] }</FormHelperText>
                }
            </FormControl>
        )
    }
}

FieldMultiselect = withStyles(style)(FieldMultiselect)

export { FieldMultiselect }
