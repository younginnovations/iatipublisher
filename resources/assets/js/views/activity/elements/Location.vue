<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div
      v-for="(item, i) in post.location_reach"
      :key="i"
      :class="{ 'mb-0': i !== post.location_reach.length - 1 }"
    >
      <div class="category">
        <span v-if="item.code">
          {{ types.geographicLocationReach[item.code] }}
        </span>
        <span v-else class="italic">{{
          translate.missing('location_reached')
        }}</span>
      </div>
    </div>
    <div
      v-for="(item, i) in post.name"
      :key="i"
      :class="{ 'mb-4': i !== post.name.length - 1 }"
    >
      <div
        v-for="(narrative, j) in item.narrative"
        :key="j"
        class="text-sm"
        :class="{ 'mb-4': j !== item.narrative.length - 1 }"
      >
        <div v-if="narrative.narrative" class="flex flex-col-reverse space-x-1">
          <span>{{ narrative.narrative }}</span>
          <span v-if="narrative.language" class="italic text-n-30"
            >({{ translate.commonText('language') }}:
            {{ types.languages[narrative.language] }})</span
          >
        </div>
        <span v-else class="italic"> {{ translate.missing('name') }}</span>
      </div>
    </div>
    <div class="ml-5">
      <table>
        <tr>
          <td>{{ translate.commonText('reference') }}</td>
          <td class="text-sm">
            <span v-if="post.ref">{{ post.ref }}</span>
            <span v-else class="italic">
              {{ translate.missing() }}
            </span>
          </td>
        </tr>
      </table>
    </div>
    <div class="ml-5">
      <div
        v-for="(item, i) in post.location_id"
        :key="i"
        :class="{ 'mb-4': i !== post.location_id.length - 1 }"
      >
        <table class="w-full">
          <tr>
            <td>{{ translate.commonText('location_id') }}</td>
            <td>
              <div class="flex space-x-1">
                <div class="value">
                  <span v-if="item.vocabulary"
                    >{{ types.geographicVocabulary[item.vocabulary] }},
                  </span>
                  <span v-else class="italic"
                    >({{ translate.missing('vocabulary') }})
                  </span>
                </div>
                <div>
                  <span v-if="item.code"
                    >{{ translate.commonText('code') }} {{ item.code }}</span
                  >
                  <span v-else class="italic">({{ translate.missing() }})</span>
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div
        v-for="(item, i) in post.description"
        :key="i"
        :class="{ 'mb-4': i !== post.description.length - 1 }"
      >
        <div
          v-for="(narrative, j) in item.narrative"
          :key="j"
          :class="{ 'mb-4': j !== item.narrative.length - 1 }"
        >
          <table class="w-full">
            <tr class="multiline">
              <td>{{ translate.commonText('description') }}</td>
              <td>
                <div v-if="narrative.narrative" class="flex flex-col">
                  <span v-if="narrative.language" class="language top"
                    >({{ translate.commonText('language') }}:
                    {{ types.languages[narrative.language] }})</span
                  >
                  <span class="description">{{ narrative.narrative }}</span>
                </div>
                <span v-else class="italic">{{ translate.missing() }}</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div
        v-for="(item, i) in post.activity_description"
        :key="i"
        :class="{ 'mb-4': i !== post.activity_description.length - 1 }"
      >
        <div
          v-for="(narrative, j) in item.narrative"
          :key="j"
          :class="{ 'mb-4': j !== item.narrative.length - 1 }"
        >
          <table class="w-full">
            <tr class="multiline">
              <td>{{ translate.commonText('activity_description') }}</td>
              <td>
                <div v-if="narrative.narrative" class="flex flex-col">
                  <span v-if="narrative.language" class="language top"
                    >({{ translate.commonText('language') }}:
                    {{ types.languages[narrative.language] }})</span
                  >
                  <span class="description">{{ narrative.narrative }}</span>
                </div>
                <span v-else class="italic">{{ translate.missing() }}</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div
        v-for="(item, i) in post.administrative"
        :key="i"
        :class="{ 'mb-4': i !== post.administrative.length - 1 }"
      >
        <table class="w-full">
          <tr>
            <td>{{ translate.commonText('administrative') }}</td>
            <td>
              <div class="flex">
                <div>
                  <span v-if="item.vocabulary"
                    >{{ translate.commonText('vocabulary') }} -
                    {{ types.geographicVocabulary[item.vocabulary] }}
                  </span>
                  <span v-else class="italic"
                    >({{ translate.missing('vocabulary') }})</span
                  >
                </div>
                <div>
                  <span v-if="item.code"
                    >, {{ translate.commonText('code') }}
                    {{ types.country[item.code] }}</span
                  >
                  <span v-else class="ml-1 italic">
                    ({{ translate.missing('code') }})</span
                  >
                </div>
                <div>
                  <span v-if="item.level"
                    >, {{ translate.commonText('level') }}
                    {{ item.level }}</span
                  >
                  <span v-else class="ml-1 italic">
                    ({{ translate.missing('level') }})</span
                  >
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div
        v-for="(item, i) in post.point"
        :key="i"
        class="flex space-x-1"
        :class="{ 'mb-4': i !== post.point.length - 1 }"
      >
        <table class="w-full">
          <td>{{ translate.commonText('point') }}</td>
          <tr>
            <td>
              <div class="flex space-x-1">
                <div>
                  <span v-if="item.srs_name">({{ item.srs_name }})</span>
                  <span v-else class="italic">
                    ({{ translate.missing('srs_name') }})</span
                  >
                </div>
                <div>
                  <span v-if="item.pos[0].latitude">
                    {{ translate.commonText('latitude') }}
                    {{ item.pos[0].latitude }},
                  </span>
                  <span v-else class="italic">
                    ({{ translate.missing('latitude') }})
                  </span>
                </div>
                <div>
                  <span v-if="item.pos[0].longitude"
                    >{{ translate.commonText('longitude') }}
                    {{ item.pos[0].longitude }}</span
                  >
                  <span v-else class="italic">
                    ({{ translate.missing('longitude') }})</span
                  >
                </div>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div
        v-for="(item, i) in post.exactness"
        :key="i"
        :class="{ 'mb-4': i !== post.exactness.length - 1 }"
      >
        <table class="w-full">
          <tr>
            <td>{{ translate.commonText('exactness') }}</td>
            <td>
              <span v-if="item.code">{{
                types.geographicExactness[item.code]
              }}</span>
              <span v-else class="italic">{{ translate.missing() }}</span>
            </td>
          </tr>
        </table>
      </div>
      <div
        v-for="(item, i) in post.location_class"
        :key="i"
        :class="{ 'mb-4': i !== post.location_class.length - 1 }"
      >
        <table class="w-full">
          <tr>
            <td>{{ translate.commonText('location_class') }}</td>
            <td>
              <span v-if="item.code">{{
                types.geographicLocationClass[item.code]
              }}</span>
              <span v-else class="italic">{{ translate.missing() }}</span>
            </td>
          </tr>
        </table>
      </div>
      <div
        v-for="(item, i) in post.feature_designation"
        :key="i"
        :class="{ 'mb-4': i !== post.feature_designation.length - 1 }"
      >
        <table class="w-full">
          <tr>
            <td>
              {{ translate.commonText('feature_designation').proper_class }}
            </td>
            <td>
              <span v-if="item.code">{{ types.locationType[item.code] }}</span>
              <span v-else class="italic">{{ translate.missing() }}</span>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ActivityLocation',
  components: {},
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      geographicVocabulary: [];
      geographicLocationReach: [];
      country: [];
      geographicExactness: [];
      geographicLocationClass: [];
      locationType: [];
      languages: [];
    }
    const translate = new Translate();
    const types = inject('types') as Types;
    return { types, translate };
  },
});
</script>
