<?php

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
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
            'name'=>'Project XY',
            'description'=>'...',
            'employee_id'=>rand(1,10),
            'shortcut'=>str_random(rand(4,6)),
            'estimated_hours'=>rand(10,100),
            'start'=>date('Y-m-d H:i:s'),
            'dead'=>date('Y-m-d H:i:s'),
        ]);
    }
}
