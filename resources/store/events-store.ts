import { defineStore } from 'pinia';
import { ref } from 'vue';

// Define the structure of an Event object
interface Event {
  id: number;
  title: string;
  date: string;
  description: string;
  start: string;
  end: string;
}

// Define a Pinia store for managing events
export const useEventsStore = defineStore({
  id: 'events', // Unique identifier for the store
  state: () => ({
    events: [] as Event[], // Array to store event objects
    chosenEvents: ref<number[]>([]), // Ref to track the IDs of chosen events, initialized as an empty array
  }),
  actions: {
    addEvent(event: Event) {
      // Action to add an event to the store
      this.events.push(event); // Push the new event object to the events array
    },
    toggleEvent(eventId: string | number) {
      // Action to toggle the selection of an event
      const parsedEventId = typeof eventId === 'string' ? parseInt(eventId, 10) : eventId; // Convert eventId to a number if it's a string
      const index = this.chosenEvents.value.indexOf(parsedEventId); // Find the index of the event ID in the chosenEvents array
      // If the event ID is not in the chosenEvents array, add it; otherwise, remove it
      if (index === -1) {
          this.chosenEvents.value.push(parsedEventId); // Add the event ID to the chosenEvents array
      } else {
          this.chosenEvents.value.splice(index, 1); // Remove the event ID from the chosenEvents array
      }
    },
  },
});
