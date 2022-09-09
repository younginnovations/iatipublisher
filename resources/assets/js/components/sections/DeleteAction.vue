<template>
  <button class="text-n-40 hover:text-spring-50" @click="deleteValue = true">
    <svg-vue icon="delete" class="text-xl"></svg-vue>
  </button>
  <Modal :modal-active="deleteValue" width="583" @close="deleteToggle">
    <div class="mb-4">
      <div class="title mb-6 flex">
        <svg-vue class="mr-1 mt-0.5 text-lg text-crimson-40" icon="delete" />
        <b v-if="props.itemType==='result'">Delete Result</b>
        <b v-else-if="props.itemType==='indicator'">Delete Indicator</b>
        <b v-else-if="props.itemType==='period'">Delete Period</b>
        <b v-else-if="props.itemType==='transaction'">Delete Transaction</b>
        <b v-else>Delete</b>
      </div>
      <div class="rounded-lg bg-rose p-4">
        <b v-if="props.itemType==='result'">Are you sure you want to delete this Result? Related Indicators and Periods will also be deleted</b>
        <b v-else-if="props.itemType==='indicator'">Are you sure you want to delete this Indicator? Related Periods will also be deleted</b>
        <b v-else-if="props.itemType==='period'">Are you sure you want to delete this Period?</b>
        <b v-else-if="props.itemType==='transaction'">Are you sure you want to delete this Transaction?</b>
        <b v-else>Are you sure you want to delete this module?</b>
      </div>
    </div>
    <div class="flex justify-end">
      <div class="inline-flex">
        <BtnComponent
          class="bg-white px-6 uppercase"
          text="Go Back"
          type=""
          @click="deleteValue = false"
        />
        <BtnComponent
          class="space"
          text="Delete"
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
import axios from 'axios';

//component
import BtnComponent from 'Components/ButtonComponent.vue';
import Modal from 'Components/PopupModal.vue';

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
