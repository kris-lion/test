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
import { UserActions } from "./actions/user";
import { UserForm } from "./components/UserForm";
import { RoleActions } from "./actions/role";

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
        id: 'login',
        label: 'Имя пользователя',
<<<<<<< HEAD
        align: 'center',
=======
        align: 'left',
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
        format: value => value.toLocaleString()
    }
];

class User extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            user: null,
            dialog: false,
            page: 0,
            rowsPerPage: 10
        };
    }

    componentDidMount () {
        const { actions, role } = this.props
        const { rowsPerPage } = this.state

        role.roles();

        return actions.users({ limit: rowsPerPage })
    }

    componentWillUnmount() {
        const { dispatch } = this.props

        dispatch({ type: 'USERS_CLEAR'})
    }

    render() {
        const { users, classes } = this.props
        const { user, dialog, page, rowsPerPage } = this.state

        const handleDelete = (id) => {
            const { actions } = this.props

            return actions.remove(id).then(
                () => {
                    return actions.users({ page: page + 1, limit: rowsPerPage })
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
                        return actions.users({ page: page + 1, limit: rowsPerPage })
                    }
                )
            }
        }

        const handleChangePage = (event, newPage) => {
            const { actions } = this.props

            return actions.users({ page: ++newPage, limit: rowsPerPage }).then(
                () => {
                    this.setState({ page: --newPage })
                }
            )
        };

        const handleChangeRowsPerPage = event => {
            const { actions } = this.props

            this.setState({ page: 0, rowsPerPage: +event.target.value })

            return actions.users({ page: 1, limit: +event.target.value})
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
                                {users.data.map(item => {
                                    return (
                                        <TableRow hover role="checkbox" tabIndex={-1} key={item.id} onClick={() => { this.setState({ dialog: true, user: item })}}>
<<<<<<< HEAD
                                            <TableCell align="center">
=======
                                            <TableCell align="left">
>>>>>>> 4fca0b746db03001dfaf7ffa390524fcc95fa8c3
                                                { item.login }
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
                        count={ users.data.length ? users.meta.total : 0 }
                        rowsPerPage={ rowsPerPage }
                        page={ page }
                        onChangePage={ handleChangePage }
                        onChangeRowsPerPage={ handleChangeRowsPerPage }
                    />
                </Grid>
                <Fab size="medium" color="primary" aria-label="Добавить" className={ classes.fab } onClick={() => { this.setState({ dialog: true })}}>
                    <AddIcon />
                </Fab>
                { dialog && <UserForm user = { user } open = { dialog } handleClose = {() => { this.setState({ dialog: false, user: null }) }} handleDelete = { handleDelete } handleSave = { handleSave } /> }
            </Grid>
        )
    }
}

function mapStateToProps(state) {
    const { users } = state.user

    return {
        users
    }
}

function mapDispatchToProps(dispatch) {
    return {
        dispatch,
        actions: bindActionCreators(UserActions, dispatch),
        role: bindActionCreators(RoleActions, dispatch)
    }
}

User = withStyles(style)(User)

const connectedUser = connect(mapStateToProps, mapDispatchToProps)(User)
export { connectedUser as User }
