import React from 'react'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'

import { withStyles } from '@material-ui/core/styles'
import {
    Grid
} from '@material-ui/core'
import { ItemActions } from "./actions/item";
import { OfferForm } from "./components/OfferForm";
import { UnitActions } from "../Category/actions/Unit/unit";
import { SystemActions } from "../App/actions/system";
import { DictionaryActions } from "../Dictionary/actions/dictionary";

const style = theme => ({
    field: {
        'height': '100%'
    },
    fullWidth: {
        'width': '100%'
    },
    data: {
        'height': 'calc(100% - 84px)',
        'width': '100%'
    },
    item: {
        'width': '100%'
    },
    table: {
        'height': '100%'
    },
    fab: {
        'margin': '0',
        'top': 'auto',
        'right': '90px',
        'bottom': '25px',
        'left': 'auto',
        'position': 'fixed'
    }
})

class Offer extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            success: false,
            dictionaries: {}
        };
    }

    componentDidMount () {
        const { system, unit, dictionary } = this.props

        unit.units();
        dictionary.generics();
        system.categories();
    }

    render() {
        const { classes } = this.props

        const handleSave = (values) => {
            const { actions } = this.props

            return actions.add(values).then(
                () => {

                }
            )
        }

        return (
            <Grid container direction="column" justify="space-between" alignItems="center" className={classes.field}>
                <Grid item className={classes.fullWidth}>
                    {
                        <OfferForm handleSave = { handleSave } />
                    }
                </Grid>
            </Grid>
        )
    }
}

function mapStateToProps(state) {
    return {}
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch,
        actions: bindActionCreators(ItemActions, dispatch),
        system: bindActionCreators(SystemActions, dispatch),
        dictionary: bindActionCreators(DictionaryActions, dispatch),
        unit: bindActionCreators(UnitActions, dispatch)
    }
}

Offer = withStyles(style)(Offer)

const connectedOffer = connect(mapStateToProps, mapDispatchToProps)(Offer)
export { connectedOffer as Offer }
