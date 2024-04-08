<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>
    
    <div id="app">
        <!-- Placeholder for TOAST UI Calendar -->
        <div id="calendar" style="height: 600px;"></div>
    </div>
    
    <!-- Load TOAST UI Calendar CSS -->
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />

    <!-- Load the Vite script -->
    @vite(['resources/js/app.js'])
</x-app-layout>
