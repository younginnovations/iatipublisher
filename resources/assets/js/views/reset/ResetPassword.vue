<template>
  <div class="mt-14">
    <div class="reset reset__password">
      <h2>Reset Password</h2>
      <p>Please enter your new password</p>
      <div class="reset__content mt-8">
        <label class="text-sm font-bold text-bluecoral" for="password"
          >New Password</label
        >
        <input
          id="new_password"
          class="input"
          type="email"
          placeholder="Enter a new password"
        />
        <svg-vue class="reset__icon text-xl" icon="pw-lock"></svg-vue>
      </div>
      <div class="reset__content mt-4">
        <label
          class="text-sm font-bold text-bluecoral"
          for="password_confirmation"
          >Repeat Password</label
        >
        <input
          id="repeat_password"
          class="input"
          type="email"
          placeholder="Re-enter your password"
        />
        <svg-vue class="reset__icon text-xl" icon="pw-lock"></svg-vue>
      </div>
      <button type="submit" class="btn reset-btn">Reset Password</button>
    </div>
  </div>
</template>
