import React from "react";
import { Field } from "formik";
import { TextField } from "formik-material-ui";
import Autocomplete from "@material-ui/lab/Autocomplete/Autocomplete";

class FieldDictionary extends React.Component {
    render () {
        const { id, label, items, values, setFieldValue, setTouched, isSubmitting } = this.props

        return (
            <Autocomplete
                freeSolo
                options={ items }
                disabled={ isSubmitting }
                getOptionLabel={ option => option.name }
                defaultValue={
                    values.hasOwnProperty(id)
                        ? { name: values[id] }
                        : { name: '' }
                }
                onChange={(e, value) => {
                    setFieldValue(`attributes.${id}`, (value.hasOwnProperty('name') ? value.name : value))
                }}
                onBlur={ () => setTouched({ [`attributes.${id}`]: true }) }
                renderInput={params => (
                    <Field
                        component={ TextField }
                        {...params}
                        name={`attributes.${id}`}
                        label={label}
                        fullWidth
                    />
                )}
            />
        )
    }
}

export { FieldDictionary }
