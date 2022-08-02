<template>
  <div class="documents">
    <div class="item elements-detail small">
      <table>
        <tbody>
          <tr v-for="(post, i) in dlData" :key="i">
            <td v-if="alignment === 'center'" style="width: 190px"></td>
            <td>
              <div class="">
                <div class="flex category">
                  {{
                    getActivityTitle(post.title[0].narrative, 'en')
                      ? getActivityTitle(post.title[0].narrative, 'en')
                      : 'Not Available'
                  }}
                </div>
                <div class="ml-4">
                  <table>
                    <tbody>
                      <tr>
                        <td>Title</td>
                        <td>
                          <div
                            v-for="(na, n) in post.title[0].narrative"
                            :key="n"
                            class="title-content"
                            :class="{
                              'mb-1.5': post.title[0].narrative.length - 1 != n,
                            }"
                          >
                            <div class="mb-1 language">
                              (Language:
                              {{
                                na.language
                                  ? type.language[na.language]
                                  : 'Not Available'
                              }})
                            </div>
                            <div class="text-xs">
                              {{ na.narrative ?? 'Not Available' }}
                            </div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>Document Link</td>
                        <td>
                          <a v-if="post.url" :href="post.url">{{ post.url }}</a>
                          <span v-else>Not Available</span>
                        </td>
                      </tr>

                      <tr>
                        <td>Format</td>
                        <td>{{ post.format ?? 'Not Available' }}</td>
                      </tr>

                      <tr>
                        <td>Description</td>
                        <td>
                          <div
                            v-for="(na, n) in post.description[0].narrative"
                            :key="n"
                            class="description-content"
                            :class="{
                              'mb-1.5':
                                post.description[0].narrative.length - 1 != n,
                            }"
                          >
                            <div class="mb-1 language">
                              (Language:
                              {{
                                na.language
                                  ? type.language[na.language]
                                  : 'Not available'
                              }})
                            </div>
                            <div class="text-xs description">
                              {{ na.narrative ?? 'Not available' }}
                            </div>
                          </div>
                        </td>
                      </tr>

                      <tr v-if="post.category.length > 0">
                        <td>Category</td>
                        <td>
                          <div
                            v-for="(cat, c) in post.category"
                            :key="c"
                            class="text-xs"
                            :class="{ 'mb-1': post.category.length - 1 != c }"
                          >
                            {{
                              cat.code
                                ? type.documentCategory[cat.code]
                                : 'Not Available'
                            }}
                          </div>
                        </td>
                      </tr>

                      <tr v-if="post.language.length > 0">
                        <td>Language</td>
                        <td>
                          <div class="text-xs">
                            {{
                              post.language[0].language
                                ? post.language
                                    .map(
                                      (entry) => type.language[entry.language]
                                    )
                                    .join(', ')
                                : 'Not Available'
                            }}
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>Document Date</td>
                        <td>
                          <div class="text-xs">
                            {{ post.document_date[0].date ?? 'Not Available' }}
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

//composable
import getActivityTitle from 'Composable/title';

export default defineComponent({
  name: 'IndicatorDocumentLink',
  components: {},
  props: {
    data: {
      type: Array,
      required: true,
    },
    type: {
      type: Object,
      required: true,
    },
    alignment: {
      type: String,
      required: false,
      default: 'center',
    },
  },
  setup(props) {
    let { data } = toRefs(props);

    /**
     * Joins data from array with a comma
     * @param language
     */

    interface DocumentLink {
      category: {
        code: string;
      }[];
      description: {
        narrative: {
          language: string;
          narrative: string;
        }[];
      }[];
      document_date: {
        date: string;
      }[];
      format: string;
      language: {
        language: string;
      }[];
      title: {
        narrative: {
          language: string;
          narrative: string;
        }[];
      }[];
      url: string;
    }

    const dlData = data.value as DocumentLink[];

    return { dlData, getActivityTitle };
  },
});
</script>
