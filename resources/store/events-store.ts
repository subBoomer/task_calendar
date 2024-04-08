import { defineStore } from 'pinia';
import { ref } from 'vue';

interface Event {
  id: number;
  title: string;
  date: string;
  description: string;
  start: string;
  end: string;
}

export const useEventsStore = defineStore({
  id: 'events',
  state: () => ({
    events: [] as Event[],
    chosenEvents: ref<number[]>([]), // Initialize chosenEvents as an empty array
  }),
  actions: {
    addEvent(event: Event) {
      this.events.push(event);
    },
    toggleEvent(eventId: string | number) {
      // Convert eventId to a number if it's a string
      const parsedEventId = typeof eventId === 'string' ? parseInt(eventId, 10) : eventId;
      const index = this.chosenEvents.value.indexOf(parsedEventId);
      if (index === -1) {
          this.chosenEvents.value.push(parsedEventId);
      } else {
          this.chosenEvents.value.splice(index, 1);
      }
    },
  },
});
