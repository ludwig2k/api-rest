<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    public function index()
{
    $tasks = Task::all();

    if ($tasks->isEmpty()) {
        return response()->json(['message' => 'No tasks found.'], 404);
    }

    return response()->json($tasks);
}

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
            ]);

            $task = Task::create($request->all());

            return response()->json($task, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create task'], 500);
        }
    }

    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);

            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            $task->update($request->all());

            return response()->json($task);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update task'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);

            $task->delete();

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Task not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete task'], 500);
        }
    }
}
