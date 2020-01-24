import React from "react";
import { Field } from "formik";
import { TextField } from "formik-material-ui";

class FieldDouble extends React.Component {
    render () {
        const { id, label } = this.props

        return (
            <Field
                fullWidth
                name={ `attributes.${id}` }
                type="number"
                label={ `${label}` }
                inputProps={{ step: 0.00001 }}
                component={ TextField }
            />
        )
    }
}

export { FieldDouble }
