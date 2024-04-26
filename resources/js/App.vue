<template>
  <div>
    <select
      v-model="selectedView"
      class="view-select"
    >
      <option
        v-for="view in viewOptions"
        :key="view.value"
        :value="view.value"
      >
        {{ view.title }}
      </option>
    </select>
    <div class="buttons">
      <button
        type="button"
        class="calendar-button"
        @click="onClickTodayButton"
      >
        Today
      </button>
      <button
        type="button"
        class="calendar-button"
        @click="onClickMoveButton(-1)"
      >
        Prev
      </button>
      <button
        type="button"
        class="calendar-button"
        @click="onClickMoveButton(1)"
      >
        Next
      </button>
    </div>
    <span class="date-range">{{ dateRangeText }}</span>
    <ToastUICalendar
      ref="calendar"
      style="height: 800px"
      :view="'week'"
      :use-form-popup="true"
      :use-detail-popup="true"
      :week="{
        showTimezoneCollapseButton: true,
        timezonesCollapsed: false,
        eventView: true,
        taskView: false,
      }"
      :month="{ startDayOfWeek: 1 }"
      :timezone="{ zones }"
      :theme="theme"
      :template="{
        // milestone: getTemplateForMilestone,
        allday: getTemplateForAllday,
      }"
      :grid-selection="true"
      :calendars="calendars"
      :events="events"
      @selectDateTime="onSelectDateTime"
      @beforeCreateEvent="onBeforeCreateEvent"
      @beforeUpdateEvent="onBeforeUpdateEvent"
      @beforeDeleteEvent="onBeforeDeleteEvent"
      @afterRenderEvent="onAfterRenderEvent"
      @clickDayName="onClickDayName"
      @clickEvent="onClickEvent"
      @clickTimezonesCollapseBtn="onClickTimezonesCollapseBtn"
    />
  </div>
</template>


<script>
/* eslint-disable no-console */
import ToastUICalendar from './Calendar';
import '@toast-ui/calendar/toastui-calendar.css';
import 'tui-date-picker/dist/tui-date-picker.min.css';
import 'tui-time-picker/dist/tui-time-picker.min.css';
import { events } from './mock-data';
import { theme } from './theme';
import '../css/app.css';
import axios from 'axios';

export default {
  components: {
    ToastUICalendar, // Importing the ToastUICalendar component
  },
  data() {
    return {
      // Data properties for the calendar
      calendars: [
        // Array of calendar configurations
        {
          id: '0',
          name: 'Private',
          backgroundColor: '#9e5fff',
          borderColor: '#9e5fff',
          dragBackgroundColor: '#9e5fff',
        },
        {
          id: '1',
          name: 'Company',
          backgroundColor: '#00a9ff',
          borderColor: '#00a9ff',
          dragBackgroundColor: '#00a9ff',
        },
      ],
      events: [], // Array to store calendar events
      zones: [
        // Array of timezone configurations
        {
          timezoneName: 'Europe/Riga',
          displayLabel: 'Riga',
          tooltip: 'UTC+02:00',
        },
      ],
      theme,  // Theme configuration for the calendar
      selectedView: 'week', // Initially selected calendar view
      viewOptions: [
        // Options for different calendar views
        {
          title: 'Monthly',
          value: 'month',
        },
        {
          title: 'Weekly',
          value: 'week',
        },
        {
          title: 'Daily',
          value: 'day',
        },
      ],
      dateRangeText: '', // Text to display the current date range
    };
  },
  computed: {
    // Computed property to get and set the calendar instance
    calendarInstance: {
      get() {
        return this.$refs.calendar.getInstance();
      },
      set(value) {
        console.warn("Setter for calendarInstance computed property called with value:", value);
      },
    },
  },
  watch: {
    // Watchers to react to changes in selectedView and events
    selectedView(newView) {
      // Change the calendar view when selectedView changes
      this.calendarInstance.changeView(newView);
      this.setDateRangeText();
    },
    events: {
      // Store events in local storage when events array changes
      handler(newEvents) {
        localStorage.setItem('events', JSON.stringify(newEvents));
      },
      deep: true,
    },
  },
  mounted() {
    console.log("Component mounted. Initializing calendar...");
    this.setDateRangeText();
    // Fetch events from the database upon page load
    axios.get('/calendar/events')
        .then(response => {
            // Update the events array with the fetched data
            this.events = response.data;
              
            // Check for duplicate events
            const uniqueEvents = this.events.filter((event, index, self) =>
                index === self.findIndex((e) => (
                    e.id === event.id
                ))
            );

            // Initialize the calendar with the updated events array
            this.initializeCalendar(uniqueEvents);      
        })
        .catch(error => {
            console.error('Error fetching events:', error);
        });
  },
  methods: {
    // Method to refresh the calendar with updated events
    refreshCalendar(events) {
      console.log('Current events array:', this.events);
      // Update the events array
      this.events = events;
      console.log('Updated events array:', this.events);

      // Get the calendar instance
      const calendarInstance = this.$refs.calendar.getInstance();

      // Set a flag to track if the event rendering is complete
      let eventRendered = false;

      // Listen for the onAfterRenderEvent callback to detect event rendering completion
      calendarInstance.on('afterRenderEvent', () => {
        // If event rendering is complete and the calendar needs to be refreshed,
        // refresh the calendar and remove the event listener
        if (eventRendered) {
          // Refresh the calendar with the updated events
          console.log('Refreshing calendar with updated events.');
          calendarInstance.setOptions({
            events: this.events
          });
          calendarInstance.off('afterRenderEvent');
        }
      });

      // Set a timeout to ensure the calendar is refreshed even if the event rendering
      // process doesn't trigger the onAfterRenderEvent callback
      setTimeout(() => {
        eventRendered = true;
      }, 2000); // Timeout after 2000 milliseconds
    },
    // Method to initialize the calendar
    initializeCalendar() {
      this.calendarInstance = this.$refs.calendar.getInstance();
      this.addEventListeners();
      if (this.events && this.events.length > 0) {
        this.calendarInstance.createEvents(this.events);
      }
    },
    // Method to add event listeners to the calendar instance
    addEventListeners() {
      console.log("Adding event listeners...");
    },
    // // Method to get a template for displaying a milestone event
    // getTemplateForMilestone(event) {
    //   return `<span style="color: #fff; background-color: ${event.backgroundColor};">${event.title}</span>`;
    // },
    // Method to get a template for displaying an all-day event
    getTemplateForAllday(event) {
      return `[All day] ${event.title}`;
    },
    // Method called when a date and time are selected in the calendar
    onSelectDateTime({ start, end }) {
      console.group('onSelectDateTime');
      console.log(`Date : ${start} ~ ${end}`);
      console.groupEnd();
    },
    // Method called before creating a new event
    onBeforeCreateEvent(eventData, callback) {
      document.body.classList.add('hidden');
      // Function to parse and validate the date string
      const parseAndValidateDate = (dateString) => {
          try {
              const date = new Date(dateString);
              if (isNaN(date.getTime())) {
                  throw new Error('Invalid date');
              }
              return date;
          } catch (error) {
              console.error('Invalid date:', dateString);
              return null;
          }
      };

      // Parse and validate start and end dates
      const start = parseAndValidateDate(eventData.start);
      const end = parseAndValidateDate(eventData.end);

      if (!start || !end) {
          console.error('Invalid start or end date:', start, end);
          return;
      }

      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const userId = '{{ Auth::id() }}';

      // Create the event object
      const event = {
          user_id: userId,
          calendarId: eventData.calendarId || '',
          title: eventData.title,
          isAllday: eventData.isAllday,
          start: start.toISOString(), // Convert date object to ISO string
          end: end.toISOString(), // Convert date object to ISO string
          category: eventData.isAllday ? 'allday' : 'time',
          dueDateClass: '',
          location: eventData.location,
          state: eventData.state,
          isPrivate: eventData.isPrivate,
      };

      // Send data to the backend to save the task
      axios.post('/calendar/addTask', event, {
          headers: {
              'X-CSRF-TOKEN': csrfToken,
          }
      })
      .then(response => {
        console.log('Response data:', response.data);

        // Update the events array
        this.events = response.data.events;

        // Get the calendar instance
        const calendarInstance = this.$refs.calendar.getInstance();

        // Refresh the calendar with the updated events
        console.log('Refreshing calendar with updated events.');
        calendarInstance.setOptions({
          events: this.events
        });

        // Call the callback with the event ID once it's available
        if (callback && typeof callback === 'function') {
          callback(response.data.event.id);
        }

        // Refresh the page after adding the event
        window.location.reload(true);
      })
      .catch(error => {
        console.error(error);
      });
    },
    // Method called before updating an existing event
    onBeforeUpdateEvent(updateData) {
      // Hide the body content temporarily
      document.body.classList.add('hidden');
      console.group('onBeforeUpdateEvent');
      console.log('Changes: ', updateData.changes);

      // Extract necessary data from the updateData object
      const targetEvent = updateData.event;
      const changes = { ...updateData.changes };
      const ID = targetEvent.id;

      console.log('Changes:', changes);
      console.log('Changes ID:', changes.calendarId);
      console.log('ID:', ID);

      // Get the CSRF token for authentication
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      // Prepare payload to send for updating the event
      let payload = {
        id: ID,
        title: changes.title || targetEvent.title,
        start: changes.start ? new Date(changes.start.d.d).toISOString() : targetEvent.start.d.d, // Use updated start or original start
        end: changes.end ? new Date(changes.end.d.d).toISOString() : targetEvent.end.d.d, // Use updated end or original end
      };

      console.log('Payload:', payload);

      // Send a POST request to update the event
      axios.post('/calendar/updateTask', payload, {
        headers: {
          'X-CSRF-TOKEN': csrfToken,
        }
      })
      .then(response => {
        console.log(response.data);

        // Refresh the page after adding the event
        window.location.reload(true);
      })
      .catch(error => {
          console.error(error);
      });


      console.groupEnd();
    },
    // Method called before deleting an existing event
    onBeforeDeleteEvent({ title, id, calendarId }) {
      console.group('onBeforeDeleteEvent');
      console.log('Event Info : ', title);
      console.groupEnd();

      // Delete the event from the calendar instance locally
      this.calendarInstance.deleteEvent(id, calendarId);

      // Send a delete request to the backend
      axios.delete(`/calendar/events/${id}`)
        .then(response => {
            console.log('Event deleted successfully:', response.data);
            // Render the calendar after the deletion process is completed
            // this.initializeCalendar(); // Render the calendar
        })
        .catch(error => {
            console.error('Error deleting event:', error);
        });
    },
    onAfterRenderEvent({ id, title, start, end }) {
      // Log event information after it has been rendered
      console.group('onAfterRenderEvent');
      console.log('Event Info : ', title);
      console.log('Event ID: ', id || 'ID not available yet');
      console.log('Event Start Time: ', start);
      console.log('Event End Time: ', end);
      console.groupEnd();
    },
    onClickDayName({ date }) {
      // Log the clicked date when a day name is clicked
      console.group('onClickDayName');
      console.log('Date : ', date);
      console.groupEnd();
    },
    onClickEvent({ nativeEvent, event }) {
      // Log mouse event and event information when an event is clicked
      console.group('onClickEvent');
      console.log('MouseEvent : ', nativeEvent);
      console.log('Event Info : ', event);
      console.groupEnd();
    },
    onClickTimezonesCollapseBtn(timezoneCollapsed) {
      // Log whether the timezones are collapsed or expanded when the collapse button is clicked
      console.group('onClickTimezonesCollapseBtn');
      console.log('Is Timezone Collapsed?: ', timezoneCollapsed);
      console.groupEnd();

      // Set a new theme for the calendar to adjust the width of day and time grids when timezones are collapsed
      const newTheme = {
        'week.daygridLeft.width': '100px',
        'week.timegridLeft.width': '100px',
      };

      this.calendarInstance.setTheme(newTheme);
    },
    onClickTodayButton() {
      // Go to today's date when the "Today" button is clicked and update the date range text
      this.calendarInstance.today();
      this.setDateRangeText();
    },
    onClickMoveButton(offset) {
      // Move the calendar by the specified offset (number of days) when the move button is clicked and update the date range text
      this.calendarInstance.move(offset);
      this.setDateRangeText();
    },
    setDateRangeText() {
      // Set the text for the date range based on the current view (month, day, or custom range)
      const date = this.calendarInstance.getDate();
      const start = this.calendarInstance.getDateRangeStart();
      const end = this.calendarInstance.getDateRangeEnd();

      const startYear = start.getFullYear();
      const endYear = end.getFullYear();

      switch (this.selectedView) {
        case 'month':
          this.dateRangeText = `${date.getFullYear()}.${date.getMonth() + 1}`;

          return;
        case 'day':
          this.dateRangeText = `${date.getFullYear()}.${date.getMonth() + 1}.${date.getDate()}`;

          return;
        default:
          this.dateRangeText = `${startYear}.${start.getMonth() + 1}.${start.getDate()} - ${
            startYear !== endYear ? `${endYear}.` : ''
          }${end.getMonth() + 1}.${end.getDate()}`;
      }
    },
  },
};
</script>




<style scoped>
.hidden {
  display: none;
}

.view-select {
    margin-bottom: 20px;
    margin-left: 10px;
}

.buttons {
  display: flex;
}

.calendar-button {
  background-color: #f0f0f0;
  border: 1px solid #ccc;
  border-radius: 3px;
  padding: 8px 12px;
  margin-right: 10px;
  cursor: pointer;
  margin-bottom: 20px;
}

.calendar-button:hover {
  background-color: #e0e0e0;
}


.date-range {
  margin-left: 10px;
  font-weight: bold;
}
</style>
