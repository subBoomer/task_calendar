let tasks = []
let newTask = {
  user_id: null,
  event_day: null,
  event_month: null,
  event_year: null,
  event_title: '',
  event_time_from: '',
  event_time_to: '',
}

document.addEventListener('DOMContentLoaded', () => {
  // Fetch tasks from the server and display them in the task view
  async function fetchTasks() {
    try {
      const response = await axios.get('/calendar');
      return response.data;
    } catch (error) {
      console.error(error);
      return [];
    }
  }

  // Add a new task to the list
  async function addTask() {
    const userId = document.getElementById('userId').value;
    const title = document.getElementById('newTaskTitle').value;
    const day = document.getElementById('eventDay').value;
    const month = document.getElementById('eventMonth').value;
    const year = document.getElementById('eventYear').value;
    const timeFrom = document.getElementById('eventTimeFrom').value;
    const timeTo = document.getElementById('eventTimeTo').value;
  
    const task = {
      userId,
      title,
      day,
      month,
      year,
      timeFrom,
      timeTo,
    };
  
    try {
      await axios.post('/calendar', task); // Send the task to the server
  
      // Fetch the updated tasks from the server
      const updatedTasks = await fetchTasks();
  
      // Update the calendar and tasks sidebar with the updated tasks
      calendarComponent.updateTasks(updatedTasks);
      tasksSidebar.updateTasks(updatedTasks);
    } catch (error) {
      console.error(error);
    }
  }

  // Fetch tasks from the server and display them in the task view
  fetchTasks()

  // Add a new task the user submits form
  const form = document.getElementById('newTaskForm')

  form.addEventListener('submit', event => {
    event.preventDefault()

    const title = document.getElementById('newTaskTitle').value

    if (!title) {
      return
    }

    newTask.event_title = title
    newTask.event_day = document.getElementById('eventDay').value
    newTask.event_month = document.getElementById('eventMonth').value
    newTask.event_year = document.getElementById('eventYear').value
    newTask.event_time_from = document.getElementById('eventTimeFrom').value
    newTask.event_time_to = document.getElementById('eventTimeTo').value

    addTask()
    form.reset()
  })
})