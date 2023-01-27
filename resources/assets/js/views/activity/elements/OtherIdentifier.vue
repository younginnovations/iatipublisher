<template>
  <div class="elements-detail wider other-identifier">
    <div
      v-for="(identifier, key) in data.content"
      :key="key"
      :class="{ 'mb-4': key !== Object.keys(data.content).length - 1 }"
    >
      <div class="category">
        <span v-if="identifier.reference_type">{{
          types.otherIdentifierType[identifier.reference_type]
        }}</span>
        <span v-else class="italic">Type Missing</span>
      </div>
      <div class="text-sm">
        <span v-if="identifier.reference">{{ identifier.reference }}</span>
        <span v-else class="italic">Reference Missing</span>
      </div>
      <div>
        <div class="tb-content ml-5">
          <div
            v-for="(post, i) in identifier.owner_org"
            :key="i"
            :class="{ 'mb-4': key !== identifier.owner_org.length - 1 }"
          >
            <table>
              <tbody>
                <tr>
                  <td>Owner Organisation Reference</td>
                  <td v-if="post.ref">{{ post.ref }}</td>
                  <td v-else class="italic">Missing</td>
                </tr>
                <tr>
                  <td>Owner Organisation Narrative</td>
                  <td>
                    <div
                      v-for="(n, k) in post.narrative"
                      :key="k"
                      class="item"
                      :class="{ 'mb-2': k != post.narrative.length - 1 }"
                    >
                      <div v-if="n.narrative" class="flex flex-col">
                        <span v-if="n.language" class="language top"
                          >(Language: {{ types.languages[n.language] }})</span
                        >
                        <span v-if="n.narrative" class="description">{{
                          n.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Missing</span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
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
    interface Types {
      otherIdentifierType: [];
      languages: [];
    }
    const types = inject('types') as Types;
    return { types };
  },
});
</script>
