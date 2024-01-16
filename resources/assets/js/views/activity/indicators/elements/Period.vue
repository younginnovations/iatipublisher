<template>
  <tr v-if="data.length === 0">
    <td></td>
    <td>
      <div>
        <NotYet
          :link="`/indicator/${id.indicator}/period/create`"
          :description="translate.button('not_yet_added_period')"
          :btn-text="translate.button('add_element', 'common.period')"
          class="max-w-[442px]"
        />
      </div>
    </td>
  </tr>

  <tr v-else>
    <td>{{ translate.commonText('periods') }}</td>
    <td>
      <div class="inline-flex gap-4">
        <div>
          <div
            v-for="(item, key) in data"
            :key="key"
            class="flex"
            :class="{
              'mb-1': Number(key) !== data.length - 1,
            }"
          >
            <div>
              <a
                class="text-xs text-n-50"
                :href="`/indicator/${id.indicator}/period/${item.id}`"
              >
                {{
                  dateFormat(item.period.period_start[0].date, 'MMMM DD, YYYY')
                }}
                -
                {{
                  dateFormat(item.period.period_end[0].date, 'MMMM DD, YYYY')
                }}
              </a>
            </div>
            <div class="ml-2">
              <Btn
                :text="translate.button('edit')"
                icon="edit"
                :link="`/indicator/${id.indicator}/period/${item.id}/edit`"
              />
            </div>
          </div>
        </div>
        <div class="shrink-0">
          <Btn
            :text="translate.button('show_full_period')"
            icon=""
            design="bgText"
            :link="`/indicator/${id.indicator}/period`"
            class="mr-2.5 -mt-1"
          />
        </div>
      </div>
    </td>
  </tr>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';

import dateFormat from 'Composable/dateFormat';
import Btn from 'Components/buttons/Link.vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'IndicatorPeriod',
  components: {
    Btn,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface ParentData {
      activity: string;
      result: string;
      indicator: string;
    }
    const translate = new Translate();
    const id = inject('parentData') as ParentData;
    return { id, dateFormat, translate };
  },
});
</script>
