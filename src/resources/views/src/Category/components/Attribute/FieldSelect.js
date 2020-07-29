import React from "react";
import { Field } from "formik";
import { TextField } from "formik-material-ui";
import { MenuItem } from "@material-ui/core";

class FieldSelect extends React.Component {
    render () {
        const { id, label, items } = this.props

        return (
            <Field
                fullWidth
                type="text"
                name={`attributes.${id}`}
                label={ label }
                select
                variant="standard"
                component={ TextField }
                InputLabelProps={{
                    shrink: true,
                }}
            >
                {items.map(option => (
                    <MenuItem key={option.id} value={option.id}>
                        {option.name}
                    </MenuItem>
                ))}
            </Field>
        )
    }
}

export { FieldSelect }
