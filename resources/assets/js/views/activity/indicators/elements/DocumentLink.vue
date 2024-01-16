<template>
  <div class="documents">
    <div class="item elements-detail small">
      <table>
        <tbody>
          <tr v-for="(post, i) in dlData" :key="i">
            <td v-if="alignment === 'center'" style="width: 190px"></td>
            <td>
              <div class="">
                <div class="category flex">
                  {{
                    getActivityTitle(post.title[0].narrative, 'en')
                      ? getActivityTitle(post.title[0].narrative, 'en')
                      : translate.missing()
                  }}
                </div>
                <div class="ml-4">
                  <table>
                    <tbody>
                      <tr>
                        <td>{{ translate.commonText('title') }}</td>
                        <td>
                          <div
                            v-for="(na, n) in post.title[0].narrative"
                            :key="n"
                            class="title-content"
                            :class="{
                              'mb-1.5': post.title[0].narrative.length - 1 != n,
                            }"
                          >
                            <div class="language mb-1">
                              ({{ translate.commonText('language') }}:
                              {{
                                na.language
                                  ? type.language[na.language]
                                  : translate.missing()
                              }})
                            </div>
                            <div class="description text-xs">
                              {{ na.narrative ?? translate.missing() }}
                            </div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>{{ translate.commonText('document_link') }}</td>
                        <td>
                          <a v-if="post.url" target="_blank" :href="post.url">{{
                            post.url
                          }}</a>
                          <span v-else>{{ translate.missing() }}</span>
                        </td>
                      </tr>

                      <tr>
                        <td>{{ translate.commonText('format') }}</td>
                        <td>
                          {{ post.format ?? translate.missing() }}
                        </td>
                      </tr>

                      <tr>
                        <td>{{ translate.commonText('description') }}</td>
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
                            <div class="language mb-1">
                              ({{ translate.commonText('language') }}:
                              {{
                                na.language
                                  ? type.language[na.language]
                                  : translate.missing()
                              }})
                            </div>
                            <div class="description text-xs">
                              {{ na.narrative ?? translate.missing() }}
                            </div>
                          </div>
                        </td>
                      </tr>

                      <tr v-if="post.category.length > 0">
                        <td>{{ translate.commonText('category') }}</td>
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
                                : translate.missing()
                            }}
                          </div>
                        </td>
                      </tr>

                      <tr v-if="post.language.length > 0">
                        <td>{{ translate.commonText('language') }}</td>
                        <td>
                          <div class="text-xs">
                            {{
                              post.language[0].language
                                ? post.language
                                    .map(
                                      (entry) => type.language[entry.language]
                                    )
                                    .join(', ')
                                : translate.missing()
                            }}
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>{{ translate.commonText('document_date') }}</td>
                        <td>
                          <div class="text-xs">
                            {{
                              post.document_date[0].date ?? translate.missing()
                            }}
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
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
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

    return { dlData, getActivityTitle, translate };
  },
});
</script>
