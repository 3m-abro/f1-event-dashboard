<template>
  <ul class="list-group">
    <li v-for="(team, index) in teams" :key="index" class="list-group-item">
      {{ team.name }} - Points: {{ team.points }}
    </li>
  </ul>
</template>

<script>
export default {
  data() {
    return {
      teams: [],
    };
  },
  mounted() {
    // Fetch the team standings data from the backend
    fetch('http://localhost:8000/api/team-standings')
      .then(response => response.json())
      .then(data => {
        this.teams = data;
      });
  },
};
</script>
