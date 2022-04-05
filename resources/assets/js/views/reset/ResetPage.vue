<template>
  <div class="mt-14">
    <div class="reset">
      <h2>Password Recovery</h2>
      <p>
        Please enter your email, we will send you a link to reset your password
      </p>
      <div class="reset__content mt-8">
        <label class="text-sm font-bold text-bluecoral" for="email"
          >Email</label
        >
        <input
          id="email"
          class="input"
          type="email"
          placeholder="Enter your email address"
        />
        <svg-vue class="reset__icon" icon="mail"></svg-vue>
      </div>
      <button type="submit" class="btn reset-btn">
        Send password reset link
      </button>
    </div>
  </div>
</template>

<style lang="scss">
.reset {
  width: 583px;
  margin: auto;
  box-shadow: 0px 20px 40px 20px rgba(0, 0, 0, 0.05);
  @apply rounded-lg bg-white p-24;

  &__content {
    @apply relative flex flex-col;

    .input {
      @apply mt-2 py-5;
    }
  }
  &__icon {
    @apply absolute left-5 bottom-6;
  }

  h2 {
    @apply text-heading-3 font-bold text-n-50;
  }
  p {
    @apply text-base text-n-40;
  }
  .reset-btn {
    @apply mt-6 w-full;
    padding: 16px 94px;

    @media screen and (min-width: 640px) {
      padding: 18px 94px;
    }
  }
  .verification {
    font-size: 190px;
  }
}
.reset__password {
  height: 610px;
}
</style>
