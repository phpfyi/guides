import { createMemoryHistory, createWebHistory, createRouter } from "vue-router";
import { isSSR } from '@/helpers'
import { routes } from './routes'

export function createApplicationRouter(): any {
    const router = createRouter({
        history: isSSR() ? createMemoryHistory() : createWebHistory(),
        routes
    });
    return router;
}