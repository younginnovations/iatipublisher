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
          {{ capitalize(translate.button('delete_element', 'common.result')) }}
        </b>
        <b v-else-if="props.itemType === 'indicator'">
          {{
            capitalize(translate.button('delete_element', 'common.indicator'))
          }}
        </b>
        <b v-else-if="props.itemType === 'period'">
          {{ capitalize(translate.button('delete_element', 'common.period')) }}
        </b>
        <b v-else-if="props.itemType === 'transaction'">
          {{
            capitalize(translate.button('delete_element', 'common.transaction'))
          }}
        </b>
        <b v-else>{{ translate.button('delete') }}</b>
      </div>
      <div class="rounded-lg bg-rose p-4">
        <p v-if="props.itemType === 'result'">
          {{ translate.commonText('delete_confirmation_default') }}
          {{ translate.commonText('result') }} ?
          {{ translate.commonText('related_indicator_period_deleted') }}
        </p>
        <p v-else-if="props.itemType === 'indicator'">
          {{ translate.commonText('delete_confirmation_default') }}
          {{ translate.commonText('indicator') }} ?
          {{ translate.commonText('related_period_deleted') }}
        </p>
        <p v-else-if="props.itemType === 'period'">
          {{ translate.commonText('delete_confirmation_default') }}
          {{ translate.commonText('period') }} ?
        </p>
        <p v-else-if="props.itemType === 'transaction'">
          {{ translate.commonText('delete_confirmation_default') }}
          {{ translate.commonText('transaction') }} ?
        </p>
        <p v-else>
          {{ translate.commonText('delete_confirmation_default') }}
          {{ translate.commonText('module') }} ?
        </p>
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <BtnComponent
          class="bg-white px-6 uppercase"
          :text="translate.button('go_back')"
          type=""
          @click="deleteValue = false"
        />
        <BtnComponent
          class="space"
          :text="translate.button('delete')"
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
import { Translate } from 'Composable/translationHelper';

// props
const props = defineProps({
  itemId: { type: [Number, String], required: true },
  itemType: { type: String, required: true },
});

const translate = new Translate();
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
