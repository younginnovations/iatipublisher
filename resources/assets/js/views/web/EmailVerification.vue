<template>
  <div class="section__wrapper flex">
    <form method="POST" action="" class="form">
      <div class="grid justify-items-center gap-6 tracking-normal xl:px-2">
        <span class="text-2xl font-bold text-n-50">{{
          props.translation.verify_account
        }}</span>
        <p class="text-base text-n-40">
          {{ props.translation.verification_email }}
          <span class="font-bold text-n-50"> {{ props.email }}</span>
          . {{ props.translation.verify_and_active }}
        </p>
        <svg-vue class="verification" icon="ic-verification"></svg-vue>
        <a href="/admin/dashboard" class="btn btn-next">
          {{ props.translation.get_started_button }}
          <svg-vue class="text-2xl" icon="right-arrow"></svg-vue>
        </a>
      </div>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  props: {
    email: String,
    translation: String,
  },

  setup(props) {
    return {
      props,
    };
  },
});
</script>
