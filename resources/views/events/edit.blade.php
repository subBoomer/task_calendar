<x-app-layout>
    <h1>Edit Event</h1>

    {!! Form::model($event, ['action' => ['EventController@update', $event->id], 'method' => 'PUT']) !!}
        @include('events._form')
        {{ Form::submit('Update Event', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}
</x-app-layout>
