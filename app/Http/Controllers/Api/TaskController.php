<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $tasks = Task::latest()->get();

    return response()->json([
        'success' => true,
        'message' => 'Tasks fetched successfully.',
        'data' => $tasks,
    ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
    $task = Task::create($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Task created successfully.',
        'data' => $task,
    ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
    return response()->json([
        'success' => true,
        'message' => 'Task fetched successfully.',
        'data' => $task,
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
    $task->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Task updated successfully.',
        'data' => $task,
    ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully.',
        ]);
    }
}
