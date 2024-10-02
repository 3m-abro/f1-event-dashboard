<template>
  <div class="container mt-5">
    <h2>Formula 1 Event Dashboard</h2>

    <!-- Schedules Section -->
    <div class="mt-4">
      <h4>Event Schedules</h4>
      <ul class="list-group">
        <li class="list-group-item" v-for="(schedule, index) in schedules" :key="index">
          {{ schedule.race }} - {{ schedule.date }}
        </li>
      </ul>
    </div>

    <!-- Team Standings Section -->
    <div class="mt-4">
      <h4>Team Standings</h4>
      <ul class="list-group">
        <li class="list-group-item" v-for="(team, index) in standings" :key="index">
          {{ team.team }} - {{ team.points }} Points
        </li>
      </ul>
    </div>

    <!-- Live Race Updates Section -->
    <div class="mt-4">
      <h4>Live Race Updates</h4>
      <ul class="list-group">
        <li class="list-group-item" v-for="(update, index) in liveUpdates" :key="index">
          {{ update }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      schedules: [],
      standings: [],
      liveUpdates: []
    };
  },
  mounted() {
    // Fetch schedules and standings on component mount
    this.getSchedules();
    this.getStandings();
    this.getLiveUpdates();
  },
  methods: {
    getSchedules() {
      axios.get('http://localhost:8000/api/f1/schedules')
        .then(response => {
          if (response.data.MRData && response.data.MRData.RaceTable) {
            this.schedules = response.data.MRData.RaceTable.Races;
          } else {
            console.error('No schedules found');
          }
        })
        .catch(error => {
          console.error('Error fetching schedules:', error);
        });
    },
    getStandings() {
      axios.get('http://localhost:8000/api/f1/standings')
        .then(response => {
          if (response.data.MRData && response.data.MRData.StandingsTable) {
            this.standings = response.data.MRData.StandingsTable.StandingsLists[0].ConstructorStandings;
          } else {
            console.error('No standings found');
          }
        })
        .catch(error => {
          console.error('Error fetching standings:', error);
        });
    },
    getLiveUpdates() {
      const eventSource = new EventSource('http://localhost:8000/api/f1/live-updates');
      eventSource.onmessage = (event) => {
        const data = JSON.parse(event.data);
        this.liveUpdates.push(data.update);
      };
      eventSource.onerror = (error) => {
        console.error('Error with live updates:', error);
      };
    }
  }
};
</script>

<style>
/* Custom styles for the dashboard */
.container {
  max-width: 800px;
}
</style>
