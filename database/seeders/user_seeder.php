<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class user_seeder extends Seeder
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
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt("ersalomo"),
                'username' => 'admin2002',
                'picture' => 'null',
                'biography' => 'null',
                'type' => 1,
                'blocked' => 0,
                'direct_publish' => 1
            ], [
                'name' => 'Admin',
                'email' => 'admin_a@gmail.com',
                'password' => Hash::make("ersalomo"),
                'username' => 'admin2000',
                'picture' => 'null',
                'biography' => 'null',
                'type' => 1,
                'blocked' => 0,
                'direct_publish' => 1
            ], [
                'name' => 'ersalomo',
                'email' => 'larablogdevelop@gmail.com',
                'password' => Hash::make("ersalomo"),
                'username' => 'Larablog',
                'picture' => 'null',
                'biography' => 'null',
                'type' => 1,
                'blocked' => 0,
                'direct_publish' => 1
            ], [
                'name' => 'Ersalomoo455',
                'email' => 'ersalomo45@gmail.com',
                'password' => Hash::make("ersalomo"),
                'username' => 'Ersalomoo455',
                'picture' => 'null',
                'biography' => 'null',
                'type' => 1,
                'blocked' => 0,
                'direct_publish' => 1

            ], [
                'name' => 'ersalomo',
                'email' => 'larablogdev@gmail.com',
                'password' => Hash::make("ersalomo"),
                'username' => 'Larablog',
                'picture' => 'null',
                'biography' => 'null',
                'type' => 1,
                'blocked' => 0,
                'direct_publish' => 1
            ]
        ];
        DB::table('users')->insert($users);
    }
}
