<template>
  <div>
    <schedule-x
      :events="events"
      @event-click="showEditDialog"
      @add-click="showAddDialog"
    ></schedule-x>
    <dialog max-width="600px">
      <div v-if="editMode">{{ 'Edit Event' }}</div>
      <div v-else>{{ 'Add Event' }}</div>
      <div>
        <label>Title:</label>
        <input v-model="editedEvent.title">
      </div>
      <div>
        <label>Start Time:</label>
        <input v-model="editedEvent.startTime">
      </div>
      <div>
        <label>End Time:</label>
        <input v-model="editedEvent.endTime">
      </div>
      <div>
        <label>Description:</label>
        <textarea v-model="editedEvent.description"></textarea>
      </div>
      <div>
        <button @click="closeDialog">Cancel</button>
        <button @click="saveEvent">{{ editMode ? 'Update' : 'Add' }}</button>
      </div>
    </dialog>
  </div>
</template>

<script>
import {ScheduleXCalendar} from '@schedule-x/vue'; // Import schedule-x from the correct location
// import Dialog from './Dialog.vue';

export default {
  components: {
    ScheduleXCalendar
    // Dialog
  },
  data() {
    return {
      events: [],
      dialog: false,
      editMode: false,
      editedEvent: {
        title: '',
        startTime: '',
        endTime: '',
        description: ''
      }
    };
  },
  methods: {
    showAddDialog(date) {
      this.editMode = false;
      this.editedEvent.startTime = date;
      this.editedEvent.endTime = date;
      this.dialog = true;
    },
    showEditDialog(event) {
      this.editMode = true;
      this.editedEvent = { ...event };
      this.dialog = true;
    },
    closeDialog() {
      this.dialog = false;
    },
    saveEvent() {
      if (this.editMode) {
        // Update existing event
        const index = this.events.findIndex(e => e.id === this.editedEvent.id);
        if (index !== -1) {
          this.events.splice(index, 1, this.editedEvent);
        }
      } else {
        // Add new event
        this.editedEvent.id = Math.random().toString(36).substr(2, 9);
        this.events.push(this.editedEvent);
      }
      this.dialog = false;
    }
  }
};
</script>
