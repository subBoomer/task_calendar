<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;


class CalendarController extends Controller
{
    public function show()
    {
        // Your logic goes here, e.g., fetching data from the database


        if (Auth::check()) {
            $user = Auth::user();
            $tasks = $user->tasks;
            // Pass tasks to the calendar view
            return view('calendar.index', ['tasks' => $tasks]);
        }

        return redirect()->route('login');
    }

    public function addTask(Request $request)
    {
        header('Content-Type: application/json');
        // Validate the request data
        $request->validate([
            'day' => 'required|integer',
            'month' => 'required|integer',
            'year' => 'required|integer',
            'title' => 'required|string',
            'timeFrom' => 'required|string',
            'timeTo' => 'required|string',
        ]);

        $user = Auth::user();

        // Create a new task with event details
        // Associate the task with the authenticated user
        // Check if the user is retrieved
        if ($user) {
            $taskData = [
                'event_day' => $request->input('day'),
                'event_month' => $request->input('month'),
                'event_year' => $request->input('year'),
                'event_title' => $request->input('title'),
                'event_time_from' => $request->input('timeFrom'),
                'event_time_to' => $request->input('timeTo'),
            ];

            /** @var \App\Models\User $user **/
            // Create a task using the tasks relationship
            $user->tasks()->create($taskData);
        }


        // Fetch tasks from the server after adding a new task
        $tasks = Task::all();

        return response()->json(['status' => 'success', 'message' => 'Event added successfully', 'tasks' => $tasks]);
    }
}
