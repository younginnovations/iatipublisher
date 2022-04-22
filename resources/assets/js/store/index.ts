import {
  createStore,
  CommitOptions,
  DispatchOptions,
  Store as VuexStore,
} from 'vuex';
import { State, state } from './setting/state';
import { Mutations, mutations } from './setting/mutation';
import { Actions, actions } from './setting/actions';

export const store = createStore({
  state,
  mutations,
  actions,
});

export type Store = Omit<
  VuexStore<State>,
  'commit' | 'dispatch'
> & {
  commit<K extends keyof Mutations, P extends Parameters<Mutations[K]>[1]>(
    key: K,
    payload: P,
    options?: CommitOptions
  ): ReturnType<Mutations[K]>
} & {
  dispatch<K extends keyof Actions>(
    key: K,
    payload: Parameters<Actions[K]>[1],
    options?: DispatchOptions
  ): ReturnType<Actions[K]>
}

export function useStore() {
  return store as Store;
}
