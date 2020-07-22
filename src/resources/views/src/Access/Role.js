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
import { RoleActions } from "./actions/role";
import { RoleForm } from "./components/RoleForm";
import { PermissionActions } from "./actions/permission";

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
        align: 'left',
        format: value => value.toLocaleString()
    },
    {
        id: 'key',
        label: 'Уникальный ключ',
        align: 'left',
        format: value => value.toLocaleString()
    }
];

class Role extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            role: null,
            dialog: false,
            page: 0,
            rowsPerPage: 10
        };
    }

    componentDidMount () {
        const { actions, permission } = this.props
        const { rowsPerPage } = this.state

        permission.permissions();

        return actions.roles({ limit: rowsPerPage })
    }

    componentWillUnmount() {
        const { dispatch } = this.props

        dispatch({ type: 'ROLES_CLEAR'})
    }

    render() {
        const { roles, classes } = this.props
        const { role, dialog, page, rowsPerPage } = this.state

        const handleDelete = (id) => {
            const { actions } = this.props

            return actions.remove(id).then(
                () => {
                    return actions.roles({ page: page + 1, limit: rowsPerPage })
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
                        return actions.roles({ page: page + 1, limit: rowsPerPage })
                    }
                )
            }
        }

        const handleChangePage = (event, newPage) => {
            const { actions } = this.props

            return actions.roles({ page: ++newPage, limit: rowsPerPage }).then(
                () => {
                    this.setState({ page: --newPage })
                }
            )
        };

        const handleChangeRowsPerPage = event => {
            const { actions } = this.props

            this.setState({ page: 0, rowsPerPage: +event.target.value })

            return actions.roles({ page: 1, limit: +event.target.value})
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
                                {roles.data.map(item => {
                                    return (
                                        <TableRow hover role="checkbox" tabIndex={-1} key={item.id} onClick={() => { this.setState({ dialog: true, role: item })}}>
                                            <TableCell align="left">
                                                { item.description }
                                            </TableCell>
                                            <TableCell align="left">
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
                        rowsPerPageOptions={ [10, 25, 100] }
                        component="div"
                        count={ roles.data.length ? roles.meta.total : 0 }
                        rowsPerPage={ rowsPerPage }
                        page={ page }
                        onChangePage={ handleChangePage }
                        onChangeRowsPerPage={ handleChangeRowsPerPage }
                    />
                </Grid>
                <Fab size="medium" color="primary" aria-label="Добавить" className={ classes.fab } onClick={() => { this.setState({ dialog: true })}}>
                    <AddIcon />
                </Fab>
                { dialog && <RoleForm role = { role } open = { dialog } handleClose = {() => { this.setState({ dialog: false, role: null }) }} handleDelete = { handleDelete } handleSave = { handleSave } /> }
            </Grid>
        )
    }
}

function mapStateToProps(state) {
    const { roles } = state.role

    return {
        roles
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch,
        actions: bindActionCreators(RoleActions, dispatch),
        permission: bindActionCreators(PermissionActions, dispatch)
    }
}

Role = withStyles(style)(Role)

const connectedRole = connect(mapStateToProps, mapDispatchToProps)(Role)
export { connectedRole as Role }
