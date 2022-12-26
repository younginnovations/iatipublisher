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
          language.common_lang.missing.element.replace(
            ':element',
            language.common_lang.type
          )
        }}
      </span>
    </div>

    <div class="mb-4 ml-5">
      <div class="category">
        <span>{{ language.common_lang.value }}</span>
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>{{ language.common_lang.value_amount }}</td>
            <td>
              {{
                post.value[0].amount
                  ? Number(post.value[0].amount).toLocaleString() +
                    ' ' +
                    types.currency[post.value[0].currency]
                  : language.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.value_date }}</td>
            <td>
              {{
                post.value[0].value_date
                  ? formatDate(post.value[0].value_date)
                  : language.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.period_start }}</td>
            <td>
              <span>
                {{
                  post.period_start[0].date
                    ? formatDate(post.period_start[0].date)
                    : language.common_lang.missing.element.replace(
                        ':element',
                        language.common_lang.date
                      )
                }}
              </span>
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.period_end }}</td>
            <td>
              <span>
                {{
                  post.period_end[0].date
                    ? formatDate(post.period_end[0].date)
                    : language.common_lang.missing.element.replace(
                        ':element',
                        language.common_lang.date
                      )
                }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="post.provider_org" class="mb-4 ml-5">
      <div class="category">
        <span
          >{{ language.common_lang.provider
          }}{{ language.common_lang.org }} org</span
        >
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>
              {{ language.common_lang.provider
              }}{{ language.common_lang.activity_id }}
            </td>
            <td>
              {{
                post.provider_org[0].type
                  ? types.organizationType[post.provider_org[0].type]
                  : language.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.reference_label }}</td>
            <td>
              {{
                post.provider_org[0].provider_activity_id ??
                language.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.reference_label }}</td>
            <td>
              {{
                post.provider_org[0].ref ?? language.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.narrative }}</td>
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
                  ({{ language.common_lang.language }}
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : language.common_lang.missing.default
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ?? language.common_lang.missing.default
                  }}
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div v-if="post.receiver_org" class="ml-5">
      <div class="category">
        <span
          >{{ language.common_lang.provider
          }}{{ language.common_lang.org }}</span
        >
      </div>
      <table class="ml-5">
        <tbody>
          <tr>
            <td>{{ language.common_lang.type }}</td>
            <td>
              {{
                post.receiver_org[0].type
                  ? types.organizationType[post.receiver_org[0].type]
                  : language.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>
              {{ language.common_lang.receiver
              }}{{ language.common_lang.activity_id }}
            </td>
            <td>
              {{
                post.receiver_org[0].receiver_activity_id ??
                language.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.reference_label }}</td>
            <td>
              {{
                post.receiver_org[0].ref ?? language.common_lang.missing.default
              }}
            </td>
          </tr>
          <tr>
            <td>{{ language.common_lang.narrative }}</td>
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
                  ({{ language.common_lang.language }}
                  {{
                    narrative.language
                      ? types.languages[narrative.language]
                      : language.common_lang.missing.default
                  }})
                </div>
                <div class="w-[500px] max-w-full">
                  {{
                    narrative.narrative ?? language.common_lang.missing.default
                  }}
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

const language = window['globalLang'];
const types = inject('types') as Types;
</script>
