<template>
  <div id="app">
    <FullCalendar 
      :options="calendarOptions"
    />
  </div>
</template>

<script>
import { defineComponent } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

export default defineComponent({
  name: 'App',
  components: {
    FullCalendar,
  },
  data() {
    return {
      calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin ],
        initialView: 'dayGridMonth'
      }
    };
  },
});
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
  width: 800px;
  height: 300px;
}
</style>