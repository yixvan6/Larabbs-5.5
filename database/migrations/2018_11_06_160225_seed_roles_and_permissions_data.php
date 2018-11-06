<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'manage_contents']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'edit_settings']);

        $founder = Role::create(['name' => 'Founder']);
        $founder->givePermissionTo(['manage_contents', 'manage_users', 'edit_settings']);

        $maintainer = Role::create(['name' => 'Maintainer']);
        $maintainer->givePermissionTo('manage_contents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        app()['cache']->forget('spatie.permission.cache');

        $table = config('permission.table_names');

        Model::unguard();
        DB::table($table['role_has_permissions'])->delete();
        DB::table($table['model_has_roles'])->delete();
        DB::table($table['model_has_permissions'])->delete();
        DB::table($table['roles'])->delete();
        DB::table($table['permissions'])->delete();
        Model::reguard();
    }
}
