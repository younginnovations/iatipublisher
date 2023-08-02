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
            {{ translate.commonText('indicator') }}
          </div>
          <!--          <div class="status ml-2.5 flex text-xs leading-5 text-crimson-50">-->
          <!--            <b class="mr-2 text-base leading-3">.</b>-->
          <!--            <span>not completed</span>-->
          <!--          </div>-->
        </div>
        <div class="icons flex items-center">
          <Btn
            :text="translate.button('add_element', 'common.indicator')"
            icon="add"
            :link="`/result/${result.id}/indicator/create`"
            class="mr-2.5"
          />
          <Btn
            :text="translate.button('show_element', 'common.full_indicator')"
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
                        translate.button('view_element', 'common.indicator')
                      "
                      icon="eye"
                      :link="`/result/${result.id}/indicator/${post.id}`"
                      class="mr-2.5"
                    />
                    <Btn
                      :text="
                        translate.button('edit_element', 'common.indicator')
                      "
                      icon="edit"
                      :link="`/result/${result.id}/indicator/${post.id}/edit`"
                    />
                  </span>
                  <Btn
                    :text="translate.button('add_element', 'common.period')"
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
                        <td>{{ translate.commonText('indicator_title') }}</td>
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
                                ({{ translate.commonText('language') }}:
                                {{
                                  type.language[title.language]
                                    ? type.language[title.language]
                                    : translate.missing()
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
                        <td>{{ translate.commonText('measure') }}</td>
                        <td>
                          {{ type.indicatorMeasure[post.indicator.measure] }}
                        </td>
                      </tr>

                      <tr v-if="post.indicator.aggregation_status">
                        <td>
                          {{ translate.commonText('aggregation_status') }}
                        </td>
                        <td>{{ post.indicator.aggregation_status != 0 }}</td>
                      </tr>

                      <tr>
                        <td>{{ translate.commonText('description') }}</td>
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
                                ({{ translate.commonText('language') }}:
                                {{
                                  type.language[description.language]
                                    ? type.language[description.language]
                                    : translate.missing()
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
                        <td>{{ translate.commonText('reference') }}</td>
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
                              {{ translate.commonText('vocabulary') }}:
                              {{ ref.vocabulary ?? translate.missing() }},
                            </span>
                            <span>
                              {{ translate.commonText('code') }}:
                              {{ ref.code ? ref.code : translate.missing() }},
                            </span>
                            <span>
                              {{ translate.commonText('indicator_uri') }}:
                              <a
                                v-if="ref.indicator_uri"
                                :href="ref.indicator_uri"
                                class="cursor-pointer"
                                target="_blank"
                              >
                                {{ ref.indicator_uri }}</a
                              >
                              <span v-else>
                                {{ translate.missing() }}
                              </span>
                            </span>
                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td>{{ translate.commonText('document_link') }}</td>
                        <td>
                          {{ countDocumentLink(post.indicator.document_link) }}
                          {{ translate.commonText('documents') }}
                        </td>
                      </tr>

                      <tr>
                        <td>{{ translate.commonText('baseline') }}</td>
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
                                {{ translate.commonText('year') }}:
                                <template v-if="base.year">
                                  {{ base.year }}
                                </template>
                                <template v-else>{{
                                  translate.missing()
                                }}</template>
                                ,
                              </span>
                              <span>
                                {{ translate.commonText('date') }}:
                                <template v-if="base.date">
                                  {{ base.date }}
                                </template>
                                <template v-else>{{
                                  translate.missing()
                                }}</template>
                                ,
                              </span>
                              <span>
                                {{ translate.commonText('value') }}:
                                <template v-if="base.value">
                                  {{ base.value }}
                                </template>
                                <template v-else>{{
                                  translate.missing()
                                }}</template>
                              </span>
                            </div>
                            <div class="flex">
                              <div>
                                {{ translate.commonText('location') }}:&nbsp;
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
                                    translate.missing()
                                  }}</template>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>
                                {{ translate.commonText('dimension') }}:&nbsp;
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
                                        {{ translate.missing() }}
                                      </template>
                                      &nbsp;
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else>
                                        ({{ translate.missing() }})
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>
                                {{ translate.commonText('comment') }}:&nbsp;
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
                                        {{ translate.missing() }}
                                      </template>
                                      &nbsp;
                                    </span>
                                    <span>
                                      ({{ translate.commonText('language') }}:
                                      <template v-if="com.language">
                                        {{ type.language[com.language] }})
                                      </template>
                                      <template v-else>
                                        {{ translate.missing() }})
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class="flex">
                              <div>
                                {{ translate.commonText('document_link') }}
                                }}:&nbsp;
                              </div>
                              <div>
                                {{ countDocumentLink(base.document_link) }}
                                {{ translate.commonText('document') }}
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
                                translate.button('not_yet_added_period')
                              "
                              :btn-text="
                                translate.button('add_element', 'common.period')
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
                            {{ translate.commonText('period') }}
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
                                  translate.button(
                                    'view_element',
                                    'common.period'
                                  )
                                "
                                icon="eye"
                                :link="`/indicator/${post.id}/period/${item.id}`"
                                class="mr-2.5"
                              />
                              <Btn
                                :text="
                                  translate.button(
                                    'edit_element',
                                    'common.period'
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
                        <td>{{ translate.commonText('target_value') }}</td>
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
                                    translate.commonText('location_reference')
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
                                          {{ translate.missing() }}
                                        </template>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="dimension flex">
                                <div>
                                  {{ translate.commonText('dimension') }}:&nbsp;
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
                                        {{ translate.missing() }}
                                      </template>
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else>
                                        ({{ translate.missing() }})
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>

                              <div class="flex">
                                <div>
                                  {{ translate.commonText('comment') }}:&nbsp;
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
                                          {{ translate.missing() }}</template
                                        >
                                        &nbsp;
                                      </span>
                                      <span>
                                        (
                                        {{ translate.commonText('language') }}:
                                        <template v-if="com.language">
                                          {{ type.language[com.language] }})
                                        </template>
                                        <template v-else>
                                          {{ translate.missing() }}
                                          )
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
                        <td>{{ translate.commonText('actual_value') }}</td>
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
                                    translate.commonText('location_reference')
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
                                          {{ translate.missing() }}
                                        </template>
                                      </span>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="dimension flex">
                                <div>
                                  {{ translate.commonText('dimension') }}:&nbsp;
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
                                        {{ translate.missing() }}</template
                                      >
                                    </span>
                                    <span>
                                      <template v-if="dim.value">
                                        ({{ dim.value }})
                                      </template>
                                      <template v-else>
                                        ({{ translate.missing() }})
                                      </template>
                                    </span>
                                  </div>
                                </div>
                              </div>

                              <div class="flex">
                                <div>
                                  {{ translate.commonText('comment') }}:&nbsp;
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
                                          {{ translate.missing() }}</template
                                        >
                                        &nbsp;
                                      </span>
                                      <span>
                                        (
                                        {{ translate.commonText('language') }}:
                                        <template v-if="com.language">
                                          {{ type.language[com.language] }})
                                        </template>
                                        <template v-else>
                                          {{ translate.missing() }}
                                          )
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
import { Translate } from 'Composable/translationHelper';

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
    const translate = new Translate();
    let { result } = toRefs(props);

    const indicatorData = result.value.indicators.reverse();

    return {
      indicatorData,
      dateFormat,
      getActivityTitle,
      countDocumentLink,
      translate,
    };
  },
});
</script>
