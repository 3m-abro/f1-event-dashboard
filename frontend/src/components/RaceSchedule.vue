<template>
  <ul class="list-group">
    <li v-for="(event, index) in events" :key="index" class="list-group-item">
      {{ event.name }} - {{ event.date }}
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      events: [],
    };
  },
  mounted() {
    // Fetch the race schedule data from the backend
    fetch('http://localhost:8000/api/race-schedule')
      .then(response => response.json())
      .then(data => {
        this.events = data;
      });
  },
};
</script>
