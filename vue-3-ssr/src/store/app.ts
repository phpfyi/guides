import { Store } from "@/store";

export interface AppState extends Object {
    fetching: boolean
}

class AppStore extends Store<AppState> {
    protected hydrate(state: object): any {
        return (state as any).app || this.data();
    }

    protected data(): AppState {
        return {
            fetching: false,
        };
    }

    set fetching(fetching: boolean) {
        this.state.fetching = fetching;
    }
}
export const appStore: AppStore = new AppStore()