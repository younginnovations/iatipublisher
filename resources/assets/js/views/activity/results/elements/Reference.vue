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
            <td>Code</td>
            <td>{{ isEmpty(ref.code) ? 'Missing' : ref.code }}</td>
          </tr>
          <tr>
            <td>Vocabulary URI</td>
            <td>
              <a target="_blank" :href="ref.vocabulary_uri">
                {{
                  isEmpty(ref.vocabulary_uri) ? 'Missing' : ref.vocabulary_uri
                }}</a
              >
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, toRefs } from 'vue';
import isEmpty from '../../../../composable/helper';

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

    let { data } = toRefs(props);
    const referenceData = data.value as ReferenceArray;
    return { referenceData };
  },
  methods: { isEmpty },
});
</script>
