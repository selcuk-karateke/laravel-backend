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
//        $id = DB::getPDO()->lastInsertId();
        //
        DB::table('employees')->insert([
//            'id'=>$id,
            'forename'=>'',
            'surename'=>'',
//            'password'=>bcrypt('secret'),
//            'email'=>str_random(10).'@example.com',
            'role_id'=>'',
            'created_at'=>'',
            'updated_at'=>''
        ]);
    }
}
