import app from './app/index'
import context from './app/context'
import { SSR } from './app/typings';

const ctx: SSR.Context = context(<SSR.Config>{
  port: process.env.PORT || 8080,
  root: __dirname,
  https: process.env.HTTPS === 'true',
  reload: process.env.RELOAD === 'true',
  template: 'index.html',
  manifest: 'ssr-manifest.json',
  entry: {
    dist: 'dist',
    client: 'client',
    server: 'server',
  }
});

app(ctx);