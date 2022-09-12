<template>
  <div>
    <table>
      <thead>
      <tr class="text-left bg-n-10">
        <th id="transaction_type" scope="col">
          <span>Element</span>
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(element) in element_list" :key="element">
        <td>
          <a :href="`/element-editor/${element}`" class="overflow-hidden ellipsis text-n-50">
            {{ element }}
          </a>
        </td>
      </tr>
      </tbody>
    </table>
    <p>Element Schema</p>
    <Vue3JsonEditor
      v-model="jsonSchema"
      :show-btns="true"
      @json-save="onSchemaSave"
    />
  </div>
</template>

<script>
import { defineComponent, reactive, toRefs } from 'vue'
import { Vue3JsonEditor } from 'vue3-json-editor'
import axios from 'axios';

export default defineComponent({
  components: {
    Vue3JsonEditor
  },
  props: {
    schema: {
      type: Object,
      required: true,
    },
    elements: {
      type: Object,
      required: true,
    }
  },
  setup (props) {

    function onSchemaSave (value) {
      axios.post('/element-editor', {data:value}).then((res) => {
        if(res.status) {
          //location.reload();
        }
      });
    }

    const state = reactive({
      element_list: props.elements,
      jsonSchema: props.schema,
    })

    return {
      ...toRefs(state),
      onSchemaSave
    }
  }
})
</script>
