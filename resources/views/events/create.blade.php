<x-app-layout>
    <h1>Create Event</h1>

    {!! Form::open(['action' => 'EventController@store', 'method' => 'POST']) !!}
        @include('events._form')
        {{ Form::submit('Create Event', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}
</x-app-layout>
