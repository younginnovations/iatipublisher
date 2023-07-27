<template>
  <div
    v-for="(post, key) in data"
    :key="key"
    class="elements-detail"
    :class="{ 'mb-4': Number(key) !== data.length - 1 }"
  >
    <div class="mb-1 text-sm">
      <div v-if="post.legacy_name">{{ post.legacy_name }}</div>
      <span v-else class="italic">
        {{ translate.missingText('name') }}
      </span>
    </div>
    <div class="ml-5">
      <table>
        <tr>
          <td>{{ translate.commonText('value') }}</td>
          <td v-if="post.value">
            <span class="description">{{ post.value }}</span>
          </td>
          <td v-else class="italic">
            {{ translate.missingText() }}
          </td>
        </tr>
      </table>
      <table>
        <tr>
          <td>{{ translate.commonText('iati_equivalent') }}</td>
          <td v-if="post.iati_equivalent">
            <span class="description">{{ post.iati_equivalent }}</span>
          </td>
          <td v-else class="italic">
            {{ translate.missingText() }}
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import { Translate } from 'Composable/translationHelper';

export default defineComponent({
  name: 'ActivitySector',
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  setup() {
    const translate = new Translate();
    return { translate };
  },
});
</script>
