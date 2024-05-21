<template>
  <div
    id="indicator"
    class="activities__content--element !bg-red w-full basis-full px-3 py-3 text-n-50"
  >
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow items-center">
          <svg-vue class="mr-1.5 text-xl text-bluecoral" icon="bill"></svg-vue>
          <div class="title text-sm font-bold">Indicator</div>
          <!--          <div class="status ml-2.5 flex text-xs leading-5 text-crimson-50">-->
          <!--            <b class="mr-2 text-base leading-3">.</b>-->
          <!--            <span>not completed</span>-->
          <!--          </div>-->
        </div>
        <div class="icons flex items-center">
          <Btn
            text="Add Indicator"
            icon="add"
            :link="`/result/${result.id}/indicator/create`"
            class="mr-2.5"
          />
          <Btn
            text="Show full indicator list"
            icon=""
            design="bgText"
            :link="`/result/${result.id}/indicator`"
            class="mr-2.5"
          />
          <svg-vue class="mr-1.5" icon="core"></svg-vue>
          <div class="help text-n-40">
            <button>
              <svg-vue icon="help"></svg-vue>
            </button>
            <div class="help__text right-0 w-60">
              <span class="font-bold text-bluecoral"></span>
              <p :v-html="toolTip"></p>
            </div>
          </div>
        </div>
      </div>
      <HelperText :helper-text="onlyDeprecatedStatusMap(indicatorData)" />
      <div class="divider mb-4 h-px w-full border-b border-n-20"></div>
      <div class="indicator">
        <template v-for="(post, ri) in indicatorData" :key="ri">
          <div class="item">
            <div class="elements-detail wider">
              <div class="category flex">
                <div class="mr-4">
                  <a
                    class="text-n-50"
                    :href="`/result/${result.id}/indicator/${post.id}`"
                  >
                    {{
                      getActivityTitle(post.indicator.title[0].narrative, 'en')
                    }}
                  </a>
                </div>
                <div class="flex shrink-0 grow justify-between">
                  <span class="flex">
                    <Btn
                      text="View Indicator"
                      icon="eye"
                      :link="`/result/${result.id}/indicator/${post.id}`"
                      class="mr-2.5"
                    />
                    <Btn
                      text="Edit Indicator"
                      icon="edit"
                      :link="`/result/${result.id}/indicator/${post.id}/edit`"
                    />
                  </span>
                  <Btn
                    text="Add Period"
                    icon="edit"
                    :link="`/indicator/${post.id}/period/create`"
                    class="mr-2.5"
                  />
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
                              <div class="language mb-1">
                                (Language:
                                {{
                                  type.language[title.language]
                                    ? type.language[title.language]
                                    : 'Missing'
                                }})
                              </div>
                              <div class="description text-xs">
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
                              <div class="language mb-1">
                                (Language:
                                {{
                                  type.language[description.language]
                                    ? type.language[description.language]
                                    : 'Missing'
                                }})
                              </div>
                              <div class="description text-xs">
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
                            <span>
                              Vocabulary: {{ ref.vocabulary ?? 'Missing' }},
                            </span>
                            <span>
                              Code: {{ ref.code ? ref.code : 'Missing' }},
                            </span>
                            <span>
                              Indicator URI:
                              <a
                                v-if="ref.indicator_uri"
                                :href="ref.indicator_uri"
                                class="cursor-pointer"
                                target="_blank"
                              >
                                {{ ref.indicator_uri }}</a
                              >
                              <span v-else>Mising</span>
                            </span>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>Document Link</td>
                        <td>
                          {{ countDocumentLink(post.indicator.document_link) }}
                          documents
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
                                b !== post.indicator.baseline.length - 1,
                            }"
                          >
                            <div>
                              <span>
                                Year:
                                <template v-if="base.year">
                                  {{ base.year }}
                                </template>
                                <template v-else>Missing</template>
                                ,
                              </span>
                              <span>
                                Date:
                                <template v-if="base.date">
                                  {{ base.date }}
                                </template>
                                <template v-else>Missing</template>
                                ,
                              </span>
                              <span>
                                Value:
                                <template v-if="base.value">
                                  {{ base.value }}
                                </template>
                                <template v-else>Missing</template>
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
                                  <template v-else>Missing</template>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>Dimension:&nbsp;</div>
                              <div class="description">
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
                                      <template v-else> Missing </template>
                                      &nbsp;
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else> (Missing) </template>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>Comment:&nbsp;</div>
                              <div class="description">
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
                                      <template v-else> Missing </template>
                                      &nbsp;
                                    </span>
                                    <span>
                                      (Language:
                                      <template v-if="com.language">
                                        {{ type.language[com.language] }})
                                      </template>
                                      <template v-else> Missing) </template>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>Document Link:&nbsp;</div>
                              <div>
                                {{ countDocumentLink(base.document_link) }}
                                document
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
                              :link="`/indicator/${post.id}/period/create`"
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
                          <div class="category flex">
                            <div class="mr-10">
                              <a
                                class="text-n-50"
                                :href="`/indicator/${post.id}/period/${item.id}`"
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
                            <div class="flex shrink-0 grow justify-between">
                              <Btn
                                text="View Period"
                                icon="eye"
                                :link="`/indicator/${post.id}/period/${item.id}`"
                                class="mr-2.5"
                              />
                              <Btn
                                text="Edit Period"
                                icon="edit"
                                :link="`/indicator/${post.id}/period/${item.id}/edit`"
                              />
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
                              <div class="language target_value mb-1">
                                {{ tar.value }}
                              </div>

                              <div class="location_reference flex">
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
                                        <template v-else> Missing </template>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="dimension flex">
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
                                      <template v-else> Missing </template>
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else> (Missing) </template>
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
                                        <template v-else> Missing </template>
                                        &nbsp;
                                      </span>
                                      <span>
                                        (Language:
                                        <template v-if="com.language">
                                          {{ type.language[com.language] }})
                                        </template>
                                        <template v-else> Missing) </template>
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
                              <div class="language target_value mb-1">
                                {{ tar.value }}
                              </div>

                              <div class="location_reference flex">
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
                                        <template v-else> Missing </template>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="dimension flex">
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
                                      <template v-else> Missing </template>
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else> (Missing) </template>
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
                                        <template v-else> Missing </template>
                                        &nbsp;
                                      </span>
                                      <span>
                                        (Language:
                                        <template v-if="com.language">
                                          {{ type.language[com.language] }})
                                        </template>
                                        <template v-else> Missing) </template>
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
            class="divider my-8 h-px w-full border-b border-n-20"
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

// helper function
import { countDocumentLink, onlyDeprecatedStatusMap } from 'Composable/utils';
import HelperText from 'Components/HelperText.vue';

export default defineComponent({
  name: 'ResultIndicator',
  methods: { onlyDeprecatedStatusMap },
  components: {
    HelperText,
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

    return { indicatorData, dateFormat, getActivityTitle, countDocumentLink };
  },
});
</script>
