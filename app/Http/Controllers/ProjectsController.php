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
        $this->middleware('auth');
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
                    'employee_id',
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

                // IF Fehlt
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
        } elseif(isset($request->inputShortcut)){
            $from_api = $request->from_api;
            $shortcut = $request->inputShortcut;
            // Redirect to Index with shortcut
            return Redirect::route('projects.create')->with( ['shortcut' => $shortcut, 'from_api' => $from_api] );
        }  elseif(isset($request->syncTable)){
            $sync = $request->syncTable;
            // Redirect to Index with shortcut
            return Redirect::route('projects.index')->with( ['sync' => $sync] );
        } else {
            //
            $request->validate([
//                'name' => 'required|unique:projects|max:255',
                'name' => 'required|max:255',
                'from_api' => '',
                'description' => 'required',
                'descr_short' => '',
                'shortcut' => 'required',
                'estimated_hours' => 'required',
                'actual_hours' => 'required',
                'start' => 'nullable|date',
                'dead' => 'nullable|date',
            ]);
            //
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
//            dd($request);
            $project->save();
//            $project = Project::find($project->id);

            // Testing
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
                }
            }
//            dd($programmer);
            foreach ($employees as $employee) {
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
                'employee_id',
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
//
        if (isset($shortcut)) {
            $url = 'https://zentralweb.atlassian.net/rest/agile/1.0/issue/' . $shortcut;
        } else {
            $url = 'https://zentralweb.atlassian.net/rest/agile/1.0/issue/HKD-100';
        }

        $response = Http::withHeaders([
            "Content-Type" => "application/json",
            "Authorization" => "Basic Y29kZUB6ZW50cmFsd2ViLmRlOm1qaFVrRjlTNmRjdnhpRGxveGhCRkMwMQ=="
        ])
            ->get($url);
        $json = json_encode($response->json());
//            $json = '{"expand":"renderedFields,names,schema,operations,editmeta,changelog,versionedRepresentations","id":"25362","self":"https://zentralweb.atlassian.net/rest/agile/1.0/issue/25362","key":"HKDSHOP-41","fields":{"statuscategorychangedate":"2020-04-29T16:22:47.136+0200","issuetype":{"self":"https://zentralweb.atlassian.net/rest/api/2/issuetype/10003","id":"10003","description":"Ein kleines Stück Arbeit, das Teil einer größeren Task ist.","iconUrl":"https://zentralweb.atlassian.net/secure/viewavatar?size=medium&avatarId=10316&avatarType=issuetype","name":"Sub-Task","subtask":true,"avatarId":10316},"parent":{"id":"25364","key":"HKDSHOP-47","self":"https://zentralweb.atlassian.net/rest/api/2/issue/25364","fields":{"summary":"ERIKA Installation","status":{"self":"https://zentralweb.atlassian.net/rest/api/2/status/10100","description":"","iconUrl":"https://zentralweb.atlassian.net/","name":"Backlog","id":"10100","statusCategory":{"self":"https://zentralweb.atlassian.net/rest/api/2/statuscategory/2","id":2,"key":"new","colorName":"blue-gray","name":"Aufgaben"}},"priority":{"self":"https://zentralweb.atlassian.net/rest/api/2/priority/3","iconUrl":"https://zentralweb.atlassian.net/images/icons/priorities/medium.svg","name":"Medium","id":"3"},"issuetype":{"self":"https://zentralweb.atlassian.net/rest/api/2/issuetype/10001","id":"10001","description":"Eine Funktionalität oder Funktion, ausgedrückt als Benutzerziel.","iconUrl":"https://zentralweb.atlassian.net/images/icons/issuetypes/story.svg","name":"Story","subtask":false}}},"timespent":43200,"sprint":null,"project":{"self":"https://zentralweb.atlassian.net/rest/api/2/project/13147","id":"13147","key":"HKDSHOP","name":"Krömer Shop M2","projectTypeKey":"software","simplified":false,"avatarUrls":{"48x48":"https://zentralweb.atlassian.net/secure/projectavatar?pid=13147&avatarId=11049","24x24":"https://zentralweb.atlassian.net/secure/projectavatar?size=small&s=small&pid=13147&avatarId=11049","16x16":"https://zentralweb.atlassian.net/secure/projectavatar?size=xsmall&s=xsmall&pid=13147&avatarId=11049","32x32":"https://zentralweb.atlassian.net/secure/projectavatar?size=medium&s=medium&pid=13147&avatarId=11049"}},"customfield_11001":null,"fixVersions":[],"aggregatetimespent":43200,"customfield_11002":"2020-05-07","resolution":null,"customfield_11003":null,"customfield_11004":[],"customfield_11005":null,"customfield_10500":null,"customfield_10700":null,"customfield_10900":null,"resolutiondate":null,"workratio":100,"watches":{"self":"https://zentralweb.atlassian.net/rest/api/2/issue/HKDSHOP-41/watchers","watchCount":3,"isWatching":true},"lastViewed":"2020-05-01T19:33:59.390+0200","created":"2019-12-09T16:58:35.741+0100","epic":null,"priority":{"self":"https://zentralweb.atlassian.net/rest/api/2/priority/3","iconUrl":"https://zentralweb.atlassian.net/images/icons/priorities/medium.svg","name":"Medium","id":"3"},"customfield_10100":null,"customfield_10300":{"hasEpicLinkFieldDependency":false,"showField":false,"nonEditableReason":{"reason":"PLUGIN_LICENSE_ERROR","message":"The Parent Link is only available to Jira Premium users."}},"labels":["magento2"],"customfield_10016":null,"customfield_10017":null,"timeestimate":0,"aggregatetimeoriginalestimate":43200,"versions":[],"issuelinks":[],"assignee":null,"updated":"2020-05-01T19:34:16.362+0200","status":{"self":"https://zentralweb.atlassian.net/rest/api/2/status/10500","description":"Dieser Status wird intern von JIRA Software verwaltet","iconUrl":"https://zentralweb.atlassian.net/","name":"QA","id":"10500","statusCategory":{"self":"https://zentralweb.atlassian.net/rest/api/2/statuscategory/4","id":4,"key":"indeterminate","colorName":"yellow","name":"In Arbeit"}},"components":[],"timeoriginalestimate":43200,"description":"_Einrichtung und Design des einseitigen Bestellprozesses mit der Integration von Versandarten und Bezahlarten._\n\nFor all HKDSHOP tasks a detailed dokumentation about the technical realisation is needed. Also [~accountid:557058:e33f889f-36f5-476b-a1a7-f21bb2c74915] has to be informed about the technical realisation before work starts\\!\n\nGeneral working rules:\n\n* Translation has to be possible without changing the code\\!\n* All data to products etc are dynamic, there is no such thing as static data\\!\n* Mobile as also as desktop version have to work after Google guide lines. If you don’t know, look it up\\!\n* Work on a task must not infect the rest of the project\\!\n* Obscurities about a task and/or functions have to be removed before the work starts also a estimation for the time needed for this task has to be given before the work starts\\!\n* No overwriting of the Core\\!\n* Time has to be tracked at the end of each day worked on a task\\!\n* At the end of a task the following documents have to be attached: Use in backend and impact on frontend, detailed code description, which modules in magento where used, where to find them and which configurations are made\\!\n\nTask description:\n\nPlease connetct the new erika version to magento2 (erika should be remoerk2.redfeshion). Make sure that orders from magento2 shop are inherited correctly to erika. Take also care of the different shops from different countrys and test if there specifications like different prices and VAT`s are inherited correctly. Also inherite the standard payment options and Heidel Pay module. \n\ngeneral procedere for this task:\n\n* connecting erika and magento2 with the help of [~accountid:557058:660975c1-9644-4563-bcce-6b0b638207ef] \n\n* konfiguration of payment with the help of [~accountid:557058:23ab615d-ca96-40a8-a693-81903c26b080] \n* set up evething needed to allow shop orders (shipping cost, discount prices etc can be neglegted)\n* copy to stage with demo settings\n\nFor info about erika version for this project please contact [~accountid:557058:660975c1-9644-4563-bcce-6b0b638207ef] and comment access data and link here and in the documentation.\n\nFor info about payment options and Heidel pay please contact [~accountid:557058:23ab615d-ca96-40a8-a693-81903c26b080] \n\nPlease allways keep in mind to progamm in dev and how to copy to live systems\\!\n\n","customfield_10210":null,"customfield_10211":null,"customfield_10015":"0|i00fub:","timetracking":{"originalEstimate":"12h","remainingEstimate":"0h","timeSpent":"12h","originalEstimateSeconds":43200,"remainingEstimateSeconds":0,"timeSpentSeconds":43200},"customfield_10203":null,"customfield_10204":null,"customfield_10600":null,"customfield_10205":null,"security":null,"customfield_10206":null,"customfield_10800":null,"attachment":[{"self":"https://zentralweb.atlassian.net/rest/api/2/attachment/20336","id":"20336","filename":"DOCUMENTATION HKDSHOP-41.docx","author":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"created":"2020-04-29T15:45:31.214+0200","size":2269676,"mimeType":"application/vnd.openxmlformats-officedocument.wordprocessingml.document","content":"https://zentralweb.atlassian.net/secure/attachment/20336/DOCUMENTATION+HKDSHOP-41.docx"}],"customfield_10207":null,"customfield_10801":null,"aggregatetimeestimate":0,"flagged":false,"customfield_10208":null,"customfield_10802":null,"customfield_10803":"2020-05-05","customfield_10209":null,"summary":"connecting ERIKA to Magento2","creator":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=557058%3Ae33f889f-36f5-476b-a1a7-f21bb2c74915","accountId":"557058:e33f889f-36f5-476b-a1a7-f21bb2c74915","emailAddress":"code@zentralweb.de","avatarUrls":{"48x48":"https://secure.gravatar.com/avatar/0f5e53072f0d81e8752af4d24ebff958?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FIG-4.png&size=48&s=48","24x24":"https://secure.gravatar.com/avatar/0f5e53072f0d81e8752af4d24ebff958?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FIG-4.png&size=24&s=24","16x16":"https://secure.gravatar.com/avatar/0f5e53072f0d81e8752af4d24ebff958?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FIG-4.png&size=16&s=16","32x32":"https://secure.gravatar.com/avatar/0f5e53072f0d81e8752af4d24ebff958?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FIG-4.png&size=32&s=32"},"displayName":"Ivan Gartsev","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"subtasks":[],"customfield_11010":"2020-04-06","reporter":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=557058%3Ae33f889f-36f5-476b-a1a7-f21bb2c74915","accountId":"557058:e33f889f-36f5-476b-a1a7-f21bb2c74915","emailAddress":"code@zentralweb.de","avatarUrls":{"48x48":"https://secure.gravatar.com/avatar/0f5e53072f0d81e8752af4d24ebff958?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FIG-4.png&size=48&s=48","24x24":"https://secure.gravatar.com/avatar/0f5e53072f0d81e8752af4d24ebff958?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FIG-4.png&size=24&s=24","16x16":"https://secure.gravatar.com/avatar/0f5e53072f0d81e8752af4d24ebff958?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FIG-4.png&size=16&s=16","32x32":"https://secure.gravatar.com/avatar/0f5e53072f0d81e8752af4d24ebff958?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FIG-4.png&size=32&s=32"},"displayName":"Ivan Gartsev","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"aggregateprogress":{"progress":43200,"total":43200,"percent":100},"customfield_10000":"2020-04-28T22:54:42.776+0200","customfield_10001":null,"customfield_10200":null,"customfield_10201":null,"customfield_10400":"{pullrequest={dataType=pullrequest, state=OPEN, stateCount=2}, json={\"cachedValue\":{\"errors\":[],\"summary\":{\"pullrequest\":{\"overall\":{\"count\":2,\"lastUpdated\":\"2020-04-29T17:35:20.234+0200\",\"stateCount\":2,\"state\":\"OPEN\",\"dataType\":\"pullrequest\",\"open\":true},\"byInstanceType\":{\"bitbucket\":{\"count\":2,\"name\":\"Bitbucket Cloud\"}}}}},\"isStale\":true}}","customfield_10202":null,"customfield_11006":null,"environment":null,"customfield_11008":null,"customfield_11009":null,"duedate":"2020-04-30","progress":{"progress":43200,"total":43200,"percent":100},"comment":{"comments":[{"self":"https://zentralweb.atlassian.net/rest/api/2/issue/25362/comment/18724","id":"18724","author":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=557058%3A23ab615d-ca96-40a8-a693-81903c26b080","accountId":"557058:23ab615d-ca96-40a8-a693-81903c26b080","avatarUrls":{"48x48":"https://secure.gravatar.com/avatar/d67c35f929350e732a55bed136f73f15?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FAS-5.png&size=48&s=48","24x24":"https://secure.gravatar.com/avatar/d67c35f929350e732a55bed136f73f15?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FAS-5.png&size=24&s=24","16x16":"https://secure.gravatar.com/avatar/d67c35f929350e732a55bed136f73f15?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FAS-5.png&size=16&s=16","32x32":"https://secure.gravatar.com/avatar/d67c35f929350e732a55bed136f73f15?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FAS-5.png&size=32&s=32"},"displayName":"Andrei Svirski","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"body":"Пиши пожалуйста что ты иммено сделал, просто время тракать та к не пойдёт. \nMerci ","updateAuthor":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=557058%3A23ab615d-ca96-40a8-a693-81903c26b080","accountId":"557058:23ab615d-ca96-40a8-a693-81903c26b080","avatarUrls":{"48x48":"https://secure.gravatar.com/avatar/d67c35f929350e732a55bed136f73f15?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FAS-5.png&size=48&s=48","24x24":"https://secure.gravatar.com/avatar/d67c35f929350e732a55bed136f73f15?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FAS-5.png&size=24&s=24","16x16":"https://secure.gravatar.com/avatar/d67c35f929350e732a55bed136f73f15?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FAS-5.png&size=16&s=16","32x32":"https://secure.gravatar.com/avatar/d67c35f929350e732a55bed136f73f15?d=https%3A%2F%2Favatar-management--avatars.us-west-2.prod.public.atl-paas.net%2Finitials%2FAS-5.png&size=32&s=32"},"displayName":"Andrei Svirski","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"created":"2020-04-28T22:54:42.776+0200","updated":"2020-04-28T22:54:42.776+0200","jsdPublic":true},{"self":"https://zentralweb.atlassian.net/rest/api/2/issue/25362/comment/18726","id":"18726","author":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"body":"Не сразу заметил коммент, ок, понял.","updateAuthor":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"created":"2020-04-29T15:45:38.720+0200","updated":"2020-04-29T15:45:38.720+0200","jsdPublic":true},{"self":"https://zentralweb.atlassian.net/rest/api/2/issue/25362/comment/18727","id":"18727","author":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"body":"Первые 4 часа - установка хайдль модуля, поиск и справления ошибки о которой я сообщал в групповом чате + устоановка модуля Zentralweb\nВторые 4 часа - переписывание модуля Zentralweb под текущие задачи, добавление обсерверов на продукт и категори.\nТретьи 4 часа - настройка связи ерика → магенто, переписывание модулей в ерики, создание репозитория под новый нетворк.","updateAuthor":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"created":"2020-04-29T15:48:43.691+0200","updated":"2020-04-29T15:48:43.691+0200","jsdPublic":true}],"maxResults":3,"total":3,"startAt":0},"votes":{"self":"https://zentralweb.atlassian.net/rest/api/2/issue/HKDSHOP-41/votes","votes":0,"hasVoted":false},"worklog":{"startAt":0,"maxResults":20,"total":3,"worklogs":[{"self":"https://zentralweb.atlassian.net/rest/api/2/issue/25362/worklog/22900","author":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"updateAuthor":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"created":"2020-04-24T16:17:38.800+0200","updated":"2020-04-24T16:17:38.800+0200","started":"2020-04-24T12:17:36.732+0200","timeSpent":"4h","timeSpentSeconds":14400,"id":"22900","issueId":"25362"},{"self":"https://zentralweb.atlassian.net/rest/api/2/issue/25362/worklog/22910","author":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"updateAuthor":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"created":"2020-04-28T17:21:15.417+0200","updated":"2020-04-28T17:21:15.417+0200","started":"2020-04-28T13:21:10.777+0200","timeSpent":"4h","timeSpentSeconds":14400,"id":"22910","issueId":"25362"},{"self":"https://zentralweb.atlassian.net/rest/api/2/issue/25362/worklog/22916","author":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"updateAuthor":{"self":"https://zentralweb.atlassian.net/rest/api/2/user?accountId=5b586e3bd2a2f82da138e269","accountId":"5b586e3bd2a2f82da138e269","avatarUrls":{"48x48":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=48&s=48","24x24":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=24&s=24","16x16":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=16&s=16","32x32":"https://avatar-management--avatars.us-west-2.prod.public.atl-paas.net/5b586e3bd2a2f82da138e269/a0738bd3-fef9-4beb-a2cf-23c6fd385485/128?size=32&s=32"},"displayName":"oleg@zentralweb.de","active":true,"timeZone":"Europe/Berlin","accountType":"atlassian"},"created":"2020-04-29T14:47:55.678+0200","updated":"2020-04-29T14:47:55.678+0200","started":"2020-04-29T10:47:53.869+0200","timeSpent":"4h","timeSpentSeconds":14400,"id":"22916","issueId":"25362"}]}}}';
//            $json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
//        $json = '{"expand":"renderedFields,names,schema,operations,editmeta,changelog,versionedRepresentations","id":"24544","self":"https:\/\/zentralweb.atlassian.net\/rest\/agile\/1.0\/issue\/24544","key":"HKD-99","fields":{"statuscategorychangedate":"2018-08-09T17:18:48.734+0200","issuetype":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/issuetype\/10001","id":"10001","description":"Eine Funktionalit\u00e4t oder Funktion, ausgedr\u00fcckt als Benutzerziel.","iconUrl":"https:\/\/zentralweb.atlassian.net\/images\/icons\/issuetypes\/story.svg","name":"Story","subtask":false},"timespent":null,"sprint":null,"project":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/project\/13117","id":"13117","key":"HKD","name":"hebebuehnen-kroemer.de","projectTypeKey":"software","simplified":false,"avatarUrls":{"48x48":"https:\/\/zentralweb.atlassian.net\/secure\/projectavatar?avatarId=10324","24x24":"https:\/\/zentralweb.atlassian.net\/secure\/projectavatar?size=small&s=small&avatarId=10324","16x16":"https:\/\/zentralweb.atlassian.net\/secure\/projectavatar?size=xsmall&s=xsmall&avatarId=10324","32x32":"https:\/\/zentralweb.atlassian.net\/secure\/projectavatar?size=medium&s=medium&avatarId=10324"}},"fixVersions":[{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/version\/12801","id":"12801","description":"","name":"190821.15","archived":false,"released":true,"releaseDate":"2019-08-20"}],"customfield_11001":null,"aggregatetimespent":null,"customfield_11002":null,"resolution":null,"customfield_11003":null,"customfield_11004":[],"customfield_11005":null,"customfield_10500":null,"customfield_10700":null,"customfield_10900":null,"resolutiondate":null,"workratio":-1,"issuerestriction":{"issuerestrictions":[],"shouldDisplay":false},"watches":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/issue\/HKD-99\/watchers","watchCount":1,"isWatching":false},"lastViewed":null,"created":"2018-07-17T03:38:49.129+0200","customfield_10021":null,"epic":null,"customfield_10022":"","customfield_10100":null,"priority":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/priority\/3","iconUrl":"https:\/\/zentralweb.atlassian.net\/images\/icons\/priorities\/medium.svg","name":"Medium","id":"3"},"customfield_10300":{"hasEpicLinkFieldDependency":false,"showField":false,"nonEditableReason":{"reason":"PLUGIN_LICENSE_ERROR","message":"Die \u00fcbergeordnete Verkn\u00fcpfung ist nur f\u00fcr Jira Premium-Benutzer verf\u00fcgbar."}},"labels":[],"customfield_10016":null,"customfield_10017":null,"timeestimate":null,"aggregatetimeoriginalestimate":null,"versions":[],"issuelinks":[],"assignee":null,"updated":"2019-08-19T14:45:43.484+0200","status":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/status\/10001","description":"","iconUrl":"https:\/\/zentralweb.atlassian.net\/","name":"Fertig","id":"10001","statusCategory":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/statuscategory\/3","id":3,"key":"done","colorName":"green","name":"Fertig"}},"components":[],"timeoriginalestimate":null,"description":"Leider wird Lieferschein an Fr., Smyrek immer noch mehr als 1x geschickt. Kann das nicht abgestellt werden?","customfield_10210":null,"customfield_10211":null,"customfield_10015":"0|i00bbn:","timetracking":[],"customfield_10203":null,"customfield_10600":null,"customfield_10204":null,"security":null,"customfield_10205":null,"customfield_10800":null,"customfield_10206":null,"attachment":[{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/attachment\/19432","id":"19432","filename":"Bildschirmfoto 2018-07-17 um 09.40.05.png","author":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/user?accountId=5a3aa65f2466f4393b8ec85d","accountId":"5a3aa65f2466f4393b8ec85d","avatarUrls":{"48x48":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/48","24x24":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/24","16x16":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/16","32x32":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/32"},"displayName":"Pascal Schattschneider","active":true,"timeZone":"Europe\/Berlin","accountType":"atlassian"},"created":"2018-07-17T03:41:54.504+0200","size":252994,"mimeType":"image\/png","content":"https:\/\/zentralweb.atlassian.net\/secure\/attachment\/19432\/Bildschirmfoto+2018-07-17+um+09.40.05.png","thumbnail":"https:\/\/zentralweb.atlassian.net\/secure\/thumbnail\/19432\/Bildschirmfoto+2018-07-17+um+09.40.05.png"}],"customfield_10801":null,"aggregatetimeestimate":null,"customfield_10207":null,"flagged":false,"customfield_10802":null,"customfield_10208":null,"customfield_10209":null,"summary":"Lieferschein wird immer noch mehrmals geschickt ","creator":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/user?accountId=5a3aa65f2466f4393b8ec85d","accountId":"5a3aa65f2466f4393b8ec85d","avatarUrls":{"48x48":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/48","24x24":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/24","16x16":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/16","32x32":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/32"},"displayName":"Pascal Schattschneider","active":true,"timeZone":"Europe\/Berlin","accountType":"atlassian"},"subtasks":[],"customfield_11010":null,"reporter":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/user?accountId=5a3aa65f2466f4393b8ec85d","accountId":"5a3aa65f2466f4393b8ec85d","avatarUrls":{"48x48":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/48","24x24":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/24","16x16":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/16","32x32":"https:\/\/avatar-management--avatars.us-west-2.prod.public.atl-paas.net\/5a3aa65f2466f4393b8ec85d\/5c5394da-34c3-41b5-a4c7-a5e0fc3982bb\/32"},"displayName":"Pascal Schattschneider","active":true,"timeZone":"Europe\/Berlin","accountType":"atlassian"},"customfield_11011":null,"customfield_11012":null,"customfield_10000":null,"aggregateprogress":{"progress":0,"total":0},"customfield_10001":null,"customfield_10200":null,"customfield_10201":null,"customfield_10400":"{}","customfield_10202":null,"customfield_11006":null,"customfield_11008":null,"environment":null,"customfield_11009":null,"duedate":null,"progress":{"progress":0,"total":0},"votes":{"self":"https:\/\/zentralweb.atlassian.net\/rest\/api\/2\/issue\/HKD-99\/votes","votes":0,"hasVoted":false},"comment":{"comments":[],"maxResults":0,"total":0,"startAt":0},"worklog":{"startAt":0,"maxResults":20,"total":0,"worklogs":[]}}}';
        return $json = json_decode($json, true);
    }
}
