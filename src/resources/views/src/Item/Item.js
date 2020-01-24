import React from 'react'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'

import { withStyles } from '@material-ui/core/styles'
import {
    Grid,
    TableContainer, Table, TableHead, TableBody, TableRow, TableCell, TablePagination,
    Fab, Select, MenuItem
} from '@material-ui/core'
import { Check } from '@material-ui/icons';
import AddIcon from '@material-ui/icons/Add';
import { ItemActions } from "./actions/item";
import { ItemForm } from "./components/ItemForm";
import { CategoryActions } from "../Category/actions/category";

const style = theme => ({
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
            rowsPerPage: 10,
            columns: []
        };
    }

    componentDidMount () {
        const { category } = this.props

        category.categories();
    }

    componentWillUnmount() {
        const { dispatch } = this.props

        dispatch({ type: 'ITEMS_CLEAR'})
    }

    render() {
        const { items, categories, classes } = this.props
        const { item, category, dialog, page, rowsPerPage, columns } = this.state

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
            const { actions } = this.props
            const { category } = this.state

            if (id) {
                return actions.save(id, values)
            } else {
                return actions.add(values).then(
                    () => {
                        if (category) {
                            return actions.items({page: page + 1, limit: rowsPerPage, category: category.id})
                        }
                    }
                )
            }
        }

        const handleChange = event => {
            const { actions } = this.props

            const category = event.target.value

            this.setState({
                category: category
            })

            return actions.items({ page: 1, category: category.id }).then(() => {
                if (category.hasOwnProperty('attributes')) {
                    this.setState({
                        columns: category.attributes.map((attribute) => {
                            return {
                                id: attribute.id,
                                label: attribute.name,
                                align: 'center',
                                format: value => value.toLocaleString()
                            }
                        })
                    })
                }
            })
        };

        const handleChangePage = (event, newPage) => {
            const { actions } = this.props

            return actions.items({ page: ++newPage, limit: rowsPerPage }).then(
                () => {
                    this.setState({ page: --newPage })
                }
            )
        };

        const handleChangeRowsPerPage = event => {
            const { actions } = this.props

            this.setState({ page: 0, rowsPerPage: +event.target.value })

            return actions.items({ page: 1, limit: +event.target.value})
        };

        const getValue = (values, id) => {
            const value = values.find((value) => { return (value.attribute.id === id) ? value : null })

            if (value) {
                switch (value.attribute.type.key) {
                    case 'generic':
                        return JSON.parse(value.value).map(el => {
                            return el.name
                        }).join(', ')
                        break
                    case 'boolean':
                        return <Check />
                    default:
                        return value.value
                }
            }

            return null
        }

        return (
            <Grid container direction="column" justify="space-between" alignItems="center" className={classes.field}>
                <Grid item className={classes.item}>
                    <Grid container direction="row" justify="flex-end" alignItems="center">
                        <Grid item sm={3}>
                            <Select
                                fullWidth
                                id="category"
                                value={ category }
                                onChange={ handleChange }
                            >
                                {categories.data.map(option => (
                                    <MenuItem key={ option.id } value={ option }>
                                        {option.name}
                                    </MenuItem>
                                ))}
                            </Select>
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
                                        <TableRow hover role="checkbox" tabIndex={-1} key={item.id} onClick={() => { this.setState({ dialog: true, item: item })}}>
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
                        rowsPerPageOptions={ [10, 25, 100] }
                        component="div"
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
    const { categories } = state.category

    return {
        items, categories
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch,
        actions: bindActionCreators(ItemActions, dispatch),
        category: bindActionCreators(CategoryActions, dispatch)
    }
}

Item = withStyles(style)(Item)

const connectedItem = connect(mapStateToProps, mapDispatchToProps)(Item)
export { connectedItem as Item }
