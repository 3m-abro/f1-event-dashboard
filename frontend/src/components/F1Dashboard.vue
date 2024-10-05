<template>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Formula 1 Event Dashboard</h1>
    
    <div class="row">
      <div class="col-6">
        <!-- Event Schedule Section -->
        <div class="card mb-4">
          <div class="card-header">Event Schedule</div>
          <div class="card-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">Race</th>
                  <th scope="col">Date</th>
                  <th scope="col">Location</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="schedule in schedules" :key="schedule.id">
                  <td>{{ schedule.raceName }}</td>
                  <td>{{ schedule.date }}</td>
                  <td>{{ schedule.Circuit.circuitName }}, {{ schedule.Circuit.Location.locality }}, {{ schedule.Circuit.Location.country }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-6">
        <!-- Team Standings Section -->
        <div class="card mb-4">
          <div class="card-header">Team Standings</div>
          <div class="card-body">
            <ul class="list-group">
              <li v-for="standing in standings" :key="standing.id" class="list-group-item">
                {{ standing.Constructor.name }} - Points: {{ standing.points }}
              </li>
            </ul>
          </div>
        </div>

        <!-- Live Race Updates Section -->
        <div class="card mb-4">
          <div class="card-header">Live Race Updates</div>
          <div class="card-body">
            <div v-if="raceData">
              <p><strong>Lap:</strong> {{ raceData.lap }}</p>
              <p><strong>Lead Driver:</strong> {{ raceData.leadDriver }}</p>
              <p><strong>Status:</strong> {{ raceData.status }}</p>
              <p><strong>Time:</strong> {{ raceData.time }}</p>
            </div>
            <div v-else>
              <p>No updates received yet...</p>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</template>

<script>
import axios from 'axios';

const API_URL = process.env.VUE_APP_API_URL;  // Point to Laravel backend

export default {
  data() {
    return {
      schedules: [],
      standings: [],
      liveUpdates: [],
      raceData: null,
      eventSource: null
    };
  },
  mounted() {
    document.title = process.env.VUE_APP_TITLE;
    // Fetch schedules and standings on component mount
    this.getSchedules();
    this.getStandings();
    this.setupLiveUpdates();
  },
  beforeUnmount() {
    this.closeLiveUpdates();
  },
  methods: {
    getSchedules() {
      axios.get(`${API_URL}/schedule`)
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
      axios.get(`${API_URL}/standings`)
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
    setupLiveUpdates() {
      this.closeLiveUpdates(); // Close any existing connection
      
      this.eventSource = new EventSource(`${API_URL}/live`);

      this.eventSource.addEventListener("raceUpdate", (event) => {
        this.raceData = JSON.parse(event.data);
      });

      this.eventSource.onerror = (error) => {
        console.error("Error in SSE connection:", error);
        this.eventSource.close();
        
        // Attempt to reconnect after 5 seconds
        setTimeout(() => this.setupLiveUpdates(), 5000);
      };

      this.eventSource.onopen = () => {
        console.log("SSE connection established");
      };
    },

    closeLiveUpdates() {
      if (this.eventSource) {
        this.eventSource.close();
        this.eventSource = null;
      }
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
