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
            'forename'=>'Selcuk',
            'surename'=>'Karateke',
//            'role_id'=>1,
        ]);
    }
}
