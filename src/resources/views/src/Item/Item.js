import React from 'react'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'

import { withStyles } from '@material-ui/core/styles'
import {
    Grid, Badge,
    TableContainer, Table, TableHead, TableBody, TableRow, TableCell, TablePagination,
    Fab, Select, MenuItem
} from '@material-ui/core'
import { red } from '@material-ui/core/colors'
import { Check } from '@material-ui/icons';
import AddIcon from '@material-ui/icons/Add';
import { ItemActions } from "./actions/item";
import { ItemForm } from "./components/ItemForm";
import { UnitActions } from "../Category/actions/Unit/unit";
import { SystemActions } from "../App/actions/system";
import { DictionaryActions } from "../Dictionary/actions/dictionary";

const style = theme => ({
    fullWidth: {
        'width': '100%'
    },
    field: {
        'height': '100%'
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
    },
    active: {
        'background-color': red[100],
        '&:hover': {
            'background-color': red[50] + '!important',
        },
    },
    default: {

    }
})

class Item extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            item: null,
            category: {},
            dialog: false,
            page: 0,
            rowsPerPage: 100,
            columns: [],
            dictionaries: {},
            offers: {
                count: 0,
                categories: {}
            }
        };
    }

    componentDidMount () {
        const { actions, system, unit } = this.props

        actions.offers().then(
            offers => {
                this.setState({ offers: offers })
            }
        )

        unit.units();
        system.categories();
    }

    componentWillUnmount() {
        const { dispatch } = this.props

        dispatch({ type: 'ITEMS_CLEAR'})
    }

    render() {
        const { items, categories, classes } = this.props
        const { item, category, dialog, page, rowsPerPage, columns, offers } = this.state

        const handleDelete = (id) => {
            const { actions } = this.props
            const { category } = this.state

            return actions.remove(id).then(
                () => {
                    return actions.items({ page: page + 1, limit: rowsPerPage, category: category.id })
                }
            )
        }

        const handleSave = (values, id = null) => {
            const { actions, dictionary } = this.props
            const { category } = this.state

            if (id) {
                return actions.save(id, values).then(
                    () => {
                        if (values.hasOwnProperty('active') && values.active) {
                            let categories = offers.categories
                            if (categories.hasOwnProperty(values.category)) {
                                if (categories[values.category] > 1) {
                                    --categories[values.category]
                                } else {
                                    delete categories[values.category]
                                }
                            }

                            this.setState({ offers: { count: --offers.count, categories: categories } })
                        }

                        return dictionary.generics()
                    }
                )
            } else {
                return actions.add(values).then(
                    () => {
                        dictionary.generics()
                        if (category) {
                            return actions.items({page: page + 1, limit: rowsPerPage, category: category.id})
                        }
                    }
                )
            }
        }

        const handleChange = event => {
            const { actions, dictionary } = this.props

            const category = event.target.value

            this.setState({
                category: category,
                page: 0
            })

            return actions.items({ page: 1, limit: this.state.rowsPerPage, category: category.id }).then(() => {
                if (category.hasOwnProperty('attributes')) {
                    let dictionaries  = this.state.dictionaries
                    let columns = []

                    category.attributes.forEach((attribute) => {
                        columns.push({
                            id: attribute.id,
                            label: attribute.name,
                            align: 'center',
                            format: value => value.toLocaleString()
                        })

                        if (attribute.type.key === 'dictionary') {
                            switch (attribute.value) {
                                case 'generics':
                                    if (!dictionaries.hasOwnProperty('generics')) {
                                        dictionary.generics()
                                    }
                                    break
                                default:
                                    break
                            }
                        }
                    })

                    this.setState({ columns: columns, dictionaries: dictionaries })
                }
            })
        };

        const handleChangePage = (event, newPage) => {
            const { actions } = this.props

            return actions.items({ page: ++newPage, limit: rowsPerPage, category: category.id }).then(
                () => {
                    this.setState({ page: --newPage })
                }
            )
        };

        const handleChangeRowsPerPage = event => {
            const { actions } = this.props

            this.setState({ page: 0, rowsPerPage: +event.target.value })

            return actions.items({ page: 1, limit: +event.target.value, category: category.id})
        };

        const getValue = (values, id) => {
            const value = values.find((value) => { return (value.attribute.id === id) ? value : null })

            if (value) {
                switch (value.attribute.type.key) {
                    case 'generic':
                        return JSON.parse(value.value).map(el => {
                            return el.name
                        }).join(', ')
                    case 'select':
                        return value.attribute.options.filter(el => parseInt(el.id) === parseInt(value.value)).map(el => { return el.option }).join(', ')
                    case 'multiselect':
                        return value.attribute.options.filter(el => JSON.parse(value.value).includes(el.id)).map(el => { return el.option }).join(', ')
                    case 'boolean':
                        return <Check />
                    default:
                        return value.value
                }
            }

            return null
        }

        const assembly = (categories, parent = 0, level = 0) => {
            let result = []

            if (categories.hasOwnProperty(parent)) {
                categories[parent].forEach(category => {
                    result.push(<MenuItem key={ category.id } value={ category } className={ offers.categories.hasOwnProperty(category.id) ? classes.active : classes.default }>{ '\u00A0\u00A0\u00A0\u00A0'.repeat(level) + category.name }</MenuItem>)

                    result = result.concat(assembly(categories, category.id, level + 1))
                })
            }

            return result
        }

        const getCategoriesTree = categories => {
            let tmp = {}
            categories.forEach(category => {
                if (!tmp.hasOwnProperty((category.category !== null) ? category.category.id : 0)) {
                    tmp[(category.category !== null) ? category.category.id : 0] = []
                }

                tmp[(category.category !== null) ? category.category.id : 0].push(category)
            })

            return assembly(tmp)
        }

        return (
            <Grid container direction="column" justify="space-between" alignItems="center" className={classes.field}>
                <Grid item className={classes.item}>
                    <Grid container direction="row" justify="flex-end" alignItems="center">
                        <Grid item sm={3}>
                            <Badge badgeContent={ offers.count } color="secondary" className={ classes.fullWidth }>
                                <Select
                                    fullWidth
                                    id="category"
                                    value={ category }
                                    onChange={ handleChange }
                                >
                                    {
                                        getCategoriesTree(categories).map(el => el)
                                    }
                                </Select>
                            </Badge>
                        </Grid>
                    </Grid>
                </Grid>
                <Grid item className={classes.data}>
                    <TableContainer className={classes.table}>
                        <Table stickyHeader aria-label="sticky table">
                            <TableHead>
                                <TableRow>
                                    {columns.map(column => (
                                        <TableCell
                                            key={column.id}
                                            align={column.align}
                                            style={{ minWidth: column.minWidth }}
                                        >
                                            {column.label}
                                        </TableCell>
                                    ))}
                                </TableRow>
                            </TableHead>
                            <TableBody>
                                {items.data.map(item => {
                                    return (
                                        <TableRow hover role="checkbox" tabIndex={-1} key={item.id} onClick={() => { this.setState({ dialog: true, item: item })}} className={ !item.active ? classes.active : classes.default } >
                                            {columns.map(column => (
                                                <TableCell
                                                    key={ column.id }
                                                    align="center"
                                                >
                                                    {
                                                        getValue(item.values, column.id)
                                                    }
                                                </TableCell>
                                            ))}
                                        </TableRow>
                                    );
                                })}
                            </TableBody>
                        </Table>
                    </TableContainer>
                </Grid>
                <Grid item className={classes.item}>
                    <TablePagination
                        rowsPerPageOptions={ [50, 100, 200] }
                        component='div'
                        labelRowsPerPage={'Записей на странице:'}
                        count={ items.data.length ? items.meta.total : 0 }
                        rowsPerPage={ rowsPerPage }
                        page={ page }
                        onChangePage={ handleChangePage }
                        onChangeRowsPerPage={ handleChangeRowsPerPage }
                    />
                </Grid>
                { !!Object.keys(category).length &&
                    <Fab size="medium" color="primary" aria-label="Добавить" className={classes.fab} onClick={() => {this.setState({dialog: true}) }}>
                        <AddIcon/>
                    </Fab>
                }
                { dialog &&
                    <ItemForm item = { item } category = { category } open = { dialog } handleClose = {() => { this.setState({ dialog: false, item: null }) }} handleDelete = { handleDelete } handleSave = { handleSave } />
                }
            </Grid>
        )
    }
}

function mapStateToProps(state) {
    const { items } = state.item
    const { categories } = state.system

    return {
        items, categories
    }
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

Item = withStyles(style)(Item)

const connectedItem = connect(mapStateToProps, mapDispatchToProps)(Item)
export { connectedItem as Item }
