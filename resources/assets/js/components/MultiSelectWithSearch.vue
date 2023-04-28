<template>
  <div style="position: relative">
    <div class="margin-20">
      <p class="m-2 pb-2 text-xs font-bold uppercase text-n-50">
        {{ props.header }}
      </p>

      <div class="search" style="margin-right: 4px !important">
        <input
          v-model="searchInput"
          class="search__input mr-3.5"
          type="text"
          :placeholder="`Search ${props.header}...`"
          style="width: 100%; height: 40px"
          @input="updateArrayBySearch()"
        />
        <svg-vue icon="search" />
      </div>

      <div class="my-1">
        <ul>
          <li v-for="(item, key) in tempListItems" :key="item">
            <div v-if="item.show" class="mt-2">
              <span class="m-2">
                <input
                  v-model="checkedBoxes"
                  type="checkbox"
                  :value="key"
                  :id="key"
                />
              </span>
              <label class="m-2 px-3 text-n-40" :for="key">{{
                item.label
              }}</label>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="footer-ribbon" style="">
      <BtnComponent
        class="space"
        text="Apply"
        type="primary"
        @click="applyFilter"
      />
    </div>
  </div>
</template>
<script lang="ts" setup>
import { defineEmits, defineProps, ref } from 'vue';
import BtnComponent from 'Components/ButtonComponent.vue';

const props = defineProps({
  listItems: {
    type: Object,
    required: true,
  },
  header: {
    type: String,
    required: true,
  },
});

const emit = defineEmits(['changeSelectedPublisher']);
let keys = Object.keys(props.listItems);
let searchInput = ref('');
let tempListItems = ref({});
let checkedBoxes = ref([]);

let changeSelectedPublisher = (selectedPublisherType) => {
  emit('changeSelectedPublisher', selectedPublisherType);
};

formatPublisherType();
function formatPublisherType() {
  let keys = Object.keys(props.listItems);
  for (let i = 0; i < keys.length; i++) {
    let key = keys[i];
    tempListItems.value[key] = {
      label: props.listItems[key],
      show: true,
    };
  }
}

const updateArrayBySearch = () => {
  let searchString = searchInput.value.toLowerCase();

  for (let i = 0; i < keys.length; i++) {
    let key = keys[i];
    let item = tempListItems.value[key];
    if (item.label.toLowerCase().includes(searchString)) {
      tempListItems.value[key].show = true;
    } else {
      tempListItems.value[key].show = false;
    }
  }
};

const applyFilter = () => {
  changeSelectedPublisher(checkedBoxes.value);
};
</script>
<style>
.border-this {
  border: 1px solid red;
}
.margin-20 {
  margin: 20px;
}

.footer-ribbon {
  display: flex;
  justify-content: flex-end;
  padding: 8px 20px;
  background: #fffde7;
}
</style>
