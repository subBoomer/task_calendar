<template>
  <div class="tasks-sidebar">
    <!-- Task list header -->
    <div class="tasks-sidebar-header">
      <h5>Tasks</h5>
    </div>
    <!-- Task list -->
    <ul class="list-group">
      <li class="list-group-item" v-for="task in tasks" :key="task.id">
        {{ task.title }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    tasks: {
      type: Array,
      required: true,
    },
  },
};
</script>