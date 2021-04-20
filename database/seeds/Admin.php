<?php

use DB;
use Illuminate\Database\Seeder;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(['name' => 'Administrator', 'password' => bcrypt('admin'), 'role' => 'Admin', 'email' => 'admin@gmail.com']);
    }
}
