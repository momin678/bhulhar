<?php

use App\Module;
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Dashboard
        $moduleAppDashboard = Module::updateOrCreate(['name' => 'Admin Dashboard']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppDashboard->id,
            'name' => 'Access Dashboard',
            'slug' => 'app.dashboard',
        ]);

        // Role management
        $moduleAppRole = Module::updateOrCreate(['name' => 'Role Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppRole->id,
            'name' => 'Access Roles',
            'slug' => 'app.roles.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppRole->id,
            'name' => 'Create Role',
            'slug' => 'app.roles.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppRole->id,
            'name' => 'Edit Role',
            'slug' => 'app.roles.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppRole->id,
            'name' => 'Delete Role',
            'slug' => 'app.roles.destroy',
        ]);

        // User management
        $moduleAppUser = Module::updateOrCreate(['name' => 'User Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppUser->id,
            'name' => 'Access Users',
            'slug' => 'app.users.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppUser->id,
            'name' => 'Create User',
            'slug' => 'app.users.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppUser->id,
            'name' => 'Edit User',
            'slug' => 'app.users.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppUser->id,
            'name' => 'Delete User',
            'slug' => 'app.users.destroy',
        ]);

        // User management
        $moduleAppProfile = Module::updateOrCreate(['name' => 'Profile']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProfile->id,
            'name' => 'Access Profile',
            'slug' => 'app.profile.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProfile->id,
            'name' => 'Create Profile',
            'slug' => 'app.profile.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProfile->id,
            'name' => 'Edit Profile',
            'slug' => 'app.profile.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppProfile->id,
            'name' => 'Delete Profile',
            'slug' => 'app.profile.destroy',
        ]);

        // User management
        $moduleAppAttendence = Module::updateOrCreate(['name' => 'Attendance Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Access Attendance',
            'slug' => 'app.attendance.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Create Attendance',
            'slug' => 'app.attendance.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Edit Attendance',
            'slug' => 'app.attendance.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Delete Attendance',
            'slug' => 'app.attendance.destroy',
        ]);

        // Admission
        $moduleAppAttendence = Module::updateOrCreate(['name' => 'Admission']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Access Admission',
            'slug' => 'app.admission.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Create admission',
            'slug' => 'app.admission.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Edit admission',
            'slug' => 'app.admission.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Delete admission',
            'slug' => 'app.admission.destroy',
        ]);

        // Class Profile
        $moduleAppAttendence = Module::updateOrCreate(['name' => 'Class Profile']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Access Class Profile',
            'slug' => 'app.classprofile.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Create Class Profile',
            'slug' => 'app.classprofile.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Edit Class Profile',
            'slug' => 'app.classprofile.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Delete Class Profile',
            'slug' => 'app.classprofile.destroy',
        ]);


        // Calender
        $moduleAppAttendence = Module::updateOrCreate(['name' => 'Calender']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Access Calendar',
            'slug' => 'app.calendar.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Create Calendar',
            'slug' => 'app.calendar.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Edit Calendar',
            'slug' => 'app.calendar.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Delete Calendar',
            'slug' => 'app.calendar.destroy',
        ]);

        // Calender
        $moduleAppAttendence = Module::updateOrCreate(['name' => 'Library']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Access Library',
            'slug' => 'app.library.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Create Library',
            'slug' => 'app.library.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Edit Library',
            'slug' => 'app.library.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Delete Library',
            'slug' => 'app.library.destroy',
        ]);

        // Fees and Collection
        $moduleAppAttendence = Module::updateOrCreate(['name' => 'Fees & Collection']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Access Collection',
            'slug' => 'app.collection.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Create Collection',
            'slug' => 'app.collection.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Edit Collection',
            'slug' => 'app.collection.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Delete Collection',
            'slug' => 'app.collection.destroy',
        ]);

        // hrm
        $moduleAppAttendence = Module::updateOrCreate(['name' => 'HR Management']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Access HRM',
            'slug' => 'app.hrm.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Create HRM',
            'slug' => 'app.hrm.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Edit HRM',
            'slug' => 'app.hrm.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Delete HRM',
            'slug' => 'app.hrm.destroy',
        ]);

        // hrm
        $moduleAppAttendence = Module::updateOrCreate(['name' => 'Access Control']);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Access User Control',
            'slug' => 'app.usercontrol.index',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Create User Control',
            'slug' => 'app.usercontrol.create',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Edit User Control',
            'slug' => 'app.usercontrol.edit',
        ]);
        Permission::updateOrCreate([
            'module_id' => $moduleAppAttendence->id,
            'name' => 'Delete User Control',
            'slug' => 'app.usercontrol.destroy',
        ]);

    }
}
