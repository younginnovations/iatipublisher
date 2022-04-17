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
          <!-- <input
            id="default_currency"
            class="register__input mb-2"
            type="text"
            placeholder="EUR - Euro"
          /> -->
          <Multiselect
            class="select"
            v-model="currency"
            :options="props.currencies"
          />

          <p>
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
          <!-- <input
            id="default_language"
            class="register__input mb-2"
            type="text"
            placeholder="en - English"
          /> -->
          <Multiselect
            class="select"
            v-model="language"
            :options="props.languages"
          />

          <p>
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
            class="register__input mb-2"
            type="text"
            placeholder="1"
          />
          <p>
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
            class="register__input mb-2"
            type="text"
            placeholder="en - English"
          />
          <p>
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
          <!-- <input
          id="humanitarian"
          class="register__input"
          type="text"
          placeholder="No"
        /> -->
          <Multiselect
            class="select"
            v-model="humanitarian"
            :options="props.humanitarian"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Multiselect from '@vueform/multiselect';

export default defineComponent({
  components: {
    Multiselect,
  },

  props: {
    currencies: String,
    languages: String,
    humanitarian: String,
  },

  setup(props) {
    return {
      props,
    };
  },
});
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
