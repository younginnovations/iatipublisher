<template>
  <div class="page-height bg-paper px-10 pt-4 pb-[71px]">
    <!-- title section -->
    <div class="page-title mb-6">
      <div class="mb-6 text-caption-c1 text-n-40">
        <BreadCrumb
          title="Organisation Name"
          link="Your Organisation Data"
        ></BreadCrumb>
      </div>
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h4 class="mr-4 font-bold">IMA World Health</h4>
          </div>
        </div>
        <div class="actions flex grow justify-end">
          <div class="inline-flex justify-center">
            <button
              class="button secondary-btn mr-3.5 font-bold"
              @click="downloadValue = true"
            >
              <svg-vue icon="download-file"></svg-vue>
            </button>
            <Modal
              :modalActive="downloadValue"
              width="583"
              @close="downloadToggle"
            >
              <div class="mb-4">
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-spring-50"
                    icon="download-file"
                  ></svg-vue>
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
            <button
              class="button secondary-btn mr-3.5 font-bold"
              @click="deleteValue = true"
            >
              <svg-vue icon="delete"></svg-vue>
            </button>
            <Modal :modalActive="deleteValue" width="583" @close="deleteToggle">
              <div class="mb-4">
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-crimson-40"
                    icon="delete"
                  ></svg-vue>
                  <b>Delete activity</b>
                </div>
                <div class="rounded-lg bg-rose p-4">
                  Are you sure you want to delete this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
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

            <!-- Unpublish Activity -->
            <button
              class="button secondary-btn mr-3.5 font-bold"
              @click="unpublishValue = true"
            >
              <svg-vue icon="cancel-cloud"></svg-vue>
              <span>Unpublish</span>
            </button>
            <Modal
              :modalActive="unpublishValue"
              width="583"
              @close="unpublishToggle"
            >
              <div class="mb-4">
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-crimson-40"
                    icon="cancel-cloud"
                  ></svg-vue>
                  <b>Unpublish activity</b>
                </div>
                <div class="rounded-lg bg-rose p-4">
                  Are you sure you want to unpublish this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
                    @click="unpublishValue = false"
                  />
                  <BtnComponent
                    class="space"
                    text="Unpublish"
                    type="primary"
                    @click="unpublishValue = false"
                  />
                </div>
              </div>
            </Modal>

            <!-- Publish Activity -->
            <button
              class="button primary-btn relative font-bold"
              @click="publishValue = true"
            >
              <svg-vue icon="approved-cloud"></svg-vue>
              <span>Publish</span>
            </button>
            <Modal
              :modalActive="publishValue"
              width="583"
              @close="publishToggle"
            >
              <div class="mb-4">
                <div class="title mb-6 flex">
                  <svg-vue
                    class="mr-1 mt-0.5 text-lg text-spring-50"
                    icon="approved-cloud"
                  ></svg-vue>
                  <b>Publish activity?</b>
                </div>
                <div class="rounded-lg bg-mint p-4">
                  Are you ready to publish this activity?
                </div>
              </div>
              <div class="flex justify-end">
                <div class="inline-flex">
                  <BtnComponent
                    class="bg-white px-6 uppercase"
                    text="Go Back"
                    @click="publishValue = false"
                  />
                  <BtnComponent
                    class="space"
                    text="Publish"
                    type="primary"
                    @click="publishValue = false"
                  />
                </div>
              </div>
            </Modal>
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
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
                position="right"
              ></HoverText>
            </div>
            <RadialProgressBar class="mb-3 h-20 text-8xl"></RadialProgressBar>
            <span>Fill core elements to get 100% score</span>
          </div>
          <div class="activities__card elements">
            <div class="mb-11 flex items-center justify-between">
              <span>Elements</span>
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
              ></HoverText>
            </div>
            <div class="flex justify-between">
              <div class="flex items-center space-x-1">
                <svg-vue
                  icon="double-tick"
                  class="text-base text-spring-50"
                ></svg-vue>
                <span>Completed</span>
              </div>
              <HoverText
                hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                name=""
              ></HoverText>
            </div>
          </div>
        </div>
        <OrganisationElements :data="elements" />
      </aside>
      <div class="activities__content">
        <div class="mb-3 inline-flex flex-wrap gap-2">
          <a
            v-for="(post, key) in groupedData"
            :key="key"
            v-smooth-scroll
            :href="`#${key}`"
            class="tab-btn-anchor"
          >
            <button :disabled="post.status == 'disabled'" class="tab-btn">
              <span>{{ post.label }}</span>
              <span class="hover__text">
                <HoverText
                  :name="post.label"
                  hover_text="You cannot publish an activity until all the mandatory fields have been filled."
                  icon_size="text-tiny"
                ></HoverText>
              </span>
            </button>
          </a>
        </div>

        <div class="activities__content--elements -mx-3 flex flex-wrap">
          <template v-for="(post, key, index) in organisation" :key="index">
            <template v-for="(element, name, i) in post.elements" :key="i">
              <OrganisationElementsDetail
                :id="key"
                :content="
                  elementsDetail.data.hasOwnProperty(key)
                    ? elementsDetail.data[key][name]
                    : element.content
                "
                :data="element"
                :title="name"
                :width="
                  name === 'total_budget' ||
                  name === 'recipient_organisation_budget' ||
                  name === 'recipient_region_budget' ||
                  name === 'recipient_country_budget' ||
                  name === 'total_expenditure' ||
                  name === 'document_link'
                    ? 'full'
                    : ''
                "
                tooltip="Example text"
              />
            </template>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref } from 'vue';
import HoverText from '../../components/HoverText.vue';
import ActivityElement from '../activity/partials/ActivityElement.vue';
import RadialProgressBar from '../../components/RadialProgressBar.vue';
import OrganisationElements from './OrganisationElements.vue';
import OrganisationElementsDetail from './OrganisationElementsDetail.vue';
import BreadCrumb from '../../components/BreadCrumb.vue';
import Modal from '../../components/PopupModal.vue';
import BtnComponent from '../../components/ButtonComponent.vue';
import { useToggle } from '@vueuse/core';

export default defineComponent({
  name: 'organisation-elements',
  components: {
    HoverText,
    ActivityElement,
    RadialProgressBar,
    OrganisationElements,
    OrganisationElementsDetail,
    BreadCrumb,
    Modal,
    BtnComponent,
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
    activity: {
      type: Object,
      required: true,
    },
    progress: {
      type: Number,
      required: true,
    },
  },
  setup(props) {
    const tab = ref('identification');
    function toggleTab(page: string) {
      tab.value = page;
    }
    const elements = reactive({
      organisation_identifier: '',
      name: '',
      reporting_org: '',
      total_budget: '',
      recipient_org_budget: '',
      recipient_country_budget: '',
      recipient_region_budget: '',
      total_expenditure: '',
      document_link: '',
    });

    const elementsDetail = reactive({
      data: {
        identification: {
          organisation_identifier: {
            identifier: 'AF-COA-1234',
          },
          organisation_name: {
            name: 'Younginnovations',
          },
          reporting_organisation: {
            language: '(Language: English)',
            narrative: 'Partnership Against Child Exploitation',
          },
        },
        budget: {
          total_budget: [
            {
              indicative: [
                {
                  indicative: 'Indicative',
                  budget: '84,967,593 USD',
                  period: 'January 19, 2022 - January 20, 2024',
                  value_date: 'January 19, 2022',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
                {
                  budget: '84,967,593 USD',
                  period: 'January 19, 2022 - January 20, 2024',
                  value_date: 'January 19, 2022',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
            {
              committed: [
                {
                  committed: 'Committed',
                  budget: '84,967,593 USD',
                  period: 'January 19, 2022 - January 20, 2024',
                  value_date: 'January 19, 2022',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
          ],
          recipient_organisation_budget: [
            {
              indicative: [
                {
                  indicative: 'Indicative',
                  budget: '84,967,593 USD',
                  recipient_organisation: {
                    reference: 'Reference -AA445GH',
                    language: '(Language: English)',
                    cash: 'Mama Cash',
                  },
                  value_date: 'January 19, 2022',
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
                {
                  budget: '84,967,593 USD',
                  recipient_organisation: {
                    reference: 'Reference -AA445GH',
                    language: '(Language: English)',
                    cash: 'Mama Cash',
                  },
                  value_date: 'January 19, 2022',
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
            {
              committed: [
                {
                  committed: 'Committed',
                  budget: '84,967,593 USD',
                  recipient_organisation: {
                    reference: 'Reference -AA445GH',
                    language: '(Language: English)',
                    cash: 'Mama Cash',
                  },
                  value_date: 'January 19, 2022',
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
          ],
          recipient_region_budget: [
            {
              indicative: [
                {
                  indicative: 'Indicative',
                  budget: '84,967,593 USD',
                  value_date: 'January 19, 2022',
                  vocabulary: '1 - OECD',
                  vocabulary_URI: 'http://example.com/vocab.html',
                  code: '289 - south of sahara, regional',
                  description: {
                    language: '(Language: English)',
                    text: 'This is to cover the isolated cases where the organisation publishing the data may not agree with name of a country or region given by the lookup codelists IATI uses.',
                  },
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
                {
                  budget: '84,967,593 USD',
                  value_date: 'January 19, 2022',
                  vocabulary: '1 - OECD',
                  vocabulary_URI: 'http://example.com/vocab.html',
                  code: '289 - south of sahara, regional',
                  description: {
                    language: '(Language: English)',
                    text: 'This is to cover the isolated cases where the organisation publishing the data may not agree with name of a country or region given by the lookup codelists IATI uses.',
                  },
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
            {
              committed: [
                {
                  committed: 'Committed',
                  budget: '84,967,593 USD',
                  value_date: 'January 19, 2022',
                  vocabulary: '1 - OECD',
                  vocabulary_URI: 'http://example.com/vocab.html',
                  code: '289 - south of sahara, regional',
                  description: {
                    language: '(Language: English)',
                    text: 'This is to cover the isolated cases where the organisation publishing the data may not agree with name of a country or region given by the lookup codelists IATI uses.',
                  },
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
          ],
          recipient_country_budget: [
            {
              indicative: [
                {
                  indicative: 'Indicative',
                  budget: '84,967,593 USD',
                  value_date: 'January 19, 2022',
                  code: '289 - south of sahara, regional',
                  description: {
                    language: '(Language: English)',
                    text: 'This is to cover the isolated cases where the organisation publishing the data may not agree with name of a country or region given by the lookup codelists IATI uses.',
                  },
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
                {
                  budget: '84,967,593 USD',
                  value_date: 'January 19, 2022',
                  code: '289 - south of sahara, regional',
                  description: {
                    language: '(Language: English)',
                    text: 'This is to cover the isolated cases where the organisation publishing the data may not agree with name of a country or region given by the lookup codelists IATI uses.',
                  },
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
            {
              committed: [
                {
                  committed: 'Committed',
                  budget: '84,967,593 USD',
                  value_date: 'January 19, 2022',
                  code: '289 - south of sahara, regional',
                  description: {
                    language: '(Language: English)',
                    text: 'This is to cover the isolated cases where the organisation publishing the data may not agree with name of a country or region given by the lookup codelists IATI uses.',
                  },
                  period: 'January 19, 2022 - January 20, 2024',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
          ],
        },
        expenditure: {
          total_expenditure: [
            {
              indicative: [
                {
                  indicative: 'Indicative',
                  budget: '84,967,593 USD',
                  period: 'January 19, 2022 - January 20, 2024',
                  value_date: 'January 19, 2022',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
                {
                  budget: '84,967,593 USD',
                  period: 'January 19, 2022 - January 20, 2024',
                  value_date: 'January 19, 2022',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
            {
              committed: [
                {
                  committed: 'Committed',
                  budget: '84,967,593 USD',
                  period: 'January 19, 2022 - January 20, 2024',
                  value_date: 'January 19, 2022',

                  budget_line: [
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                    {
                      budget: '200,000 USD',
                      reference: '1234',
                      narrative: [
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                        {
                          language: '(Language: English)',
                          narrative: 'Budget divided as extra living expenses',
                        },
                      ],
                    },
                  ],
                },
              ],
            },
          ],
        },
        document: {
          document_link: {
            document_title: 'Document link title',
            title: [
              {
                language: '(Language: English)',
                document_link_title: 'Document link title',
              },
              {
                language: '(Language: Nepali)',
                document_link_title: 'Document link title',
              },
            ],
            link: 'iatipublisher.org',
            description: [
              {
                language: '(Language: English)',
                text: 'This programme will bring change for boys and girls to enjoy their rights to be protected from the worst forms of child labour in Central African Republic, the Democratic Republic of the Congo (DRC) and Ethiopia.',
              },
              {
                language: '(Language: English)',
                text: 'This programme will bring change for boys and girls to enjoy their rights to be protected from the worst forms of child labour in Central African Republic, the Democratic Republic of the Congo (DRC) and Ethiopia.',
              },
            ],
            category: [
              {
                A: 'A01 - Pre- and post-project impact appraisal',
              },
              {
                B: 'A01 - Pre- and post-project impact appraisal',
              },
            ],
            language: 'English, Nepali',
            document_date: 'November 20,2022',
            recipient_country: [
              {
                country: 'AF- Afghanistan',
                language: '(Language: English)',
                text: 'This programme will bring change for boys and girls to enjoy their rights to be protected from the worst forms of child labour in Central African Republic, the Democratic Republic of the Congo (DRC) and Ethiopia.',
              },
              {
                language: '(Language: English)',
                text: 'This programme will bring change for boys and girls to enjoy their rights to be protected from the worst forms of child labour in Central African Republic, the Democratic Republic of the Congo (DRC) and Ethiopia.',
              },
            ],
          },
        },
      },
    });

    let pageTitle = '';

    /**
     * Grouping all the data's for scroll function
     *
     * this data is created using props.groups and props.activity
     */
    const groupedData = { ...props.groups },
      detailData = props.activity,
      organisation = { ...props.groups };

    // generating available elements
    Object.keys(organisation).map((key) => {
      let flag = false;
      Object.keys(organisation[key]['elements']).map((k) => {
        if (detailData[k]) {
          organisation[key]['elements'][k]['content'] = detailData[k];
          flag = true;
        } else {
          organisation[key]['elements'][k]['content'] = [];
        }
      });

      // generating available categories of elements
      Object.keys(groupedData).map((key) => {
        if (organisation.hasOwnProperty(key)) {
          groupedData[key]['status'] = 'enabled';
        } else {
          groupedData[key]['status'] = 'disabled';
        }
      });
    });

    const [publishValue, publishToggle] = useToggle();
    const [unpublishValue, unpublishToggle] = useToggle();
    const [deleteValue, deleteToggle] = useToggle();
    const [downloadValue, downloadToggle] = useToggle();

    return {
      elements,
      organisation,
      groupedData,
      pageTitle,
      tab,
      toggleTab,
      publishValue,
      publishToggle,
      unpublishValue,
      unpublishToggle,
      deleteValue,
      deleteToggle,
      downloadValue,
      downloadToggle,
      elementsDetail,
    };
  },
});
</script>

<style lang="scss">
.mandatory::after {
  content: '';
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
    content: '';
    @apply absolute bottom-0 left-0 h-1 w-full scale-0 bg-bluecoral duration-300;
  }
  &:hover::after {
    content: '';
    @apply visible scale-100;
  }
  &--active {
    @apply font-bold text-bluecoral;
  }
}
.tab__links--active::after {
  content: '';
  @apply absolute bottom-0 left-0 h-1 w-full bg-bluecoral duration-300;
}
.separator {
  @apply mx-4;
}
.last {
  @apply text-n-30;
}
</style>
