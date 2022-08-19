import { createStore, Commit } from 'vuex';

interface StateInterface {
  selectedActivities: number[];
}

const state = {
  selectedActivities: [],
};

const mutations = {
  mutateSelectedActivities: function (
    state: StateInterface,
    payload: number[]
  ) {
    state.selectedActivities = payload;
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
};

const activityListStore = createStore({
  state,
  mutations,
  actions,
});

export function useStore() {
  return activityListStore;
}
