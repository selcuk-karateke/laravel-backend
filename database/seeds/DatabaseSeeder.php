<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('roles')->truncate();
        DB::table('employees')->truncate();
        DB::table('tasks')->truncate();
        // Seeder
//        $this->call(UserSeeder::class);
//        $this->call(RoleSeeder::class);
//        $this->call(EmployeeSeeder::class);
//        $this->call(TaskSeeder::class);

        // Factory
        factory(App\Role::class, 3)->create();
        factory(App\Task::class, 10)->create();
        factory(App\Employee::class, 10)->create();
//        factory(App\Employee::class, 10)->create()->each(function($employee){
//            $employee->tasks()->save(factor(App\Task::class)->make());
//        });
    }
}
