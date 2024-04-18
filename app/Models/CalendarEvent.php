<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class CalendarEvent extends Model
{
    use HasFactory;

    protected $table = 'calendar_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'is_locked',
        'start',
        'end',
        'is_all_day',
        'availability',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'is_locked' => 'boolean',
        'is_all_day' => 'boolean',
    ];

    /**
     * Get the user that owns the calendar event.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createEvent(Request $request)
    {
        // Validate request data, handle authorization, etc.

        // Create new event instance and populate fields
        $event = new CalendarEvent();
        $event->user_id = auth()->id(); // Assuming you have authentication set up
        $event->title = $request->input('title');
        $event->start = $request->input('start');
        $event->end = $request->input('end');

        // Save the event to the database
        $event->save();

        // Fetch the ID assigned by the database
        $eventId = $event->id;

        // Return a response with the generated ID
        return response()->json(['id' => $eventId, 'message' => 'Event created successfully'], 201);
    }
}
