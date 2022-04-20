import { MutationTree } from 'vuex';

const state = {
  publishingForm: {
    publisher_id: '',
    api_token: '',
  },
  defaultForm: {
    default_currency: '',
    default_language: '',
    hierarchy: '',
    linked_data_url: '',
    humanitarian: 'no',
  },
  publishingError: {
    publisher_id: '',
    api_token: '',
  },
  defaultError: {
    default_currency: '',
    default_language: '',
    hierarchy: '',
    linked_data_url: '',
    humanitarian: '',
  },
};

const actions = {
  updatePublisherInfo({ commit }, payload: Object) {
    commit('updatePublisherInfo', payload);
  },

  updatePublishingError({ commit }, payload: Object) {
    commit('updatePublishingError', payload);
  },

  updateDefaultError({ commit }, payload: Object) {
    commit('updateDefaultError', payload);
  },

  updateDefaultForm({ commit }, payload: Object) {
    commit('updateDefaultForm', payload);
  },
};

const mutations = {
  updatePublisherInfo(state: any, payload: Object) {
    state.publishingForm[payload.key] = payload.value;
  },
  updateDefaultForm(state: any, payload: Object) {
    state.defaultForm[payload.key] = payload.value;
  },
  updatePublishingError(state: any, payload: Object) {
    state.publishingError[payload.key] = payload.value;
  },
  updateDefaultError(state: any, payload: Object) {
    state.defaultError[payload.key] = payload.value;
  }
};

export default {
  namespaced: true,
  state,
  actions,
  mutations,
};


