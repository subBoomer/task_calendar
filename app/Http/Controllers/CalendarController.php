<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;


class CalendarController extends Controller
{
    public function show(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // If authenticated, retrieve the authenticated user
            $user = Auth::user();

            // Return the calendar index view
            return view('calendar.index');
        }

        // If not authenticated, redirect the user to the login page
        return redirect()->route('login');
    }

    public function getEvents(Request $request)
    {
        // Retrieve events from the database or any other data source
        $events = CalendarEvent::all();

        // Return the events data in JSON format
        return response()->json($events);
    }

    public function deleteEvent($id)
    {
        // Find the event by its ID
        $event = CalendarEvent::findOrFail($id);

        // Check if the event exists
        if (!$event) {
            // Return a 404 Not Found response if the event does not exist
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Delete the event
        $event->delete();

        // Return a success response
        return response()->json(['message' => 'Event deleted successfully']);
    }

    public function addTask(Request $request)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $user = Auth::user();

        if ($user) {
            // Create new event
            $event = new CalendarEvent([
                'user_id' => $user->id,
                'type' => $request->input('type'),
                'title' => $request->input('title'),
                'location' => $request->input('location'),
                'is_locked' => $request->input('is_locked', false),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'is_all_day' => $request->input('is_all_day', false),
                'availability' => $request->input('availability'),
            ]);
            // Save event to database
            $event->save();

            // Return a success response
            return response()->json(['status' => 'success', 'message' => 'Task added successfully', 'event' => $event]);
        }

        // Return a error response
        return response()->json(['status' => 'error', 'message' => 'User not retrieved'], 400);
    }

    public function updateTask(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id' => 'required|exists:calendar_events,id',
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date',
        ]);

        $user = Auth::user();

        if ($user) {
            // Update existing task
            $taskId = $request->input('id');
            $event = CalendarEvent::findOrFail($taskId);
            // Update task attributes with new data
            $event->update([
                'user_id' => $user->id,
                'type' => $request->input('type'),
                'title' => $request->input('title'),
                'location' => $request->input('location'),
                'is_locked' => $request->input('is_locked', false),
                'start' => $request->input('start'),
                'end' => $request->input('end'),
                'is_all_day' => $request->input('is_all_day', false),
                'availability' => $request->input('availability'),
            ]);

            return response()->json(['status' => 'success', 'message' => 'Task updated successfully', 'event' => $event]);
        }

        return response()->json(['status' => 'error', 'message' => 'User not retrieved'], 400);
    }
}
