import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import Register from "@/views/Register.vue";
import Home from "@/views/Home.vue";
import Login from "@/views/Login.vue";
import store from "@/store";

const routes: Array<RouteRecordRaw> = [
  {path: '/', component: Home},
  {path: '/login', component: Login},
  {path: '/register', component: Register},
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
