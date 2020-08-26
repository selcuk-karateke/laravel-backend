<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('from_api');
            $table->text('description')->nullable();
            $table->text('descr_short')->nullable();
//            $table->string('manager');
//            $table->string('programmer');
//            $table->string('tester');
            $table->char('shortcut', 9);
            $table->integer('estimated_hours')->nullable(); // Geschätzte Stunden
            $table->integer('actual_hours')->nullable(); // Tatsächliche Stunden
            $table->date('start');
            $table->date('dead')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
