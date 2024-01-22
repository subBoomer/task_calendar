<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Get the tasks associated with the user
        $tasks = $user->tasks;

        // Logic to show all tasks

        // Retrieve all tasks from the Task model
        $tasks = Task::all();

        // Pass the tasks data to the 'tasks.tasks' view to render
        return view('tasks.tasks', ['tasks' => $tasks]);
    }

    public function show($id)
    {
        // Logic to show a specific task by $id
        // Find the task by its ID using the Task model
        $task = Task::findOrFail($id);

        // Pass the found task data to the 'tasks.show' view to render
        return view('tasks.show', ['task' => $task]);
    }

    public function showAll()
    {
    // Logic to fetch all tasks using the Task model
    $tasks = Task::all();

    // Pass the tasks data to the 'tasks' view to render
    return view('tasks.tasks', ['tasks' => $tasks]);

    // Other actions related to tasks
    }

    public function store(Request $request)
    {
        // Logic to handle creating and storing a new task (e.g., form submission)

        // Example: Create a new task using request data
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();

        return redirect()->route('tasks')->with('success', 'Task created successfully');
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

        return redirect()->route('tasks', ['task' => $task])->with('success', 'Task updated successfully');
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

        return redirect()->route('tasks')->with('success', 'Task deleted successfully');
    }
}
