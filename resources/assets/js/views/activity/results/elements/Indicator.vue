<template>
  <div
    id="indicator"
    class="px-3 py-3 activities__content--element basis-full text-n-50"
  >
    <div class="p-4 bg-white rounded-lg">
      <div class="flex mb-4">
        <div class="flex items-center title grow">
          <svg-vue class="mr-1.5 text-xl text-bluecoral" icon="bill"></svg-vue>
          <div class="text-sm font-bold title">Indicator</div>
          <div class="status ml-2.5 flex text-xs leading-5 text-crimson-50">
            <b class="mr-2 text-base leading-3">.</b>
            <span>not completed</span>
          </div>
        </div>
        <div class="flex items-center icons">
          <Btn
            text="Show full indicator list"
            icon="add"
            :link="`/activities/${result.activity_id}/result/${result.id}/indicator/create`"
            class="mr-2.5"
          />
          <Btn
            text="Show full indicator list"
            icon=""
            design="bgText"
            :link="`/activities/${result.activity_id}/result/${result.id}/indicator`"
            class="mr-2.5"
          />
          <svg-vue class="mr-1.5" icon="moon"></svg-vue>
          <div class="help text-n-40">
            <button>
              <svg-vue icon="help"></svg-vue>
            </button>
            <div class="right-0 help__text w-60">
              <span class="font-bold text-bluecoral"></span>
              <p :v-html="toolTip"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full h-px mb-4 border-b divider border-n-20"></div>
      <div class="indicator">
        <template v-for="(post, ri) in indicatorData" :key="ri">
          <div class="item">
            <div class="elements-detail wider">
              <div class="flex category">
                <div class="mr-4">
                  <a
                    class="text-n-50"
                    :href="`/activities/${result.activity_id}/result/${result.id}/indicator/${post.id}`"
                  >
                    {{
                      getActivityTitle(post.indicator.title[0].narrative, 'en')
                    }}
                  </a>
                </div>
                <div class="flex justify-between shrink-0 grow">
                  <a
                    :href="`/activities/${result.activity_id}/result/${result.id}/indicator/${post.id}/edit`"
                    class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
                    <span>Edit Indicator</span>
                  </a>
                  <a
                    :href="`/activities/${result.activity_id}/result/${result.id}/indicator/${post.id}/period/create`"
                    class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="add"></svg-vue>
                    <span>Add Period</span>
                  </a>
                </div>
              </div>
              <div class="ml-4">
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
                                  post.indicator.title[0].narrative.length - 1,
                              }"
                            >
                              <div class="mb-1 language">
                                (Language: {{ type.language[title.language] }})
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
                        <td>
                          {{ type.indicatorMeasure[post.indicator.measure] }}
                        </td>
                      </tr>

                      <tr v-if="post.indicator.aggregation_status">
                        <td>Aggregation Status</td>
                        <td>{{ post.indicator.aggregation_status != 0 }}</td>
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
                                  post.indicator.description[0].narrative
                                    .length -
                                    1,
                              }"
                            >
                              <div class="mb-1 language">
                                (Language:
                                {{ type.language[description.language] }})
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
                                r !== post.indicator.reference.length - 1,
                            }"
                          >
                            <span v-if="ref.vocabulary">
                              Vocabulary: {{ ref.vocabulary }},
                            </span>
                            <span v-if="ref.code"> Code: {{ ref.code }}, </span>
                            <span v-if="ref.indicator_uri">
                              Indicator URI: {{ ref.indicator_uri }}
                            </span>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>Document Link</td>
                        <td>{{ post.indicator.document_link.length }}</td>
                      </tr>

                      <tr>
                        <td>Baseline</td>
                        <td>
                          <div
                            v-for="(base, b) in post.indicator.baseline"
                            :key="b"
                            :class="{
                              'mb-1.5':
                                b !== post.indicator.baseline.length - 1,
                            }"
                          >
                            <div>
                              <span>
                                Year:
                                <template v-if="base.year">
                                  {{ base.year }}
                                </template>
                                <template v-else>Not Available</template>
                                ,
                              </span>
                              <span>
                                Date:
                                <template v-if="base.date">
                                  {{ base.date }}
                                </template>
                                <template v-else>Not Available</template>
                                ,
                              </span>
                              <span>
                                Value:
                                <template v-if="base.value">
                                  {{ base.value }}
                                </template>
                                <template v-else>Not Available</template>
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
                                    'mb-1.5': l !== base.location.length - 1,
                                  }"
                                >
                                  <template v-if="loc.reference">
                                    {{ loc.reference }}
                                  </template>
                                  <template v-else>Not Available</template>
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
                                    'mb-1.5': d !== base.dimension.length - 1,
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
                                  v-for="(com, c) in base.comment[0].narrative"
                                  :key="c"
                                  class="item"
                                  :class="{
                                    'mb-1.5':
                                      c !==
                                      base.comment[0].narrative.length - 1,
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
                                        {{ type.language[com.language] }})
                                      </template>
                                      <template v-else>
                                        Not Available)
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>Document Link:&nbsp;</div>
                              <div>
                                {{ base.document_link.length }}
                              </div>
                            </div>
                          </div>
                        </td>
                      </tr>

                      <tr v-if="post.periods.length === 0">
                        <td></td>
                        <td>
                          <div class="mt-3">
                            <NotYet
                              :link="`/activities/${result.activity_id}/result/${result.id}/indicator/${post.id}/period/create`"
                              description="You haven't added any periods yet."
                              btn-text="Add period"
                              class="w-[442px]"
                            />
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- for periods -->
                <div v-if="post.periods.length > 0" class="periods">
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
                              <a
                                class="text-n-50"
                                :href="`/activities/${result.activity_id}/result/${result.id}/indicator/${post.id}/period/${item.id}`"
                              >
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
                              </a>
                            </div>
                            <div class="flex justify-between shrink-0 grow">
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
                                'mb-1.5': t !== item.period.target.length - 1,
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
                                      'mb-1.5': l !== tar.location.length - 1,
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
                                      'mb-1.5': d !== tar.dimension.length - 1,
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
                                    v-for="(com, c) in tar.comment[0].narrative"
                                    :key="c"
                                    class="item"
                                    :class="{
                                      'mb-1.5': c !== tar.comment.length - 1,
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
                                          {{ type.language[com.language] }})
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
                                'mb-1.5': t !== item.period.actual.length - 1,
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
                                      'mb-1.5': l !== tar.location.length - 1,
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
                                      'mb-1.5': d !== tar.dimension.length - 1,
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
                                    v-for="(com, c) in tar.comment[0].narrative"
                                    :key="c"
                                    class="item"
                                    :class="{
                                      'mb-1.5': c !== tar.comment.length - 1,
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
                                          {{ type.language[com.language] }})
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
          <div
            v-if="ri != indicatorData.length - 1"
            class="w-full h-px my-8 border-b divider border-n-20"
          ></div>
        </template>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

//composable
import dateFormat from 'Composable/dateFormat';
import getActivityTitle from 'Composable/title';

//components
import NotYet from 'Components/sections/HaveNotAddedYet.vue';
import Btn from 'Components/buttons/Link.vue';

export default defineComponent({
  name: 'ResultIndicator',
  components: {
    NotYet,
    Btn,
  },
  props: {
    result: {
      type: Object,
      required: true,
    },
    type: {
      type: Object,
      required: true,
    },
    toolTip: {
      type: String,
      required: false,
      default: '',
    },
  },
  setup(props) {
    let { result } = toRefs(props);

    const indicatorData = result.value.indicators.reverse();
    return { indicatorData, dateFormat, getActivityTitle };
  },
});
</script>
