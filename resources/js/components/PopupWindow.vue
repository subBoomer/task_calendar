<template>
  <div class="popup-container" v-if="show">
    <!-- Pop-up window content for adding tasks -->
    <div class="popup-content">
      <h2>Add Task</h2>
      <label for="title">Title:</label>
      <input type="text" id="title" v-model="task.title">
      <label for="description">Description:</label>
      <textarea id="description" v-model="task.description"></textarea>
      <label for="startTime">Start Time:</label>
      <input type="time" id="startTime" v-model="task.startTime">
      <label for="endTime">End Time:</label>
      <input type="time" id="endTime" v-model="task.endTime">
      <button @click="saveTask">Save</button>
      <button @click="close">Close</button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    value: Boolean
  },
  emits: ['update:value', 'save-task'],
  data() {
    return {
      task: {
        title: '',
        description: '',
        startTime: '',
        endTime: ''
      }
    };
  },
  computed: {
    show: {
      get() {
        return this.value;
      },
      set(newValue) {
        this.$emit('update:value', newValue);
      }
    }
  },
  methods: {
    saveTask() {
      // Save the task and close the pop-up window
      // You can emit an event to notify the parent component
      this.show = false;
      console.log('Task saved:', this.task);
      this.$emit('save-task');
    }, 
    close() {
      // Emit a 'close' event to notify the parent component to hide the pop-up window
      this.$emit('close');
    }
  }
};
</script>

<style scoped>
.popup-container {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 20px;
  border: 1px solid #ccc;
}

.popup-content {
  max-width: 400px;
  margin: 0 auto;
}

input[type="text"],
textarea,
input[type="time"],
button {
  display: block;
  margin-bottom: 10px;
}
</style>
