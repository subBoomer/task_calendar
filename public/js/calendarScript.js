// JavaScript logic for the calendar and task management
// You can use a JavaScript framework like React or Vue for a more structured approach

// Implement your calendar logic here

// Fetch tasks from the server and display them in the task view
function fetchTasks() {
    fetch('/tasks')
        .then(response => response.json())
        .then(tasks => {
            const taskList = document.getElementById('taskList');
            taskList.innerHTML = '';

            tasks.forEach(task => {
                const listItem = document.createElement('li');
                listItem.textContent = task.title;
                taskList.appendChild(listItem);
            });
        })
        .catch(error => console.error('Error fetching tasks:', error));
}

fetchTasks();