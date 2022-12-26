<template>
  <div
    v-for="(ref, r) in referenceData"
    :key="r"
    class="item elements-detail"
    :class="{ 'mb-4': Number(r) !== data.length - 1 }"
  >
    <div class="category flex">{{ type[ref.vocabulary] }}</div>
    <div class="ml-4">
      <table class="mb-3">
        <tbody>
          <tr>
            <td>{{ language.common_lang.code }}</td>
            <td>{{ ref.code }}</td>
          </tr>
          <tr>
            <td>{{ language.common_lang.vocabulary_uri }}</td>
            <td>
              <a
                v-if="ref.vocabulary_uri"
                target="_blank"
                :href="ref.vocabulary_uri"
                >{{ ref.vocabulary_uri }}</a
              >
              <span v-else>{{ language.common_lang.missing.default }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';

export default defineComponent({
  name: 'ResultReference',
  components: {},
  props: {
    data: {
      type: [Object, String],
      required: true,
    },
    type: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    /**
     * Typescript interface
     */
    interface ReferenceArray {
      [index: number]: {
        vocabulary: number;
        code: string;
        vocabulary_uri: string;
      };
    }

    const language = window['globalLang'];
    let { data } = toRefs(props);
    const referenceData = data.value as ReferenceArray;
    return { referenceData, language };
  },
});
</script>
