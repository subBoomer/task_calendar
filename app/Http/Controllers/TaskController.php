<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        // Logic to show all tasks

        // Retrieve all tasks from the Task model
        $tasks = Task::all();

        // Pass the tasks data to the 'tasks.index' view to render
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function show($id)
    {
        // Logic to show a specific task by $id
        // Find the task by its ID using the Task model
        $task = Task::find($id);

        // If the task is not found, return a 404 error
        if (!$task) {
            return abort(404, 'Task not found');
        }

        // Pass the found task data to the 'tasks.show' view to render
        return view('tasks.show', ['task' => $task]);
    }

    // Other actions related to tasks

    public function store(Request $request)
    {
        // Logic to handle creating and storing a new task (e.g., form submission)

        // Example: Create a new task using request data
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    public function edit($id)
    {
        // Logic to handle editing an existing task

        // Example: Find the task by ID and pass it to the edit view
        $task = Task::find($id);
        if (!$task) {
            return abort(404, 'Task not found');
        }

        return view('tasks.edit', ['task' => $task]);
    }

    public function update(Request $request, $id)
    {
        // Logic to handle updating an existing task

        // Example: Find the task by ID and update its details
        $task = Task::find($id);
        if (!$task) {
            return abort(404, 'Task not found');
        }

        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();

        return redirect()->route('tasks.show', ['task' => $task])->with('success', 'Task updated successfully');
    }

    public function destroy($id)
    {
        // Logic to handle deleting an existing task

        // Example: Find the task by ID and delete it
        $task = Task::find($id);
        if (!$task) {
            return abort(404, 'Task not found');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
