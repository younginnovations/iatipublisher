import { MutationTree } from 'vuex';
import { State, state as SettingState } from './state';

export enum MutationTypes {
  UPDATE_PUBLISHING_FORM = 'UPDATE_PUBLISHING_FORM',
  UPDATE_PUBLISHER_INFO = 'UPDATE_PUBLISHER_INFO',
  UPDATE_PUBLISHING_ERROR = 'UPDATE_PUBLISHING_ERROR',
  UPDATE_DEFAULT_VALUES = 'UPDATE_DEFAULT_VALUES',
  UPDATE_DEFAULT_ERROR = 'UPDATE_DEFAULT_ERROR',
  IS_LOADING = 'IS_LOADING',
}

export type Mutations<S = State> = {
  [MutationTypes.UPDATE_PUBLISHING_FORM](state: S, payload: object): void;
  [MutationTypes.UPDATE_PUBLISHER_INFO](state: S, payload: object): void;
  [MutationTypes.UPDATE_DEFAULT_VALUES](state: S, payload: object): void;
  [MutationTypes.UPDATE_PUBLISHING_ERROR](state: S, payload: object): void;
  [MutationTypes.UPDATE_DEFAULT_ERROR](state: S, payload: object): void;
  [MutationTypes.IS_LOADING](state: S, payload: object): void;
};

interface PayloadPublishingForm {
  key: keyof typeof SettingState.publishingForm;
  value: string;
}

interface PayloadPublisherInfo {
  key: keyof typeof SettingState.publishingInfo;
  value: boolean;
}

interface PayloadDefaultForm {
  key: keyof typeof SettingState.defaultForm;
  value: string;
}

interface PayloadPublisherError {
  key: keyof typeof SettingState.publishingError;
  value: string;
}

interface PayloadDefaultError {
  key: keyof typeof SettingState.defaultError;
  value: string;
}

export const mutations: MutationTree<State> & Mutations = {
  [MutationTypes.UPDATE_PUBLISHING_FORM](
    state,
    payload: PayloadPublishingForm
  ) {
    state.publishingForm[payload.key] = payload.value;
  },
  [MutationTypes.UPDATE_PUBLISHER_INFO](state, payload: PayloadPublisherInfo) {
    state.publishingInfo[payload.key] = payload.value;
  },
  [MutationTypes.UPDATE_DEFAULT_VALUES](state, payload: PayloadDefaultForm) {
    state.defaultForm[payload.key] = payload.value;
  },
  [MutationTypes.UPDATE_PUBLISHING_ERROR](
    state,
    payload: PayloadPublisherError
  ) {
    state.publishingError[payload.key] = payload.value;
  },
  [MutationTypes.UPDATE_DEFAULT_ERROR](state, payload: PayloadDefaultError) {
    state.defaultError[payload.key] = payload.value;
  },
  [MutationTypes.IS_LOADING](state, payload: PayloadDefaultError) {
    state.defaultError[payload.key] = payload.value;
  },
};
