import { createRouter, createWebHistory } from 'vue-router'
import beforeGuard from './beforeGuard'
import routes from './routes'

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  linkActiveClass: 'link_active',
  linkExactActiveClass: 'link_exact-active',
  routes
})

// Before Guard
router.beforeEach(beforeGuard)

export default router
