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

const columns = [];

class Category extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            category: null,
            dialog: false,
            page: 0,
            rowsPerPage: 10
        };
    }

    componentDidMount () {
        const { actions } = this.props
        const { rowsPerPage } = this.state

        return actions.categories({ limit: rowsPerPage })
    }

    componentWillUnmount() {
        const { dispatch } = this.props

        dispatch({ type: 'PRODUCTS_CLEAR'})
    }

    render() {
        const { categories, classes } = this.props
        const { category, dialog, page, rowsPerPage } = this.state

        const handleDelete = (id) => {
            const { actions } = this.props

            return actions.remove(id).then(
                () => {
                    return actions.categories({ page: page + 1, limit: rowsPerPage })
                }
            )
        }

        const handleSave = (values, id = null) => {
            const { actions } = this.props

            if (id) {
                return actions.save(id, values)
            } else {
                return actions.add(values).then(
                    () => {
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

                            </TableBody>
                        </Table>
                    </TableContainer>
                </Grid>
                <Grid item className={classes.item}>
                    <TablePagination
                        rowsPerPageOptions={ [10, 25, 100] }
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
            </Grid>
        )
    }
}

function mapStateToProps(state) {
    const { categories } = state.category

    return {
        categories
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch,
        actions: bindActionCreators(CategoryActions, dispatch)
    }
}

Category = withStyles(style)(Category)

const connectedCategory = connect(mapStateToProps, mapDispatchToProps)(Category)
export { connectedCategory as Category }
