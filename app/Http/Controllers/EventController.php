<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    public function index()
{
    $events = Event::all(); // Assuming your model is named Event
    return view('events.index', ['events' => $events]);
}

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'day' => 'required|numeric',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
            'title' => 'required|string|max:255',
            'timeFrom' => 'required|string',
            'timeTo' => 'required|string',
        ]);

        // Extract validated data
        $day = $validatedData['day'];
        $month = $validatedData['month'];
        $year = $validatedData['year'];

        // Find or create the event based on the date
        $event = Event::firstOrCreate(
            ['day' => $day, 'month' => $month, 'year' => $year],
            ['events' => []]
        );

        // Add the new event to the events array
        $event->events[] = [
            'title' => $validatedData['title'],
            'timeFrom' => $validatedData['timeFrom'],
            'timeTo' => $validatedData['timeTo'],
        ];

        // Save the changes
        $event->save();

        // Log the request data to check if it's being received correctly
        Log::info('Request data: ' . json_encode($request->all()));

        // Return a response (e.g., success message or updated events)
        return response()->json(['message' => 'Event stored successfully']);
            
    }

    public function edit($id)
    {
        $event = Event::find($id);
        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'timeFrom' => 'required|string',
            'timeTo' => 'required|string',
        ]);

        // Find the event by ID
        $event = Event::findOrFail($id);

        // Find the index of the event in the events array
        $eventIndex = null;
        foreach ($event->events as $index => $eventData) {
            if ($eventData['id'] == $id) {
                $eventIndex = $index;
                break;
            }
        }

        // If the event is not found, return an error response
        if ($eventIndex === null) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Update the event data
        $event->events[$eventIndex] = [
            'id' => $id,
            'title' => $validatedData['title'],
            'timeFrom' => $validatedData['timeFrom'],
            'timeTo' => $validatedData['timeTo'],
        ];

        // Save the changes
        $event->save();

        // Return a response (e.g., success message or updated events)
        return response()->json(['message' => 'Event updated successfully']);
    
    }

    public function show($id)
    {
        $event = Event::find($id);
        return view('events.show', ['event' => $event]);
    }

    public function destroy($id)
    {
        // Find the event by ID
        $event = Event::find($id);

        // If the event is not found, return an error response
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Find the index of the event in the events array
        $eventIndex = null;
        foreach ($event->events as $index => $eventData) {
            if ($eventData['id'] == $id) {
                $eventIndex = $index;
                break;
            }
        }

        // If the event is not found in the array, return an error response
        if ($eventIndex === null) {
            return response()->json(['error' => 'Event not found in the array'], 404);
        }

        // Remove the event from the events array
        unset($event->events[$eventIndex]);

        // Save the changes
        $event->save();

        // Return a response (e.g., success message or updated events)
        return response()->json(['message' => 'Event deleted successfully']);
    }
}
