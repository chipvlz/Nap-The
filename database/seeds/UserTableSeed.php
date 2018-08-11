<?php

use Illuminate\Database\Seeder;

class UserTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'kienkienutc95@gmail.com',
            'phone' => '0964953029',
            'password' => bcrypt('admin@123'),
        ]);
    }
}
