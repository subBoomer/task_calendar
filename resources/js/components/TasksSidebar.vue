<template>
  <v-container fluid>
    <v-list>
      <v-list-item v-for="(event, index) in events" :key="index">
        <v-list-item-content>
          <v-list-item-title v-html="event.title"></v-list-item-title>
          <v-list-item-subtitle v-html="event.start"></v-list-item-subtitle>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-container>
</template>

<script>
export default {
  name: 'TaskSidebar',
  props: {
    events: {
      type: Array,
      required: true,
    },
  },
}
</script>