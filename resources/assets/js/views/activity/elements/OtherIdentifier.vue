<template>
  <div class="elements-detail wider other-identifier">
    <div class="category">
      <span v-if="data.content.reference_type">{{
        types.otherIdentifierType[data.content.reference_type]
      }}</span>
      <span v-else class="italic">Type Not Available</span>
    </div>
    <div class="text-sm">
      <span v-if="data.content.reference">{{ data.content.reference }}</span>
      <span v-else class="italic">Reference Not Available</span>
    </div>
    <div>
      <div class="ml-5 tb-content">
        <div
          v-for="(post, key) in data.content.owner_org"
          :key="key"
          :class="{ 'mb-4': key !== data.content.owner_org.length - 1 }"
        >
          <table>
            <tr>
              <td>Owner Organisation Reference</td>
              <td v-if="post.ref">{{ post.ref }}</td>
              <td v-else class="italic">Not Available</td>
            </tr>
            <tr>
              <td>Owner Organisation Narrative</td>
              <td>
                <div
                  v-for="(i, k) in post.narrative"
                  :key="k"
                  class="item"
                  :class="{ 'mb-2': i != post.narrative.length - 1 }"
                >
                  <div v-if="i.narrative" class="flex flex-col">
                    <span v-if="i.language" class="language top"
                      >(Language: {{ types.languages[i.language] }})</span
                    >
                    <span v-if="i.narrative" class="description">{{
                      i.narrative
                    }}</span>
                  </div>
                  <span v-else class="italic">Not Available</span>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, inject } from 'vue';

export default defineComponent({
  name: 'OtherIdentifier',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const types = inject('types');
    return { types };
  },
});
</script>
