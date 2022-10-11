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
        <span v-else class="italic">URL Not Available</span>
      </div>
      <div class="ml-4">
        <table>
          <tbody>
            <tr>
              <td>Title</td>
              <td>
                <div
                  v-for="(narrative, j) in document_link.title['0'].narrative"
                  :key="j"
                  :class="{
                    'mb-1.5': j != document_link.title['0'].narrative.length - 1,
                  }"
                >
                  <span v-if="narrative.language" class="language">
                    ({{
                      narrative.language
                        ? `Language: ${types?.languages[narrative.language]}`
                        : "Language : Not Available"
                    }})
                  </span>
                  <div v-if="narrative.narrative" class="flex flex-col">
                    <span>
                      {{ narrative.narrative }}
                    </span>
                  </div>
                  <span v-else class="italic">Not Available</span>
                </div>
              </td>
            </tr>
            <tr>
              <td>Description</td>
              <td>
                <div
                  v-for="(narrative, j) in document_link.description['0'].narrative"
                  :key="j"
                  class="description-content"
                  :class="{
                    'mb-4': j != document_link.description['0'].length - 1,
                  }"
                >
                  <div class="language mb-1.5">
                    ({{
                      narrative.language
                        ? `Language: ${types?.languages[narrative.language]}`
                        : "Language : Not Available"
                    }})
                  </div>
                  <div class="w-[500px] max-w-full">
                    {{ narrative.narrative ?? "Narrative Not Available" }}
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td>Language</td>
              <td>
                <div
                  class="item"
                  :class="{ 'mb-1.5': i != document_link.language.length - 1 }"
                >
                  <span>
                    {{
                      document_link.language
                        .map((entry) => types.languages[entry.language])
                        .join(", ") === ""
                        ? "Language Not Available"
                        : document_link.language
                            .map((entry) => types.languages[entry.language])
                            .join(", ")
                    }}
                  </span>
                </div>
              </td>
            </tr>
            <tr>
              <td>Format</td>
              <td v-if="document_link.format">
                {{ document_link.format }}
              </td>
              <td v-else class="italic">Not Available</td>
            </tr>
            <tr>
              <td>Category</td>
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
                        : "Category Not Available"
                    }}
                  </span>
                  <span v-else class="italic">Not Available</span>
                </div>
              </td>
            </tr>
            <tr>
              <td>Document Date</td>
              <td>
                <div v-for="(document_date, i) in document_link.document_date" :key="i">
                  <span v-if="document_date.date">
                    {{ formatDate(document_date.date) }}
                  </span>
                  <span v-else class="italic">Not Available</span>
                </div>
              </td>
            </tr>
            <tr>
              <td>Recipient Country</td>
              <td>
                <div
                  v-for="(recipient_country, i) in document_link.recipient_country"
                  :key="i"
                >
                  <div class="mb-1.5 text-xs">
                    {{
                      recipient_country.code
                        ? `${types?.country[recipient_country.code]}`
                        : "Not Available"
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
                          ? `Language: ${types?.languages[narrative.language]} `
                          : "Language : Not Available"
                      }})
                    </div>
                    <div class="w-[500px] max-w-full">
                      {{ narrative.narrative ?? "Narrative Not Available" }}
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
import { defineProps, inject } from "vue";
import moment from "moment";

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

const types = inject("orgTypes") as TypesInterface;

function formatDate(date: Date) {
  return date ? moment(date).format("LL") : "Date Not Available";
}
</script>
