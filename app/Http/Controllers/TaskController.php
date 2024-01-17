<?php

namespace App\Http\Controllers;

use App\Task;
use Validator;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::all();
    }

    public function show(Task $task)
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        $rules = array(
            'completed' => "required",
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return $validator->errors();
        }else{
        $task = Task::create($request->all());
        return response()->json($task, 201);
        }
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return response()->json($task, 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}

