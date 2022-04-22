<template>
  <div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Default Values</div>
      <div class="flex items-center text-xs text-n-50">
        <span class="mr-1"
          ><span class="text-salmon-50">* </span>Mandatory fields</span
        >
        <button>
          <svg-vue class="text-base" icon="help"></svg-vue>
        </button>
      </div>
    </div>
    <p class="text">
      These values will be used in the xml files which is published to the IATI
      Registry. You have the option to override the activities.
    </p>
    <span class="text-sm font-bold text-n-50">Default for all data</span>
    <div class="register mt-4 mb-6">
      <div class="register__container mb-0">
        <div>
          <div class="flex justify-between">
            <label for="default_currency">Default Currency</label>
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <Multiselect
            class="select"
            v-model="defaultForm.default_currency"
            :options="props.currencies"
            :searchable="true"
            @click="updateStore('default_currency')"
          />
          <span class="error" role="alert" v-if="defaultError.default_currency">
            {{ defaultError.default_currency }}
          </span>

          <p v-if="!defaultError.default_currency">
            The currency in which you normally report your financial
            transactions. Select from dropdown.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="default_language"
              >Default Language <span class="text-salmon-50">*</span></label
            >
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <Multiselect
            :class="
              defaultError.default_language ? 'error__input select' : 'select'
            "
            v-model="defaultForm.default_language"
            :searchable="true"
            :options="props.languages"
            @click="updateStore('default_language')"
          />
          <span class="error" role="alert" v-if="defaultError.default_language">
            {{ defaultError.default_language }}
          </span>

          <p v-if="!defaultError.default_language">
            The language in which you normally report. Select from dropdown.
          </p>
        </div>
      </div>
    </div>
    <span class="text-sm font-bold text-n-50">Default for activity data</span>
    <div class="register mt-4">
      <div class="register__container">
        <div>
          <div class="flex justify-between">
            <label for="default_hierarchy">Default Hierarchy</label>
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="default_hierarchy"
            :class="
              defaultError.hierarchy
                ? 'error__input register__input mb-2'
                : 'register__input mb-2'
            "
            type="text"
            placeholder="1"
            v-model="defaultForm.hierarchy"
            @input="updateStore('hierarchy')"
          />
          <span class="error" role="alert" v-if="defaultError.hierarchy">
            {{ defaultError.hierarchy }}
          </span>
          <p v-if="!defaultError.hierarchy">
            IATI allows for activities to be reported hierarchically (eg. parent
            - child ; programme - project - sub-project, etc). For activities at
            lower levels, their hierarchy can be edited as you are entering
            them.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="linked_data_url"
              >Linked Data URL <span class="text-salmon-50">*</span></label
            >
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="data_url"
            :class="
              defaultError.linked_data_url
                ? 'error__input register__input mb-2'
                : 'register__input mb-2'
            "
            type="text"
            placeholder="en - English"
            v-model="defaultForm.linked_data_url"
            @input="updateStore('linked_data_url')"
          />
          <span class="error" role="alert" v-if="defaultError.linked_data_url">
            {{ defaultError.linked_data_url }}
          </span>
          <p v-if="!defaultError.linked_data_url">
            The language in which you normally report. Select from dropdown.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="humanitarian"
              >Humanitarian <span class="text-salmon-50">*</span></label
            >

            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <Multiselect
            :class="
              defaultError.humanitarian ? 'error__input select' : 'select'
            "
            class="select"
            v-model="defaultForm.humanitarian"
            :options="props.humanitarian"
            :searchable="true"
            @click="updateStore('default_currency')"
          />
          <span class="error" role="alert" v-if="defaultError.humanitarian">
            {{ defaultError.humanitarian }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, computed, ref } from 'vue';
import Multiselect from '@vueform/multiselect';
import { useStore } from '../../store';
import { ActionTypes } from '../../store/setting/actions';

export default defineComponent({
  components: {
    Multiselect,
  },

  props: {
    currencies: [String, Object],
    languages: [String, Object],
    humanitarian: [String, Object],
  },

  setup(props) {
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
      defaultForm,
      defaultError,
      updateStore,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
