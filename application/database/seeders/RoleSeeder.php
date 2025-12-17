<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $terms = [
            [
               'name'=>'Super Admin',
               'code'=>'super_admin',
               'type' => 'Global'
            ],
            [
               'name'=>'User',
               'code'=>'user',
               'type' => 'General'
            ],
        ];

        foreach ($terms as $key => $value) {
            $check = Role::where('code', $value['code'])->first();
            if(!$check){
                Role::create($value);
            }
        }
    }
}
