<template>
  <button
    class="text-n-40 hover:text-spring-50"
    @click="
      (event) => {
        deleteValue = true;
        event.stopPropagation();
      }
    "
  >
    <svg-vue icon="delete" class="text-xl"></svg-vue>
  </button>
  <Modal :modal-active="deleteValue" width="583" @close="deleteToggle">
    <div class="mb-4">
      <div class="title mb-6 flex">
        <svg-vue class="mr-1 mt-0.5 text-lg text-crimson-40" icon="delete" />
        <b v-if="props.itemType === 'result'">
          {{
            capitalize(
              language.button_lang.delete_element.replace(
                ':element',
                capitalize(language.common_lang.result)
              )
            )
          }}
        </b>
        <b v-else-if="props.itemType === 'indicator'">
          {{
            capitalize(
              language.button_lang.delete_element.replace(
                ':element',
                capitalize(language.common_lang.indicator)
              )
            )
          }}
        </b>
        <b v-else-if="props.itemType === 'period'">
          {{
            capitalize(
              language.button_lang.delete_element.replace(
                ':element',
                capitalize(language.common_lang.period)
              )
            )
          }}
        </b>
        <b v-else-if="props.itemType === 'transaction'">
          {{
            capitalize(
              language.button_lang.delete_element.replace(
                ':element',
                capitalize(language.common_lang.transaction)
              )
            )
          }}
        </b>
        <b v-else>{{ language.button_lang.delete }}</b>
      </div>
      <div class="rounded-lg bg-rose p-4">
        <p v-if="props.itemType === 'result'">
          {{ language.common_lang.delete_confirmation_default }}
          {{ language.common_lang.result }} ?
          {{ language.common_lang.related_indicator_period_deleted }}
        </p>
        <p v-else-if="props.itemType === 'indicator'">
          {{ language.common_lang.delete_confirmation_default }}
          {{ language.common_lang.indicator }} ?
          {{ language.common_lang.related_period_deleted }}
        </p>
        <p v-else-if="props.itemType === 'period'">
          {{ language.common_lang.delete_confirmation_default }}
          {{ language.common_lang.period }} ?
        </p>
        <p v-else-if="props.itemType === 'transaction'">
          {{ language.common_lang.delete_confirmation_default }}
          {{ language.common_lang.transaction }} ?
        </p>
        <p v-else>
          {{ language.common_lang.delete_confirmation_default }}
          {{ language.common_lang.module }} ?
        </p>
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <BtnComponent
          class="bg-white px-6 uppercase"
          :text="language.button_lang.go_back"
          type=""
          @click="deleteValue = false"
        />
        <BtnComponent
          class="space"
          :text="language.button_lang.delete"
          type="primary"
          @click="deleteFunction"
        />
      </div>
    </div>
  </Modal>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { useToggle } from '@vueuse/core';
import { capitalize } from 'vue';
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';

const language = window['globalLang'];
// props
const props = defineProps({
  itemId: { type: [Number, String], required: true },
  itemType: { type: String, required: true },
});

// toggle state for modal popup
let [deleteValue, deleteToggle] = useToggle();

const deleteFunction = () => {
  if (props.itemType === 'result' || props.itemType === 'transaction') {
    axios.delete(`${props.itemType}/${props.itemId}`).then(() => {
      deleteValue.value = false;
      location.reload();
    });
  }

  if (props.itemType === 'indicator') {
    axios.delete(`${props.itemType}/${props.itemId}`).then(() => {
      deleteValue.value = false;
      location.reload();
    });
  }

  if (props.itemType === 'period') {
    axios.delete(`${props.itemType}/${props.itemId}`).then(() => {
      deleteValue.value = false;
      location.reload();
    });
  }
};
</script>
