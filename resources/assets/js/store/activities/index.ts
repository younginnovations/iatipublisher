import { createStore, Commit } from 'vuex';

interface StateInterface {
  selectedActivities: number[];
  bulkPublishLength: number;
  cancelUpload: boolean;
  maximizeXls: boolean;
  startXlsDownload: boolean;
  completeXlsDownload: boolean;
  cancelDownload: boolean;
  closeXlsModel: boolean;
}

const state = {
  selectedActivities: [],
  bulkPublishLength: 0,
  cancelUpload: false,
  maximizeXls: true,
  startXlsDownload: false,
  completeXlsDownload: false,
  cancelDownload: false,
  closeXlsModel: false,
};

const mutations = {
  mutateSelectedActivities: function (
    state: StateInterface,
    payload: number[]
  ) {
    state.selectedActivities = payload;
  },
  mutateCloseXlsModel: function (state: StateInterface, payload: boolean) {
    state.closeXlsModel = payload;
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
  mutateStartXlsDownload: function (state: StateInterface, payload: boolean) {
    state.startXlsDownload = payload;
  },
  mutateCompleteXlsDownload: function (
    state: StateInterface,
    payload: boolean
  ) {
    state.completeXlsDownload = payload;
  },
  mutateCancelDownload: function (state: StateInterface, payload: boolean) {
    state.cancelDownload = payload;
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
  updateCloseXlsModel: function ({ commit }: CommitFunction, payload: boolean) {
    commit('mutateCloseXlsModel', payload);
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
  updateStartXlsDownload: function (
    { commit }: CommitFunction,
    payload: boolean
  ) {
    commit('mutateStartXlsDownload', payload);
  },
  updateCompleteXlsDownload: function (
    { commit }: CommitFunction,
    payload: boolean
  ) {
    commit('mutateCompleteXlsDownload', payload);
  },
  updateCancelDownload: function (
    { commit }: CommitFunction,
    payload: boolean
  ) {
    commit('mutateCancelDownload', payload);
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
