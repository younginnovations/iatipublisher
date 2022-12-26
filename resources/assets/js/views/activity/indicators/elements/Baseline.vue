<template>
  <tr>
    <td>{{ language.common_lang.baseline }}</td>
    <td>
      <div
        v-for="(base, b) in baseline"
        :key="b"
        :class="{
          'mb-3': b !== baseline.length - 1,
        }"
      >
        <div :class="elementSpacing">
          <span>
            {{ language.common_lang.year }}:
            <template v-if="base.year">
              {{ base.year }}
            </template>
            <template v-else>{{
              language.common_lang.missing.default
            }}</template>
            ,
          </span>
          <span>
            {{ language.common_lang.date }}:
            <template v-if="base.date">
              {{ base.date }}
            </template>
            <template v-else>{{
              language.common_lang.missing.default
            }}</template>
            ,
          </span>
          <span>
            {{ language.common_lang.value }}:
            <template v-if="base.value">
              {{ base.value }}
            </template>
            <template v-else>{{
              language.common_lang.missing.default
            }}</template>
          </span>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>{{ language.common_lang.location }}:&nbsp;</div>
          <div>
            {{
              location(base.location)
                ? location(base.location)
                : language.common_lang.baseline.default
            }}
          </div>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>{{ language.common_lang.dimension }}:&nbsp;</div>
          <div class="description">
            {{ dimensions(base.dimension) }}
          </div>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>{{ language.common_lang.comment }}:&nbsp;</div>
          <div>
            <div
              v-for="(com, c) in base.comment[0].narrative"
              :key="c"
              class="item"
              :class="{
                'mb-1.5': c !== base.comment[0].narrative.length - 1,
              }"
            >
              <div>
                <div class="description">
                  {{
                    com.narrative
                      ? com.narrative
                      : language.common_lang.missing.default
                  }}
                  <span class="text-n-30">
                    (Language:
                    {{
                      com.language
                        ? baseType.language[com.language]
                        : language.common_lang.missing.default
                    }})</span
                  >
                </div>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="mb-2.5 flex">
            <div>{{ language.common_lang.document_link }}:&nbsp;</div>
            <div></div>
          </div>
          <div class="divider mb-4 h-px w-full border-b border-n-20"></div>
          <DocumentLink
            :data="base.document_link"
            :type="baseType"
            alignment=""
          />
        </div>
      </div>
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import { DocumentLink } from './Index';
import { countDocumentLink } from 'Composable/utils';

export default defineComponent({
  name: 'IndicatorBaseline',
  components: { DocumentLink },
  props: {
    data: {
      type: Array,
      required: true,
    },
    baseType: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    let { data } = toRefs(props);
    const elementSpacing = 'mb-1';

    /**
     * Baseline
     */
    interface Comment {
      [index: number]: {
        narrative: [
          {
            language: string;
            narrative: string;
          }
        ];
      };
    }

    interface Dimension {
      name: string;
      value: string;
    }

    interface BaselineElements {
      comment: Comment;
      date: string;
      dimension: Dimension[];
      document_link: [];
      location: Location[];
      value: number;
      year: number;
    }

    const language = window['globalLang'];
    const baseline = data.value as BaselineElements[];

    /**
     * Function to return all locations of baseline
     * @param data
     */

    interface Location {
      reference: string;
    }

    const location = (data: Location[]) => {
      let locations: string[] = [];

      locations = data.map((item) => {
        return item.reference;
      });

      const lastLocation = locations.slice(-1)[0];
      locations = locations.slice(0, -1);

      if (locations.length > 0) {
        return (
          locations.join(', ') +
          ' ' +
          language.common_lang.sticky.common.and +
          ' ' +
          lastLocation
        );
      } else {
        return lastLocation;
      }
    };

    /**
     * Function to return dimensions of baseline
     * @param data
     */
    const dimensions = (data: Dimension[]) => {
      let dimensions: string[] = [];

      dimensions = data.map((item) => {
        const name = item.name ?? language.common_lang.missing.default,
          value = item.value ?? language.common_lang.missing.default;
        return `${language.common_lang.code} - ${name}, ${language.common_lang.value} - (${value})`;
      });

      return dimensions.join('; ');
    };
    return {
      baseline,
      location,
      dimensions,
      elementSpacing,
      countDocumentLink,
      language,
    };
  },
});
</script>
