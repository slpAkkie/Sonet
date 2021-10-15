import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'MainView',
    component: () => import('../views/MainView')
  },
  {
    path: '/login',
    name: 'LoginView',
    component: () => import('../views/LoginView')
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
