<!-- eslint-disable -->
<template>
  <div class="smooth -mb-7 px-5 py-7 sm:px-10 sm:py-14 md:-mb-20">
    <div class="mx-auto max-w-[700px]">
      <section
        class="rounded bg-white px-6 py-4 shadow-textbox sm:px-12 sm:py-8"
      >
        <h3 class="text-lg font-bold text-bluecoral">
          {{
            translate.publishingChecklistText('organisations_using_iati_label')
          }}
        </h3>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            1.
            {{
              translate.publishingChecklistText('register_a_publisher_header')
            }}
          </h3>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'register_a_publisher_description.one'
              )
            }}
          </p>
          <a
            target="_blank"
            href="https://www.iatiregistry.org/register_publisher/"
          >
            {{
              translate.publishingChecklistText(
                'register_a_publisher_description.two'
              )
            }}
          </a>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'register_a_publisher_description.three'
              )
            }}
          </p>
          <a target="_blank" href="/register">
            {{
              translate.publishingChecklistText(
                'register_a_publisher_description.four'
              )
            }}
          </a>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            2.
            {{
              translate.publishingChecklistText(
                'publish_your_organisation_header'
              )
            }}
          </h3>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'publish_your_organisation_description.one'
              )
            }}
          </p>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'publish_your_organisation_description.two'
              )
            }}
          </p>
          <a target="_blank" href="/iati-standard">
            {{
              translate.publishingChecklistText(
                'publish_your_organisation_description.three'
              )
            }}
          </a>
          <br />
          <a target="_blank" href="/activities" @click="triggerModel">
            {{
              translate.publishingChecklistText(
                'publish_your_organisation_description.four'
              )
            }}
          </a>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            3.
            {{
              translate.publishingChecklistText('publish_your_activity_header')
            }}
          </h3>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'publish_your_activity_description.one'
              )
            }}
          </p>
          <p class="mt-2 text-base">
            {{
              translate.publishingChecklistText(
                'publish_your_activity_description.two.list_items.header'
              )
            }}
          </p>
          <ul class="mt-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black">
                {{
                  translate.publishingChecklistText(
                    'publish_your_activity_description.two.list_items.one'
                  )
                }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{
                  translate.publishingChecklistText(
                    'publish_your_activity_description.two.list_items.two'
                  )
                }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{
                  translate.publishingChecklistText(
                    'publish_your_activity_description.two.list_items.three'
                  )
                }}
              </span>
            </li>
          </ul>
          <p class="mt-2 text-base">
            {{
              translate.publishingChecklistText(
                'publish_your_activity_description.three.list_items.header'
              )
            }}
          </p>
          <ul class="mt-4 ml-4 list-disc text-base text-bluecoral">
            <li class="text-base">
              <span class="text-black">
                {{
                  translate.publishingChecklistText(
                    'publish_your_activity_description.three.list_items.one'
                  )
                }}
              </span>
            </li>
            <li class="text-base">
              <span class="text-black">
                {{
                  translate.publishingChecklistText(
                    'publish_your_activity_description.three.list_items.two'
                  )
                }}
              </span>
            </li>
          </ul>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'publish_your_activity_description.four'
              )
            }}
          </p>

          <a target="_blank" href="/iati-standard">
            {{
              translate.publishingChecklistText(
                'publish_your_activity_description.five'
              )
            }}
          </a>
          <br />
          <a target="_blank" href="/activities" @click="triggerModel">
            {{
              translate.publishingChecklistText(
                'publish_your_activity_description.six'
              )
            }}
          </a>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            4.
            {{
              translate.publishingChecklistText(
                'understand_further_data_header'
              )
            }}
          </h3>
          <p class="my-2 text-base">
            <span
              v-html="
                translate.publishingChecklistText(
                  'understand_further_data_description.one'
                )
              "
            ></span>
          </p>
          <p class="my-2 text-base">
            <span
              v-html="
                translate.publishingChecklistText(
                  'understand_further_data_description.two'
                )
              "
            ></span>
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            5.
            {{
              translate.publishingChecklistText('run_automatic_checks_header')
            }}
          </h3>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'run_automatic_checks_description.one'
              )
            }}
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            6.
            {{ translate.publishingChecklistText('publish_your_data_header') }}
          </h3>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'publish_your_data_description.one'
              )
            }}
          </p>
          <p class="my-2 text-base">
            {{
              translate.publishingChecklistText(
                'publish_your_data_description.two'
              )
            }}
            <br />
            <a target="_blank" href="https://iatiregistry.org/publisher/">
              https://iatiregistry.org/publisher/
            </a>
            .
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            7.
            {{ translate.publishingChecklistText('access_your_data_header') }}
          </h3>
          <p class="my-2 text-base">
            <span
              v-html="
                translate.publishingChecklistText(
                  'access_your_data_description.one'
                )
              "
            ></span>
          </p>
          <p class="my-2 text-base">
            <span
              v-html="
                translate.publishingChecklistText(
                  'access_your_data_description.two'
                )
              "
            ></span>
          </p>
          <p class="my-2 text-base">
            <span
              v-html="
                translate.publishingChecklistText(
                  'access_your_data_description.three'
                )
              "
            ></span>
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <h3 class="py-2 text-2xl font-bold text-bluecoral">
            8.
            <span
              v-html="
                translate.publishingChecklistText('update_and_improve_header')
              "
            ></span>
          </h3>
          <p class="my-2 text-base">
            <span
              v-html="
                translate.publishingChecklistText(
                  'update_and_improve_description.one'
                )
              "
            ></span>
          </p>
        </article>
        <article class="py-4 sm:py-6">
          <span
            v-html="
              translate.publishingChecklistText(
                'update_and_improve_description.two'
              )
            "
          ></span>
        </article>
      </section>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { Translate } from 'Composable/translationHelper';

function triggerModel() {
  localStorage.setItem('openAddModel', 'true');
}
const translate = new Translate();
</script>
