<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category">
      <span>
        {{
          types.budgetType[post.planned_disbursement_type] ??
          translate.missing('type')
        }}
      </span>
    </div>

    <div class="mb-4 ml-5">
      <div class="category">
        <span>{{ translate.commonText('value') }}</span>
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>{{ translate.commonText('value_amount') }}</td>
            <td>
              {{
                post.value[0].amount
                  ? Number(post.value[0].amount).toLocaleString() +
                    ' ' +
                    types.currency[post.value[0].currency]
                  : translate.missing()
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('value_date') }}</td>
            <td>
              {{
                post.value[0].value_date
                  ? formatDate(post.value[0].value_date)
                  : translate.missing()
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('period_start') }}</td>
            <td>
              <span>
                {{
                  post.period_start[0].date
                    ? formatDate(post.period_start[0].date)
                    : translate.missing('type')
                }}
              </span>
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('period_end') }}</td>
            <td>
              <span>
                {{
                  post.period_end[0].date
                    ? formatDate(post.period_end[0].date)
                    : translate.missing('type')
                }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="post.provider_org" class="mb-4 ml-5">
      <div class="category">
        <span>
          {{ translate.elementLabel('activities.provider_org_spaced') }}
        </span>
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>
              {{ translate.commonText('provider')
              }}{{ translate.commonText('activity_id') }}
            </td>
            <td>
              {{
                post.provider_org[0].type
                  ? types.organizationType[post.provider_org[0].type]
                  : translate.missing()
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('reference') }}</td>
            <td>
              {{
                post.provider_org[0].provider_activity_id ?? translate.missing()
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('reference') }}</td>
            <td>
              {{ post.provider_org[0].ref ?? translate.missing() }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('narrative') }}</td>
            <td>
              <div
                v-for="(narrative, k) in post.provider_org[0].narrative"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.provider_org[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  ({{ translate.commonText('language') }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : translate.missing()
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{ narrative.narrative ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="post.receiver_org" class="ml-5">
      <div class="category">
        <span>{{
          translate.elementLabel('activities.receiver_org_spaced')
        }}</span>
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>{{ translate.commonText('type') }}</td>
            <td>
              {{
                post.receiver_org[0].type
                  ? types.organizationType[post.receiver_org[0].type]
                  : translate.missing()
              }}
            </td>
          </tr>
          <tr>
            <td>
              {{ translate.commonText('receiver')
              }}{{ translate.commonText('activity_id') }}
            </td>
            <td>
              {{
                post.receiver_org[0].receiver_activity_id ?? translate.missing()
              }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('reference') }}</td>
            <td>
              {{ post.receiver_org[0].ref ?? translate.missing() }}
            </td>
          </tr>
          <tr>
            <td>{{ translate.commonText('narrative') }}</td>
            <td>
              <div
                v-for="(narrative, k) in post.receiver_org[0].narrative"
                :key="k"
                class="description-content"
                :class="{
                  'mb-4': k !== post.receiver_org[0].narrative.length - 1,
                }"
              >
                <div class="language mb-1.5">
                  ({{ translate.commonText('language') }}:
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : translate.missing()
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{ narrative.narrative ?? translate.missing() }}
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, inject } from 'vue';
import moment from 'moment';
import { Translate } from 'Composable/translationHelper';

defineProps({
  data: {
    type: Object,
    required: true,
  },
});

interface Types {
  budgetType: [];
  languages: [];
  currency: [];
  organizationType: [];
}

function formatDate(date: Date) {
  return moment(date).format('LL');
}

const translate = new Translate();
const types = inject('types') as Types;
</script>
