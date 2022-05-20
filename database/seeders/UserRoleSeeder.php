<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User();
        $user->name = 'Demo Admin';
        $user->email = 'zohaibazhar359@gmail.com';
        $user->password = md5('1234567');
        $user->save();
        //creating Role
        $super_admin = Role::create([ 'name' => 'super_admin']);
        $manager = Role::create([ 'name' => 'manager']);
        $guard = Role::create([ 'name' => 'guard']);
        $client = Role::create([ 'name' => 'client']);
        $user->assignRole($super_admin);
    }
}
