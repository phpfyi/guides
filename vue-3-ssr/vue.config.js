const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const nodeExternals = require('webpack-node-externals');

module.exports = {
  outputDir: './dist/client',
  publicPath: '/',
  runtimeCompiler: true,
  devServer: {
    https: false,
    port: 8080,
    writeToDisk: true
  },
  chainWebpack: (config) => {
    config.entryPoints.delete('app')

    if (!process.env.SSR) {
      config.entry('client').add('./src/entry.client.ts');
      return
    }
    config.entry('server').add('./src/entry.server.ts');

    config.target('node');
    config.output.libraryTarget('commonjs2');

    config.externals(nodeExternals({ allowlist: /\.(css|vue)$/ }));

    config.plugin('manifest').use(new WebpackManifestPlugin({ fileName: 'ssr-manifest.json' }));

    config.optimization.splitChunks(false).minimize(false);

    config.plugins.delete('hmr');
    config.plugins.delete('html');
    config.plugins.delete('preload');
    config.plugins.delete('prefetch');
    config.plugins.delete('progress');
    config.plugins.delete('friendly-errors');
    config.plugins.delete('mini-css-extract-plugin');
  }
}