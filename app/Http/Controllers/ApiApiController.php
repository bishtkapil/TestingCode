<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use DB;

class ApiApiController extends Controller
{
    //

    public function store(Request $request){

        DB::table('apitable')->insert([

            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'course' => $request->input('course'),

        ]);

        return response()->json([

            'msg' => 'submitted',
            'status' => 'success',

        ]);
    }
}
