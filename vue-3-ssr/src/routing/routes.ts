export const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import(/* webpackChunkName: "Home" */ '../components/Page/HomePage.vue')
    },
]