<template>
  <button
    class="button primary-btn relative font-bold"
    @click="toggle"
    ref="dropdownBtn"
  >
    <svg-vue icon="plus"></svg-vue>
    <span>Add Activity</span>
    <div
      v-if="state.isVisible"
      class="button__dropdown absolute right-0 top-full z-10 w-48 bg-white p-2 text-left shadow-dropdown"
    >
      <ul>
        <li>
          <a href="#" @click="toggleModel(true)" :class="liClass"
            >Add activity manually</a
          >
        </li>
        <li><a href="#" :class="liClass">Upload activities from .xml</a></li>
        <li><a href="#" :class="liClass">Upload activities from .csv</a></li>
      </ul>
    </div>
  </button>
  <Model :modalActive="modelVisible" @close="toggleModel(false)">
    <form action="/activities" method="POST" class="flex space-x-3">
      <input type="hidden" name="_token" :value="csrf()" />
      <div class="grid">
        <div class="flex">
          <div class="flex flex-1 flex-col">
            <label for="narrative">Title narrative</label>
            <input type="text" name="narrative" id="narrative" class="border" />
          </div>
          <div class="flex flex-1 flex-col">
            <label for="language">Title language</label>
            <input type="text" name="language" id="language" class="border" />
          </div>
        </div>

        <div class="flex">
          <div class="flex flex-1 flex-col">
            <label for="activity_identifier">activity identifier</label>
            <input
              type="text"
              name="activity_identifier"
              id="activity_identifier"
              class="border"
            />
          </div>
          <div class="flex flex-1 flex-col">
            <label for="iati_identifier_text">iati-identifier</label>
            <input
              type="text"
              name="iati_identifier_text"
              id="iati_identifier_text"
              class="border"
            />
          </div>
        </div>
      </div>
      <button type="submit">submit</button>
    </form>
  </Model>
</template>

<script lang="ts">
import { reactive, defineComponent, ref, onMounted } from 'vue';
import Model from '../../../components/PopupModal.vue';

export default defineComponent({
  name: 'add-activity-button',
  components: { Model },
  setup() {
    const state = reactive({
      isVisible: false,
    });

    const csrf = () => {
      return document
        .querySelector('meta[name="csrf-token"]')!
        .getAttribute('content');
    };

    const modelVisible = ref(false);

    const toggleModel = (value: boolean) => {
      modelVisible.value = value;
    };

    const liClass =
      'block p-2.5 text-n-40 text-tiny leading-[1.5] font-bold hover:text-n-50 hover:bg-n-10';

    const dropdownBtn = ref();
    onMounted(() => {
      window.addEventListener('click', (e) => {
        if (!dropdownBtn.value.contains(e.target)) {
          state.isVisible = false;
        }
      });
    });

    const toggle = () => {
      state.isVisible = !state.isVisible;
    };

    return {
      state,
      liClass,
      toggle,
      modelVisible,
      toggleModel,
      csrf,
      dropdownBtn,
    };
  },
});
</script>
