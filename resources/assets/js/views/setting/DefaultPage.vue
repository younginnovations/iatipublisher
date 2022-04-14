<template>
  <div class="setting__container mb-14">
    <div class="flex">
      <button class="tab-btn mr-2">Publishing Settings</button>
      <button class="tab-btn active__tab">Default Values</button>
    </div>
    <div class="registry__info">
      <div class="mb-4 text-sm font-bold text-n-50">Default Values</div>
      <div class="flex items-center text-xs text-n-50">
        <span class="mr-1"
          ><span class="text-salmon-50">* </span>Mandatory fields</span
        >
        <button>
          <svg-vue class="text-base" icon="help"></svg-vue>
        </button>
      </div>
    </div>
    <p class="text">
      These values will be used in the xml files which is published to the IATI
      Registry. You have the option to override the activities.
    </p>
    <span class="text-sm font-bold text-n-50">Default for all data</span>
    <div class="register mt-4 mb-6">
      <div class="register__container mb-0">
        <div>
          <div class="flex justify-between">
            <label for="default_currency">Default Currency</label>
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="default_currency"
            class="register__input mb-2"
            type="text"
            placeholder="EUR - Euro"
          />
          <p>
            The currency in which you normally report your financial
            transactions. Select from dropdown.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="default_language"
              >Default Language <span class="text-salmon-50">*</span></label
            >
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="default_language"
            class="register__input mb-2"
            type="text"
            placeholder="en - English"
          />
          <p>
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
            <label for="default_hierarchy">Default Hierarchy</label>
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="default_hierarchy"
            class="register__input mb-2"
            type="text"
            placeholder="1"
          />
          <p>
            IATI allows for activities to be reported hierarchically (eg. parent
            - child ; programme - project - sub-project, etc). For activities at
            lower levels, their hierarchy can be edited as you are entering
            them.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="linked_data_url"
              >Linked Data URL <span class="text-salmon-50">*</span></label
            >
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="data_url"
            class="register__input mb-2"
            type="text"
            placeholder="en - English"
          />
          <p>
            The language in which you normally report. Select from dropdown.
          </p>
        </div>
        <div>
          <div class="flex justify-between">
            <label for="humanitarian"
              >Humanitarian <span class="text-salmon-50">*</span></label
            >
            <button><svg-vue class="text-base" icon="help"></svg-vue></button>
          </div>
          <input
            id="humanitarian"
            class="register__input"
            type="text"
            placeholder="No"
          />
        </div>
      </div>
    </div>
  </div>
</template>
