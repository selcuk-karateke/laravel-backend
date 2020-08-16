<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
// Models
use App\Project;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

//        $data = Project::all();
//        dd($data);
        $data = DB::table('projects')
            ->select(
                'id',
                'name',
                'description',
                'employee_id',
                'shortcut',
                'estimated_hours',
                'start',
                'dead',
                DB::raw('datediff(dead,start) as days'
                ))
//            ->where('name', '<>', 1)
            ->orderBy('days', 'asc')
//            ->groupBy('name')
            ->get();

        return view('projects.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:posts|max:255',
            'description' => 'required',
            'shortcut' => 'required',
            'estimated_hours' => 'required',
            'start' => 'nullable|date',
            'dead' => 'nullable|date',
        ]);
        //
        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'employee_id' => 1,
            'shortcut' => $request->shortcut,
            'estimated_hours' => $request->estimated_hours,
            'start' => $request->start,
            'dead' => $request->dead,
        ]);
        return redirect('/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Project::find($id);

        return view('projects.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = Project::find($id);

        return view('projects.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = Project::find($id);
        $data->update($request->all());

        return redirect('/projects/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
