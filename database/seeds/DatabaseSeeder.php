<?php

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
        // $this->call(UsersTableSeeder::class);
        DB::table( 'users' )->insert( [
            'name'      => 'Linxb',
            'email'     => '448923515@qq.com',
            'password'  => bcrypt( '123456' ),
            'api_token' => str_random( 60 ),
        ] );
    }
}
