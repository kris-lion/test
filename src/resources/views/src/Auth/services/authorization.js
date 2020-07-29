export const AuthorizationService = {
    access,
    ability,
    roles,
    permissions
}

function access(account, Roles = [], Permissions = [], require = false) {
    if (Roles.length) {
        if (Permissions.length) {
            return ability(account, Roles, Permissions, require)
        }

        return roles(account, Roles, require)
    } else if (Permissions.length) {
        return permissions(account, Permissions, require)
    }

    return false
}

function ability(account, Roles, Permissions, require = false) {
    let access = false

    if (roles(account, Roles, require)) {
        access = true
    }

    if (permissions(account, Permissions, require)) {
        if (require && access) {
            access = true
        }
    } else if (require) {
        access = false
    }

    return access
}

function roles(account, name, require = false) {
    if (Array.isArray(name)) {
        for (const i in name) {
            let has = roles(account, name[i])

            if (has && !require) {
                return true
            } else if (!has && require) {
                return false
            }
        }

        return require
    } else {
        if (account.roles) {
            for (const i in account.roles) {
                if (account.roles[i].name === name) {
                    return true
                }
            }
        }
    }

    return false
}

function permissions(account, name, require = false) {
    if (Array.isArray(name)) {
        for (const i in name) {
            let has = permissions(account, name[i])

            if (has && !require) {
                return true
            } else if (!has && require) {
                return false
            }
        }

        return require
    } else {
        if (account.roles) {
            for (const i in account.roles) {
                if (account.roles[i].permissions) {
                    for (const j in account.roles[i].permissions) {
                        if (account.roles[i].permissions[j].name === name) {
                            return true
                        }
                    }
                }
            }
        }
    }

    return false
}
