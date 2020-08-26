<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'Selcuk Karateke',
            'email' => 'selcuk.karateke@live.de',
            'email_verified_at' => now(),
            'password'=>bcrypt('admin'),
        ]);
    }
}
