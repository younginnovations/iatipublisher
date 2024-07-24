<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Default Values</div>
      <div class="mb-4 flex items-center text-xs text-n-50">
        <button>
          <HoverText
            name="Default Values"
            hover-text="These values will be automatically added to your data files."
          />
        </button>
      </div>
    </div>
    <span class="text-sm font-bold text-n-50">Default for all data</span>
    <div class="register mb-4 mt-4">
      <div class="register__container mb-0">
        <div>
          <div class="flex justify-between">
            <label for="default-currency">Default Currency</label>
            <button>
              <HoverText
                name="Default Currency"
                hover-text="The currency in which you report your financial transactions. You can later manually change the currency on individual transactions and budgets if required."
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="default-currency"
            v-model="defaultForm.default_currency"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            placeholder="Select from dropdown"
            :options="props.currencies"
            :searchable="true"
            @click="updateStore('default_currency')"
          />
          <span v-if="defaultError.default_currency" class="error" role="alert">
            {{ defaultError.default_currency }}
          </span>

          <p v-if="!defaultError.default_currency">
            If you do not set your default currency, you have to choose and
            select currency manually for all the financial transactions.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="default-language">Default Language</label>
            <button>
              <HoverText
                name="Default Language"
                hover-text="The language in which you provide data on your activities. You can later manually change the language on individual text if required."
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
            placeholder="Select language from dropdown"
            :searchable="true"
            :options="props.languages"
            @click="updateStore('default_language')"
          />
          <span v-if="defaultError.default_language" class="error" role="alert">
            {{ defaultError.default_language }}
          </span>

          <p v-if="!defaultError.default_language">
            If you do not set your default language, you have to choose and
            select language for all the narrative text in activity and
            organisation.
          </p>
        </div>
      </div>
    </div>

    <span class="text-sm font-bold text-n-50"
      >Recommended defaults for activity data</span
    >
    <div class="register mb-4 mt-4">
      <div class="register__container">
        <!-- Default Hierarchy -->
        <div>
          <div class="flex justify-between">
            <label for="default-hierarchy">Default Hierarchy</label>
            <button>
              <HoverText
                width="w-64"
                name="Default Hierarchy"
                hover-text="If you are reporting both programmes (parent activities) and projects (child activities),
                choose the hierarchical level that most of your activities are at. e.g. parent activity = 1; child activity = 2.
                <br>If all your activities are at the same level i.e. you have no child activities, then choose 1."
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
            placeholder="Type default hierarchy here"
            @input="updateStore('hierarchy')"
          />
          <span v-if="defaultError.hierarchy" class="error" role="alert">
            {{ defaultError.hierarchy }}
          </span>
          <p v-if="!defaultError.hierarchy">
            If hierarchy is not reported then 1 is assumed. If multiple levels
            are reported then, to avoid double counting, financial transactions
            should only be reported at the lowest hierarchical level.
          </p>
        </div>
        <!-- Default Hierarchy -->

        <!-- Humanitarian -->
        <div>
          <div class="flex justify-between">
            <label for="humanitarian">Humanitarian</label>
            <button>
              <HoverText
                width="w-72"
                name="Humanitarian"
                hover-text="Add a 'Humanitarian Flag' to every activity that your organisation publishes data on. This means that your organisation identifies all their activities as wholly or partially addressing a humanitarian crisis or multiple crises. You can later manually add or remove a Humanitarian Flag on individual activities if required."
                :show-iati-reference="true"
              />
            </button>
          </div>
          <Multiselect
            id="humanitarian"
            v-model="defaultForm.humanitarian"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{ error__input: defaultError.humanitarian }"
            placeholder="Select Humanitarian here"
            :options="props.humanitarian"
            :searchable="true"
            @click="updateStore('humanitarian')"
          />
          <span v-if="defaultError.humanitarian" class="error" role="alert">
            {{ defaultError.humanitarian }}
          </span>
        </div>
        <!-- Humanitarian -->

        <!-- Default Flow Type -->
        <div>
          <div class="flex justify-between">
            <label for="default-collaboration-type">Default Flow Type</label>
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
            :class="{ error__input: defaultError.default_flow_type }"
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
          <p v-if="!defaultError.default_flow_type">
            If selected, then default flow type will be automatically populated
            in activity when created.
          </p>
        </div>
        <!-- Default Flow Type -->

        <!-- Default Finance Type -->
        <div>
          <div class="flex justify-between">
            <label for="default-collaboration-type">Default Finance Type</label>
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
            :class="{ error__input: defaultError.default_finance_type }"
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
          <p v-if="!defaultError.default_finance_type">
            If selected, then default finance type will be automatically
            populated in activity when created.
          </p>
        </div>
        <!-- Default Finance Type -->

        <!-- Default Aid Type -->
        <div>
          <div class="flex justify-between">
            <label for="default-collaboration-type">Default Aid Type</label>
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
            :class="{ error__input: defaultError.default_aid_type }"
            placeholder="Select Default Aid Type here"
            :options="props.defaultAidType"
            :searchable="true"
            @click="updateStore('default_aid_type')"
          />
          <span v-if="defaultError.default_aid_type" class="error" role="alert">
            {{ defaultError.default_aid_type }}
          </span>
          <p v-if="!defaultError.default_aid_type">
            If selected, then default aid type will be automatically populated
            in activity when created. Also, Vocabulary type "OECD DAC" will be
            chosen by default.
          </p>
        </div>
        <!-- Default Aid Type -->

        <!-- Default Tied Status -->
        <div>
          <div class="flex justify-between">
            <label for="default-tied-status">Default Tied Status</label>
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
            :class="{ error__input: defaultError.default_tied_status }"
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
          <p v-if="!defaultError.default_tied_status">
            If selected, then default tied status will be automatically
            populated in activity when created.
          </p>
        </div>
        <!-- Default Tied Status -->
      </div>
    </div>

    <span class="text-sm font-bold text-n-50"
      >Optional defaults for activity data</span
    >
    <div class="register mb-4 mt-4">
      <div class="register__container">
        <!-- Budget Not Provided -->
        <div>
          <div class="flex justify-between">
            <label for="budget-not-provided">Budget Not Provided</label>
            <button>
              <HoverText
                width="w-72"
                name="Budget Not Provided"
                hover-text="A code indicating the reason why this activity does not contain any iati-activity/budget elements. The attribute MUST only be used when no budget elements are present."
              />
            </button>
          </div>
          <Multiselect
            id="budget_not_provided"
            v-model="defaultForm.budget_not_provided"
            :disabled="userRole !== 'admin' ? true : false"
            class="vue__select"
            :class="{ error__input: defaultError.budget_not_provided }"
            placeholder="Select budget not provided type here"
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
        <!-- Budget Not Provided -->

        <!-- Linked Data URI -->
        <div>
          <div class="flex justify-between">
            <label for="default-hierarchy">Linked Data URI</label>
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
        <!-- Linked Data URI -->

        <!-- Default Collaboration Type -->
        <div>
          <div class="flex justify-between">
            <label for="default-collaboration-type"
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
            :class="{ error__input: defaultError.default_collaboration_type }"
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
          <p v-if="!defaultError.default_collaboration_type">
            If selected, then default collaboration type will be automatically
            populated in activity when created.
          </p>
        </div>
        <!-- Default Collaboration Type -->
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
    };
  },
});
</script>
