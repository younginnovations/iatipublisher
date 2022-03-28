<template>
  <div
    id="empty-state"
    class="relative flex min-h-[647px] flex-col items-center justify-center bg-white p-10"
  >
    <div
      v-show="dismiss"
      class="absolute left-0 top-0 flex w-full rounded-bl rounded-br bg-rose py-4 px-5 text-[14px] leading-[1.6] text-n-50"
    >
      <div class="grow">
        Please <a href="#" class="font-bold">complete your setup</a> in order to
        enable complete features of IATI publisher tool.
      </div>
      <div class="grow-0">
        <a href="javascript:void(0);" @click="dismiss = false">Dismiss</a>
      </div>
    </div>
    <div
      class="mb-6 flex h-[150px] w-[150px] items-center justify-center rounded-full"
      style="background: linear-gradient(180deg, #e3ecfa 0%, #dae7ff 100%)"
    >
      <svg-vue icon="folder" class="text-[94px]"></svg-vue>
    </div>
    <h5 class="mb-[5px] text-heading-5 font-bold leading-9">
      No activity has been added yet.
    </h5>
    <div class="mb-[17px] text-caption-c1 leading-5 text-n-50">
      Click on the button below to add a new activity
    </div>
    <ActivityButton />
  </div>
</template>

<script>
import ActivityButton from './AddActivityButton.vue';

export default {
  name: 'empty-activity',
  components: {
    ActivityButton,
  },
  data() {
    return {
      dismiss: true,
    };
  },
};
</script>
