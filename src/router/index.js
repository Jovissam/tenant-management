import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/auth/LogIn.vue')
  },
  {
    path: '/sign-up',
    name: 'signUp',
    component: () => import('@/views/auth/SignUp.vue')
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
