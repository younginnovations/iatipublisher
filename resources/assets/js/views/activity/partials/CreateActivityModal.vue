<template>
  <!--====================
        Add Activity Modal
    ========================-->
  <Modal :modalActive="props.modalValue">
    <Loader v-if="loaderVisibility"></Loader>

    <h5 class="title mb-5 flex text-2xl font-bold text-bluecoral">
      Add a title and identifier for the activity
    </h5>
    <div>
      <form class="input__field">
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
                  <label class="label" for="narrative"
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
                  :class="
                    errorData.narrative != ''
                      ? 'error__input form__input'
                      : 'form__input'
                  "
                  type="text"
                  placeholder="Enter an activity title"
                  v-model="formData.narrative"
                />
                <span
                  class="error"
                  role="alert"
                  v-if="errorData.narrative != ''"
                >
                  {{ errorData.narrative }}
                </span>
                <span v-else class="text-xs font-normal text-n-40"
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
                  :class="
                    errorData.language != ''
                      ? 'error__input vue__select'
                      : 'vue__select'
                  "
                  :searchable="true"
                  :options="languages"
                  v-model="formData.language"
                />

                <span
                  class="error"
                  role="alert"
                  v-if="errorData.language != ''"
                >
                  {{ errorData.language }}
                </span>

                <span v-else class="text-xs font-normal text-n-40"
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
                <input
                  :class="
                    errorData.activity_identifier != ''
                      ? 'error__input form__input'
                      : 'form__input'
                  "
                  type="text"
                  placeholder="Unique activity identifier"
                  v-model="formData.activity_identifier"
                />
                <span
                  class="error"
                  role="alert"
                  v-if="errorData.activity_identifier != ''"
                >
                  {{ errorData.activity_identifier }}
                </span>
                <span v-else class="text-xs font-normal text-n-40"
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
                  :class="
                    errorData.iati_identifier_text != ''
                      ? 'error__input form__input'
                      : 'form__input'
                  "
                  type="text"
                  placeholder="Unique activity identifier"
                  v-model="formData.iati_identifier_text"
                />

                <span
                  class="error"
                  role="alert"
                  v-if="errorData.iati_identifier_text != ''"
                >
                  {{ errorData.iati_identifier_text }}
                </span>

                <span v-else class="text-xs font-normal text-n-40"
                  >This is a help text
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-8 flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="bg-white px-6 uppercase"
              @click="closeModal"
              text="Cancel"
            />
            <BtnComponent
              class="space"
              type="primary"
              @click="storeActivity()"
              text="Save"
            />
          </div>
        </div>
      </form>
    </div>
  </Modal>
</template>

<script lang="ts">
import { defineComponent, reactive, ref, onMounted } from 'vue';
import Modal from '../../../components/PopupModal.vue';
import BtnComponent from '../../../components/ButtonComponent.vue';
import Multiselect from '@vueform/multiselect';
import HoverText from '../../../components/HoverText.vue';
import Loader from '../../../components/Loader.vue';
import axios from 'axios';

export default defineComponent({
  components: {
    Modal,
    BtnComponent,
    HoverText,
    Multiselect,
    Loader,
  },
  props: {
    modalValue: {
      type: Boolean,
      required: false,
    },
  },
  emits: ['closeModal', 'toast'],
  setup(props, { emit }) {
    const formData = reactive({
      narrative: '',
      language: '',
      activity_identifier: '',
      iati_identifier_text: '',
    });

    const errorData = reactive({
      narrative: '',
      language: '',
      activity_identifier: '',
      iati_identifier_text: '',
    });

    const loaderVisibility = ref(false);

    const languages = reactive({});

    onMounted(async () => {
      axios
        .get('api/languages')
        .then((res) => {
          console.log(res);
          const response = res.data;
          Object.assign(languages, response.data);
        })
        .catch((error) => {
          const { errors } = error.response.data;
        });
    });

    function closeModal() {
      emit('closeModal');
    }

    function storeActivity() {
      axios
        .post('api/activity', formData)
        .then((res) => {
          const response = res.data;
          loaderVisibility.value = false;
          emit('closeModal');
          emit('toast', response.message, response.type);
          loaderVisibility.value = false;
        })
        .catch((error) => {
          const { errors } = error.response.data;

          errorData.narrative = errors.narrative ? errors.narrative[0] : '';
          errorData.language = errors.language ? errors.language[0] : '';
          errorData.activity_identifier = errors.activity_identifier
            ? errors.activity_identifier[0]
            : '';
          errorData.iati_identifier_text = errors.iati_identifier_text
            ? errors.iati_identifier_text[0]
            : '';

          loaderVisibility.value = false;
        });
    }

    return {
      props,
      formData,
      errorData,
      loaderVisibility,
      languages,
      closeModal,
      storeActivity,
    };
  },
});
</script>

<style lang="scss">
.form-group {
  @apply rounded-lg border border-n-20 p-5;

  &:last-child {
    margin-bottom: 0;
  }

  .form__content {
    margin-top: 0;
  }
}
.form-group-title-container {
  @apply mb-1 flex space-x-1;
}
.form-group-title {
  @apply text-xs font-bold text-bluecoral;
}
.search {
  position: relative;

  &__input {
    @apply mr-3.5 border border-n-30 bg-transparent outline-none;
    border-radius: 20px;
    padding: 10px 42px 10px 34px;
  }
}
</style>
