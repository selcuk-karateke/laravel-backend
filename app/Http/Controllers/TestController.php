<?php

namespace App\Http\Controllers;

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

}
