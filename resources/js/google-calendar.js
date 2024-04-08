import { Calendar, Event } from '@fullcalendar/core'

const gcal = {
  events: [
    // Add events from your Google Calendar here
    // You can fetch events using Google Calendar API and then assign them to gcal.events
  ],
  calendar: null,

  init() {
    gcal.calendar = new Calendar(document.getElementById('gcal'))
    gcal.calendar.render()
  },

  async fetchEvents() {
    // Fetch events using Google Calendar API
    // You can use the 'gapi' object to make API requests
  },
}

export { gcal }