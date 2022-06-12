<template>
  <!--====================
        Add Activity Modal
    ========================-->
  <Modal :modal-active="props.modalValue">
    <Loader v-if="loaderVisibility" />

    <h5 class="title mb-5 flex text-2xl font-bold text-bluecoral">
      Add a title and identifier for the activity
    </h5>
    <div class="overflow-hidden">
      <div class="input__field">
        <div class="mb-5">
          <div class="form-group-title-container">
            <HoverText
              :name="'title'"
              hover-text="A short, human-readable title. <a href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/' target='_blank'>For more information</a>"
              position="right"
            />
            <p class="form-group-title">
              title
            </p>
          </div>
          <div class="form-group">
            <div class="form__content">
              <div>
                <div class="label-field">
                  <label class="label" for="narrative"
                    >narrative
                    <span class="text-salmon-40"> *</span>
                  </label>
                  <HoverText
                    :name="'narrative'"
                    hover-text="The free text name or description of the item being described. This can be repeated in multiple languages. <a href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/narrative/' target='_blank'>For more information</a>"
                  />
                </div>
                <input
                  v-model="formData.narrative"
                  class="form__input"
                  :class="{
                    error__input: errorData.narrative != '',
                  }"
                  type="text"
                  placeholder="Type narrative here"
                >
                <span
                  v-if="errorData.narrative != ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData.narrative }}
                </span>
              </div>
              <div>
                <div class="label-field">
                  <label class="label" for=""
                    >@xml: lang
                    <span class="text-salmon-40"> *</span>
                  </label>
                  <HoverText
                    name="@xml:lang"
                    hover-text="A code specifying the language of text in this element. It is recommended that wherever possible only codes from ISO 639-1 are used. If not present, the default language is assumed. <a href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/title/narrative/' target='_blank'>For more information</a>"
                  />
                </div>

                <Multiselect
                  v-model="formData.language"
                  class="vue__select"
                  :class="{
                    error__input: errorData.language != '',
                  }"
                  :searchable="true"
                  :options="languages"
                  placeholder="Select @xml:lang"
                />

                <span
                  v-if="errorData.language != ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData.language }}
                </span>

                <span
                  v-else
                  class="text-xs font-normal text-n-40"
                >If no value is selected, default value is assumed.
                </span>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="form-group-title-container">
            <HoverText
              :name="'iati-identifier'"
              position="right"
              hover-text="A globally unique identifier for the activity.<br><br>This MUST be prefixed with EITHER the current IATI organisation identifier for the reporting organisation (reporting-org/@ref) OR a previous identifier reported in other-identifier, and suffixed with the organisation’s own activity identifier. The prefix and the suffix should be separated by a hyphen “-“.<br><br>Once an activity has been reported to IATI its identifier MUST NOT be changed in subsequent updates. <a href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/iati-identifier/' target='_blank'>For more information</a>"
            />
            <p class="form-group-title">
              iati-identifier
            </p>
          </div>
          <div class="form-group">
            <div class="form__content">
              <div>
                <div class="label-field">
                  <label class="label" for=""
                    >activity identifier
                    <span class="text-salmon-40"> *</span>
                  </label>
                </div>
                <input
                  v-model="formData.activity_identifier"
                  class="form__input"
                  :class="{
                    error__input: errorData.activity_identifier != '',
                  }"
                  type="text"
                  placeholder="Type activity-identifier here"
                >
                <span
                  v-if="errorData.activity_identifier != ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData.activity_identifier }}
                </span>
                <span
                  v-else
                  class="text-xs font-normal text-n-40"
                >Enter your own unique activity identifier such as
                  abbreviation or simply a number. Make sure it is unique across
                  all the activities. IATI Publisher will concatenate
                  Organization Identifier and Activity Identifier to
                  autogenerate 'iati-identifier'.
                </span>
              </div>
              <div>
                <div class="label-field">
                  <label class="label" for=""
                    >iati-identifier
                    <span class="text-salmon-40"> *</span>
                  </label>
                </div>
                <input
                  class="form__input"
                  type="text"
                  placeholder=""
                  :value="
                    formData.activity_identifier
                      ? organization.identifier +
                        '-' +
                        formData.activity_identifier
                      : ''
                  "
                  disabled="disabled"
                >

                <span
                  v-if="errorData.iati_identifier_text != ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData.iati_identifier_text }}
                </span>

                <span
                  v-else
                  class="text-xs font-normal text-n-40"
                >This is autogenerated
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-8 flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="mx-3 bg-white px-3 uppercase"
              text="Cancel"
              @click="closeModal"
            />
            <BtnComponent
              class="space"
              type="primary"
              text="Save"
              @click="storeActivity()"
            />
          </div>
        </div>
      </div>
    </div>
  </Modal>
</template>

<script lang="ts">
import { defineComponent, reactive, ref, onMounted } from 'vue';
import Modal from '../../components/PopupModal.vue';
import BtnComponent from '../../components/ButtonComponent.vue';
import Multiselect from '@vueform/multiselect';
import HoverText from '../../components/HoverText.vue';
import Loader from '../../components/Loader.vue';
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
    });

    const errorData = reactive({
      narrative: '',
      language: '',
      activity_identifier: '',
    });

    const loaderVisibility = ref(false);

    const languages = reactive({});
    const organization = reactive({});

    onMounted(async () => {
      axios.get('/activity/codelists').then((res) => {
        const response = res.data;
        Object.assign(languages, response.data.languages);
        Object.assign(organization, response.data.organization);
      });
    });

    function closeModal() {
      emit('closeModal');
    }

    function storeActivity() {
      loaderVisibility.value = true;

      axios
        .post('/activities', formData)
        .then((res) => {
          const response = res.data;
          loaderVisibility.value = false;

          if (response.success) {
            emit('toast', response.message, response.success);
            emit('closeModal');
            window.location.href = `/activities/${response.data.id}`;
          }
        })
        .catch((error) => {
          const { errors } = error.response.data;

          errorData.narrative = errors.narrative ? errors.narrative[0] : '';
          errorData.language = errors.language ? errors.language[0] : '';
          errorData.activity_identifier = errors.activity_identifier
            ? errors.activity_identifier[0]
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
      organization,
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

    .label-field {
      @apply mb-2 flex items-center justify-between;
    }
  }
}
.form-group-title-container {
  @apply mb-1.5 flex space-x-1;
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
