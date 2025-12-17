<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class CreateUsersSeeder extends Seeder
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
               'name'=>'Noushad Nipun',
               'email'=>'admin@system.com',
               'password'=>bcrypt('23568923'),
            ],
        ];

        foreach ($users as $key => $value) {
        $check = User::where('email', $value['email'])->first();
            if(!$check){
                User::create($value);
            }
        }
    }
}
