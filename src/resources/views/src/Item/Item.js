import React from 'react'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'

import { withStyles } from '@material-ui/core/styles'
import {
    Grid, Badge,
    TableContainer, Table, TableHead, TableBody, TableRow, TableCell, TablePagination,
<<<<<<< HEAD
    Fab, Select, MenuItem
=======
    Fab, Select, MenuItem, TextField
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
<<<<<<< HEAD
        'height': 'calc(100% - 84px)',
=======
        'height': 'calc(100% - 132px)',
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
<<<<<<< HEAD
=======
            search: '',
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
            item: null,
            category: {},
            dialog: false,
            page: 0,
<<<<<<< HEAD
            rowsPerPage: 10,
=======
            rowsPerPage: 100,
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
<<<<<<< HEAD
        const { item, category, dialog, page, rowsPerPage, columns, offers } = this.state
=======
        const { item, category, dialog, page, rowsPerPage, columns, offers, search } = this.state
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3

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
<<<<<<< HEAD

                        return dictionary.generics()
=======
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
                    }
                )
            } else {
                return actions.add(values).then(
                    () => {
<<<<<<< HEAD
                        dictionary.generics()
                        if (category) {
                            return actions.items({page: page + 1, limit: rowsPerPage, category: category.id})
=======
                        if (category) {
                            return actions.items({...{page: page + 1, limit: rowsPerPage, category: category.id}, ...((search.length >= 3) ? {search: search} : {})})
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
                        }
                    }
                )
            }
        }

<<<<<<< HEAD
=======
        const handleSearch = event => {
            const { actions, dictionary } = this.props

            const value = event.target.value

            this.setState({
                search: value,
                page: 0
            })

            if (!value.length || (value.length >= 3)) {
                return actions.items({...{page: 0, category: category.id, limit: rowsPerPage}, ...((value.length >= 3) ? {search: value} : {})}).then(() => {
                    if (category.hasOwnProperty('attributes')) {
                        let dictionaries = this.state.dictionaries
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
                                            dictionaries = {
                                                ...dictionaries,
                                                ...{generics: dictionary.generics()}
                                            }
                                        }
                                        break
                                    default:
                                        break
                                }
                            }
                        })

                        this.setState({columns: columns, dictionaries: dictionaries})
                    }
                })
            }
        }

>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
        const handleChange = event => {
            const { actions, dictionary } = this.props

            const category = event.target.value

            this.setState({
<<<<<<< HEAD
                category: category
            })

            return actions.items({ page: 1, limit: this.state.rowsPerPage, category: category.id }).then(() => {
=======
                category: category,
                page: 0
            })

            return actions.items({...{ page: 1, limit: this.state.rowsPerPage, category: category.id }, ...((search.length >= 3) ? {search: search} : {})}).then(() => {
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
<<<<<<< HEAD
                                        dictionary.generics()
=======
                                        dictionaries = {
                                            ...dictionaries,
                                            ...{generics: dictionary.generics()}
                                        }
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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

<<<<<<< HEAD
            return actions.items({ page: ++newPage, limit: rowsPerPage }).then(
=======
            return actions.items({...{ page: ++newPage, limit: rowsPerPage, category: category.id }, ...((search.length >= 3) ? {search: search} : {})}).then(
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
                () => {
                    this.setState({ page: --newPage })
                }
            )
        };

        const handleChangeRowsPerPage = event => {
            const { actions } = this.props

            this.setState({ page: 0, rowsPerPage: +event.target.value })

<<<<<<< HEAD
            return actions.items({ page: 1, limit: +event.target.value})
=======
            return actions.items({...{ page: 1, limit: +event.target.value, category: category.id}, ...((search.length >= 3) ? {search: search} : {})})
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
<<<<<<< HEAD
            <Grid container direction="column" justify="space-between" alignItems="center" className={classes.field}>
                <Grid item className={classes.item}>
                    <Grid container direction="row" justify="flex-end" alignItems="center">
=======
            <Grid container direction="column" justify="flex-start" alignItems="stretch" className={classes.field} spacing={2}>
                <Grid item className={classes.item}>
                    <Grid container direction="row" justify="space-between" alignItems="center">
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
                        <Grid item sm={3}>
                            <Badge badgeContent={ offers.count } color="secondary" className={ classes.fullWidth }>
                                <Select
                                    fullWidth
                                    id="category"
                                    value={ category }
                                    onChange={ handleChange }
                                >
<<<<<<< HEAD
                                    {
                                        getCategoriesTree(categories).map(el => el)
                                    }
                                </Select>
                            </Badge>
                        </Grid>
=======
                                    {getCategoriesTree(categories).map(el => el)}
                                </Select>
                            </Badge>
                        </Grid>
                        <Grid item sm={3}>
                            <TextField
                                fullWidth
                                id="category"
                                disabled={!Object.keys(category).length}
                                label='Поиск'
                                value={search}
                                onChange={ handleSearch }
                            />
                        </Grid>
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
<<<<<<< HEAD
                                            align={column.align}
                                            style={{ minWidth: column.minWidth }}
=======
                                            align="left"
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
<<<<<<< HEAD
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
=======
                                            {columns.map(column => {
                                                const value = getValue(item.values, column.id)

                                                return (
                                                    <TableCell
                                                        key={column.id}
                                                        align="left"
                                                        title={value}
                                                    >
                                                        {value}
                                                    </TableCell>
                                                )
                                            })}
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
                                        </TableRow>
                                    );
                                })}
                            </TableBody>
                        </Table>
                    </TableContainer>
                </Grid>
                <Grid item className={classes.item}>
                    <TablePagination
<<<<<<< HEAD
                        rowsPerPageOptions={ [10, 25, 100] }
                        component="div"
=======
                        rowsPerPageOptions={ [50, 100, 200] }
                        component='div'
                        labelRowsPerPage={'Записей на странице:'}
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
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
