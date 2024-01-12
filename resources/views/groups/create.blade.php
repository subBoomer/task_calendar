<x-app-layout>
    <h1>Create a New Group</h1>

    <form method="post" action="{{ route('groups.create') }}">
        @csrf
        <!-- Other form fields -->
        <label for="name">Group Name:</label>
        <input type="text" name="name" required>
        
        <label for="member_count">Member Count:</label>
        <input type="number" name="member_count" required>
        
        <label for="member_emails">Member Emails (comma-separated):</label>
        <input type="text" name="member_emails" placeholder="john@example.com, jane@example.com">
        
        <!-- Add more fields as needed -->

        <button type="submit">Create Group</button>
    </form>
</x-app-layout>
