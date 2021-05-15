import { SSR } from '../typings';

const SIGNALS: Array<string> = [
    'SIGINT',
    'SIGUR1',
    'SIGUR2',
    'SIGTERM',
    'uncaughtException',
];

export default function(): void {
    const handler: SSR.ExitHandler = (options: Record<string, boolean>, code: number): void => {
        options.clean && console.log(code);
        options.exit && process.exit();
    }
    SIGNALS.forEach((code) => process.on(code, handler.bind(null, { exit: true })));

    process.on('exit', handler.bind(null, { clean: true }));
}