<template>
  <div
    v-for="(document_link, key) in content"
    :key="key"
    class="elements-detail"
    :class="{
      'mb-4 border-b border-n-20 pb-4': Number(key) !== content.length - 1,
    }"
  >
    <div class="elements-detail">
      <div class="category flex">
        <a v-if="document_link.url" :href="document_link.url" target="_blank">
          {{ document_link.url }}
        </a>
        <span v-else class="italic">{{ translate.missing('url') }}</span>
      </div>
      <div class="ml-4">
        <table>
          <tbody>
            <tr>
              <td>{{ translate.commonText('title') }}</td>
              <td>
                <div
                  v-for="(narrative, j) in document_link.title['0'].narrative"
                  :key="j"
                  :class="{
                    'mb-1.5':
                      j != document_link.title['0'].narrative.length - 1,
                  }"
                >
                  <span v-if="narrative.language" class="language">
                    ({{
                      narrative.language
                        ? `${translate.commonText('language')}: ${
                            types?.languages[narrative.language]
                          }`
                        : `${translate.commonText(
                            'language'
                          )} : ${translate.missing()}`
                    }})
                  </span>
                  <div v-if="narrative.narrative" class="flex flex-col">
                    <span>
                      {{ narrative.narrative }}
                    </span>
                  </div>
                  <span v-else class="italic">{{ translate.missing() }}</span>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ translate.commonText('description') }}</td>
              <td>
                <div
                  v-for="(narrative, j) in document_link.description['0']
                    .narrative"
                  :key="j"
                  class="description-content"
                  :class="{
                    'mb-4': j != document_link.description['0'].length - 1,
                  }"
                >
                  <div class="language mb-1.5">
                    ({{
                      narrative.language
                        ? `${translate.commonText('language')}: ${
                            types?.languages[narrative.language]
                          }`
                        : `${translate.commonText(
                            'language'
                          )} : ${translate.missing()}`
                    }})
                  </div>
                  <div class="w-[500px] max-w-full">
                    {{ narrative.narrative ?? translate.missing('narrative') }}
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ translate.commonText('language') }}</td>
              <td>
                <div
                  class="item"
                  :class="{ 'mb-1.5': i != document_link.language.length - 1 }"
                >
                  <span>
                    {{
                      document_link.language
                        .map((entry) => types.languages[entry.language])
                        .join(', ') === ''
                        ? translate.missing('language')
                        : document_link.language
                            .map((entry) => types.languages[entry.language])
                            .join(', ')
                    }}
                  </span>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ translate.commonText('format') }}</td>
              <td v-if="document_link.format">
                {{ document_link.format }}
              </td>
              <td v-else class="italic">
                {{ translate.missing() }}
              </td>
            </tr>
            <tr>
              <td>{{ translate.commonText('category') }}</td>
              <td>
                <div
                  v-for="(category, i) in document_link.category"
                  :key="i"
                  class="item"
                  :class="{
                    'mb-1.5': i != document_link.category.length - 1,
                  }"
                >
                  <span v-if="category.code">
                    {{
                      category.code
                        ? types?.documentCategory[category.code]
                        : translate.missing('category')
                    }}
                  </span>
                  <span v-else class="italic">{{ translate.missing() }}</span>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ translate.commonText('document_date') }}</td>
              <td>
                <div
                  v-for="(document_date, i) in document_link.document_date"
                  :key="i"
                >
                  <span v-if="document_date.date">
                    {{ formatDate(document_date.date) }}
                  </span>
                  <span v-else class="italic">{{ translate.missing() }}</span>
                </div>
              </td>
            </tr>
            <tr>
              <td>{{ translate.commonText('recipient_country') }}</td>
              <td>
                <div
                  v-for="(
                    recipient_country, i
                  ) in document_link.recipient_country"
                  :key="i"
                >
                  <div class="mb-1.5 text-xs">
                    {{
                      recipient_country.code
                        ? `${types?.country[recipient_country.code]}`
                        : translate.missing()
                    }}
                  </div>
                  <div
                    v-for="(narrative, j) in recipient_country.narrative"
                    :key="j"
                    class="description-content"
                    :class="{
                      'mb-4': j != document_link.description['0'].length - 1,
                    }"
                  >
                    <div class="language mb-1.5">
                      ({{
                        narrative.language
                          ? `${translate.commonText('language')}: ${
                              types?.languages[narrative.language]
                            } `
                          : `${translate.commonText(
                              'language'
                            )} : ${translate.missing()}`
                      }})
                    </div>
                    <div class="w-[500px] max-w-full">
                      {{
                        narrative.narrative ?? translate.missing('narrative')
                      }}
                    </div>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, inject } from 'vue';
import moment from 'moment';
import { Translate } from 'Composable/translationHelper';

defineProps({
  content: { type: Object, required: true },
});

interface TypesInterface {
  languages: [];
  budgetType: [];
  regionVocabulary: [];
  country: [];
  documentCategory: [];
}

const translate = new Translate();
const types = inject('orgTypes') as TypesInterface;

function formatDate(date: Date) {
  return date ? moment(date).format('LL') : translate.missing('date');
}
</script>
