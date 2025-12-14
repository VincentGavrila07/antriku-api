<?php

namespace App\Translations;

class LangEn {
    public static function get() {
        return [
            "Sidebar" => [
                "appName" => "Antriku",
                "adminDashboard" => "Admin Dashboard",
                "userManagement" => "User Management",
                "user" => "User",
                "role" => "Role",
                "permission" => "Permission",
                "reports" => "Reports",
                "service" => "Service",
                "staffDashboard" => "Staff Dashboard",
                "orders" => "Orders",
                "myDashboard" => "My Dashboard",
                "profile" => "Profile",
                "logout" => "Logout"
            ],
            'Forbidden' => [
                'Forbidden' => 'Forbidden',
                'Sorry' => 'Sorry, you do not have permission to access this page.
                            If you believe this is an error, please contact the administrator.'
            ],
            "welcome" => [
                "welcome" => "Welcome"
            ],
            "userManagement" => [
                // General
                'ListUser' => 'User List', // Lebih natural daripada "List User"
                'ListPermission' => 'Permission List',
                'ListRole' => 'Role List',
                'EditPermission' => 'Edit Permission',
                'PermissionInfo' => 'Permission Info',
                'Name' => 'Name',
                'Slug' => 'Slug',
                'AssignRoles' => 'Assign Roles', // "(Multi-Select)" dihapus agar UI lebih bersih, user akan tahu dari bentuk inputnya
                'Save' => 'Save',
                'Loading' => 'Loading...',
                'Forbidden' => 'Access Denied', // Lebih umum untuk UI daripada "Forbidden"

                // Permission
                'SuccessUpdate' => 'Permission Updated Successfully',
                'SuccessUpdateDesc' => 'Roles for this permission have been updated.',
                'ErrorUpdate' => 'Failed to Update Permission',
                'ErrorUpdateDesc' => 'An error occurred while saving data.',
                'ErrorLoad' => 'Failed to Load Permission Data',
                'ErrorLoadDesc' => 'An error occurred while loading permission data.',

                // Role management
                'EditRole' => 'Edit Role',
                'AddRole' => 'Add Role',
                'RoleName' => 'Role Name',
                'RoleNameRequired' => 'Role name is required.',
                'RoleNamePlaceholder' => 'Enter role name',
                'SuccessAddRole' => 'Role added successfully.',
                'SuccessEditRole' => 'Role updated successfully.',
                'ErrorAddRole' => 'Failed to add role.',
                'ErrorEditRole' => 'Failed to update role.',
                'ErrorAddRoleDesc' => 'An error occurred while adding the role.',
                'ErrorEditRoleDesc' => 'An error occurred while saving changes.',
                'ErrorLoadRole' => 'Failed to Load Role Data',
                'ErrorLoadRoleDesc' => 'An error occurred while loading role data.',
                'SuccessDeleteRole' => 'Role deleted successfully.',
                'ErrorDeleteRole' => 'Failed to delete role.',
                'ErrorDeleteRoleDesc' => 'An error occurred while deleting the role.',
                'DeleteRoleConfirmTitle' => 'Delete Role?', // Lebih ringkas & to the point
                'DeleteRoleConfirmText' => 'Are you sure you want to delete this role?',
                'DeleteRoleConfirmOk' => 'Delete',
                'DeleteRoleConfirmCancel' => 'Cancel',

                // User detail
                'UserDetail' => 'User Details',
                'AddUser' => 'Add User',
                'EditUser' => 'Edit User',
                'UserId' => 'User ID',
                'UserName' => 'Full Name', // Lebih spesifik daripada "Name"
                'UserEmail' => 'Email Address',
                'UserRole' => 'Role',
                'UserPassword' => 'Password',
                'UserPasswordPlaceholder' => 'Enter password',
                'UserPasswordRequired' => 'Password is required.',
                'SuccessAddUser' => 'User added successfully.',
                'SuccessEditUser' => 'User updated successfully.',
                'ErrorAddUser' => 'Failed to add user.',
                'ErrorEditUser' => 'Failed to update user.',
                'ErrorAddUserDesc' => 'An error occurred while adding the user.',
                'ErrorEditUserDesc' => 'An error occurred while saving user changes.',
                'ErrorLoadUser' => 'Failed to Load User Data',
                'ErrorLoadUserDesc' => 'An error occurred while loading user data.',
                'SuccessDeleteUser' => 'User deleted successfully.',
                'ErrorDeleteUser' => 'Failed to delete user.',
                'ErrorDeleteUserDesc' => 'An error occurred while deleting the user.',
                'DeleteUserConfirmTitle' => 'Delete User?',
                'DeleteUserConfirmText' => 'Are you sure you want to delete this user?',
                'DeleteUserConfirmOk' => 'Delete',
                'DeleteUserConfirmCancel' => 'Cancel',
                'SearchByName' => 'Search by name...'
            ],
            "profile" => [
                'EditProfile' => 'Edit Profile',
                'changePass' => 'Change Password',
                'name' => 'Name',
                'NewPass' => 'New Password',
                'ConfirmPass' => 'Confirm Current Password',
                'Save' => 'Save'
            ],
            'report' => [
                'GenerateServiceReport' => 'Generate Service Report',
                'GenerateReport' => 'Generate Report',
                'Keterangan' => 'Select a date and click the Generate PDF button; the PDF will automatically open in a new tab.',
                'OpenManually' => 'Open PDF Manually'
            ],
            'service' => [
                'page' => [
                    'ListService' => 'Service List',
                    'AddLayanan' => 'Add Service',
                    'EditServie' => 'Edit Service'
                ],
                'AddService' => [
                    'Name' => 'Service Name',
                    'ServiceCode' => 'Service Code',
                    'Description' => 'Description',
                    'AssignStaf' => 'Assign Staff',
                    'EstimatedTime' => 'Estimated Time',
                    'Save' => 'Save',
                ],
            ],

        ];
    }
}
