import { reactive, readonly } from 'vue';
import { isSSR } from '@/helpers'

export abstract class Store<T extends Object> {
    protected state: T;

    constructor() {
        const data = isSSR()
            ? this.data()
            : this.hydrate((window as any).__STATE__ || {});

        this.state = reactive(data) as T;
    }

    protected abstract hydrate(state: object): T

    protected abstract data(): T

    public getState(): T {
        return readonly(this.state) as T
    }
}