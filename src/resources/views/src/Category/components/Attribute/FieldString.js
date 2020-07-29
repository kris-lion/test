import React from "react";
import { Field } from "formik";
import { TextField } from "formik-material-ui";

class FieldString extends React.Component {
    render () {
        const { id, label } = this.props

        return (
            <Field
                fullWidth
                name={ `attributes.${id}` }
                type="text"
                label={ `${label}` }
                component={ TextField }
            />
        )
    }
}

export { FieldString }
