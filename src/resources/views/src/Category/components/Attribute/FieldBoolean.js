import React from "react";
import { FormControlLabel } from "@material-ui/core";
import { Field } from "formik";
import { Switch } from "formik-material-ui";

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

export { FieldBoolean }
