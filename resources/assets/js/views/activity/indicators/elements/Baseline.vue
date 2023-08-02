<template>
  <tr>
    <td>{{ translate.commonText('baseline') }}</td>
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
            {{ translate.commonText('year') }}:
            <template v-if="base.year">
              {{ base.year }}
            </template>
            <template v-else>{{ translate.missing() }}</template>
            ,
          </span>
          <span>
            {{ translate.commonText('date') }}:
            <template v-if="base.date">
              {{ base.date }}
            </template>
            <template v-else>{{ translate.missing() }}</template>
            ,
          </span>
          <span>
            {{ translate.commonText('value') }}:
            <template v-if="base.value">
              {{ base.value }}
            </template>
            <template v-else>{{ translate.missing() }}</template>
          </span>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>{{ translate.commonText('location') }}:&nbsp;</div>
          <div>
            {{
              location(base.location)
                ? location(base.location)
                : translate.missing()
            }}
          </div>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>{{ translate.commonText('dimension') }}:&nbsp;</div>
          <div class="description">
            {{ dimensions(base.dimension) }}
          </div>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>{{ translate.commonText('comment') }}:&nbsp;</div>
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
                  {{ com.narrative ? com.narrative : translate.missing() }}
                  <span class="text-n-30">
                    ({{ translate.commonText('language') }}:
                    {{
                      com.language
                        ? baseType.language[com.language]
                        : translate.missing()
                    }})</span
                  >
                </div>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="mb-2.5 flex">
            <div>{{ translate.commonText('document_link') }}:&nbsp;</div>
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
import { Translate } from 'Composable/translationHelper';

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

    const translate = new Translate();
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
          translate.stickyText('and', 'common') +
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
        const name = item.name ?? translate.missing(),
          value = item.value ?? translate.missing();
        return `${translate.commonText(
          'code'
        )} - ${name}, ${translate.commonText('value')} - (${value})`;
      });

      return dimensions.join('; ');
    };
    return {
      baseline,
      location,
      dimensions,
      elementSpacing,
      countDocumentLink,
      translate,
    };
  },
});
</script>
