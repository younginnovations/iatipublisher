<template>
  <div
    v-for="(participating_org, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="category">
      <span v-if="participating_org.organization_role">{{
        types.organisationRole[participating_org.organization_role]
      }}</span>
      <span v-else class="italic">{{
        language.common_lang.missing.element.replace(
          ':element',
          language.common_lang.organisation_role
        )
      }}</span>
    </div>

    <div class="mb-4 text-sm">
      <span v-if="participating_org.narrative['0'].narrative">{{
        participating_org.narrative['0'].narrative
      }}</span>
      <span v-else class="italic">{{
        language.common_lang.missing.element.replace(
          ':element',
          language.common_lang.narrative
        )
      }}</span>
    </div>

    <div class="ml-5">
      <table class="w-full">
        <tr class="multiline">
          <td>{{ language.common_lang.organisation_name }}</td>
          <td>
            <div
              v-for="(narrative, i) in participating_org.narrative"
              :key="i"
              class="flex flex-col"
            >
              <div v-if="narrative.narrative" class="flex flex-col">
                <span v-if="narrative.language" class="language top"
                  >({{ language.common_lang.language }}
                  {{ types.languages[narrative.language] }})</span
                >
                <span v-if="narrative.narrative" class="description">{{
                  narrative.narrative
                }}</span>
              </div>
              <span v-else class="italic">{{
                language.common_lang.missing.default
              }}</span>
            </div>
          </td>
        </tr>
        <tr>
          <td>{{ language.common_lang.organisation_type }}</td>
          <td v-if="participating_org.type">
            {{ types.organizationType[participating_org.type] }}
          </td>
          <td v-else class="italic">
            {{ language.common_lang.missing.default }}
          </td>
        </tr>
        <tr>
          <td>{{ language.common_lang.organisation_role }}</td>
          <td v-if="participating_org.organization_role">
            {{ types.organisationRole[participating_org.organization_role] }}
          </td>
          <td v-else class="italic">
            {{ language.common_lang.missing.default }}
          </td>
        </tr>
        <tr>
          <td>{{ language.common_lang.ref }}</td>
          <td v-if="participating_org.ref">
            {{ participating_org.ref }}
          </td>
          <td v-else class="italic">
            {{ language.common_lang.missing.default }}
          </td>
        </tr>
        <tr>
          <td>{{ language.common_lang.activity_id }}</td>
          <td>
            <div>
              <span v-if="participating_org.identifier">{{
                participating_org.identifier
              }}</span>
              <span v-else class="italic">{{
                language.common_lang.missing.default
              }}</span>
            </div>
          </td>
        </tr>
        <tr v-if="participating_org.crs_channel_code">
          <td>{{ language.common_lang.crs_channel_code }}</td>
          <td>
            {{ types.crsChannelCode[participating_org.crs_channel_code] }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';

export default defineComponent({
  name: 'ActivityParticipatingOrg',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    interface Types {
      organizationType: [];
      organisationRole: [];
      crsChannelCode: [];
      languages: [];
    }
    const language = window['globalLang'];
    const types = inject('types') as Types;

    return { types, language };
  },
});
</script>
