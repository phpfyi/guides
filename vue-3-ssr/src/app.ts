import { createApp, createSSRApp } from 'vue'
import { Router } from 'vue-router'
import { createApplicationRouter } from './routing/router'
import { isSSR } from "@/helpers";
import App from './components/App/App.vue'
import PageMeta from "./components/Page/PageMeta.vue";
import PageMetaTeleport from "./components/Page/PageMetaTeleport.vue";

export function createApplication() {
    const app = isSSR() ? createSSRApp(App) : createApp(App);

    const router: Router = createApplicationRouter();

    app.use(router)

    app.component('PageMeta', PageMeta)
    app.component('PageMetaTeleport', PageMetaTeleport)

    return { app, router };
}