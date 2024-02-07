<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Groups') }}
        </h2>
    </x-slot>
    <h1>All Groups</h1>
    @foreach ($groups as $group)
        <div>
            <a href="{{ route('groups.show', ['id' => $group->id]) }}">
                {{ $group->name }}
            </a>
        </div>
    @endforeach
</x-app-layout>


