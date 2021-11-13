import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'MainView',
    component: () => import('../views/MainView'),
  },
  {
    path: '/login',
    name: 'LoginView',
    component: () => import('../views/LoginView'),
  },
  {
    path: '/register',
    name: 'RegisterView',
    component: () => import('../views/RegisterView'),
  },
  {
    path: '/notes/:id',
    name: 'NoteView',
    component: () => import('../views/NoteView'),
    props: true,
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
