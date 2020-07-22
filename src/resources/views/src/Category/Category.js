import React from 'react'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'

import { withStyles } from '@material-ui/core/styles'
import {
    Grid,
    TableContainer, Table, TableHead, TableBody, TableRow, TableCell, TablePagination,
    Fab
} from '@material-ui/core'
import AddIcon from '@material-ui/icons/Add';
import { CategoryActions } from "./actions/category";
import { CategoryForm } from "./components/CategoryForm";
import { TypeActions } from "./actions/Attribute/type";
import { SystemActions } from "../App/actions/system";
import { ItemActions } from "../Item/actions/item";

const style = theme => ({
    field: {
        'height': '100%'
    },
    data: {
        'height': 'calc(100% - 52px)',
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

const columns = [
    {
        id: 'name',
        label: 'Наименование',
        align: 'center',
        format: value => value.toLocaleString()
    },
];

class Category extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            category: null,
            dialog: false,
            page: 0,
            rowsPerPage: 100
        };
    }

    componentDidMount () {
        const { actions, type, system } = this.props
        const { rowsPerPage } = this.state

        type.types();
        system.categories();

        return actions.categories({ limit: rowsPerPage })
    }

    componentWillUnmount() {
        const { dispatch } = this.props

        dispatch({ type: 'PRODUCTS_CLEAR'})
    }

    render() {
        const { categories, options, classes } = this.props
        const { category, dialog, page, rowsPerPage } = this.state

        const handleDelete = (id, params = null) => {
            const { actions, item, system } = this.props

            return new Promise((resolve, reject) => {
                if (params) {
                    return actions.remove(id, params).then(
                        () => {
                            system.categories();
                            actions.categories({page: page + 1, limit: rowsPerPage})
                            resolve()
                        }
                    )
                } else {
                    item.count({category: id})
                        .then(
                            count => {
                                if (count > 0) {
                                    resolve(count)
                                } else {
                                    return actions.remove(id).then(
                                        () => {
                                            system.categories();
                                            actions.categories({page: page + 1, limit: rowsPerPage})
                                            resolve()
                                        }
                                    )
                                }
                            },
                            error => {
                                reject()
                            }
                        )
                }
            })
        }

        const handleSave = (values, id = null) => {
            const { actions, system } = this.props

            if (id) {
                return actions.save(id, values).then(
                    () => {
                        return system.categories();
                    }
                )
            } else {
                return actions.add(values).then(
                    () => {
                        system.categories();
                        return actions.categories({ page: page + 1, limit: rowsPerPage })
                    }
                )
            }
        }

        const handleChangePage = (event, newPage) => {
            const { actions } = this.props

            return actions.categories({ page: ++newPage, limit: rowsPerPage }).then(
                () => {
                    this.setState({ page: --newPage })
                }
            )
        };

        const handleChangeRowsPerPage = event => {
            const { actions } = this.props

            this.setState({ page: 0, rowsPerPage: +event.target.value })

            return actions.categories({ page: 1, limit: +event.target.value})
        };

        return (
            <Grid container direction="column" justify="space-between" alignItems="center" className={classes.field}>
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
                                {categories.data.map(item => {
                                    return (
                                        <TableRow hover role="checkbox" tabIndex={-1} key={item.id} onClick={() => { this.setState({ dialog: true, category: item })}}>
                                            <TableCell align="center">
                                                { item.name }
                                            </TableCell>
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
                        component="div"
                        count={ categories.data.length ? categories.meta.total : 0 }
                        rowsPerPage={ rowsPerPage }
                        page={ page }
                        onChangePage={ handleChangePage }
                        onChangeRowsPerPage={ handleChangeRowsPerPage }
                    />
                </Grid>
                <Fab size="medium" color="primary" aria-label="Добавить" className={ classes.fab } onClick={() => { this.setState({ dialog: true })}}>
                    <AddIcon />
                </Fab>
                { dialog && <CategoryForm category = { category } categories = { options } open = { dialog } handleClose = {() => { this.setState({ dialog: false, category: null }) }} handleDelete = { handleDelete } handleSave = { handleSave } /> }
            </Grid>
        )
    }
}

function mapStateToProps(state) {
    const { categories } = state.category

    return {
        categories, options: state.system.categories
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch,
        actions: bindActionCreators(CategoryActions, dispatch),
        item: bindActionCreators(ItemActions, dispatch),
        system: bindActionCreators(SystemActions, dispatch),
        type: bindActionCreators(TypeActions, dispatch)
    }
}

Category = withStyles(style)(Category)

const connectedCategory = connect(mapStateToProps, mapDispatchToProps)(Category)
export { connectedCategory as Category }
