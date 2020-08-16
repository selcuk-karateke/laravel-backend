<?php

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('tasks')->insert([
            'employee_id'=>rand(1,10),
            'project_id'=>rand(1,10),
            'calendar_week'=>rand(0,52),
            'workonday'=>'',
        ]);
    }
}
