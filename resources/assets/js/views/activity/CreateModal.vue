<template>
  <!--====================
        Add Activity Modal
    ========================-->
  <Modal :modal-active="props.modalValue">
    <Loader v-if="loaderVisibility" />

    <h5 class="title mb-5 flex text-xl font-bold text-bluecoral sm:text-2xl">
      {{
        translate.textFromKey('activities.add_a_tittle_and_identifier_label')
      }}
    </h5>
    <div class="manual-import overflow-hidden">
      <div class="input__field">
        <div class="mb-5">
          <div class="form-group-title-container">
            <HoverText
              :name="translate.element('title')"
              :hover-text="
                translate.textFromKey('elements.activities.title.hover_text')
              "
              position="right"
              :show-iati-reference="true"
            />
            <p class="form-group-title">
              {{ translate.element('title') }}
            </p>
          </div>
          <div class="form-group">
            <div class="form__content gap-6">
              <div>
                <div class="label-field">
                  <label class="label" for="narrative"
                    >{{ translate.element('narrative') }}
                    <span class="required-icon"> *</span>
                  </label>
                  <HoverText
                    :name="translate.element('narrative')"
                    :hover-text="
                      translate.textFromKey(
                        'elements.activities.title.narrative.hover_text'
                      )
                    "
                    :show-iati-reference="true"
                  />
                </div>
                <input
                  v-model="formData.narrative"
                  class="form__input"
                  :class="{
                    error__input: errorData.narrative != '',
                  }"
                  type="text"
                  :placeholder="translate.element('type_narrative_here')"
                />
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
                    >{{ translate.element('language') }}
                    <span class="required-icon"> *</span>
                  </label>
                  <HoverText
                    :name="translate.element('language')"
                    :hover-text="
                      translate.element(
                        'a_code_specifying_text_org_document_link_title_narrative'
                      )
                    "
                    :show-iati-reference="true"
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
                  :placeholder="translate.element('select_language')"
                />

                <span
                  v-if="errorData.language != ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData.language }}
                </span>

                <span v-else class="text-xs font-normal text-n-40"
                  >{{
                    translate.element('your_default_language_assumed_no_that')
                  }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <div>
          <div class="form-group-title-container">
            <HoverText
              :name="translate.element('iati_identifier')"
              position="right"
              :hover-text="
                translate.textFromKey(
                  'elements.activities.iati_identifier.hover_text'
                )
              "
              :show-iati-reference="true"
            />
            <p class="form-group-title">
              {{ translate.element('iati_identifier') }}
            </p>
          </div>
          <div class="form-group">
            <div class="form__content">
              <div>
                <div class="label-field">
                  <label class="label" for=""
                    >{{ translate.element('activity_identifier') }}
                    <span class="required-icon"> *</span>
                  </label>
                </div>
                <input
                  v-model="formData.activity_identifier"
                  class="form__input"
                  :class="{
                    error__input: errorData.activity_identifier != '',
                  }"
                  type="text"
                  :placeholder="translate.element('type_identifier_here')"
                />
                <span
                  v-if="errorData.activity_identifier != ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData.activity_identifier }}
                </span>
                <span v-else class="text-xs font-normal text-n-40"
                  >{{
                    translate.textFromKey(
                      'elements.activities.activity_identifier.shorter_help_text'
                    )
                  }}
                </span>
              </div>
              <div>
                <div class="label-field">
                  <label class="label" for=""
                    >{{ translate.element('iati_identifier') }}
                    <span class="required-icon"> *</span>
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
                  disabled="true"
                />

                <span
                  v-if="errorData.iati_identifier_text != ''"
                  class="error"
                  role="alert"
                >
                  {{ errorData.iati_identifier_text }}
                </span>

                <span v-else class="text-xs font-normal text-n-40"
                  >{{ translate.commonText('this_is_autogenerated') }}
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-8 flex justify-end">
          <div class="inline-flex">
            <BtnComponent
              class="mx-3 bg-white px-3 uppercase"
              type=""
              :text="translate.button('cancel')"
              @click="closeModal"
            />
            <BtnComponent
              class="space"
              type="primary"
              :text="translate.button('save')"
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
import { Translate } from 'Composable/translationHelper';

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
    interface ObjectType {
      [key: string]: string;
    }

    const translate = new Translate();
    const formData: ObjectType = reactive({
      narrative: '',
      language: '',
      activity_identifier: '',
    });

    const errorData: ObjectType = reactive({
      narrative: '',
      language: '',
      activity_identifier: '',
    });

    const loaderVisibility = ref(false);

    const languages = reactive({});
    const organization: ObjectType = reactive({});

    onMounted(async () => {
      axios.get('/activities/codelists').then((res) => {
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
        .post('/activity', formData)
        .then((res) => {
          const response = res.data;
          loaderVisibility.value = false;

          if (response.success) {
            emit('closeModal');
            window.location.href = `/activity/${response.data.id}`;
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
      translate,
    };
  },
});
</script>

<style lang="scss" scoped>
.form-group {
  @apply rounded-lg border border-n-20 p-5;

  &:last-child {
    margin-bottom: 0;
  }

  .form__content {
    margin-top: 0;
    gap: 25px;

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
</style>
