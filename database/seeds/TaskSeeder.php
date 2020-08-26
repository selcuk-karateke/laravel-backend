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
            'name'=>'',
            'description'=>'',
            'status'=>'',
            'employee_id'=>rand(1,10),
            'project_id'=>rand(1,10),
            'estimated_hours'=>rand(10,100),
            'real_hours'=>rand(50,200),
            'calendar_week'=>rand(0,52),
            'task_end'=>'',
            'real_end'=>'',
            'charged'=>rand(0,1),
        ]);
    }
}
