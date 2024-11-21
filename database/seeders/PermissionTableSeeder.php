<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{


$permissions = [

        'إدارة الارشيف',
        'الصلاحيات',
        'إدارة المسؤولين',
        'الجهات',

];



foreach ($permissions as $permission) {

Permission::create(['name' => $permission]);
}


}
}
