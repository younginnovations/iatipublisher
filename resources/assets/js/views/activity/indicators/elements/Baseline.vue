<template>
  <tr>
    <td>Baseline</td>
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
            Year:
            <template v-if="base.year">
              {{ base.year }}
            </template>
            <template v-else>
              <MissingDataItem item="year" />
            </template>
            ,
          </span>
          <span>
            Date:
            <template v-if="base.date">
              {{ base.date }}
            </template>
            <template v-else>
              <MissingDataItem item="date" />
            </template>
            ,
          </span>
          <span>
            Value:
            <template v-if="base.value">
              {{ base.value }}
            </template>
            <template v-else>
              <MissingDataItem item="value" />
            </template>
          </span>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>Location:&nbsp;</div>
          <div>
            <ConditionalTextDisplay
              :success-text="location(base.location)"
              :condition="location(base.location)"
              failure-text="location"
            />
          </div>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>Dimension:&nbsp;</div>
          <div class="description">
            Code:
            <ConditionalTextDisplay
              :success-text="base.dimension[0].name"
              :condition="base.dimension[0].name"
              failure-text="name"
            />, Value:
            <ConditionalTextDisplay
              :success-text="base.dimension[0].value"
              :condition="base.dimension[0].value"
              failure-text="value"
            />
          </div>
        </div>

        <div class="flex" :class="elementSpacing">
          <div>Comment:&nbsp;</div>
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
                  <ConditionalTextDisplay
                    :success-text="com.narrative"
                    :condition="com.narrative"
                  />
                  <span class="text-n-30">
                    (Language:
                    <ConditionalTextDisplay
                      :success-text="baseType.language[com.language]"
                      :condition="com.language"
                    />)
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="mb-2.5 flex">
            <div>Document Link:&nbsp;</div>
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
import ConditionalTextDisplay from 'Components/ConditionalTextDisplay.vue';
import MissingDataItem from 'Components/MissingDataItem.vue';

export default defineComponent({
  name: 'IndicatorBaseline',
  components: { MissingDataItem, ConditionalTextDisplay, DocumentLink },
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
        return locations.join(', ') + ' ' + 'and' + ' ' + lastLocation;
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

      console.log(data);
      dimensions = data.map((item) => {
        const name = item.name ?? 'Missing',
          value = item.value ?? 'Missing';
        return `code - ${name}, value - ${value}`;
      });

      return dimensions.join('; ');
    };
    return {
      baseline,
      location,
      dimensions,
      elementSpacing,
      countDocumentLink,
    };
  },
});
</script>
