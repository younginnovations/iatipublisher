<template>
  <button class="button primary-btn relative font-bold" @click="toggle">
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
  <!-- <CreateActivityModal :modalActive="modelVisible" @close="toggleModel(false)"></CreateActivityModal> -->
  <Model :modalActive="modelVisible" @close="toggleModel(false)">
    <h5 class="title mb-5 flex text-2xl font-bold text-bluecoral">
      Add a title and identifier for the activity
    </h5>
    <form action="/activities" method="POST" class="flex space-x-3">
      <input type="hidden" name="_token" :value="csrf()" />
      <div>
        <div class="form-group-title-container">
          <HoverText
            :name="'title'"
            :hover_text="'Help text'"
            position="left"
          ></HoverText>
          <p class="form-group-title">title</p>
        </div>
        <div class="form-group">
          <div class="form__content">
            <div>
              <div class="flex items-center justify-between">
                <div class="flex flex-1 flex-col">
                  <label class="form-group-title" for="narrative"
                    >Title narrative
                    <span class="text-salmon-40"> *</span></label
                  >
                  <HoverText
                    :name="'test'"
                    :hover_text="'UNFPA Angola Improved national population data systems to map and address inequalities; to advance the achievement of the Sustainable Development Goals and the commitments of the Programme of Action of the International Conference on Population and Development'"
                    :link="'https://google.com'"
                  ></HoverText>

                  <input
                    type="text"
                    name="narrative"
                    id="narrative"
                    class="error__input form__input"
                  />
                </div>
              </div>
              <div class="flex items-center justify-between">
                <div class="flex flex-1 flex-col">
                  <label class="form-group-title" for="language"
                    >Title language
                    <span class="text-salmon-40"> *</span></label
                  >
                  <HoverText
                    :name="'test'"
                    :hover_text="'UNFPA Angola Improved national population data systems to map and address inequalities; to advance the achievement of the Sustainable Development Goals and the commitments of the Programme of Action of the International Conference on Population and Development'"
                    :link="'https://google.com'"
                  ></HoverText>

                  <input
                    type="text"
                    name="language"
                    id="language"
                    class="error__input form__input"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form__content">
            <div class="flex items-center justify-between">
              <div class="flex flex-1 flex-col">
                <label class="form-group-title" for="activity_identifier"
                  >activity identifier <span class="text-salmon-40"> *</span>
                </label>
                <HoverText
                  :name="'test'"
                  :hover_text="'UNFPA Angola Improved national population data systems to map and address inequalities; to advance the achievement of the Sustainable Development Goals and the commitments of the Programme of Action of the International Conference on Population and Development'"
                  :link="'https://google.com'"
                ></HoverText>

                <input
                  type="text"
                  name="activity_identifier"
                  id="activity_identifier"
                  class="error__input form__input"
                />
              </div>
            </div>
            <div class="flex items-center justify-between">
              <div class="flex flex-1 flex-col">
                <label class="form-group-title" for="iati_identifier_text"
                  >iati-identifier <span class="text-salmon-40"> *</span></label
                >
                <HoverText
                  :name="'test'"
                  :hover_text="'UNFPA Angola Improved national population data systems to map and address inequalities; to advance the achievement of the Sustainable Development Goals and the commitments of the Programme of Action of the International Conference on Population and Development'"
                  :link="'https://google.com'"
                ></HoverText>

                <input
                  type="text"
                  name="iati_identifier_text"
                  id="iati_identifier_text"
                  class="error__input form__input"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-8 flex justify-end">
        <div class="inline-flex">
          <BtnComponent class="bg-white px-6 uppercase" text="Cancel" />
          <BtnComponent class="space" type="primary" text="Save" />
        </div>
      </div>
    </form>
  </Model>
</template>

<script lang="ts">
import { reactive, defineComponent, ref } from 'vue';
import Model from '../../../components/PopupModal.vue';
import HoverText from '../../../components/HoverText.vue';
import CreateActivityModal from './CreateActivityModal.vue';

export default defineComponent({
  name: 'add-activity-button',
  components: { Model, HoverText },
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

    const toggle = () => {
      state.isVisible = !state.isVisible;
    };

    return { state, liClass, toggle, modelVisible, toggleModel, csrf };
  },
});
</script>
