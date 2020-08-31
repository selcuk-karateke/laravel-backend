<?php

use Illuminate\Database\Seeder;

class EmployeeProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('employee_project')->insert(['employee_id' => '1','project_id' => '1',]);
        DB::table('employee_project')->insert(['employee_id' => '1','project_id' => '2',]);
        DB::table('employee_project')->insert(['employee_id' => '1','project_id' => '3',]);
        DB::table('employee_project')->insert(['employee_id' => '1','project_id' => '4',]);
    }
}
