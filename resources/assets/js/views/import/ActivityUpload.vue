<template>
  <div class="listing__page bg-paper px-10 pt-4 pb-[71px]">
    <div class="page-title mb-4">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="breadcrumb">
              <div class="flex">
                <a class="whitespace-nowrap font-bold" href="/activities"
                  >Your Activities</a
                >
              </div>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <h4 class="mr-4 font-bold">Import Activity</h4>
            <div class="tooltip-btn">
              <button class="">
                <svg-vue icon="question-mark" />
                <span>What is activity?</span>
              </button>
              <div class="tooltip-btn__content z-[1]">
                <div class="content">
                  <div class="mb-1.5 text-caption-c1 font-bold text-bluecoral">
                    What is an activity?
                  </div>
                  <p>
                    Organisations need to publish data on their activities. An ‘activity’
                    is an individual project or piece of development and humanitarian
                    work. The unit of work described by an ‘activity’ is determined by the
                    organisation that is publishing the data. For example, an activity
                    could be a donor government providing US$ 50 million to a recipient
                    country’s government in order to implement basic education over 5
                    years. Another activity could be an NGO spending US$ 500,000 to
                    deliver clean drinking water to 1000 households over 6 months.
                  </p>
                  <p class="text-n-40">
                    Learn more about how to publish data on activities in IATI’s
                    publishing
                    <a href="#" class="text-bluecoral"><b>guidance.</b></a
                    >.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <div class="actions flex grow justify-end">
          <div class="inline-flex justify-center">
            <BtnComponent
              class="mr-3.5"
              type="primary"
              text="Import (5/10)"
              icon="download-file"
            />
          </div>
        </div> -->
      </div>
    </div>
    <div
      class="flex min-h-[65vh] items-start justify-center rounded-lg border border-n-20 bg-white"
    >
      <div class="mt-24 rounded-lg border border-n-30">
        <div>
          <p class="border-b border-n-30 p-4 text-sm font-bold uppercase text-n-50">
            Import .CSV/.XML file
          </p>
          <div class="p-6">
            <div class="mb-4 rounded border border-n-30 px-4 py-3">
              <input
                ref="file"
                type="file"
                class="min-w-[480px] cursor-pointer p-0 text-sm file:cursor-pointer file:rounded-full file:border file:border-solid file:border-spring-50 file:bg-white file:px-4 file:py-0.5 file:text-spring-50 file:outline-none"
              />
            </div>
            <span v-if="error" class="error">{{ error }}</span>
            <div class="flex items-end justify-between">
              <BtnComponent
                type="primary"
                text="Upload file"
                icon="upload-file"
                @click="uploadFile"
              />
              <div class="flex items-center space-x-2.5">
                <button class="relative text-sm text-bluecoral">
                  <svg-vue :icon="'download'" class="mr-1" />
                  <span>Download .CSV activity Template</span>
                </button>
                <HoverText
                  hover-text="This template contains all the elements that you have to fill as per the IATI Standard before uploading in IATI Publisher. Please make sure that you follow the structure and format of the template."
                  name=""
                  class="hover-text"
                  position="right"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Loader v-if="loader" :text="loaderText" :class="{ 'animate-loader': loader }" />
</template>

<script lang="ts">
import { defineComponent, ref } from "@vue/runtime-core";
import BtnComponent from "Components/ButtonComponent.vue";
import HoverText from "Components/HoverText.vue";
import Loader from "Components/sections/ProgressLoader.vue";
import axios from "axios";

export default defineComponent({
  name: "ActivityUpload",
  components: {
    BtnComponent,
    HoverText,
    Loader,
  },

  setup() {
    const file = ref();
    const error = ref("");
    const loader = ref(false);
    const loaderText = ref("Please Wait");

    function uploadFile() {
      loader.value = true;
      loaderText.value = "Uploading .csv file";
      let activity = file.value.files.length ? file.value.files[0] : "";
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      let data = new FormData();
      data.append("activity", activity);
      error.value = "";

      axios
        .post("/import", data, config)
        .then((res) => {
          if (file.value.files.length) {
            window.location.href = "/import/list";
          }
        })
        .catch((err) => {
          error.value = "The file field is required and must be csv or xml.";
        });
      loader.value = false;
    }

    return {
      file,
      error,
      uploadFile,
      loader,
      loaderText,
    };
  },
});
</script>

<style lang="scss"></style>
