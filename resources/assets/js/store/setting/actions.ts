import { ActionTree, ActionContext } from 'vuex';
import { State } from './state';
import { MutationTypes, Mutations } from './mutation';

export enum ActionTypes {
  UPDATE_PUBLISHING_FORM = 'UPDATE_PUBLISHING_FORM',
  UPDATE_PUBLISHER_INFO = 'UPDATE_PUBLISHER_INFO',
  UPDATE_PUBLISHING_ERROR = 'UPDATE_PUBLISHING_ERROR',
  UPDATE_DEFAULT_VALUES = 'UPDATE_DEFAULT_VALUES',
  UPDATE_DEFAULT_ERROR = 'UPDATE_DEFAULT_ERROR',
  UPDATE_IS_LOADING = 'UPDATE_IS_LOADING',
}

type AugmentedActionContext = {
  commit<K extends keyof Mutations>(
    key: K,
    payload: Parameters<Mutations[K]>[1]
  ): ReturnType<Mutations[K]>;
} & Omit<ActionContext<State, State>, 'commit'>;

export interface Actions {
  [ActionTypes.UPDATE_PUBLISHING_FORM](
    { commit }: AugmentedActionContext,
    payload: object
  ): void;

  [ActionTypes.UPDATE_PUBLISHER_INFO](
    { commit }: AugmentedActionContext,
    payload: object
  ): void;

  [ActionTypes.UPDATE_PUBLISHING_ERROR](
    { commit }: AugmentedActionContext,
    payload: object
  ): void;

  [ActionTypes.UPDATE_DEFAULT_VALUES](
    { commit }: AugmentedActionContext,
    payload: object
  ): void;

  [ActionTypes.UPDATE_DEFAULT_ERROR](
    { commit }: AugmentedActionContext,
    payload: object
  ): void;
  [ActionTypes.UPDATE_IS_LOADING](
    { commit }: AugmentedActionContext,
    payload: object
  ): void;
}

export const actions: ActionTree<State, State> = {
  [ActionTypes.UPDATE_PUBLISHING_FORM]({ commit }, payload) {
    commit(MutationTypes.UPDATE_PUBLISHING_FORM, payload);
  },

  [ActionTypes.UPDATE_PUBLISHER_INFO]({ commit }, payload) {
    commit(MutationTypes.UPDATE_PUBLISHER_INFO, payload);
  },

  [ActionTypes.UPDATE_PUBLISHING_ERROR]({ commit }, payload) {
    commit(MutationTypes.UPDATE_PUBLISHING_ERROR, payload);
  },

  [ActionTypes.UPDATE_DEFAULT_VALUES]({ commit }, payload) {
    commit(MutationTypes.UPDATE_DEFAULT_VALUES, payload);
  },

  [ActionTypes.UPDATE_DEFAULT_ERROR]({ commit }, payload) {
    commit(MutationTypes.UPDATE_DEFAULT_ERROR, payload);
  },
  [ActionTypes.UPDATE_IS_LOADING]({ commit }, payload) {
    commit(MutationTypes.IS_LOADING, payload);
  },
};
