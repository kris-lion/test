import React from "react";
import { Field } from "formik";
import { TextField } from "formik-material-ui";

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

export { FieldInteger }
