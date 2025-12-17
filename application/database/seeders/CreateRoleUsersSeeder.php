<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Roleuser;

class CreateRoleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
               'role_id'=>'1',
               'user_id'=>'1',
            ],
        ];

        foreach ($users as $key => $value) {
            $check = Roleuser::where('id', 1)->first();
             if(!$check){
                Roleuser::create($value);
            }
        }
    }
}
