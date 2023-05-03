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
                    !isEmpty(getActivityTitle(post.title[0].narrative, 'en'))
                      ? getActivityTitle(post.title[0].narrative, 'en')
                      : 'Missing'
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
                            <div class="language mb-1">
                              (Language:
                              {{
                                !isEmpty(na.language)
                                  ? type.language[na.language]
                                  : 'Missing'
                              }})
                            </div>
                            <div class="description text-xs">
                              {{
                                !isEmpty(na.narrative)
                                  ? na.narrative
                                  : 'Missing'
                              }}
                            </div>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>Document Link</td>
                        <td>
                          <a
                            v-if="!isEmpty(post.url)"
                            target="_blank"
                            :href="post.url"
                            >{{ post.url }}</a
                          >
                          <span v-else>Missing</span>
                        </td>
                      </tr>

                      <tr>
                        <td>Format</td>
                        <td>
                          {{ !isEmpty(post.format) ? post.format : 'Missing' }}
                        </td>
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
                            <div class="language mb-1">
                              (Language:
                              {{
                                !isEmpty(na.language)
                                  ? type.language[na.language]
                                  : 'Missing'
                              }})
                            </div>
                            <div class="description text-xs">
                              {{
                                !isEmpty(na.narrative)
                                  ? na.narrative
                                  : 'Missing'
                              }}
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
                              !isEmpty(cat.code)
                                ? type.documentCategory[cat.code]
                                : 'Missing'
                            }}
                          </div>
                        </td>
                      </tr>

                      <tr v-if="post.language.length > 0">
                        <td>Language</td>
                        <td>
                          <div class="text-xs">
                            {{
                              !isEmpty(post.language[0].language)
                                ? post.language
                                    .map(
                                      (entry) => type.language[entry.language]
                                    )
                                    .join(', ')
                                : 'Missing'
                            }}
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>Document Date</td>
                        <td>
                          <div class="text-xs">
                            {{
                              !isEmpty(post.document_date[0].date)
                                ? post.document_date[0].date
                                : 'Missing'
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
import isEmpty from '../../../../composable/helper';

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
  methods: { isEmpty },
});
</script>
