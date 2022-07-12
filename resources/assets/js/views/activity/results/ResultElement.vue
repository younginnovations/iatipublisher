<template>
  <div
    class="activities__content--element px-3 py-3 text-n-50"
    :class="{
      'basis-full': width === 'full',
      'basis-6/12': width === '',
    }"
    id=""
  >
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow">
          <div class="title text-sm font-bold">{{ elementName }}</div>
        </div>
        <div class="icons flex items-center">
          <svg-vue class="mr-1.5" icon="core"></svg-vue>
          <HoverText hover_text="example text" class="text-n-40 text-sm"></HoverText>
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20"></div>
      <div>
        <!-- for title / DESCRIPTION -->
        <template
          v-if="elementName === 'title' || elementName === 'description'"
        >
          <template v-for="(post, i) in data[0].narrative" :key="i">
            <div
              class="title-content"
              :class="{ 'mb-4': i !== data[0].narrative.length - 1 }"
            >
              <div class="language mb-1.5">(Language: {{ post.language }})</div>
              <div class="description text-sm">
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
                <div class="category flex">
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
                            <div class="language mb-1">
                              (Language: {{ na.language }})
                            </div>
                            <div class="description text-xs">
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
                            <div class="language mb-1">
                              (Language: {{ na.language }})
                            </div>
                            <div class="description text-xs">
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
                          {{
                            post.language
                              .map((entry) => entry.language)
                              .join(', ')
                          }}
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
              <div class="category flex">{{ ref.vocabulary }}</div>
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
import { defineComponent } from 'vue';
import HoverText from '../../../components/HoverText.vue';
import moment from 'moment';

export default defineComponent({
  name: 'activity-element',
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
    return {};
  },
});
</script>
