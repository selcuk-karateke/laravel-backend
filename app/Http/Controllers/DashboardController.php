<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        // Hole die ID des Users
        $id = Auth::id();
        //
        $projects = DB::table('projects')
//            ->where('employee_id', $id)
        ->count();
        //
        $tasks = DB::table('tasks')
//            ->where('employee_id', $id)
        ->count();
        //
        return view('dashboard', compact('projects', 'tasks'));
    }
}
