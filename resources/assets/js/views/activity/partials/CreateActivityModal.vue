<template>
  <Modal @close="modalToggle" :modalActive="props.modalActive">
    <h5 class="title mb-5 flex text-2xl font-bold text-bluecoral">
      Add a title and identifier for the activity
    </h5>
    <div>
      <form>
        <div class="mb-5">
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
                  <label class="label" for=""
                    >narrative
                    <span class="text-salmon-40"> *</span>
                  </label>
                  <HoverText
                    :name="'test'"
                    :hover_text="'UNFPA Angola Improved national population data systems to map and address inequalities; to advance the achievement of the Sustainable Development Goals and the commitments of the Programme of Action of the International Conference on Population and Development'"
                    :link="'https://google.com'"
                  ></HoverText>
                </div>
                <input
                  class="error__input form__input"
                  type="text"
                  placeholder="Enter an activity title"
                />

                <span class="text-xs font-normal text-n-40"
                  >This is a help text
                </span>
              </div>
              <div>
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >@xml: lang
                    <span class="text-salmon-40"> *</span>
                  </label>
                  <HoverText
                    :name="'test'"
                    :hover_text="'lorem ipsum'"
                  ></HoverText>
                </div>

                <Multiselect
                  class="vue__select"
                  :searchable="true"
                  :options="{ one: 'one', two: 'two' }"
                />

                <span class="text-xs font-normal text-n-40"
                  >This is a help text
                </span>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="form-group-title-container">
            <HoverText
              :name="'title'"
              :hover_text="'Help text'"
              position="left"
            ></HoverText>
            <p class="form-group-title">iati-identifier</p>
          </div>
          <div class="form-group">
            <div class="form__content">
              <div>
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >activity identifier
                    <span class="text-salmon-40"> *</span>
                  </label>
                  <HoverText
                    :name="'test'"
                    :hover_text="'lorem ipsum'"
                  ></HoverText>
                </div>
                <Multiselect
                  class="vue__select"
                  :searchable="true"
                  :options="{ one: 'one', two: 'two' }"
                />

                <span class="text-xs font-normal text-n-40"
                  >This is a help text
                </span>
              </div>
              <div>
                <div class="flex items-center justify-between">
                  <label class="label" for=""
                    >iati-identifier
                    <span class="text-salmon-40"> *</span>
                  </label>
                  <HoverText
                    :name="'test'"
                    :hover_text="'lorem ipsum'"
                  ></HoverText>
                </div>
                <input
                  class="error__input form__input"
                  type="text"
                  placeholder="Unique activity identifier"
                />

                <span class="text-xs font-normal text-n-40"
                  >This is a help text
                </span>
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
    </div>
  </Modal>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
import Modal from '../../../components/PopupModal.vue';
import HoverText from '../../../components/HoverText.vue';

export default defineComponent({
  component: {
    Modal,
    HoverText,
  },
  props: {
    modalActive: Boolean,
  },
  setup(props) {
    return { props };
  },
});
</script>
