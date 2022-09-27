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
        <div class="actions flex grow justify-end">
          <div class="inline-flex justify-center">
            <BtnComponent
              class="mr-3.5"
              type="primary"
              :text="`Import (${selectedCount}/${activitiesLength})`"
              icon="download-file"
              @click="importActivities"
            />
          </div>
        </div>
      </div>
    </div>
    <!-- Table layout: show after upload complete -->
    <div class="iati-list-table upload-list-table">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="title" scope="col">
              <a class="text-n-50 transition duration-500 hover:text-spring-50" href="#">
                <span class="sorting-indicator descending">
                  <svg-vue icon="descending-arrow" />
                </span>
                <span>Activity Title</span>
              </a>
            </th>
            <th id="status" scope="col">
              <span class="block text-left">Status</span>
            </th>
            <th id="cb" scope="col">
              <span class="">
                <svg-vue icon="checkbox" @click="selectAllActivities()" />
              </span>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(activity, index) in activities"
            :key="index"
            :class="{
              'upload-error': Object.keys(activity['errors']).length > 0,
            }"
          >
            <ListElement
              :activity="activity"
              :index="index"
              :selected-activities="JSON.stringify(selectedActivities)"
              @select-element="updateSelectedActivities(index)"
            />
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <Loader
    v-if="loader"
    :text="loaderText"
    :class="{ 'animate-loader': loader }"
    :change-text="false"
  />
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, reactive } from "@vue/runtime-core";
import BtnComponent from "Components/ButtonComponent.vue";
import Loader from "Components/sections/ProgressLoader.vue";
import ListElement from "../import/ListElement.vue";
import axios from "axios";

export default defineComponent({
  name: "ImportList",
  components: {
    BtnComponent,
    Loader,
    ListElement,
  },

  setup() {
    const error = {};
    let activities = reactive({});
    const selectedActivities: Array<string> = reactive([]);
    const selectedCount = ref(0);
    const activitiesLength = ref(0);
    const loader = ref(false);
    const selectAll = ref(false);
    const loaderText = ref("Please Wait");
    let timer;

    onMounted(() => {
      loader.value = true;
      loaderText.value = "Uploading .csv file";
      timer = setInterval(() => {
        axios
          .get("/import/check_status")
          .then((res) => {
            Object.assign(activities, res.data.data);
            console.log(activities);
            activitiesLength.value = res.data.data.length;

            if (res.data.status) {
              clearInterval(timer);
            }
          })
          .catch((err) => {
            console.log(err);
            loader.value = false;
          });
      }, 2000);
      loader.value = false;
    });

    function updateSelectedActivities(activity_id) {
      let index = selectedActivities.indexOf(activity_id);

      if (activities[activity_id]["errors"].length > 0) {
        if (index >= 0) {
          selectedActivities.splice(index, 1);
          selectedCount.value = selectedCount.value - 1;
        } else {
          selectedActivities.push(activity_id);
          selectedCount.value = selectedCount.value + 1;
        }
      }
    }

    function selectAllActivities() {
      selectAll.value = !selectAll.value;
      selectedCount.value = 0;
      selectedActivities.length = 0;

      Object.keys(activities).forEach((activity_id) => {
        let index = selectedActivities.indexOf(activity_id);
        if (activities[activity_id]["errors"].length > 0) {
          if (selectAll.value) {
            selectedActivities.push(activity_id);
            selectedCount.value = selectedCount.value + 1;
          } else {
            selectedActivities.splice(index, 1);
          }
        }
      });
      console.log(selectedActivities);

      if (!selectAll.value) {
        selectedCount.value = 0;
      }
    }

    function importActivities() {
      loader.value = true;
      loaderText.value = "Importing .csv file";
      clearInterval(timer);

      axios
        .post("/import/activity", {
          activities: selectedActivities,
          filetype: "csv",
        })
        .then((res) => {
          console.log(res);
          window.location.href = "/activities";
        })
        .catch((err) => {
          console.log(err);
        });
    }

    return {
      error,
      activities,
      activitiesLength,
      selectedCount,
      importActivities,
      selectedActivities,
      updateSelectedActivities,
      loader,
      loaderText,
      selectAllActivities,
    };
  },
});
</script>

<style lang="scss"></style>
