<template>
  <div class="documents">
    <template v-for="(post, i) in dlData" :key="i">
      <div class="item elements-detail">
        <div
          class="category w-[800px] max-w-[80%] overflow-x-hidden text-ellipsis whitespace-nowrap"
        >
          {{ post.title[0].narrative[0].narrative }}
        </div>
        <div class="ml-4">
          <table class="mb-3">
            <tbody>
              <tr>
                <td>{{ translate.commonText('title') }}</td>
                <td>
                  <template v-for="(na, n) in post.title[0].narrative" :key="n">
                    <div class="title-content mb-1.5">
                      <div class="language mb-1">
                        ({{ translate.commonText('language') }}:
                        {{
                          type.language[na.language]
                            ? type.language[na.language]
                            : translate.missing()
                        }})
                      </div>
                      <div
                        class="description !w-[800px] !max-w-[50%] overflow-x-hidden text-ellipsis whitespace-nowrap text-xs"
                      >
                        {{ na.narrative }}
                      </div>
                    </div>
                  </template>
                </td>
              </tr>

              <tr v-if="post.url">
                <td>{{ translate.commonText('document_link') }}</td>
                <td>
                  <a
                    class="w-[800px] !max-w-[50%] overflow-x-hidden text-ellipsis whitespace-nowrap"
                    target="_blank"
                    :href="post.url"
                    >{{ post.url }}</a
                  >
                </td>
              </tr>

              <tr>
                <td>{{ translate.commonText('format') }}</td>
                <td>
                  {{ post.format ? post.format : translate.missing() }}
                </td>
              </tr>

              <tr>
                <td>{{ translate.commonText('description') }}</td>
                <td>
                  <template
                    v-for="(na, n) in post.description[0].narrative"
                    :key="n"
                  >
                    <div class="description-content mb-1.5">
                      <div class="language mb-1">
                        ({{ translate.commonText('language') }}:
                        {{
                          type.language[na.language]
                            ? type.language[na.language]
                            : translate.missing()
                        }})
                      </div>
                      <div class="description text-xs">
                        {{ na.narrative }}
                      </div>
                    </div>
                  </template>
                </td>
              </tr>

              <tr>
                <td>{{ translate.commonText('category') }}</td>
                <td>
                  <template v-for="(cat, c) in post.category" :key="c">
                    <div class="mb-1 text-xs">
                      {{
                        type.documentCategory[cat.code]
                          ? type.documentCategory[cat.code]
                          : translate.missing()
                      }}
                    </div>
                  </template>
                </td>
              </tr>

              <tr v-if="post.language.length > 0">
                <td>{{ translate.commonText('language') }}</td>
                <td>
                  <div class="text-xs">
                    {{
                      post.language[0].language === null
                        ? translate.missing()
                        : post.language
                            .map((entry) => type.language[entry.language])
                            .join(', ')
                    }}
                  </div>
                </td>
              </tr>

              <tr>
                <td>{{ translate.commonText('document_date') }}</td>
                <td>
                  <div class="text-xs">
                    {{
                      post.document_date[0].date
                        ? post.document_date[0].date
                        : translate.missing()
                    }}
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ResultDocumentLink',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    type: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    let { data } = toRefs(props);
    const dlData = data.value;
    const translate = new Translate();

    return { dlData, translate };
  },
});
</script>
