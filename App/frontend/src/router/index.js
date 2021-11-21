import { createRouter, createWebHistory } from 'vue-router'
import beforeGuard from './beforeGuard'
import routes from './routes'

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

// Before Guard
router.beforeEach(beforeGuard)

export default router
