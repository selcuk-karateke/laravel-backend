<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
// Models
use App\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class ProjectsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // If session contains a month
        $month = session()->get('month');
        if (isset($month)) {
            $data = DB::table('projects')
                ->select(
                    'id',
                    'name',
                    'description',
//                    'employee_id',
                    'shortcut',
                    'estimated_hours',
                    'start',
                    'dead',
                    DB::raw('datediff(dead,start) as days'
                    ))
                ->where('name', '<>', 1)
                ->whereMonth('dead', $month)
//                ->whereNull('deleted_at')
                ->orderBy('days', 'asc')
//                ->groupBy('name')
                ->get();
        } else {
//        $data = Project::all();
//        dd($data);
            $data = DB::table('projects')
                ->select(
                    'id',
                    'name',
                    'description',
//                    'employee_id',
                    'shortcut',
                    'estimated_hours',
                    'start',
                    'dead',
                    DB::raw('datediff(dead,start) as days'
                    ))
                ->where('name', '<>', 1)
//                ->whereNull('deleted_at')
                ->orderBy('days', 'asc')
//                ->groupBy('name')
                ->get();
        }
        $employees = DB::table('employees')
            ->select(
                'id',
                'forename',
                'surename',
                'user_id'
            )
            ->get();

        // Get all projects
        $projects = Project::all()->sortBy('dead');
//        $projects = Project::paginate(5);

        // Get all shortcuts to update them
        $shortcuts = array();

        // If Sync Button is clicked
        $sync = session()->get('sync');

        if (isset($sync)) {
            foreach ($projects as $project) {
                // Show all shortcuts
                // $shortcuts[] = $project->shortcut;
                $shortcuts[] = $project->shortcut;
                // Save ID
                $id = $project->id;

                // Get from API
                $json = $this->jiraApi($project->shortcut);

                // Update all Shortcuts
                $project = Project::find($id);

                // If From API
                if($project->from_api == 1){
                    $project->dead = isset($json['fields']['duedate']) ? $json['fields']['duedate'] : null;
//                dd($project->dead);
//                $project->estimated_hours = isset($json['fields']['aggregatetimeoriginalestimate'])? $json['fields']['aggregatetimeoriginalestimate'] : "";
//                $project->actual_hours = isset($json['fields']['timetracking']['timeSpentSeconds'])? $json['fields']['timetracking']['timeSpentSeconds'] : "";
//
//                @todo One To Many
//
//                $project->employees =
//                $project->programmer = isset($json['fields']['assignee']['displayName'])? $json['fields']['assignee']['displayName'] : "";
//                $project->tester = isset($json['fields']['customfield_11008']['displayName'])? $json['fields']['customfield_11008']['displayName']  : "";
//
//                $project->status = isset($json['fields']['status']['name'])? $json['fields']['status']['name'] : "";
//                $project->shortcut_ = isset($json['fields']['project']['key'])? $json['fields']['project']['key'] : "";
                    $project->shortcut = isset($json['key']) ? $json['key'] : "";
                    //            $project->progress = isset($json['fields']['progress']['percent'])? $json['fields']['progress']['percent'] : "";
                    $project->descr_short = isset($json['fields']['issuetype']['descr_short']) ? $json['fields']['issuetype']['descr_short'] : "";
                    $project->description = isset($json['fields']['issuetype']['description']) ? $json['fields']['issuetype']['description'] : "";
                    $project->name = isset($json['fields']['project']['name']) ? $json['fields']['project']['name'] : "";

                    $project->save();
                }
                //            $this->update($json, $id);
            }
        }
        session()->forget('shortcut');
        session()->forget('month');
        session()->forget('sync');
        //
        return view('projects.index', compact('data', 'employees', 'month', 'projects', 'shortcuts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $shortcut = session()->get('shortcut');
        $from_api = session()->get('from_api');

        //
        $json = $this->jiraApi($shortcut);

        // Connect both arrays
//        $data = array_merge($data, $json);
        // Connect both Objects
//        $data = (object) array_merge((array) $data, (array) $json);
        //
        return view('projects.create', compact( 'json', 'from_api'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // If date given
        if(isset($request->inputMonth) && $request->inputMonth != 0 ){
            $month = $request->inputMonth;
            // Redirect to Index with month
            return Redirect::route('projects.index')->with( ['month' => $month] );
        }
        // Fetch Shortcut from API
        elseif(isset($request->inputShortcut)){
            $from_api = $request->from_api;
            $shortcut = $request->inputShortcut;
            // Redirect to Create with shortcut
            return Redirect::route('projects.create')->with( ['shortcut' => $shortcut, 'from_api' => $from_api] );
        }
        // If Sync Button pressed
        elseif(isset($request->syncTable)){
            $sync = $request->syncTable;
            // Redirect to Index
            return Redirect::route('projects.index')->with( ['sync' => $sync] );
        } else {
            //
            $request->validate([
//                'name' => 'required|unique:projects|max:255',
                'name' => 'required|max:255',
                'from_api' => '',
                'description' => 'required',
                'descr_short' => '',
                'shortcut' => 'required|unique:projects',
                'estimated_hours' => 'required',
                'actual_hours' => 'required',
                'start' => 'nullable|date',
                'dead' => 'nullable|date',
            ]);
            // Save Project with Employees
            $project = new Project([
                'name' => $request->name,
                'from_api' => $request->from_api,
                'description' => $request->description,
//                'descr_short' => $request->descr_short, // new
//                'employee_id' => 1,
//                'programmer' => $request->programmer, // new
                'shortcut' => $request->shortcut,
                'progress' => '',
                'estimated_hours' => $request->estimated_hours,
                'actual_hours' => $request->actual_hours,
                'start' => $request->start,
                'dead' => $request->dead,
            ]);
            $project->save();

            // Check if Employees already exists
            $employees = Employee::all();
            foreach ($employees as $employee){
                if($employee->from_api == $request->programmer){
                    $programmer = $employee;
                } else {
                    // Insert and add role to programmer
                    $programmer = new Employee([
                        'from_api' => $request->programmer, //new
                        'forename' => '',
                        'surename' => '',
                        'user_id' => null,
                    ]);
//                    $programmer->roles('');
                }
                if ($employee->from_api == $request->tester) {
                    $tester = $employee;
                } else {
                    // Insert and add role to tester
                    $tester = new Employee([
                        'from_api' => $request->tester, //new
                        'forename' => '',
                        'surename' => '',
                        'user_id' => null,
                    ]);
                }
            }
            //
            $project->employees()->save($programmer);
            $project->employees()->save($tester);

            //
            return redirect('/projects');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
        $data = Project::find($id);

        // Array aufbauen mit allen zugehörigen Tasks und übergeben
        $tasks = DB::table('tasks')
            ->select(
                'id',
                'name',
                'description',
                'status',
//                'employee_id',
                'project_id',
                'estimated_hours',
                'real_hours',
                'calendar_week',
                'task_end',
                'real_end',
                'charged'
            )
            ->where('project_id', '=', $id)
//            ->whereNull('deleted_at')
            ->orderBy('calendar_week', 'asc')
//            ->groupBy('name')
            ->get();

        return view('projects.show', compact('data', 'tasks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * @param Request $request
     * @param  int  $id
     * @return Response
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
     * @return Response
     */
    public function destroy($id)
    {
        //
        $data = Project::find($id);
        $data->delete();

        return redirect('/projects');
    }
    /**
     * Get Tasks from Jira
     *
     * @param string $shortcut
     * @return array
     */
    public function jiraApi($shortcut){
        // Create Base64 Key
//        echo $base = env('JIRA_USER').":".env('JIRA_PASS');
//        dd(base64_encode($base));
        //
        $url = env('JIRA_URL');
        $url = isset($shortcut) ? $url . $shortcut : $url . 'HKD-100';

        $response = Http::withHeaders([
            "Content-Type" => env('JIRA_CONTENT_TYPE'),
            "Authorization" => env('JIRA_AUTHORIZATION')
        ])->get($url);

        $json = $response->json();
        // Find the mistake :)
//        $json = json_encode($response->json());
//        $json = json_decode($json, true)
//        $json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
        return $json;
    }
    /**
     * Get All Projects from DB
     *
     * @return array
     */
    public function getProjects(){
        $projects = Project::all()->sortBy('dead');
        return $projects;
    }
}
