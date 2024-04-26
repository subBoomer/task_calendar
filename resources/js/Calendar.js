/* eslint-disable no-undefined */ // Disable eslint warning for using undefined

// Import necessary modules
import Calendar from '@toast-ui/calendar';
import Vue from 'vue/dist/vue.js';

// Define a Vue component named ToastUICalendar
const ToastUICalendar = Vue.component('ToastUICalendar', {
  name: 'ToastUICalendar',
  props: {
    // Define component props
    view: String, // Current view of the calendar
    useFormPopup: {
      // Whether to use form popup for event creation
      type: Boolean,
      default: () => undefined, // Default value is undefined
    },
    useDetailPopup: {
      // Whether to use detail popup for event information
      type: Boolean,
      default: () => undefined,
    },
    isReadOnly: {
      // Whether the calendar is read-only
      type: Boolean,
      default: () => undefined,
    },
    usageStatistics: {
      // Whether to send usage statistics to the server
      type: Boolean,
      default: () => undefined,
    },
    eventFilter: Function, // Function to filter events
    week: Object, // Week-related settings
    month: Object, // Month-related settings
    gridSelection: {
      // Grid selection settings
      type: [Object, Boolean],
      default: () => undefined,
    },
    timezone: Object, // Timezone settings
    theme: Object, // Calendar theme settings
    template: Object, // Template settings
    calendars: Array, // Array of calendar data
    events: Array, // Array of event data
  },
  data() {
    // Component data
    return {
      calendarInstance: null, // Initialize calendar instance as null
    };
  },
  watch: {
    // Watchers for props changes
    view(value) {
      // Update the calendar view when 'view' prop changes
      this.calendarInstance.changeView(value);
    },
    useFormPopup(value) {
      // Update calendar options when 'useFormPopup' prop changes
      this.calendarInstance.setOptions({ useFormPopup: value });
    },
    useDetailPopup(value) {
      // Update calendar options when 'useDetailPopup' prop changes
      this.calendarInstance.setOptions({ useDetailPopup: value });
    },
    isReadOnly(value) {
      // Update calendar options when 'isReadOnly' prop changes
      this.calendarInstance.setOptions({ isReadOnly: value });
    },
    eventFilter(value) {
      // Update calendar options when 'eventFilter' prop changes
      this.calendarInstance.setOptions({ eventFilter: value });
    },
    week(value) {
      // Update calendar options when 'week' prop changes
      this.calendarInstance.setOptions({ week: value });
    },
    month(value) {
      // Update calendar options when 'month' prop changes
      this.calendarInstance.setOptions({ month: value });
    },
    gridSelection(value) {
      // Update calendar options when 'gridSelection' prop changes
      this.calendarInstance.setOptions({ gridSelection: value });
    },
    timezone(value) {
      // Update calendar options when 'timezone' prop changes
      this.calendarInstance.setOptions({ timezone: value });
    },
    theme(value) {
      // Update calendar theme when 'theme' prop changes
      this.calendarInstance.setTheme(value);
    },
    template(value) {
      // Update calendar options when 'template' prop changes
      this.calendarInstance.setOptions({ template: value });
    },
    calendars(value) {
      // Update calendar data when 'calendars' prop changes
      this.calendarInstance.setCalendars(value);
    },
    events(value) {
      // Update calendar events when 'events' prop changes
      this.calendarInstance.clear();  // Clear existing events and create new events
      this.calendarInstance.createEvents(value);
    },
  },
  mounted() {
    // Extract start and end dates from the nested structure
    const events = this.events.map(event => ({
      ...event,
      start: event.start.d,
      end: event.end.d
    }));

    // Log the modified events array to the console
    console.log('Modified events array:', events);

    // Create a new instance of the Toast UI Calendar
    this.calendarInstance = new Calendar(this.$refs.container, {
      defaultView: this.view,
      useFormPopup: this.useFormPopup,
      useDetailPopup: this.useDetailPopup,
      isReadOnly: this.isReadOnly,
      usageStatistics: this.usageStatistics,
      eventFilter: this.eventFilter,
      week: this.week,
      month: this.month,
      gridSelection: this.gridSelection,
      timezone: this.timezone,
      theme: this.theme,
      template: this.template,
      calendars: this.calendars,
    });
    
    // Add event listeners to the calendar instance
    this.addEventListeners();

    // Create events on the calendar instance
    this.calendarInstance.createEvents(this.events);

     // Log the created calendar instance to the console
     console.log('Calendar instance:', this.calendarInstance);
  },
  beforeDestroy() {
    // Remove event listeners and destroy the calendar instance
    this.calendarInstance.off();
    this.calendarInstance.destroy();
  },
  methods: {
    addEventListeners() {
       // Add event listeners to the calendar instance
      Object.keys(this.$listeners).forEach((eventName) => {
         // Iterate over each listener and attach it to the calendar instance
        this.calendarInstance.on(eventName, (...args) => this.$emit(eventName, ...args));
      });
    },
    getRootElement() {
      return this.$refs.container;
    },
    getInstance() {
      return this.calendarInstance;
    },
  },
  template: '<div ref="container" class="toastui-vue-calendar" />',
});

export default ToastUICalendar; // Export the component as default
