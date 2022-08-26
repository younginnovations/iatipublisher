import { createStore, Commit } from 'vuex';

const state = {
  unPublished: false,
  showPublished: false,
  publishErrors: [],
};

type State = typeof state;

const mutations = {
  mutateUnPublished: function (state: State, payload: boolean) {
    state.unPublished = payload;
  },
  mutateShowPublished: function (state: State, payload: boolean) {
    state.showPublished = payload;
  },
  mutatePublishErrors: function (state: State, payload: []) {
    state.publishErrors = payload;
  },
};

interface CommitFunction {
  commit: Commit;
}

const actions = {
  updateUnPublished: function ({ commit }: CommitFunction, payload: boolean) {
    commit('mutateUnPublished', payload);
  },
  updateShowPublished: function ({ commit }: CommitFunction, payload: boolean) {
    commit('mutateShowPublished', payload);
  },
  updatePublishErrors: function ({ commit }: CommitFunction, payload: []) {
    commit('mutatePublishErrors', payload);
  },
};

const activityDetailStore = createStore({
  state,
  mutations,
  actions,
});

export function useStore() {
  return activityDetailStore;
}
