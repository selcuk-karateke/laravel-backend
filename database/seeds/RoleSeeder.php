<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
        DB::table('roles')->insert([
//            'id'=>$id,
            'name'=>''
        ]);
    }
}
