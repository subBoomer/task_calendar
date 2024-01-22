<x-app-layout>
    <h1>Event Details</h1>
    <p><strong>Title:</strong> {{ $event->title }}</p>
    <p><strong>Description:</strong> {{ $event->description }}</p>
    <!-- Add more details as needed -->
    
    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">Edit Event</a>

    {!! Form::open(['action' => ['EventController@destroy', $event->id], 'method' => 'DELETE', 'class' => 'float-right']) !!}
        {{ Form::submit('Delete Event', ['class' => 'btn btn-danger']) }}
    {!! Form::close() !!}
</x-app-layout>
