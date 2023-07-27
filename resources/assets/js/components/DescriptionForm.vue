<template>
  <form
    accept-charset="UTF-8"
    action=""
    data-select2-id="select2-data-11-gstq"
    method="POST"
  >
    <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
      <label
        class="control-label flex rounded-tl-lg rounded-tr-lg border-t border-r border-spring-50 py-4 px-6 text-sm font-bold leading-relaxed"
        >{{ translate.commonText('description') }}</label
      >
      <div class="multi-form relative">
        <div
          class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6"
        >
          <div class="form-field max-w-half basis-6/12">
            <div class="form-field-label">
              <label for=""
                >{{ translate.commonText('type')
                }}<span class="text-salmon-40"> *</span></label
              >
            </div>
            <div>
              <select
                id=""
                aria-hidden="true"
                class=""
                required=""
                tabindex="-1"
              >
                <option value="">
                  {{ translate.commonText('placeholder.select_a_value') }}
                </option>
                <option data-select2-id="select2-data-2-e15l" value="1">
                  1 - {{ translate.commonText('general') }}
                </option>
                <option value="2">
                  2 - {{ translate.commonText('objectives') }}
                </option>
                <option value="3">
                  3 - {{ translate.commonText('target_groups') }}
                </option>
                <option value="4">
                  4 - {{ translate.commonText('other') }}
                </option>
              </select>
            </div>
          </div>
        </div>
        <button
          class="add_to_collection add_more button relative ml-6 -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-bluecoral"
          icon=""
          type="button"
        >
          <span class="mr-1.5 text-lg">
            <svg-vue icon="add-more" />
          </span>
          {{ translate.commonText('add_narrative_in_other_lang') }}
        </button>
        <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
          <label
            class="control-label flex rounded-tl-lg rounded-tr-lg border-t border-r border-spring-50 py-4 px-6 text-sm font-bold leading-relaxed"
            >{{ translate.commonText('narrative') }}</label
          >
          <div class="form-child-body relative">
            <div
              class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6"
            >
              <div class="form-field max-w-half basis-6/12">
                <div class="form-field-label">
                  <label for=""
                    >{{ translate.commonText('type')
                    }}<span class="text-salmon-40"> *</span></label
                  >
                </div>
                <textarea
                  class="form__input border-0"
                  cols="50"
                  name=""
                  required=""
                  rows="10"
                >
Education and psychosocial support to children in Aleppo Governorate</textarea
                >
              </div>
              <div class="form-field max-w-half basis-6/12">
                <div class="form-field-label">
                  <label for=""
                    >@xml:lang<span class="text-salmon-40"> *</span></label
                  >
                </div>
                <div>
                  <select>
                    <option value="">
                      {{ translate.commonText('placeholder.select_a_value') }}
                    </option>
                    <option value="aa">Afar</option>
                    <option value="ab">Abkhazian</option>
                    <option value="en">English</option>
                    <option value="fr">French</option>
                    <option value="sp">Spanish</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button
      class="add_to_parent add_more button relative -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-bluecoral"
      icon=""
      type="button"
    >
      <span class="mr-1.5 text-lg">
        <svg-vue icon="add-more" />
      </span>
      {{ translate.commonText('add_additional_description') }}
    </button>
  </form>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Translate } from 'Composable/translationHelper';
export default defineComponent({
  name: 'DescriptionForm',
  components: {},
  props: {},
  setup() {
    const translate = new Translate();

    return { translate };
  },
});
</script>
