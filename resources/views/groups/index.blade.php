<x-app-layout>
    <h1>All Groups</h1>
    @foreach ($groups as $group)
        <div>
            <a href="{{ route('groups.show', ['id' => $group->id]) }}">
                {{ $group->name }}
            </a>
        </div>
    @endforeach
</x-app-layout>


