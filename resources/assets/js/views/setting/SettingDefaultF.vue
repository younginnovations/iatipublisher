<template>
  <div class="setting">
    <span class="text-xs font-bold text-n-40">Settings</span>
    <div class="flex items-center">
      <a href="#"><svg-vue icon="left-arrow"></svg-vue></a>
      <h2 class="ml-3 text-heading-4 font-bold text-n-50">Settings</h2>
    </div>
    <div class="setting__container">
      <div class="flex">
        <button class="tab-btn mr-2">Publishing Settings</button>
        <button class="tab-btn active__tab">Default Values</button>
      </div>
      <div class="registry__info mt-7 mb-4 border-b border-b-n-20">
        <div class="mb-4 text-sm font-bold text-n-50">Default Values</div>
      </div>
      <p class="mb-6 text-sm text-n-40">
        These values will be used in the xml files which is published to the
        IATI Registry. You have the option to override the activities.
      </p>
      <span class="text-sm font-bold text-n-50">Default for all data</span>
      <div class="register mt-4 mb-6">
        <div class="register__container mb-0">
          <div>
            <div class="flex justify-between">
              <label class="text-xs text-n-50" for="username"
                >Default Currency</label
              >
              <a href="#"><svg-vue icon="help"></svg-vue></a>
            </div>
            <input
              class="register__input mb-2"
              type="text"
              placeholder="EUR - Euro"
            />
            <p class="text-xs leading-5 text-n-40">
              The currency in which you normally report your financial
              transactions. Select from dropdown.
            </p>
          </div>
          <div>
            <div class="flex justify-between">
              <label class="text-xs text-n-50" for="username"
                >Default Language <span class="text-crimson-50">*</span></label
              >
              <a href="#"><svg-vue icon="help"></svg-vue></a>
            </div>
            <input
              class="register__input mb-2"
              type="text"
              placeholder="en - English"
            />
            <p class="text-xs leading-5 text-n-40">
              The language in which you normally report. Select from dropdown.
            </p>
          </div>
        </div>
      </div>
      <span class="text-sm font-bold text-n-50">Default for activity data</span>
      <div class="register mt-4">
        <div class="register__container">
          <div>
            <div class="flex justify-between">
              <label class="text-xs text-n-50" for="username"
                >Default Hierarchy</label
              >
              <a href="#"><svg-vue icon="help"></svg-vue></a>
            </div>
            <input class="register__input mb-2" type="text" placeholder="1" />
            <p class="text-xs leading-5 text-n-40">
              IATI allows for activities to be reported hierarchically (eg.
              parent - child ; programme - project - sub-project, etc). For
              activities at lower levels, their hierarchy can be edited as you
              are entering them.
            </p>
          </div>
          <div>
            <div class="flex justify-between">
              <label class="text-xs text-n-50" for="username"
                >Linked Data URL <span class="text-crimson-50">*</span></label
              >
              <a href="#"><svg-vue icon="help"></svg-vue></a>
            </div>
            <input
              class="register__input mb-2"
              type="text"
              placeholder="en - English"
            />
            <p class="text-xs leading-5 text-n-40">
              The language in which you normally report. Select from dropdown.
            </p>
          </div>
          <div>
            <div class="flex justify-between">
              <label class="text-xs text-n-50" for="username"
                >Humanitarian <span class="text-crimson-50">*</span></label
              >
              <a href="#"><svg-vue icon="help"></svg-vue></a>
            </div>
            <input class="register__input" type="text" placeholder="No" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
