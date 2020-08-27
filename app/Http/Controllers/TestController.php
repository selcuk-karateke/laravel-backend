<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use DB;
use App\Http\Controllers\Controller;

class TestController
{
    public function dbTest()
    {
        $results = DB::select('select * from results');

        return view('results', ['results'=>$results]);

        var_dump($results);


    }

    public function paginate(){
        $projects = Project::paginate(5);
        return view('results', compact('projects'));
//        return view('results', ['projects'=>$projects]);
    }

}
