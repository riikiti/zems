import { createRouter, createWebHistory } from 'vue-router'
import PlatformView from '@/views/PlatformView.vue'
import ProjectView from '@/views/ProjectView.vue'
import TaskView from '@/views/TaskView.vue'
import { useAuthStore } from '@/stores/auth'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/platform',
            name: 'platform',
            component: PlatformView,
            meta: { requiresAuth: true }

        },
        {
            path: '/platform/project/:id',
            name: 'project',
            component: ProjectView,
            meta: { requiresAuth: true }

        },
        {
            path: '/platform/task/:id',
            name: 'task',
            component: TaskView,
            meta: { requiresAuth: true }
        },
        { path: '/:pathMatch(.*)*', redirect: '/platform' }
    ]
})
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()
    const token = localStorage.getItem('JWT_SECRET')
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (token) {
            await authStore.fetchUser()
            next()
        } else {
            next('/')
        }
    } else {
        if (token) {
            next('/platform')
        }
        next()
    }
})
export default router
