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
  bulkpublishActivities: object;
  startBulkPublish: boolean;
}

const state = {
  selectedActivities: [],
  bulkPublishLength: 0,
  cancelUpload: false,
  startBulkPublish: false,
  maximizeXls: true,
  startXlsDownload: false,
  completeXlsDownload: false,
  cancelDownload: false,
  closeXlsModel: false,
  bulkpublishActivities: {
    publishingActivities: {
      activities: { activity_id: 0, activity_title: '', status: '' },
      organization_id: 0,
      job_batch_uuid: '',
      status: '',
      message: '',
    },
  },
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
  mutateBulkpublishActivities: function (
    state: StateInterface,
    payload: object
  ) {
    state.bulkpublishActivities = payload;
  },
  mutateStartBulkPublish: function (state: StateInterface, payload: boolean) {
    state.startBulkPublish = payload;
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
  updateCancelUpload: function ({ commit }: CommitFunction, payload: boolean) {
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
  updateBulkpublishActivities: function (
    { commit }: CommitFunction,
    payload: object
  ) {
    commit('mutateBulkpublishActivities', payload);
  },
  updateStartBulkPublish: function (
    { commit }: CommitFunction,
    payload: boolean
  ) {
    commit('mutateStartBulkPublish', payload);
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
