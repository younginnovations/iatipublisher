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
        <span v-else class="italic">{{
          language.common_lang.missing.element.replace(
            ':element',
            language.common_lang.type
          )
        }}</span>
      </div>
      <div class="text-sm">
        <span v-if="identifier.reference">{{ identifier.reference }}</span>
        <span v-else class="italic">{{
          language.common_lang.missing.element.replace(
            ':element',
            language.common_lang.reference_label
          )
        }}</span>
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
                  <td>
                    {{ language.common_lang.owner_organisation_reference }}
                  </td>
                  <td v-if="post.ref">{{ post.ref }}</td>
                  <td v-else class="italic">
                    {{ language.common_lang.missing.default }}
                  </td>
                </tr>
                <tr>
                  <td>
                    {{ language.common_lang.owner_organisation_narrative }}
                  </td>
                  <td>
                    <div
                      v-for="(n, k) in post.narrative"
                      :key="k"
                      class="item"
                      :class="{ 'mb-2': k != post.narrative.length - 1 }"
                    >
                      <div v-if="n.narrative" class="flex flex-col">
                        <span v-if="n.language" class="language top"
                          >({{ language.common_lang.language }}:
                          {{ types.languages[n.language] }})</span
                        >
                        <span v-if="n.narrative" class="description">{{
                          n.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">{{
                        language.common_lang.missing.default
                      }}</span>
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
    const language = window['globalLang'];
    return { types, language };
  },
});
</script>
