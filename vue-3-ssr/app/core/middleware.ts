import express, { Request, Response } from 'express';
import { SSR } from '../typings';

export default <SSR.Scoped>function ({ directories }: SSR.Context): SSR.Middleware {
    return {
        assets: () => express.static(directories.client(), { index: false }),

        https: () => (req: Request, res: Response, next: () => any): void => {
            !req.secure ? res.redirect(`https://${req.headers.host}${req.url}`) : next();
        },

        reload: () => {
            const livereload = require("livereload");

            const server = livereload.createServer();
            server.watch(directories.dist());
            server.server.once("connection", () => {
                setTimeout(() => {
                    server.refresh("/");
                }, 100);
            });
            return require('connect-livereload')({
                port: 35729
            })
        }
    }
}