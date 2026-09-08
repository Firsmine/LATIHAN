<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->get();
        return response()->json([
            'success'=>True,
            'data'=>$tasks
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'status'=>'nullable|in:pending,in_progress,completed',
            'deadline'=>'nullable|date'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=>'Invalid Field',
                'errors'=>$validator->errors()
            ]);
        }

        $taks = $request->user()->tasks()->create($validator->validated());

        return response()->json([
            'success'=>true,
            'message'=>'Task added.',
            'data'=>$taks
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
