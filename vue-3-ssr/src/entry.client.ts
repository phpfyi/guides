import { createApplication } from './app'

const { app, router } = createApplication();

(async (r, a) => {
    await r.isReady();
    a.mount('#app', true);
})(router, app);