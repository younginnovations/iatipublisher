<template>
  <div
    :id="elementName"
    class="px-3 py-3 activities__content--element text-n-50"
    :class="{
      'basis-full': width === 'full',
      'basis-6/12': width === '',
    }"
  >
    <div class="p-4 bg-white rounded-lg">
      <div class="flex mb-4">
        <div class="flex title grow">
          <div class="text-sm font-bold title">{{ elementName }}</div>
        </div>
        <div class="flex items-center icons">
          <svg-vue class="mr-1.5" icon="core"></svg-vue>
          <HoverText hover-text="example text" class="text-n-40"></HoverText>
        </div>
      </div>
      <div class="w-full h-px mb-4 divider bg-n-20"></div>
      <div>
        <!-- for title / DESCRIPTION -->
        <template
          v-if="elementName === 'title' || elementName === 'description'"
        >
          <template v-for="(post, i) in tdData[0].narrative" :key="i">
            <div
              class="title-content"
              :class="{
                'mb-4': i !== Object.keys(tdData[0].narrative).length - 1,
              }"
            >
              <div class="language mb-1.5">(Language: {{ post.language }})</div>
              <div class="text-sm description">
                {{ post.narrative }}
              </div>
            </div>
          </template>
        </template>

        <!-- aggregation_status -->
        <template v-else-if="elementName === 'aggregation_status'">
          {{ data }}
        </template>

        <!-- document link -->
        <template v-else-if="elementName === 'document_link'">
          <div class="documents">
            <template v-for="(post, i) in data" :key="i">
              <div class="item elements-detail">
                <div class="flex category">
                  {{ post.title[0].narrative[0].narrative }}
                </div>
                <div class="ml-4">
                  <table class="mb-3">
                    <tr>
                      <td>Title</td>
                      <td>
                        <template
                          v-for="(na, n) in post.title[0].narrative"
                          :key="n"
                        >
                          <div class="title-content mb-1.5">
                            <div class="mb-1 language">
                              (Language: {{ na.language }})
                            </div>
                            <div class="text-xs description">
                              {{ na.narrative }}
                            </div>
                          </div>
                        </template>
                      </td>
                    </tr>

                    <tr v-if="post.url">
                      <td>Document Link</td>
                      <td>
                        <a :href="post.url">{{ post.url }}</a>
                      </td>
                    </tr>

                    <tr v-if="post.format">
                      <td>Format</td>
                      <td>{{ post.format }}</td>
                    </tr>

                    <tr>
                      <td>Description</td>
                      <td>
                        <template
                          v-for="(na, n) in post.description[0].narrative"
                          :key="n"
                        >
                          <div class="description-content mb-1.5">
                            <div class="mb-1 language">
                              (Language: {{ na.language }})
                            </div>
                            <div class="text-xs description">
                              {{ na.narrative }}
                            </div>
                          </div>
                        </template>
                      </td>
                    </tr>

                    <tr v-if="post.category.length > 0">
                      <td>Category</td>
                      <td>
                        <template v-for="(cat, c) in post.category" :key="c">
                          <div class="mb-1 text-xs">
                            {{ cat.code }}
                          </div>
                        </template>
                      </td>
                    </tr>

                    <tr v-if="post.category">
                      <td>Language</td>
                      <td>
                        <div class="text-xs">
                          {{ getLanguages(post.language) }}
                        </div>
                      </td>
                    </tr>

                    <tr v-if="post.document_date[0].date">
                      <td>Document Date</td>
                      <td>
                        <div class="text-xs">
                          {{ post.document_date[0].date }}
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </template>
          </div>
        </template>

        <!-- REFERENCE -->
        <template v-else-if="elementName === 'reference'">
          <template v-for="(ref, r) in data" :key="r">
            <div
              class="item elements-detail"
              :class="{ 'mb-4': Number(r) !== data.length - 1 }"
            >
              <div class="flex category">{{ ref.vocabulary }}</div>
              <div class="ml-4">
                <table class="mb-3">
                  <tbody>
                    <tr>
                      <td>Code</td>
                      <td>{{ ref.code }}</td>
                    </tr>
                    <tr>
                      <td>Vocabulary URI</td>
                      <td>{{ ref.vocabulary_uri }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </template>
        </template>

        <template v-else>
          {{ data }}
        </template>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import HoverText from '../../../components/HoverText.vue';

export default defineComponent({
  name: 'ActivityElement',
  components: { HoverText },
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    elementName: {
      type: String,
      required: true,
    },
    editUrl: {
      type: String,
      required: true,
    },
    width: {
      type: String,
      required: false,
      default: '',
    },
  },
  setup(props) {
    /**
     * Reactive data for title or description
     */

    interface NarrativeArray {
      [index: number]: { language: string; narrative: string };
    }

    interface Narratives {
      [index: number]: {
        narrative: NarrativeArray;
      };
    }

    let { data } = toRefs(props);

    const tdData = data.value as Narratives;

    /**
     * Joins data from array with a comma
     * @param language
     */

    interface Entry {
      [key: string]: string;
    }

    function getLanguages(language: Entry[]) {
      return language.map((entry) => entry.language).join(', ');
    }
    return { tdData, getLanguages };
  },
});
</script>
