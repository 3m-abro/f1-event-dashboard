<template>
  <div class="live-updates">
    <p v-for="update in liveUpdates" :key="update.id">{{ update.message }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      liveUpdates: [],
    };
  },
  mounted() {
    const eventSource = new EventSource('http://localhost:8000/api/live-updates');
    
    eventSource.onmessage = (event) => {
      const newUpdate = JSON.parse(event.data);
      this.liveUpdates.push(newUpdate);
    };
  },
};
</script>

<style scoped>
.live-updates {
  height: 200px;
  overflow-y: scroll;
  background-color: #f8f9fa;
  padding: 10px;
  border: 1px solid #ddd;
}
</style>
