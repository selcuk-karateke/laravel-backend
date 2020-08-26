<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Grocery;
use Illuminate\Http\Request;

class GroceriesController extends Controller
{
    public function store(Request $request)
    {
//        $request->validate([
//            'name' => 'required|unique:groceries|max:255',
//            'type' => 'required',
//            'price' => 'required',
//        ]);

        $validation  = Validator::make($request->all(), [
            'name' => 'required|unique:groceries|max:255',
            'type' => 'required',
            'price' => 'required',
        ]);

        $error_array = array();
        $success_output = '';

        if ($validation->fails()) {
            foreach($validation->messages()->getMessages() as $field_name => $messages){
                $error_array[] = $messages;
            }
        } else {
//            if($request->get('button_action') == "insert"){
                //
                Grocery::create([
                    'name' => $request->name,
                    'type' => $request->type,
                    'price' => $request->price,
                ]);
                $success_output = '<div class="alert alert-success">Data Inserted</div>';
//            }
        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
//        return response()->json(['success'=>'Data is successfully added']);
    }
}
