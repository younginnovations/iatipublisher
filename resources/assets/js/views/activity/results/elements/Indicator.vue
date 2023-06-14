<template>
  <div
    id="indicator"
    class="activities__content--element !bg-red w-full basis-full px-3 py-3 text-n-50"
  >
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow items-center">
          <svg-vue class="mr-1.5 text-xl text-bluecoral" icon="bill"></svg-vue>
          <div class="title text-sm font-bold">
            {{ language.common_lang.indicator }}
          </div>
          <!--          <div class="status ml-2.5 flex text-xs leading-5 text-crimson-50">-->
          <!--            <b class="mr-2 text-base leading-3">.</b>-->
          <!--            <span>not completed</span>-->
          <!--          </div>-->
        </div>
        <div class="icons flex items-center">
          <Btn
            :text="
              language.button_lang.add_element.replace(
                ':element',
                language.common_lang.indicator
              )
            "
            icon="add"
            :link="`/result/${result.id}/indicator/create`"
            class="mr-2.5"
          />
          <Btn
            :text="
              language.button_lang.show_element.replace(
                ':element',
                language.common_lang.full_indicator
              )
            "
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
                      :text="
                        language.button_lang.view_element.replace(
                          ':element',
                          language.common_lang.indicator
                        )
                      "
                      icon="eye"
                      :link="`/result/${result.id}/indicator/${post.id}`"
                      class="mr-2.5"
                    />
                    <Btn
                      :text="
                        language.button_lang.edit_element.replace(
                          ':element',
                          language.common_lang.indicator
                        )
                      "
                      icon="edit"
                      :link="`/result/${result.id}/indicator/${post.id}/edit`"
                    />
                  </span>
                  <Btn
                    :text="
                      language.button_lang.add_element.replace(
                        ':element',
                        language.common_lang.period
                      )
                    "
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
                        <td>{{ language.common_lang.indicator_title }}</td>
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
                                ({{ language.common_lang.language }}:
                                {{
                                  type.language[title.language]
                                    ? type.language[title.language]
                                    : language.common_lang.missing.default
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
                        <td>{{ language.common_lang.measure }}</td>
                        <td>
                          {{ type.indicatorMeasure[post.indicator.measure] }}
                        </td>
                      </tr>

                      <tr v-if="post.indicator.aggregation_status">
                        <td>{{ language.common_lang.aggregation_status }}</td>
                        <td>{{ post.indicator.aggregation_status != 0 }}</td>
                      </tr>

                      <tr>
                        <td>{{ language.common_lang.description }}</td>
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
                                ({{ language.common_lang.language }}:
                                {{
                                  type.language[description.language]
                                    ? type.language[description.language]
                                    : language.common_lang.missing.default
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
                        <td>{{ language.common_lang.reference_label }}</td>
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
                              {{ language.common_lang.vocabulary }}:
                              {{
                                ref.vocabulary ??
                                language.common_lang.missing.default
                              }},
                            </span>
                            <span>
                              {{ language.common_lang.code }}:
                              {{
                                ref.code
                                  ? ref.code
                                  : language.common_lang.missing.default
                              }},
                            </span>
                            <span>
                              {{ language.common_lang.indicator_uri }}:
                              <a
                                v-if="ref.indicator_uri"
                                :href="ref.indicator_uri"
                                class="cursor-pointer"
                                target="_blank"
                              >
                                {{ ref.indicator_uri }}</a
                              >
                              <span v-else>{{
                                language.common_lang.missing.default
                              }}</span>
                            </span>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>{{ language.common_lang.document_link }}</td>
                        <td>
                          {{ countDocumentLink(post.indicator.document_link) }}
                          {{ language.common_lang.documents }}
                        </td>
                      </tr>

                      <tr>
                        <td>{{ language.common_lang.baseline }}</td>
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
                                {{ language.common_lang.year }}:
                                <template v-if="base.year">
                                  {{ base.year }}
                                </template>
                                <template v-else>{{
                                  language.common_lang.missing.default
                                }}</template>
                                ,
                              </span>
                              <span>
                                {{ language.common_lang.date }}:
                                <template v-if="base.date">
                                  {{ base.date }}
                                </template>
                                <template v-else>{{
                                  language.common_lang.missing.default
                                }}</template>
                                ,
                              </span>
                              <span>
                                {{ language.common_lang.value }}:
                                <template v-if="base.value">
                                  {{ base.value }}
                                </template>
                                <template v-else>{{
                                  language.common_lang.missing.default
                                }}</template>
                              </span>
                            </div>
                            <div class="flex">
                              <div>
                                {{ language.common_lang.location }}:&nbsp;
                              </div>
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
                                  <template v-else>{{
                                    language.common_lang.missing.default
                                  }}</template>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>
                                {{ language.common_lang.dimension }}:&nbsp;
                              </div>
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
                                      <template v-else>
                                        {{
                                          language.common_lang.missing.default
                                        }}
                                      </template>
                                      &nbsp;
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else>
                                        ({{
                                          language.common_lang.missing.default
                                        }})
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>
                                {{ language.common_lang.comment }}:&nbsp;
                              </div>
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
                                      <template v-else>
                                        {{
                                          language.common_lang.missing.default
                                        }}
                                      </template>
                                      &nbsp;
                                    </span>
                                    <span>
                                      ({{ language.common_lang.language }}:
                                      <template v-if="com.language">
                                        {{ type.language[com.language] }})
                                      </template>
                                      <template v-else>
                                        {{
                                          language.common_lang.missing.default
                                        }})
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>
                                {{ language.common_lang.document_link }}:&nbsp;
                              </div>
                              <div>
                                {{ countDocumentLink(base.document_link) }}
                                {{ language.common_lang.document }}
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
                              :description="
                                language.button_lang.not_yet_added_period
                              "
                              :btn-text="
                                language.button_lang.add_element.replace(
                                  ':element',
                                  language.common_lang.period
                                )
                              "
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
                            {{ language.common_lang.period }}
                            {{ Number(key) + 1 }}
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
                                :text="
                                  language.button_lang.view_element.replace(
                                    ':element',
                                    language.common_lang.period
                                  )
                                "
                                icon="eye"
                                :link="`/indicator/${post.id}/period/${item.id}`"
                                class="mr-2.5"
                              />
                              <Btn
                                :text="
                                  language.button_lang.edit_element.replace(
                                    ':element',
                                    language.common_lang.period
                                  )
                                "
                                icon="edit"
                                :link="`/indicator/${post.id}/period/${item.id}/edit`"
                              />
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>{{ language.common_lang.target_value }}</td>
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
                                <div>
                                  {{
                                    language.common_lang.location_reference
                                  }}:&nbsp;
                                </div>
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
                                          {{
                                            language.common_lang.missing.default
                                          }}
                                        </template>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="dimension flex">
                                <div>
                                  {{ language.common_lang.dimension }}:&nbsp;
                                </div>
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
                                        {{
                                          language.common_lang.missing.default
                                        }}
                                      </template>
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else>
                                        ({{
                                          language.common_lang.missing.default
                                        }})
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>

                              <div class="flex">
                                <div>
                                  {{ language.common_lang.comment }}:&nbsp;
                                </div>
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
                                          {{
                                            language.common_lang.missing.default
                                          }}</template
                                        >
                                        &nbsp;
                                      </span>
                                      <span>
                                        ({{ language.common_lang.language }}:
                                        <template v-if="com.language">
                                          {{ type.language[com.language] }})
                                        </template>
                                        <template v-else>
                                          {{
                                            language.common_lang.missing
                                              .default
                                          }})
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
                        <td>{{ language.common_lang.actual_value }}</td>
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
                                <div>
                                  {{
                                    language.common_lang.location_reference
                                  }}:&nbsp;
                                </div>
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
                                          {{
                                            language.common_lang.missing.default
                                          }}
                                        </template>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="dimension flex">
                                <div>
                                  {{ language.common_lang.dimension }}:&nbsp;
                                </div>
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
                                        {{
                                          language.common_lang.missing.default
                                        }}</template
                                      >
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else>
                                        ({{
                                          language.common_lang.missing.default
                                        }})
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>

                              <div class="flex">
                                <div>
                                  {{ language.common_lang.comment }}:&nbsp;
                                </div>
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
                                          {{
                                            language.common_lang.missing.default
                                          }}</template
                                        >
                                        &nbsp;
                                      </span>
                                      <span>
                                        ({{ language.common_lang.language }}:
                                        <template v-if="com.language">
                                          {{ type.language[com.language] }})
                                        </template>
                                        <template v-else>
                                          {{
                                            language.common_lang.missing
                                              .default
                                          }})
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
import { countDocumentLink } from 'Composable/utils';

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
    const language = window['globalLang'];
    let { result } = toRefs(props);

    const indicatorData = result.value.indicators.reverse();

    return {
      indicatorData,
      dateFormat,
      getActivityTitle,
      countDocumentLink,
      language,
    };
  },
});
</script>
