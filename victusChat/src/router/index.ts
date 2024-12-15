import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/Login.vue';
import HomeView from '@/views/Home.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/home',
    name: 'Home',
    component: HomeView
  },
 
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router