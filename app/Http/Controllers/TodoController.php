<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{

    public function index()
    {
        // Retrieve all todos from the database
        $todos = Todo::all();
        // Return the dashboard view with the retrieved todos
        return view('dashboard', ['todos' => $todos]);
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new Todo instance with the validated data
        $todo = new Todo([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'user_id' => Auth::id(), // Associate the authenticated user's ID with the todo
        ]);


        // Save the new todo to the database
        $todo->save();

        // Redirect back or return a response as needed
        return redirect()->back()->with('success', 'TODO task added successfully');
    }

    public function destroy(Todo $todo)
    {
        // Delete the specified todo
        $todo->delete();

        // Redirect to the todos index page with a success message
        return redirect()->route('todos.index')->with('success', 'Todo deleted successfully');
    }

    public function update(Request $request, Todo $todo)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update the todo with the new data
        $todo->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        // Redirect back or return a response as needed
        return redirect()->route('todos.index')->with('success', 'Todo updated successfully');
    }

}
