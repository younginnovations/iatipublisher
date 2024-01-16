<template>
  <div class="mt-14">
    <div class="reset text-center">
      <h2>
        {{
          translate.textFromKey('password_recovery.password_recovery_header')
        }}
      </h2>
      <p class="mb-5">
        {{
          translate.textFromKey(
            'password_recovery.your_email_has_been_sent_with_label'
          )
        }}
      </p>
      <svg-vue class="verification m-auto" icon="ic-verification" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { Translate } from 'Composable/translationHelper';

const translate = new Translate();
</script>
