<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        //Role
        $this->call(RoleSeeder::class);
        //User Create
        $this->call(CreateUsersSeeder::class);
        //Role User Create
        $this->call(CreateRoleUsersSeeder::class);
         //Term
        $this->call(TermsSeeder::class);
        //Term Taxonomy
        $this->call(TermTaxonomySeeder::class);
    }
}
