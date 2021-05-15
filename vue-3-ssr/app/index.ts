import express, { Express, Request, Response } from 'express';
import compression from 'compression';
import middleware from './core/middleware'
import renderer from './core/renderer'
import shutdown from './core/shutdown'
import { SSR } from './typings';

export default <SSR.Scoped>function (ctx: SSR.Context): void {
    const { assets, https, reload } = middleware(ctx);

    const app: Express = express();

    app.use(compression())
    app.use(assets());

    const { config } = ctx;

    config.https && app.use(https());
    config.reload && app.use(reload());

    app.get('*', async (req: Request, res: Response) => {
        await renderer(ctx).response(req, res);
    });
    app.listen(config.port, () =>
        console.log(`Server started at localhost:${config.port}`)
    );
    shutdown();
}