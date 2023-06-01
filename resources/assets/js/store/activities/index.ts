import { createStore, Commit } from 'vuex';

interface StateInterface {
  selectedActivities: number[];
  bulkPublishLength: number;
  cancelUpload: boolean;
  maximizeXls: boolean;
}

const state = {
  selectedActivities: [],
  bulkPublishLength: 0,
  cancelUpload: false,
  maximizeXls: true,
};

const mutations = {
  mutateSelectedActivities: function (
    state: StateInterface,
    payload: number[]
  ) {
    state.selectedActivities = payload;
  },
  mutateBulkPublishLength: function (state: StateInterface, payload: number) {
    state.bulkPublishLength = payload;
  },
  mutateCancelUpload: function (state: StateInterface, payload: boolean) {
    state.cancelUpload = payload;
  },
  mutateMaximizeXls: function (state: StateInterface, payload: boolean) {
    state.maximizeXls = payload;
  },
};

interface CommitFunction {
  commit: Commit;
}

const actions = {
  updateSelectedActivities: function (
    { commit }: CommitFunction,
    payload: number[]
  ) {
    commit('mutateSelectedActivities', payload);
  },
  updateBulkPublishLength: function (
    { commit }: CommitFunction,
    payload: number[]
  ) {
    commit('mutateBulkPublishLength', payload);
  },
  updateCancelUpload: function ({ commit }: CommitFunction, payload: number[]) {
    commit('mutateCancelUpload', payload);
  },
  updateMaximizeXls: function ({ commit }: CommitFunction, payload: number[]) {
    commit('mutateMaximizeXls', payload);
  },
};

const activityListStore = createStore({
  state,
  mutations,
  actions,
});

export function useStore() {
  return activityListStore;
}
