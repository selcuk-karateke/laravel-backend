<?php

use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('employees')->insert([
            'forename'=>'',
            'surename'=>'',
//            'password'=>bcrypt('secret'),
//            'email'=>str_random(10).'@example.com',
            'role_id'=>'',
        ]);
    }
}
