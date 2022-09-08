<template>
  <div class="relative bg-paper px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="page-title mb-6">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="max-w-sm pb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <div class="flex">
                <a class="whitespace-nowrap font-bold" href="/activities"
                  >Your Organisation</a
                >
                <span class="separator mx-4"> / </span>
                <div class="breadcrumb__title">
                  <span class="breadcrumb__title last overflow-hidden text-n-30">{{
                    organization.name
                      ? organization.name["0"].narrative ?? "Untitled"
                      : "Untitled"
                  }}</span>
                  <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                    {{
                      organization.name
                        ? organization.name["0"].narrative ?? "Untitled"
                        : "Untitled"
                    }}
                  </span>
                </div>
              </div>
            </nav>
          </div>
          <div class="inline-flex max-w-3xl items-center">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left" />
              </a>
            </div>
            <div>
              <h4 class="ellipsis__title relative mr-4 text-2xl font-bold">
                <span class="ellipsis__title overflow-hidden">
                  {{
                    organization.name
                      ? organization.name["0"].narrative ?? "Untitled"
                      : "Untitled"
                  }}
                </span>
                <span class="ellipsis__title--hover w-[calc(100%_+_35px)]">
                  {{
                    organization.name
                      ? organization.name["0"].narrative ?? "Untitled"
                      : "Untitled"
                  }}
                </span>
              </h4>
            </div>
          </div>
        </div>
        <div class="actions flex grow flex-col items-end justify-end">
          <!-- <div class="mb-3">
            <Toast
              v-if="toastData.visibility"
              :message="toastData.message"
              :type="toastData.type"
            />
          </div> -->
          <div class="inline-flex justify-end">
            <Toast
              v-if="toastData.visibility"
              class="mr-3.5"
              :message="toastData.message"
              :type="toastData.type"
            />

            <!-- Download File -->
            <!-- <button
              class="button secondary-btn mr-3.5 font-bold"
              @click="downloadValue = true"
            >
              <svg-vue icon="download-file" />
            </button> -->
            <Modal :modal-active="downloadValue" width="583" @close="downloadToggle">
              <div class="mb-4">
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-spring-50"
                    icon="download-file"
                  />
                  <b>Download file.</b>
                </div>
                <div class="rounded-lg bg-mint p-4">
                  Click the download button to save the file.
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
                    type=""
                    @click="downloadValue = false"
                  />
                  <BtnComponent
                    class="space"
                    text="Download"
                    type="primary"
                    @click="downloadValue = false"
                  />
                </div>
              </div>
            </Modal>

            <!-- Delete Activity -->
            <!-- <button
              class="button secondary-btn mr-3.5 font-bold"
              @click="deleteValue = true"
            >
              <svg-vue icon="delete" />
            </button> -->
            <Modal :modal-active="deleteValue" width="583" @close="deleteToggle">
              <div class="mb-4">
                <div class="title mb-6 flex">
                  <svg-vue class="mr-1 mt-0.5 text-lg text-crimson-40" icon="delete" />
                  <b>Delete organisation</b>
                </div>
                <div class="rounded-lg bg-rose p-4">
                  Are you sure you want to delete this organisation?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
                    type=""
                    @click="deleteValue = false"
                  />
                  <BtnComponent
                    class="space"
                    text="Delete"
                    type="primary"
                    @click="deleteValue = false"
                  />
                </div>
              </div>
            </Modal>

            <!-- Unpublish /Publish Activity -->
            <PublishUnpublish />
          </div>
        </div>
      </div>
    </div>
    <!-- title section ends -->
    <div class="activities">
      <aside class="activities__sidebar">
        <div class="mb-1 flex">
          <div class="activities__card progress mr-1">
            <div class="mb-2 flex items-center justify-between">
              <span class="mr-2">Publishing Progress</span>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                class="hover-text"
                position="right"
              />
            </div>
            <RadialProgressBar
              class="mb-3 h-20 text-8xl"
              :is-percent="true"
              :percent="progress"
            ></RadialProgressBar>
            <span>Fill core elements to get 100% score</span>
          </div>
          <div class="activities__card elements">
            <div class="mb-7 flex items-center justify-between">
              <span>Elements</span>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                class="hover-text"
              />
            </div>
            <div class="mb-3 flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue icon="star" />
                <span>Mandatory</span>
              </div>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                class="hover-text"
              />
            </div>
            <div class="flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue icon="double-tick" class="text-spring-50"></svg-vue>
                <span>Completed</span>
              </div>
              <HoverText
                hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                class="hover-text"
              />
            </div>
          </div>
        </div>
        <OrganisationElements
          :activity-id="organization.id"
          :data="elementProps"
          :status="status"
          :completed="co"
        />
      </aside>
      <div class="activities__content overflow-hidden">
        <div class="mb-3 inline-flex flex-wrap gap-2">
          <a
            v-for="(post, key, index) in groupedData"
            :key="index"
            v-smooth-scroll
            :href="`#${String(key)}`"
            class="tab-btn-anchor"
          >
            <button :disabled="post.status == 'disabled'" class="tab-btn">
              <span>{{ post.label }}</span>
              <span class="hover__text">
                <HoverText
                  :name="post.label"
                  hover-text="You cannot publish an activity until all the mandatory fields have been filled."
                  icon_size="text-tiny"
                />
              </span>
            </button>
          </a>
        </div>
        <div class="activities__content--elements -mx-3 flex flex-wrap">
          <template v-for="(post, key, index) in groupedData" :key="index">
            <div
              class="elements-title relative mx-3 mt-3 mb-1 flex w-full items-center text-sm uppercase text-n-40"
            >
              <div class="mr-4 shrink-0">{{ key }}</div>
            </div>
            <template v-for="(element, name, i) in post.elements" :key="i">
              <OrganisationElementsDetail
                v-if="
                  (typeof element.content === 'object'
                    ? Object.keys(element.content).length > 0
                    : element.content) || typeof element.content === 'number'
                "
                :id="key"
                :data="element"
                :title="name.toString()"
                :activity-id="organization.id"
                :content="element.content"
                :types="types"
                :tooltip="elements[name]['hover_text']"
                :status="
                  String(name) === 'organisation_identifier'
                    ? status['identifier']
                    : status[name]
                "
                :width="String(name) === 'organisation_identifier' ? '' : 'full'"
              />
            </template>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, onMounted, toRefs, provide, watch } from "vue";
import HoverText from "../../components/HoverText.vue";
import RadialProgressBar from "../../components/RadialProgressBar.vue";
import OrganisationElements from "./OrganisationElements.vue";
import OrganisationElementsDetail from "./OrganisationElementsDetail.vue";
import Modal from "../../components/PopupModal.vue";
import BtnComponent from "../../components/ButtonComponent.vue";
import Toast from "../../components/Toast.vue";
import PublishUnpublish from "Components/sections/OrganizationPublishUnpublishButton.vue";
import { useToggle } from "@vueuse/core";
import { watchIgnorable } from "@vueuse/core";

export default defineComponent({
  name: "OrganisationData",
  components: {
    HoverText,
    RadialProgressBar,
    OrganisationElements,
    OrganisationElementsDetail,
    Modal,
    Toast,
    BtnComponent,
    PublishUnpublish,
  },
  props: {
    elements: {
      type: Object,
      required: true,
    },
    groups: {
      type: Object,
      required: true,
    },
    organization: {
      type: Object,
      required: true,
    },
    progress: {
      type: Number,
      required: true,
    },
    toast: {
      type: Object,
      required: true,
    },
    types: {
      type: Object,
      required: true,
    },
    mandatoryCompleted: {
      type: Boolean,
      required: true,
    },
    status: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const toastData = reactive({
      visibility: false,
      message: "",
      type: true,
    });

    const [publishValue, publishToggle] = useToggle();
    const [unpublishValue, unpublishToggle] = useToggle();
    const [deleteValue, deleteToggle] = useToggle();
    const [downloadValue, downloadToggle] = useToggle();

    onMounted(() => {
      if (props.toast.message !== "") {
        toastData.type = props.toast.type === "success" ? true : false;
        toastData.visibility = true;
        toastData.message = props.toast.message;
      }
    });

    const { ignoreUpdates } = watchIgnorable(toastData, () => undefined, {
      flush: "sync",
    });

    watch(
      () => toastData.visibility,
      () => {
        console.log("watching");
        setTimeout(() => {
          toastData.visibility = false;
          ignoreToastUpdate();
        }, 5000);
      }
    );

    const ignoreToastUpdate = () => {
      ignoreUpdates(() => {
        toastData.message = "";
      });
    };

    /**
     * Grouping all the data's for scroll function
     *
     * this data is created using props.groups and props.activity
     */
    const { groups, organization, elements } = toRefs(props),
      groupedData = groups.value,
      organizationProps = organization.value,
      organizationData = groups.value,
      elementProps = elements.value;

    // generating available elements
    Object.keys(organizationData).map((key) => {
      let flag = false;

      Object.keys(organizationData[key]["elements"]).map((k) => {
        if (organizationProps[k] || typeof organizationProps[k] === "number") {
          organizationData[key]["elements"][k]["content"] = organizationProps[k];
          flag = true;
          elementProps[k]["has_data"] = true;
        } else {
          delete organizationData[key][k];
          elementProps[k]["has_data"] = false;
        }

        elementProps[k]["core"] = organizationData[key]["elements"][k]["core"];
        elementProps[k]["completed"] = organizationProps["element_status"][k];
      });

      if (flag === false) {
        delete organizationData[key];
      }
    });

    // generating available categories of elements
    Object.keys(groupedData).map((key) => {
      if (Object.prototype.hasOwnProperty.call(organizationData, key)) {
        groupedData[key]["status"] = "enabled";
      } else {
        groupedData[key]["status"] = "disabled";
      }
    });

    /**
     * Publish message toast after publishing
     */
    interface PublishMessage {
      message: string;
      type: boolean;
    }

    const publishMessage: PublishMessage = reactive({
      message: "",
      type: false,
    });

    interface PublishStatusTypeface {
      is_published: boolean;
      status: string;
    }

    const publishStatus: PublishStatusTypeface = reactive({
      is_published: organizationProps.is_published,
      status: organizationProps.status,
    });

    // const toastMessage = reactive({
    //   message: "",
    //   type: false,
    // });

    provide("publishMessage", publishMessage);
    provide("mandatoryCompleted", props.mandatoryCompleted);
    provide("toastData", toastData);
    provide("publishStatus", publishStatus);

    return {
      groupedData,
      organizationData,
      publishValue,
      publishToggle,
      unpublishValue,
      unpublishToggle,
      deleteValue,
      deleteToggle,
      downloadValue,
      downloadToggle,
      elementProps,
      toastData,
      publishStatus,
    };
  },
});
</script>

<style lang="scss">
.mandatory::after {
  content: "";
  width: 0.5px;
  height: 140px;
  @apply absolute top-1 -right-6 bg-n-20;
}

.element {
  @apply mb-3 ml-2;

  &__inner {
    @apply flex space-x-2.5;
  }

  &__notes {
    @apply h-4 w-8 rounded-sm border;
  }
}

.element__search {
  @apply my-4 h-10 w-full rounded border border-n-30 bg-white py-3 pr-3 pl-10 text-n-40 outline-none duration-300;

  &::placeholder {
    @apply text-sm text-n-30 duration-300;
    letter-spacing: -0.02em;
  }

  &:focus::placeholder {
    @apply text-n-40;
  }
}

.tab__links {
  @apply relative cursor-pointer px-2 pb-6;

  &::after {
    content: "";
    @apply absolute bottom-0 left-0 h-1 w-full scale-0 bg-bluecoral duration-300;
  }

  &:hover::after {
    content: "";
    @apply visible scale-100;
  }

  &--active {
    @apply font-bold text-bluecoral;
  }
}

.tab__links--active::after {
  content: "";
  @apply absolute bottom-0 left-0 h-1 w-full bg-bluecoral duration-300;
}

.separator {
  @apply mx-4;
}

.last {
  @apply text-n-30;
}
</style>
