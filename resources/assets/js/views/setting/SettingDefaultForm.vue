<template>
  <div>
    <div class="registry__info">
      <div class="translate-text mb-4 text-sm font-bold text-n-50">
        {{ translate.textFromKey('settings.default_values.label') }}
      </div>
      <div class="mb-4 flex items-center text-xs text-n-50">
        <button>
          <HoverText
            :name="translate.textFromKey('settings.default_values.label')"
            :hover-text="
              translate.textFromKey('settings.default_values.hover_text')
            "
          />
        </button>
      </div>
    </div>
    <span class="translate-text text-sm font-bold text-n-50">{{
      translate.textFromKey('settings.default_for_all_data_label')
    }}</span>
    <div class="register mt-4 mb-6">
      <div class="register__container mb-0">
        <div>
          <div class="flex justify-between">
            <label for="default-currency translate-text">{{
              translate.textFromKey('settings.default_currency.label')
            }}</label>
            <button>
              <HoverText
                :name="translate.textFromKey('settings.default_currency.label')"
                :hover-text="
                  translate.textFromKey('settings.default_currency.hover_text')
                "
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-currency"
            v-model="defaultForm.default_currency"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :placeholder="
              translate.textFromKey('settings.default_currency.placeholder')
            "
            :options="props.currencies"
            :searchable="true"
            @click="updateStore('default_currency')"
          />
          <span v-if="defaultError.default_currency" class="error" role="alert">
            {{ defaultError.default_currency }}
          </span>

          <p v-if="!defaultError.default_currency" class="translate-text">
            {{ translate.textFromKey('settings.default_currency.help_text') }}
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="default-language" class="translate-text">{{
              translate.textFromKey('settings.default_language.label')
            }}</label>
            <button>
              <HoverText
                :name="translate.textFromKey('settings.default_language.label')"
                :hover-text="
                  translate.textFromKey('settings.default_language.hover_text')
                "
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-language"
            v-model="defaultForm.default_language"
            class="vue__select"
            :class="{
              error__input: defaultError.default_language,
            }"
            :disabled="userRole !== 'admin' ? true : false"
            :placeholder="
              translate.textFromKey('settings.default_language.placeholder')
            "
            :searchable="true"
            :options="props.languages"
            @click="updateStore('default_language')"
          />
          <span
            v-if="defaultError.default_language"
            class="error translate-text"
            role="alert"
          >
            {{ defaultError.default_language }}
          </span>

          <p v-if="!defaultError.default_language" class="translate-text">
            {{ translate.textFromKey('settings.default_language.help_text') }}
          </p>
        </div>
      </div>
    </div>
    <span class="translate-text text-sm font-bold text-n-50">{{
      translate.textFromKey('settings.default_for_activity_label')
    }}</span>
    <div class="register mt-4">
      <div class="register__container">
        <div>
          <div class="flex justify-between">
            <label for="default-hierarchy" class="translate-text">{{
              translate.textFromKey('settings.default_hierarchy.label')
            }}</label>
            <button>
              <HoverText
                width="w-64"
                :name="
                  translate.textFromKey('settings.default_hierarchy.label')
                "
                :hover-text="
                  translate.textFromKey('settings.default_hierarchy.hover_text')
                "
                :show-iati-reference="true"
              />
            </button>
          </div>
          <input
            id="default-hierarchy"
            v-model="defaultForm.hierarchy"
            :disabled="userRole !== 'admin' ? true : false"
            class="register__input mb-2"
            type="text"
            :placeholder="
              translate.textFromKey('settings.default_hierarchy.placeholder')
            "
            @input="updateStore('hierarchy')"
          />
          <span v-if="defaultError.hierarchy" class="error" role="alert">
            {{ defaultError.hierarchy }}
          </span>
          <p v-if="!defaultError.hierarchy" class="translate-text">
            {{ translate.textFromKey('settings.default_hierarchy.help_text') }}
          </p>
        </div>
        <!--  Default Hierarchy      -->
        <div>
          <div class="flex justify-between">
            <label for="budget-not-provided" class="translate-text">{{
              translate.textFromKey('settings.budget_not_provided.label')
            }}</label>

            <button>
              <HoverText
                width="w-72"
                :name="
                  translate.textFromKey('settings.budget_not_provided.label')
                "
                :hover-text="
                  translate.textFromKey(
                    'settings.budget_not_provided.hover_text'
                  )
                "
              />
            </button>
          </div>
          <Multiselect
            id="budget_not_provided"
            v-model="defaultForm.budget_not_provided"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{
              error__input: defaultError.budget_not_provided,
            }"
            :placeholder="
              translate.textFromKey('settings.budget_not_provided.placeholder')
            "
            :options="props.budgetNotProvided"
            :searchable="true"
            @click="updateStore('budget_not_provided')"
          />
          <span
            v-if="defaultError.budget_not_provided"
            class="error"
            role="alert"
          >
            {{ defaultError.budget_not_provided }}
          </span>
        </div>
        <!--  Budget Not Provided      -->
        <div>
          <div class="flex justify-between">
            <label for="humanitarian" class="translate-text">{{
              translate.textFromKey('settings.humanitarian.label')
            }}</label>

            <button>
              <HoverText
                width="w-72"
                :name="translate.textFromKey('settings.humanitarian.label')"
                :hover-text="
                  translate.textFromKey('settings.humanitarian.hover_text')
                "
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="humanitarian"
            v-model="defaultForm.humanitarian"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{
              error__input: defaultError.humanitarian,
            }"
            :placeholder="
              translate.textFromKey('settings.humanitarian.placeholder')
            "
            :options="props.humanitarian"
            :searchable="true"
            @click="updateStore('humanitarian')"
          />
          <span
            v-if="defaultError.humanitarian"
            class="error translate-text"
            role="alert"
          >
            {{ defaultError.humanitarian }}
          </span>
          <p v-if="!defaultError.humanitarian" class="translate-text">
            {{ translate.textFromKey('settings.humanitarian.help_text') }}
          </p>
        </div>
        <!--  Humanitarian      -->
        <div>
          <div class="flex justify-between">
            <label for="default-hierarchy" class="translate-text"
              >Linked Data URI</label
            >
            <button>
              <HoverText
                width="w-64"
                name="Linked Data URI"
                hover-text="If a publisher chooses to publish linked data about their IATI activities then allowing them to declare where this data is published would support discovery of it, and any additional information they may choose to publish as Linked Data alongside it."
                :show-iati-reference="true"
              />
            </button>
          </div>
          <input
            id="linked-data-uri"
            v-model="defaultForm.linked_data_uri"
            :disabled="userRole !== 'admin' ? true : false"
            class="register__input mb-2"
            type="text"
            placeholder="Type linked data uri here"
            @input="updateStore('linked_data_uri')"
          />
          <span v-if="defaultError.linked_data_uri" class="error" role="alert">
            {{ defaultError.linked_data_uri }}
          </span>
        </div>
        <!--  Linked Data Uri      -->
        <div>
          <div class="flex justify-between">
            <label for="default-collaboration-type" class="translate-text"
              >Default Collaboration Type</label
            >
            <button>
              <HoverText
                width="w-72"
                name="collaboration-type"
                hover-text="The type of collaboration involved in the activity’s disbursements, e.g. “bilateral” or “multilateral”.<a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/collaboration-type/'>For more information</a>"
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="collaboration-type"
            v-model="defaultForm.default_collaboration_type"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{
              error__input: defaultError.default_collaboration_type,
            }"
            placeholder="Select Collaboration Type here"
            :options="props.defaultCollaborationType"
            :searchable="true"
            @click="updateStore('default_collaboration_type')"
          />
          <span
            v-if="defaultError.default_collaboration_type"
            class="error"
            role="alert"
          >
            {{ defaultError.default_collaboration_type }}
          </span>
          <p
            v-if="!defaultError.default_collaboration_type"
            class="translate-text"
          >
            If selected, then default collaboration type will be automatically
            populated in activity when created.
          </p>
        </div>
        <!--  Default Collaboration Type  -->
        <div>
          <div class="flex justify-between">
            <label for="default-collaboration-type" class="translate-text"
              >Default Flow Type</label
            >
            <button>
              <HoverText
                width="w-72"
                name="default-flow-type"
                hover-text="Whether the activity is funded by Official Development Assistance (ODA), Other Official Flows (OOF), etc. <a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-flow-type/'>For more information</a>"
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-flow-type"
            v-model="defaultForm.default_flow_type"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{
              error__input: defaultError.default_flow_type,
            }"
            placeholder="Select Default Flow Type here"
            :options="props.defaultFlowType"
            :searchable="true"
            @click="updateStore('default_flow_type')"
          />
          <span
            v-if="defaultError.default_flow_type"
            class="error"
            role="alert"
          >
            {{ defaultError.default_flow_type }}
          </span>
          <p v-if="!defaultError.default_flow_type" class="translate-text">
            If selected, then default flow type will be automatically populated
            in activity when created.
          </p>
        </div>
        <!--  Default Flow Type  -->
        <div>
          <div class="flex justify-between">
            <label for="default-collaboration-type" class="translate-text"
              >Default Finance Type</label
            >
            <button>
              <HoverText
                width="w-72"
                name="default-finance-type"
                hover-text="The type of finance (e.g. grant, loan, debt relief, etc). This the default value for all transactions in the activity report; it can be overridden by individual transactions. <a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-finance-type/'>For more information</a>"
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-finance-type"
            v-model="defaultForm.default_finance_type"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{
              error__input: defaultError.default_finance_type,
            }"
            placeholder="Select Default Finance Type here"
            :options="props.defaultFinanceType"
            :searchable="true"
            @click="updateStore('default_finance_type')"
          />
          <span
            v-if="defaultError.default_finance_type"
            class="error"
            role="alert"
          >
            {{ defaultError.default_finance_type }}
          </span>
          <p v-if="!defaultError.default_finance_type" class="translate-text">
            If selected, then default finance type will be automatically
            populated in activity when created.
          </p>
        </div>
        <!--  Default Finance Type  -->
        <div>
          <div class="flex justify-between">
            <label for="default-collaboration-type" class="translate-text"
              >Default Aid Type</label
            >
            <button>
              <HoverText
                width="w-72"
                name="default-aid-type"
                hover-text="The type of aid being supplied (project-type intervention, budget support, debt relief, etc.). This element specifies a default for all the activity’s financial transactions; it can be overridden at the individual transaction level. <a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-aid-type/'>For more information</a>"
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-aid-type"
            v-model="defaultForm.default_aid_type"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{
              error__input: defaultError.default_aid_type,
            }"
            placeholder="Select Default Aid Type here"
            :options="props.defaultAidType"
            :searchable="true"
            @click="updateStore('default_aid_type')"
          />
          <span v-if="defaultError.default_aid_type" class="error" role="alert">
            {{ defaultError.default_aid_type }}
          </span>
          <p v-if="!defaultError.default_aid_type" class="translate-text">
            If selected, then default aid type will be automatically populated
            in activity when created. Also, Vocabulary type "OECD DAC" will be
            chosen by default.
          </p>
        </div>
        <!--  Default Aid Type   -->
        <div>
          <div class="flex justify-between">
            <label for="default-tied-status" class="translate-text"
              >Default Tied Status</label
            >
            <button>
              <HoverText
                width="w-72"
                name="default-tied-status"
                hover-text="Whether the aid is untied, tied, or partially tied. This element specifies a default for all the activity’s financial transactions; it can be overridden at the individual transaction level.<a target='_blank' href='https://iatistandard.org/en/iati-standard/203/activity-standard/iati-activities/iati-activity/default-tied-status/'>For more information</a>"
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-tied-status"
            v-model="defaultForm.default_tied_status"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{
              error__input: defaultError.default_tied_status,
            }"
            placeholder="Select Default Tied Status here"
            :options="props.defaultTiedStatus"
            :searchable="true"
            @click="updateStore('default_tied_status')"
          />
          <span
            v-if="defaultError.default_tied_status"
            class="error"
            role="alert"
          >
            {{ defaultError.default_tied_status }}
          </span>
          <p v-if="!defaultError.default_tied_status" class="translate-text">
            If selected, then default tied status will be automatically
            populated in activity when created.
          </p>
        </div>
        <!--  Default Tied Status      -->
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed, inject } from 'vue';
import Multiselect from '@vueform/multiselect';
import { useStore } from '../../store';
import { ActionTypes } from '../../store/setting/actions';
import HoverText from './../../components/HoverText.vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  components: {
    Multiselect,
    HoverText,
  },
  props: {
    currencies: {
      type: [String, Object],
      required: true,
    },
    languages: {
      type: [String, Object],
      required: true,
    },
    humanitarian: {
      type: [String, Object],
      required: true,
    },
    budgetNotProvided: {
      type: [String, Object],
      required: true,
    },
    defaultCollaborationType: {
      type: [String, Object],
      required: true,
    },
    defaultFlowType: {
      type: [String, Object],
      required: true,
    },
    defaultFinanceType: {
      type: [String, Object],
      required: true,
    },
    defaultAidType: {
      type: [String, Object],
      required: true,
    },
    defaultTiedStatus: {
      type: [String, Object],
      required: true,
    },
  },

  setup(props) {
    const translate = new Translate();
    const userRole = inject('userRole');
    const store = useStore();

    const defaultForm = computed(() => {
      return store.state.defaultForm;
    });

    const defaultError = computed(() => {
      return store.state.defaultError;
    });

    function updateStore(key: keyof typeof defaultForm.value) {
      store.dispatch(ActionTypes.UPDATE_DEFAULT_VALUES, {
        key: key,
        value: defaultForm.value[key],
      });
    }

    return {
      props,
      userRole,
      defaultForm,
      defaultError,
      updateStore,
      translate,
    };
  },
});
</script>
