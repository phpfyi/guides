import path from 'path';
import { SSR } from './typings';

export default function (config: SSR.Config): SSR.Context {
    const directories: SSR.Directories = {
        dist: () => path.join(config.root, config.entry.dist),

        client: () => path.join(directories.dist(), config.entry.client),

        server: () => path.join(directories.dist(), config.entry.server),
    }
    const paths: SSR.Paths = {
        template: () => path.join(directories.client(), config.template),

        manifest: () => path.join(directories.server(), config.manifest)
    }
    return { config, directories, paths }
}