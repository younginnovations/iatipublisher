<template>
  <div class="flex space-x-4">
    <div class="h-[calc(100vh_-_60px)] overflow-auto">
      <table class="bg-bluecoral">
        <thead>
          <tr class="text-left">
            <th id="transaction_type" scope="col">
              <div class="border-none bg-bluecoral p-5 text-lavender-10">
                Element
              </div>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="element in element_list" :key="element">
            <td>
              <a
                :href="`/element-editor/${element}`"
                class="ellipsis overflow-hidden border-t px-5 py-1 text-lavender-20 duration-200 hover:font-bold hover:text-lavender-10"
              >
                {{ element }}
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="my-4 h-[calc(100vh_-_100px)] overflow-auto">
      <p>Element Schema</p>
      <Vue3JsonEditor
        v-model="jsonSchema"
        :show-btns="true"
        @json-save="onSchemaSave"
      />
    </div>
  </div>
</template>

<script>
import { defineComponent, reactive, toRefs } from 'vue';
import { Vue3JsonEditor } from 'vue3-json-editor';
import axios from 'axios';

export default defineComponent({
  components: {
    Vue3JsonEditor,
  },
  props: {
    schema: {
      type: Object,
      required: true,
    },
    elements: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    function onSchemaSave(value) {
      axios.post('/element-editor', { data: value }).then((res) => {
        if (res.status) {
          //location.reload();
        }
      });
    }

    const state = reactive({
      element_list: props.elements,
      jsonSchema: props.schema,
    });

    return {
      ...toRefs(state),
      onSchemaSave,
    };
  },
});
</script>
