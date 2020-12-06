<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * The validation for creating/editing a task
     *
     * @var array
     * @TDOD move to request filter
     */
    private $request_validation = [
        'title' => 'required|unique:tasks|max:255',
        'due_date' => 'date',
        'is_done' => 'required',
    ];
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return response($tasks->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'Not Implemented';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$request['due_date'] = Carbon::createFromFormat('Y-m-d H:i:s e+', $request['due_date'])->format('Y-m-d');
        $request['due_date'] = Carbon::parse($request['due_date'])->toDateTimeString();

        $request->validate($this->request_validation);
  
        $task = Task::create($request->all());
   
        return response($task->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return response($task->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        return 'Not Implemented';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $request['due_date'] = Carbon::parse($request['due_date'])->toDateTimeString();
        //$request['due_date'] = Carbon::createFromFormat('Y-m-d H:i:s e+', $request['due_date'])->format('Y-m-d');

        $request->validate($this->request_validation);

        $task->update($request->all());
        $task->save();
      
        return response($task->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
  
        return response('Task deleted.', Response::HTTP_NO_CONTENT);
    }
}
