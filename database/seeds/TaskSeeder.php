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
//        $id = DB::getPDO()->lastInsertId();
        //
        DB::table('tasks')->insert([
//            'id'=>$id,
            'name'=>'',
            'shortcut'=>str_random(10),
            'calendar_week'=>rand(0,52),
            'employee_id'=>rand(1,6),
            'estimated_hours'=>rand(10,100),
            'workonday'=>'',
            'dead'=>date('Y-m-d H:i:s'),
            'created_at'=>'',
            'updated_at'=>''
        ]);
    }
}
