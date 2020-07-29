import React from "react";
import { Field } from "formik";
import { TextField } from "formik-material-ui";
import Autocomplete from "@material-ui/lab/Autocomplete/Autocomplete";

class FieldUnit extends React.Component {
    render () {
        const { id, label, items, values, setFieldValue, setTouched, isSubmitting } = this.props

        return (
            <Autocomplete
                options={ items }
                disabled={ isSubmitting }
                getOptionLabel={option => option.short}
                defaultValue={
                    values.hasOwnProperty(id)
                        ? { short: values[id] }
                        : { short: '' }
                }
                onChange={(e, value) => {
                    setFieldValue(`attributes.${id}`, (value.hasOwnProperty('name') ? value.short : value))
                }}
                onBlur={ () => setTouched({ [`attributes.${id}`]: true }) }
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
