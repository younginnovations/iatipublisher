import { createStore, Commit } from 'vuex';

const state = {
  published: false,
  publishErrors: [],
};

type State = typeof state;

const mutations = {
  mutatePublishedState: function (state: State, payload: boolean) {
    state.published = payload;
  },
  mutatePublishErrors: function (state: State, payload: []) {
    state.publishErrors = payload;
  },
};

interface CommitFunction {
  commit: Commit;
}

const actions = {
  updatePublishedState: function (
    { commit }: CommitFunction,
    payload: boolean
  ) {
    commit('mutatePublishedState', payload);
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
