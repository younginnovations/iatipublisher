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
                <td>Title</td>
                <td>
                  <template v-for="(na, n) in post.title[0].narrative" :key="n">
                    <div class="title-content mb-1.5">
                      <div class="language mb-1">
                        (Language:
                        {{
                          type.language[na.language]
                            ? type.language[na.language]
                            : 'Missing'
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
                <td>Document Link</td>
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
                <td>Format</td>
                <td>{{ post.format ? post.format : 'Missing' }}</td>
              </tr>

              <tr>
                <td>Description</td>
                <td>
                  <template
                    v-for="(na, n) in post.description[0].narrative"
                    :key="n"
                  >
                    <div class="description-content mb-1.5">
                      <div class="language mb-1">
                        (Language:
                        {{
                          type.language[na.language]
                            ? type.language[na.language]
                            : 'Missing'
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
                <td>Category</td>
                <td>
                  <template v-for="(cat, c) in post.category" :key="c">
                    <div class="mb-1 text-xs">
                      {{
                        type.documentCategory[cat.code]
                          ? type.documentCategory[cat.code]
                          : 'Missing'
                      }}
                    </div>
                  </template>
                </td>
              </tr>

              <tr v-if="post.language.length > 0">
                <td>Language</td>
                <td>
                  <div class="text-xs">
                    {{
                      post.language[0].language === null
                        ? 'Missing'
                        : post.language
                            .map((entry) => type.language[entry.language])
                            .join(', ')
                    }}
                  </div>
                </td>
              </tr>

              <tr>
                <td>Document Date</td>
                <td>
                  <div class="text-xs">
                    {{
                      post.document_date[0].date
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
    </template>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

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

    return { dlData };
  },
});
</script>
