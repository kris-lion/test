import React from "react";
import { Field } from "formik";
import { TextField } from "formik-material-ui";
import Autocomplete from "@material-ui/lab/Autocomplete/Autocomplete";

class FieldUnit extends React.Component {
    render () {
        const { id, label, items } = this.props

        return (
            <Autocomplete
                options={ items }
                getOptionLabel={option => option.short}
                renderInput={params => (
                    <Field
                        fullWidth
                        {...params}
                        name={`attributes.${id}`}
                        type="text"
                        label={ label }
                        component={ TextField }
                    />
                )}
            />
        )
    }
}

export { FieldUnit }
