<x-app-layout>
    <!-- Define the page header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <!-- Include the CSS file for the simple calendar -->
        <link rel="stylesheet" href="{{ asset('css/simpleCalendar.css') }}" />
    </x-slot>

    
    <div class="grid grid-cols-12 gap-6">
        <!-- Sidebar -->
        <div class="col-span-3 pl-4">
             <!-- TODO Form -->
             <div id="todo-form" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6"> <!-- Add mb-6 here -->
                    <h2 class="text-lg font-semibold mb-4">TODO Form</h2>
                    <form action="{{ route('todos.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input type="text" name="title" id="title" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="3" class="form-input rounded-md shadow-sm mt-1 block w-full"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo disabled:opacity-25 transition ease-in-out duration-150">
                                Add Todo
                            </button>
                        </div>
                    </form>
                </div>
             <!-- Todo List -->
             <div id="todo-list" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Todo List</h3>

                    @isset($todos)
                        @if($todos->isEmpty())
                            <p>No todos found.</p>
                        @else
                            {{-- Display todos --}}
                            <ul>
                                @foreach($todos as $todo)
                                <li class="mb-2">
                                    <span class="hover:text-blue-500 cursor-pointer" onclick="showTodoDetails('{{ $todo->title }}', '{{ $todo->description }}')">{{ $todo->title }}</span>
                                    <span class="ml-2">
                                    <button type="button" onclick="editTodo('{{ $todo->id }}')" class="inline-block px-3 py-1 rounded-lg bg-blue-500 text-white hover:bg-blue-600">Edit</button>
                                        <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="inline" onclick="event.stopPropagation();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-block px-3 py-1 rounded-lg bg-red-500 text-white hover:bg-red-600">Delete</button>
                                        </form>
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                        @endif
                    @else
                        <p>No todos found.</p>
                    @endisset
                </div>
            <!-- Todo Details Modal -->
            <div id="todoDetailsModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background Overlay -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Modal Content -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                        <!-- Modal Content Goes Here -->
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200" id="modal-headline">Todo Details</h3>
                                    <div class="mt-2">
                                        <div class="mb-4">
                                            <label for="todo_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                            <input type="text" id="todo_title" class="form-input rounded-md shadow-sm mt-1 block w-full" disabled>
                                        </div>
                                        <div class="mb-4">
                                            <label for="todo_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                            <textarea id="todo_description" rows="3" class="form-input rounded-md shadow-sm mt-1 block w-full" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" onclick="closeTodoDetailsModal()" class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 shadow-sm px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Edit Todo Modal -->
            @isset($todos)
            @if(!$todos->isEmpty())
            <div id="editTodoModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- Background Overlay -->
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <!-- Edit Modal Content -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                        <!-- Modal Content Goes Here -->
                        <form id="editTodoForm" action="{{ route('todos.update', ['todo' => $todo->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200" id="modal-headline">Edit Todo</h3>
                                        <div class="mt-2">
                                            <div class="mb-4">
                                                <label for="edit_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                                                <input type="text" name="title" id="edit_title" class="form-input rounded-md shadow-sm mt-1 block w-full" required value="{{ $todo->title }}">
                                            </div>
                                            <div class="mb-4">
                                                <label for="edit_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                                <textarea name="description" id="edit_description" rows="3" class="form-input rounded-md shadow-sm mt-1 block w-full">{{ $todo->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Save Changes
                                </button>
                                <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 shadow-sm px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @endisset
        </div>

        <!-- Main Content -->
        <div class="col-span-6">
            <!-- Calendar -->
            <div class="calendar">
            <header>
                <h3></h3>
                <nav>
                <button id="prev"></button>
                <button id="next"></button>
                </nav>
            </header>
            <section>
                <ul class="days">
                <li>Sun</li>
                <li>Mon</li>
                <li>Tue</li>
                <li>Wed</li>
                <li>Thu</li>
                <li>Fri</li>
                <li>Sat</li>
                </ul>
                <ul class="dates"></ul>
            </section>
            </div>
        </div>
    </div>

    <!-- Style block for adjusting positioning -->
    <style>
        /* Adjust positioning of the todo form */
        #todo-form {
            position: relative;
            top: 82px;
        }

        /* Adjust positioning of the todo list */
        #todo-list {
            position: relative;
            top: 82px;
        }
    </style>
</x-app-layout>

<script>
    // Function to open the edit todo modal
    function editTodo(todoId) {
        console.log('editTodo function called');

        // Show the modal
        document.getElementById('editTodoModal').classList.remove('hidden');
    }

    // Function to close the edit todo modal
    function closeEditModal() {
        console.log('closeEditModal function called');

        // Close the modal
        document.getElementById('editTodoModal').classList.add('hidden');
    }

    // Function to show todo details in a modal
    function showTodoDetails(title, description) {
        console.log('showTodoDetails function called');
        
        // Set the title and description in the modal
        document.getElementById('todo_title').value = title;
        document.getElementById('todo_description').value = description;
        
        // Show the modal
        document.getElementById('todoDetailsModal').classList.remove('hidden');
    }

    // Function to close the todo details modal
    function closeTodoDetailsModal() {
        console.log('closeTodoDetailsModal function called');
        
        // Close the modal
        document.getElementById('todoDetailsModal').classList.add('hidden');
    }
</script>

<!-- Include the simpleCalendar JavaScript file -->
<script src="{{ asset('js/simpleCalendar.js') }}" defer></script>