<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <div class="mb-6 page-title">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="breadcrumb">
              <p>
                <a href="/activities" class="font-bold"> Your Activities </a>
                <span class="mx-4 separator"> / </span>
                <span class="text-n-30">
                  <a href="/activities/1">Activity Name</a>
                </span>
                <span class="mx-4 separator"> / </span>
                <span class="text-n-30"> Add Result </span>
                <span class="mx-4 separator"> / </span>
                <span class="last text-n-30"> Result Detail </span>
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h4 class="mr-4 font-bold">Result detail</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="activities">
      <aside class="activities__sidebar">
        <div class="px-6 py-4 rounded-lg indicator bg-eggshell text-n-50">
          <ul class="text-sm font-bold leading-relaxed">
            <li>
              <a href="#" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                title
              </a>
            </li>
            <li>
              <a href="#" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                description
              </a>
            </li>
            <li>
              <a href="#" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                document-link
              </a>
            </li>
            <li>
              <a href="#" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                reference
              </a>
            </li>
          </ul>
          <a
            :href="`/activities/${result.activity_id}/result/${result.id}/indicator/create`"
            class="flex w-full p-2 text-sm font-bold leading-relaxed bg-white border border-dashed rounded border-n-40"
          >
            <svg-vue icon="add" class="mr-2 text-n-40"></svg-vue>
            add indicator
          </a>
        </div>
      </aside>
      <div class="activities__content">
        <div class="flex justify-end mb-11">
          <a
            :href="`/activities/${result.activity_id}/result/${result.id}/edit`"
            class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit Result</span>
          </a>
        </div>
        <div class="flex flex-wrap -mx-3 -mt-3 activities__content--elements">
          <template v-for="(post, key) in result.result" :key="key">
            <ResultElement
              :data="post"
              :element-name="key.toString()"
              :edit-url="`/activities/${result.activity_id}/result/${result.id}`"
              :width="
                key.toString() === 'title' ||
                key.toString() === 'description' ||
                key.toString() === 'document_link' ||
                key.toString() === 'reference'
                  ? 'full'
                  : ''
              "
            />
          </template>

          <!-- Indicator -->
          <div
            id=""
            class="px-3 py-3 activities__content--element basis-full text-n-50"
          >
            <div class="p-4 bg-white rounded-lg">
              <div class="flex mb-4">
                <div class="flex items-center title grow">
                  <svg-vue
                    class="mr-1.5 text-xl text-bluecoral"
                    icon="bill"
                  ></svg-vue>
                  <div class="text-sm font-bold title">Indicator</div>
                  <div
                    class="status ml-2.5 flex text-xs leading-5 text-crimson-50"
                  >
                    <b class="mr-2 text-base leading-3">.</b>
                    <span>not completed</span>
                  </div>
                </div>
                <div class="flex items-center icons">
                  <a
                    :href="`/activities/${result.activity_id}/result/${result.id}/indicator/create`"
                    class="mr-2.5 flex items-center text-tiny font-bold uppercase"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="add"></svg-vue>
                    <span>Add new indicator</span>
                  </a>
                  <svg-vue class="mr-1.5" icon="moon"></svg-vue>
                  <div class="help text-n-40">
                    <button>
                      <svg-vue icon="help"></svg-vue>
                    </button>
                    <div class="right-0 help__text w-60">
                      <span class="font-bold text-bluecoral"></span>
                      <p>Example text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="w-full h-px mb-4 divider bg-n-20"></div>
              <div class="indicator">
                <!-- loop item -->

                <template v-for="(post, ri) in result.indicators" :key="ri">
                  <div class="item">
                    <div class="elements-detail wider">
                      <div class="flex category">
                        <div class="mr-4">
                          {{ post.indicator.title[0].narrative[0].narrative }}
                        </div>
                        <div class="flex justify-between shrink-0 grow">
                          <a
                            :href="`/activities/${result.activity_id}/result/${result.id}/indicator/${post.id}/edit`"
                            class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                          >
                            <svg-vue
                              class="mr-0.5 text-base"
                              icon="edit"
                            ></svg-vue>
                            <span>Edit Indicator</span>
                          </a>
                          <a
                            :href="`/activities/${result.activity_id}/result/${result.id}/indicator/${post.id}/period/create`"
                            class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                          >
                            <svg-vue
                              class="mr-0.5 text-base"
                              icon="add"
                            ></svg-vue>
                            <span>Add Period</span>
                          </a>
                        </div>
                      </div>
                      <div class="ml-4">
                        <!-- for indicators -->
                        <div class="indicators">
                          <table class="mb-3">
                            <tbody>
                              <tr>
                                <td>Indicator Title</td>
                                <td>
                                  <template
                                    v-for="(title, t) in post.indicator.title[0]
                                      .narrative"
                                    :key="t"
                                  >
                                    <div
                                      class="title-content"
                                      :class="{
                                        'mb-1.5':
                                          t !==
                                          post.indicator.title[0].narrative
                                            .length -
                                            1,
                                      }"
                                    >
                                      <div class="mb-1 language">
                                        (Language: {{ title.language }})
                                      </div>
                                      <div class="text-xs description">
                                        {{ title.narrative }}
                                      </div>
                                    </div>
                                  </template>
                                </td>
                              </tr>

                              <tr v-if="post.indicator.measure">
                                <td>Measure</td>
                                <td>{{ post.indicator.measure }}</td>
                              </tr>

                              <tr v-if="post.indicator.aggregation_status">
                                <td>Aggregation Status</td>
                                <td>{{ post.indicator.aggregation_status }}</td>
                              </tr>

                              <tr>
                                <td>Description</td>
                                <td>
                                  <template
                                    v-for="(description, d) in post.indicator
                                      .description[0].narrative"
                                    :key="d"
                                  >
                                    <div
                                      class="title-content"
                                      :class="{
                                        'mb-1.5':
                                          d !==
                                          post.indicator.description[0]
                                            .narrative.length -
                                            1,
                                      }"
                                    >
                                      <div class="mb-1 language">
                                        (Language: {{ description.language }})
                                      </div>
                                      <div class="text-xs description">
                                        {{ description.narrative }}
                                      </div>
                                    </div>
                                  </template>
                                </td>
                              </tr>

                              <tr>
                                <td>Reference</td>
                                <td>
                                  <div
                                    v-for="(ref, r) in post.indicator.reference"
                                    :key="r"
                                    :class="{
                                      'mb-1.5':
                                        r !==
                                        post.indicator.reference.length - 1,
                                    }"
                                  >
                                    <span v-if="ref.vocabulary">
                                      Vocabulary: {{ ref.vocabulary }},
                                    </span>
                                    <span v-if="ref.code">
                                      Code: {{ ref.code }},
                                    </span>
                                    <span v-if="ref.indicator_uri">
                                      Indicator URI: {{ ref.indicator_uri }}
                                    </span>
                                  </div>
                                </td>
                              </tr>

                              <tr>
                                <td>Baseline</td>
                                <td>
                                  <div
                                    v-for="(base, b) in post.indicator.baseline"
                                    :key="b"
                                    :class="{
                                      'mb-1.5':
                                        b !==
                                        post.indicator.baseline.length - 1,
                                    }"
                                  >
                                    <div>
                                      <span>
                                        Year:
                                        <template v-if="base.year">
                                          {{ base.year }}
                                        </template>
                                        <template v-else
                                          >Not Available</template
                                        >
                                        ,
                                      </span>
                                      <span>
                                        Date:
                                        <template v-if="base.date">
                                          {{ base.date }}
                                        </template>
                                        <template v-else
                                          >Not Available</template
                                        >
                                        ,
                                      </span>
                                      <span>
                                        Date:
                                        <template v-if="base.value">
                                          {{ base.value }}
                                        </template>
                                        <template v-else
                                          >Not Available</template
                                        >
                                      </span>
                                    </div>
                                    <div class="flex">
                                      <div>Location:&nbsp;</div>
                                      <div>
                                        <div
                                          v-for="(loc, l) in base.location"
                                          :key="l"
                                          class="item"
                                          :class="{
                                            'mb-1.5':
                                              l !== base.location.length - 1,
                                          }"
                                        >
                                          <template v-if="loc.reference">
                                            {{ loc.reference }}
                                          </template>
                                          <template v-else
                                            >Not Available</template
                                          >
                                        </div>
                                      </div>
                                    </div>

                                    <div class="flex">
                                      <div>Dimension:&nbsp;</div>
                                      <div>
                                        <div
                                          v-for="(dim, d) in base.dimension"
                                          :key="d"
                                          :class="{
                                            'mb-1.5':
                                              d !== base.dimension.length - 1,
                                          }"
                                        >
                                          <div>
                                            <span>
                                              <template v-if="dim.name">
                                                {{ dim.name }}
                                              </template>
                                              <template v-else>
                                                Not Available
                                              </template>
                                              &nbsp;
                                            </span>
                                            <span>
                                              <template v-if="dim.value">
                                                ({{ dim.value }})
                                              </template>
                                              <template v-else>
                                                (Not Available)
                                              </template>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="flex">
                                      <div>Comment:&nbsp;</div>
                                      <div>
                                        <div
                                          v-for="(com, c) in base.comment[0]
                                            .narrative"
                                          :key="c"
                                          class="item"
                                          :class="{
                                            'mb-1.5':
                                              c !==
                                              base.comment[0].narrative - 1,
                                          }"
                                        >
                                          <div>
                                            <span>
                                              <template v-if="com.narrative">
                                                {{ com.narrative }}
                                              </template>
                                              <template v-else>
                                                Not Available
                                              </template>
                                              &nbsp;
                                            </span>
                                            <span>
                                              (Language:
                                              <template v-if="com.language">
                                                {{ com.language }})
                                              </template>
                                              <template v-else>
                                                Not Available)
                                              </template>
                                            </span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        <!-- for periods -->
                        <div class="periods">
                          <table v-for="(item, key) in post.periods" :key="key">
                            <tbody>
                              <tr>
                                <td>
                                  <div class="category">
                                    Period {{ Number(key) + 1 }}
                                  </div>
                                </td>
                                <td>
                                  <div class="flex category">
                                    <div class="mr-10">
                                      {{
                                        dateFormat(
                                          item.period.period_start[0].date,
                                          'MMMM DD, YYYY'
                                        )
                                      }}
                                      -
                                      {{
                                        dateFormat(
                                          item.period.period_end[0].date,
                                          'MMMM DD, YYYY'
                                        )
                                      }}
                                    </div>
                                    <div
                                      class="flex justify-between shrink-0 grow"
                                    >
                                      <a
                                        :href="`/activities/${result.activity_id}/result/${result.id}/indicator/${post.id}/period/${item.id}/edit`"
                                        class="flex items-center font-bold uppercase text-tiny text-bluecoral"
                                      >
                                        <svg-vue
                                          class="mr-0.5 text-base"
                                          icon="edit"
                                        ></svg-vue>
                                        <span>Edit Period</span>
                                      </a>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td>Target Value</td>
                                <td>
                                  <template
                                    v-for="(tar, t) in item.period.target"
                                    :key="t"
                                  >
                                    <div
                                      class="item"
                                      :class="{
                                        'mb-1.5': t !== item.period.target - 1,
                                      }"
                                    >
                                      <div class="mb-1 language target_value">
                                        {{ tar.value }}
                                      </div>

                                      <div class="flex location_reference">
                                        <div>Location Reference:&nbsp;</div>
                                        <div>
                                          <div
                                            v-for="(loc, l) in tar.location"
                                            :key="l"
                                            class="item"
                                            :class="{
                                              'mb-1.5':
                                                l !== tar.location.length - 1,
                                            }"
                                          >
                                            <div>
                                              <span>
                                                <template v-if="loc.reference">
                                                  {{ loc.reference }}
                                                </template>
                                                <template v-else>
                                                  Not Available
                                                </template>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="flex dimension">
                                        <div>Dimension:&nbsp;</div>
                                        <div>
                                          <div
                                            v-for="(dim, d) in tar.dimension"
                                            :key="d"
                                            class="item"
                                            :class="{
                                              'mb-1.5':
                                                d !== tar.dimension.length - 1,
                                            }"
                                          >
                                            <span>
                                              <template v-if="dim.name">
                                                {{ dim.name }}
                                              </template>
                                              <template v-else>
                                                Not Available
                                              </template>
                                            </span>
                                            <span>
                                              <template v-if="dim.value">
                                                ({{ dim.value }})
                                              </template>
                                              <template v-else>
                                                (Not Available)
                                              </template>
                                            </span>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="flex">
                                        <div>Comment:&nbsp;</div>
                                        <div>
                                          <div
                                            v-for="(com, c) in tar.comment[0]
                                              .narrative"
                                            :key="c"
                                            class="item"
                                            :class="{
                                              'mb-1.5':
                                                c !== tar.comment.length - 1,
                                            }"
                                          >
                                            <div>
                                              <span>
                                                <template v-if="com.narrative">
                                                  {{ com.narrative }}
                                                </template>
                                                <template v-else>
                                                  Not Available
                                                </template>
                                                &nbsp;
                                              </span>
                                              <span>
                                                (Language:
                                                <template v-if="com.language">
                                                  {{ com.language }})
                                                </template>
                                                <template v-else>
                                                  Not Available)
                                                </template>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </template>
                                </td>
                              </tr>

                              <tr>
                                <td>Actual Value</td>
                                <td>
                                  <template
                                    v-for="(tar, t) in item.period.actual"
                                    :key="t"
                                  >
                                    <div
                                      class="item"
                                      :class="{
                                        'mb-1.5': t !== item.period.target - 1,
                                      }"
                                    >
                                      <div class="mb-1 language target_value">
                                        {{ tar.value }}
                                      </div>

                                      <div class="flex location_reference">
                                        <div>Location Reference:&nbsp;</div>
                                        <div>
                                          <div
                                            v-for="(loc, l) in tar.location"
                                            :key="l"
                                            class="item"
                                            :class="{
                                              'mb-1.5':
                                                l !== tar.location.length - 1,
                                            }"
                                          >
                                            <div>
                                              <span>
                                                <template v-if="loc.reference">
                                                  {{ loc.reference }}
                                                </template>
                                                <template v-else>
                                                  Not Available
                                                </template>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="flex dimension">
                                        <div>Dimension:&nbsp;</div>
                                        <div>
                                          <div
                                            v-for="(dim, d) in tar.dimension"
                                            :key="d"
                                            class="item"
                                            :class="{
                                              'mb-1.5':
                                                d !== tar.dimension.length - 1,
                                            }"
                                          >
                                            <span>
                                              <template v-if="dim.name">
                                                {{ dim.name }}
                                              </template>
                                              <template v-else>
                                                Not Available
                                              </template>
                                            </span>
                                            <span>
                                              <template v-if="dim.value">
                                                ({{ dim.value }})
                                              </template>
                                              <template v-else>
                                                (Not Available)
                                              </template>
                                            </span>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="flex">
                                        <div>Comment:&nbsp;</div>
                                        <div>
                                          <div
                                            v-for="(com, c) in tar.comment[0]
                                              .narrative"
                                            :key="c"
                                            class="item"
                                            :class="{
                                              'mb-1.5':
                                                c !== tar.comment.length - 1,
                                            }"
                                          >
                                            <div>
                                              <span>
                                                <template v-if="com.narrative">
                                                  {{ com.narrative }}
                                                </template>
                                                <template v-else>
                                                  Not Available
                                                </template>
                                                &nbsp;
                                              </span>
                                              <span>
                                                (Language:
                                                <template v-if="com.language">
                                                  {{ com.language }})
                                                </template>
                                                <template v-else>
                                                  Not Available)
                                                </template>
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </template>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>

        <!-- indicator button -->
        <button
          class="flex w-full py-6 text-xs leading-normal bg-white border border-dashed rounded add_indicator border-n-40 px-9"
        >
          <div class="text-left grow">You haven't added any indicator yet.</div>
          <div
            class="flex items-center font-bold uppercase shrink-0 text-bluecoral"
          >
            <svg-vue icon="add" class="mr-1 shrink-0"></svg-vue>
            <span class="grow">Add new indicator</span>
          </div>
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import ResultElement from './ResultElement.vue';
import dateFormat from './../../../composable/dateFormat';

export default defineComponent({
  name: 'ResultDetail',
  components: {
    ResultElement,
  },
  props: {
    activity: {
      type: Object,
      required: true,
    },
    result: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const linkClasses =
      'flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-relaxed mb-2 shadow-default';

    return {
      linkClasses,
      dateFormat,
    };
  },
});
</script>

<style lang="scss" scoped></style>
