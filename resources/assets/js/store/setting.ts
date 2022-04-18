import { createStore } from 'vuex';

const state= {
    publishingForm: {
      publisher_id: 'a',
      api_token: 'b',
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
    updatePublisherInfo(state: any, key:string, value:string) {
      state.setting.publishingForm[key] = value;
    },
    updateDefaultForm(state: any, key:string, value:string) {
      state.setting.defaultForm[key] = value;
    },
    updatePublisherError(state: any, key:string, value:string) {
      state.setting.publishingError[key] = value;
    },
    updateDefaultError(state: any, key:string, value:string) {
      state.setting.defaultError[key] = value;
    }
  };

  const mutations = {

  };

export default {
  namespaced : true,
  state,
  actions,
  mutations,
}


