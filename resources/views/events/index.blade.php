<x-app-layout>
    <h1>Events</h1>

    @if(count($events) > 0)
        <ul>
            @foreach($events as $event)
                <li>
                    <a href="{{ route('events.show', $event->id) }}">{{ $event->title }}</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No events available</p>
    @endif
</x-app-layout>
