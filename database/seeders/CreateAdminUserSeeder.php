<?php
namespace Database\Seeders;
use Carbon\Carbon;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{

         $user = User::create([
        'name' => 'admin',
        'email' => 'admin@admin.com',
        'phone' => '1122002942',
        'password' => bcrypt('12345678'),
        'roles_name' => ["مدير"],
        'entity_id'=>1
        ]);

        $role = Role::create(['name' => 'مدير']);
        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);


}
}
