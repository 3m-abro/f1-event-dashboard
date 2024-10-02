import { createRouter, createWebHistory } from 'vue-router';
import F1Dashboard from '../components/F1Dashboard.vue';

const routes = [
  { path: '/', component: F1Dashboard },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
