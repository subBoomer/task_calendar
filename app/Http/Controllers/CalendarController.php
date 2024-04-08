<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;


class CalendarController extends Controller
{
    public function show(Request $request)
    {
        // Your logic goes here, e.g., fetching data from the database


        if (Auth::check()) {
            $user = Auth::user();
            $tasks = $user->tasks->map(function ($task) {
                return [
                    'title' => $task->event_title,
                    'start' => "$task->event_year-$task->event_month-$task->event_day $task->event_time_from",
                    'end' => "$task->event_year-$task->event_month-$task->event_day $task->event_time_to",
                    'id' => $task->id,
                ];
            })->toArray();
            
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
            $task = $user->tasks()->create($taskData);

            // Return the newly created task as JSON
            return response()->json(['status' => 'success', 'message' => 'Event added successfully', 'task' => $task]);
        }


        // Return an error JSON response if the user is not retrieved
        return response()->json(['status' => 'error', 'message' => 'User not retrieved'], 400);
    }

    public function addTaskAjax(Request $request): JsonResponse
    {
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
            $task = $user->tasks()->create($taskData);

            // Return the newly created task as JSON
            return response()->json(['status' => 'success', 'message' => 'Event added successfully', 'task' => $task]);
        }

        // Return an error JSON response if the user is not retrieved
        return response()->json(['status' => 'error', 'message' => 'User not retrieved'], 400);
    }
}
