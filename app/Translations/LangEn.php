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
                'ListUser' => 'List User'
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
