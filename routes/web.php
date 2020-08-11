<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', function () {
    $data = array(
        'projects'=>array(
            'p1'=>array(
                'name' => 'OnlineShop',
                'manager'=>'Test Tester',
                'shortcut'=>'OSY1',
                'details'=>array(
                    'start'=>"09.12.2010",
                    'dead'=>"31.12.2025",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p2'=>array(
                'name' => 'SEO Project',
                'manager'=>'Bernd Tester',
                'shortcut'=>'SPZ1',
                'details'=>array(
                    'start'=>"10.08.2020",
                    'dead'=>"31.12.2022",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p3'=>array(
                'name' => 'OnlineShop',
                'manager'=>'Jürgen Tester',
                'shortcut'=>'OSZ1',
                'details'=>array(
                    'start'=>"02.08.2020",
                    'dead'=>"04.08.2020",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p4'=>array(
                'name' => 'Portfolio',
                'manager'=>'Berna Tester',
                'shortcut'=>'PXZ2',
                'details'=>array(
                    'start'=>"12.12.2020",
                    'dead'=>"31.12.2020",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p5'=>array(
                'name' => 'Web Application',
                'manager'=>'Jürgen Tester',
                'shortcut'=>'WAZ1',
                'details'=>array(
                    'start'=>"10.08.2020",
                    'dead'=>"15.08.2020",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p6'=>array(
                'name' => 'Webdesign',
                'manager'=>'',
                'shortcut'=>'WDZ2',
                'details'=>array(
                    'start'=>"12.08.2020",
                    'dead'=>"31.12.2020",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            )
        )
    );

    $date = Carbon::now();

    return view('dashboard', compact('data','date'));
});

Route::get('/schedule', function () {
    $data = array(
        'projects'=>array(
            'p1'=>array(
                'name' => 'OnlineShop',
                'manager'=>'Test Tester',
                'shortcut'=>'OSY1',
                'details'=>array(
                    'start'=>"09.12.2010",
                    'dead'=>"31.12.2025",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p2'=>array(
                'name' => 'SEO Project',
                'manager'=>'Bernd Tester',
                'shortcut'=>'SPZ1',
                'details'=>array(
                    'start'=>"10.08.2020",
                    'dead'=>"31.12.2022",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p3'=>array(
                'name' => 'OnlineShop',
                'manager'=>'Jürgen Tester',
                'shortcut'=>'OSZ1',
                'details'=>array(
                    'start'=>"02.08.2020",
                    'dead'=>"04.08.2020",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p4'=>array(
                'name' => 'Portfolio',
                'manager'=>'Berna Tester',
                'shortcut'=>'PXZ2',
                'details'=>array(
                    'start'=>"12.12.2020",
                    'dead'=>"31.12.2020",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p5'=>array(
                'name' => 'Web Application',
                'manager'=>'Jürgen Tester',
                'shortcut'=>'WAZ1',
                'details'=>array(
                    'start'=>"10.08.2020",
                    'dead'=>"15.08.2020",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            ),
            'p6'=>array(
                'name' => 'Webdesign',
                'manager'=>'',
                'shortcut'=>'WDZ2',
                'details'=>array(
                    'start'=>"12.08.2020",
                    'dead'=>"31.12.2020",
                    'mail'=>"customer@zentralweb.de",
                    'link'=>'www.test.de'
                )
            )
        )
    );
    $date = Carbon::now();

    return view('schedule.index', compact('data','date'));
});

Route::get('/dbtest', 'TestController@dbTest');
