import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

// Import Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

// Create Vue app
createApp(App).use(router).mount('#app');
