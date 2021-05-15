import path from 'path';
import { Request } from 'express';
import { SSR } from '../typings';

export default <SSR.Scoped>function ({ config, directories, paths }: SSR.Context): SSR.Bundle {
    const bundle: SSR.Bundle = {
        manifest: () => require(paths.manifest()),

        path: () => path.join(directories.server(), bundle.manifest()[`${config.entry.server}.js`]),

        entry: async (req: Request): Promise<SSR.BundleContext> => await require(bundle.path()).default(req),
    }
    return bundle
}