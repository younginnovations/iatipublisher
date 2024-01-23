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
      <span v-else class="italic">Organization Role Missing</span>
    </div>

    <div class="mb-4 text-sm">
      <span v-if="participating_org.narrative['0'].narrative">{{
        participating_org.narrative['0'].narrative
      }}</span>
      <span v-else class="italic">Narrative Missing</span>
    </div>

    <div class="ml-5">
      <table class="w-full">
        <tr class="multiline">
          <td>Organisation Name</td>
          <td>
            <div
              v-for="(narrative, i) in participating_org.narrative"
              :key="i"
              class="flex flex-col"
            >
              <div v-if="narrative.narrative" class="flex flex-col">
                <span v-if="narrative.language" class="language top"
                  >(Language: {{ types.languages[narrative.language] }})</span
                >
                <span v-if="narrative.narrative" class="description">{{
                  narrative.narrative
                }}</span>
              </div>
              <span v-else class="italic">
                <MissingDataItem item="organisation name" />
              </span>
            </div>
          </td>
        </tr>
        <tr>
          <td>Organisation Type</td>
          <td v-if="participating_org.type">
            {{ types.organizationType[participating_org.type] }}
          </td>
          <td v-else class="italic">
            <MissingDataItem item="organisation type" />
          </td>
        </tr>
        <tr>
          <td>Organisation Role</td>
          <td v-if="participating_org.organization_role">
            {{ types.organisationRole[participating_org.organization_role] }}
          </td>
          <td v-else class="italic">
            <MissingDataItem item="organisation role" />
          </td>
        </tr>
        <tr>
          <td>Ref</td>
          <td v-if="participating_org.ref">
            {{ participating_org.ref }}
          </td>
          <td v-else class="italic">
            <MissingDataItem item="ref" />
          </td>
        </tr>
        <tr>
          <td>Activity Id</td>
          <td>
            <div>
              <span v-if="participating_org.identifier">{{
                participating_org.identifier
              }}</span>
              <span v-else class="italic">
                <MissingDataItem item="activity id" />
              </span>
            </div>
          </td>
        </tr>
        <tr v-if="participating_org.crs_channel_code">
          <td>CRS Channel Code</td>
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
import MissingDataItem from 'Components/MissingDataItem.vue';

export default defineComponent({
  name: 'ActivityParticipatingOrg',
  components: { MissingDataItem },
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
    const types = inject('types') as Types;

    return { types };
  },
});
</script>
