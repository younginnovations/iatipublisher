<template>
  <div :class="layout" class="activities__content--element px-3 py-3">
    <!-- <div class=" uppercase text-sm text-n-40 mb-4 mr-4">{{  }}
      <span class="title-border relative"></span>
    </div> -->
    <div class="rounded-lg bg-white p-4">
      <div class="mb-4 flex">
        <div class="title flex grow">
          <template
            v-if="
              title === 'reporting_org' ||
              title === 'default_tied_status' ||
              title === 'crs_add' ||
              title === 'fss'
            "
          >
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="activity-elements/building"
            />
          </template>

          <template v-else-if="title === 'identifier'">
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="activity-elements/iati_identifier"
            />
          </template>

          <template v-else>
            <svg-vue
              :icon="'activity-elements/' + title"
              class="mr-1.5 text-xl text-bluecoral"
            />
          </template>

          <div class="title text-sm font-bold">
            {{ title.toString().replace(/_/g, '-') }}
          </div>

          <div
            :class="{
              'text-spring-50': completed === true,
              'text-crimson-50': completed === false,
            }"
            class="status ml-2.5 flex text-xs leading-5"
          >
            <b class="mr-2 text-base leading-3">.</b>
            <span v-if="completed">completed</span>
            <span v-else>not completed</span>
          </div>
        </div>

        <div class="icons flex">
          <a
            :href="`/activities/${activityId}/${title}`"
            class="edit-button mr-2.5 flex items-center text-xs font-bold uppercase"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit" />
            <span>Edit</span>
          </a>

          <template v-if="'core' in data">
            <svg-vue v-if="data.core" class="mr-1.5" icon="core" />
          </template>

          <HoverText v-if="tooltip" :hover-text="tooltip" class="text-n-40" />
        </div>
      </div>
      <div class="divider mb-4 h-px w-full bg-n-20" />
      <template v-if="title === 'title'">
        <div v-for="(post, i) in data.content" :key="i" class="title-content">
          <div class="language mb-1.5">(Language: {{ post.language }})</div>
          <div v-if="post.narrative" class="description text-sm">
            {{ post.narrative }}
          </div>
          <div v-if="i !== data.content.length - 1" class="mb-4"></div>
        </div>
      </template>

      <template v-else-if="title === 'identifier'">
        <div class="identifier-content">
          <div v-if="data.content.iati_identifier_text" class="text-sm">
            {{ data.content.iati_identifier_text }}
          </div>
        </div>
      </template>

      <template v-else-if="title === 'description'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="description-type mb-4 text-sm font-bold">
            {{ props.types.descriptionType[post.type] }}
          </div>
          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="description-content"
          >
            <div class="language mb-1.5">(Language: {{ item.language }})</div>
            <div v-if="item.narrative" class="description text-sm">
              {{ item.narrative }}
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'activity_date'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="date-type mb-1 flex flex-col space-y-2 text-sm font-bold">
            <span>{{ props.types.activityDate[post.type] }}</span>
            <span class="text-sm font-normal text-n-50">{{ post.date }}</span>
          </div>
          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="date-content flex"
          >
            <span class="w-[100px] text-xs text-n-40">Description</span>
            <div class="ml-2">
              <div class="language mb-1.5">(Language: {{ item.language }})</div>
              <div v-if="item.narrative" class="description text-xs leading-5">
                {{ item.narrative }}
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'recipient_country'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="recipient_country-code mb-4 flex gap-1 text-sm">
            <span>{{ post.country_code }}</span>
            <span v-if="post.percentage" class="text-sm font-normal text-n-50"
              >({{ post.percentage }}%)</span
            >
          </div>

          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="recipient_country-content description"
          >
            <div class="language mb-1.5">(Language: {{ item.language }})</div>
            <div v-if="item.narrative" class="text-sm">
              {{ item.narrative }}
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'related_activity'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="related-content">
            <div class="type mb-1.5 text-sm italic text-n-30">
              {{ props.types.relatedActivityType[post.relationship_type] }}
            </div>
            <div class="text-sm">ref: {{ post.activity_identifier }}</div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'legacy_data'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="related-content">
            <div class="text-sm">name: {{ post.name }}</div>
            <div class="text-sm">value: {{ post.value }}</div>
            <div class="text-sm">
              iati-equivalent: {{ post.iati_equivalent }}
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'conditions'">
        <div
          class="country_budget_items overflow-hidden rounded-lg border border-n-20"
        >
          <div
            class="date-type tb-title flex gap-1 bg-n-10 px-6 py-2 text-xs font-bold"
          >
            <span> Attached: </span>
            <span class="font-normal italic text-n-30">
              <span v-if="data.content.condition_attached === '0'">No</span>
              <span v-else-if="data.content.condition_attached === '1'"
                >Yes</span
              >
            </span>
          </div>
          <div class="tb-content condition-contents px-6 py-2">
            <div
              v-for="(post, key) in data.content.condition"
              :key="key"
              :class="{ 'mb-4': key !== data.content.condition.length - 1 }"
            >
              <div class="mb-4 text-sm font-bold">
                {{ props.types.conditionType[post.condition_type] }}
              </div>
              <div
                v-for="(item, i) in post.narrative"
                :key="i"
                :class="{ 'mb-4': i !== post.narrative.length - 1 }"
                class="description-content"
              >
                <div class="language mb-1.5">
                  (Language: {{ item.language }})
                </div>
                <div v-if="item.narrative" class="text-sm">
                  {{ item.narrative }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'humanitarian_scope'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="humanitarian_scope"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <ul class="mb-4 inline-flex flex-wrap gap-3">
            <li class="inline-block">
              <div class="date-type flex gap-1 text-sm font-bold">
                <span>Code: </span>
                <span class="text-sm font-normal italic text-n-30">
                  {{ post.code }}
                </span>
              </div>
            </li>
            <li class="inline-block">
              <div class="date-type flex gap-1 text-sm font-bold">
                <span>Type: </span>
                <span class="text-sm font-normal italic text-n-30">
                  {{ types.humanitarianScopeType[post.type] }}
                </span>
              </div>
            </li>
            <li class="inline-block">
              <div class="date-type flex gap-1 text-sm font-bold">
                <span>Vocabulary: </span>
                <span class="text-sm font-normal italic text-n-30">
                  {{ types.humanitarianScopeVocabulary[post.vocabulary] }}
                </span>
              </div>
            </li>
            <li v-if="post.vocabulary === '99'" class="inline-block">
              <div class="date-type flex gap-1 text-sm font-bold">
                <span>Vocabulary Uri: </span>
                <span class="text-sm font-normal italic text-n-30">
                  {{ post.vocabulary_uri }}
                </span>
              </div>
            </li>
          </ul>
          <div class="humanitarian_scope-content">
            <div
              v-for="(item, i) in post.narrative"
              :key="i"
              :class="{ 'mb-4': i !== post.narrative.length - 1 }"
              class="description"
            >
              <div class="language mb-1.5">(Language: {{ item.language }})</div>
              <div v-if="item.narrative" class="text-sm">
                {{ item.narrative }}
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'default_aid_type'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="default_aid_type"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="default_aid_type-content">
            <div class="date-type mb-4 text-sm font-bold">
              {{ types.aidTypeVocabulary[post.default_aidtype_vocabulary] }}
            </div>

            <div v-if="post.default_aidtype_vocabulary === '2'" class="text-sm">
              {{ types.earmarkingCategory[post.earmarking_category] }}
            </div>

            <div
              v-else-if="post.default_aidtype_vocabulary === '3'"
              class="text-sm"
            >
              {{ types.earmarkingModality[post.earmarking_modality] }}
            </div>

            <div
              v-else-if="post.default_aidtype_vocabulary === '4'"
              class="text-sm"
            >
              {{
                types.cashandVoucherModalities[post.cash_and_voucher_modalities]
              }}
            </div>

            <div v-else class="text-sm">
              {{ post.default_aid_type }}
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'country_budget_items'">
        <div class="overflow-hidden rounded-lg border border-n-20">
          <div
            class="tb-title country_budget_vocabulary bg-n-10 px-6 py-2 text-xs font-bold"
          >
            {{
              props.types.budgetIdentifierVocabulary[
                data.content.country_budget_vocabulary
              ]
            }}
          </div>
          <div class="country_budget_items tb-content px-6 py-2">
            <div
              v-for="(post, key) in data.content.budget_item"
              :key="key"
              class="country_budget_item"
              :class="{ 'mb-4': key !== data.content.budget_item.length - 1 }"
            >
              <ul class="mb-4 inline-flex flex-wrap gap-3">
                <li
                  v-if="data.content.country_budget_vocabulary === '1'"
                  class="inline-block"
                >
                  <div class="date-type flex gap-1 text-sm font-bold">
                    <span>Code: </span>
                    <span class="text-sm font-normal italic text-n-30">
                      {{ post.code }}
                    </span>
                  </div>
                </li>
                <li v-else class="inline-block">
                  <div class="date-type flex gap-1 text-sm font-bold">
                    <span>Code: {{ post.code_text }}</span>
                    <span class="text-sm font-normal italic text-n-30">
                      {{ post.code_text }}
                    </span>
                  </div>
                </li>
                <li class="inline-block">
                  <div class="date-type flex gap-1 text-sm font-bold">
                    <span>Percentage:</span>
                    <span class="text-sm font-normal italic text-n-30">
                      {{ post.percentage }}%
                    </span>
                  </div>
                </li>
              </ul>
              <div class="country_budget_item-content">
                <template v-for="(item, i) in post.description" :key="i">
                  <div
                    v-for="(j, k) in item.narrative"
                    :key="k"
                    class="item description"
                    :class="{ 'mb-4': k !== item.narrative - 1 }"
                  >
                    <div class="language mb-1.5">
                      (Language: {{ i.language }})
                    </div>
                    <div v-if="j.narrative" class="text-sm">
                      {{ j.narrative }}
                    </div>
                  </div>
                </template>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'sector'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="country_budget_items overflow-hidden rounded-lg border border-n-20"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="tb-title bg-n-10 px-6 py-2 text-xs font-bold">
            {{ types.sectorVocabulary[post.sector_vocabulary] }}
          </div>
          <div class="tb-content px-6 py-2">
            <ul class="mb-4 inline-flex flex-wrap gap-2">
              <li
                v-if="
                  post.sector_vocabulary === '98' ||
                  post.sector_vocabulary === '99'
                "
              >
                <div class="flex gap-1 text-sm font-bold">
                  <span>Vocabulary-uri: </span>
                  <span class="text-sm font-normal italic text-n-30">
                    {{ post.vocabulary_uri }}
                  </span>
                </div>
              </li>
              <li>
                <div class="flex gap-1 text-sm font-bold">
                  <span>Code: </span>
                  <span class="text-sm font-normal italic text-n-30">
                    <span v-if="post.sector_vocabulary === '1'">
                      {{ types.sectorCode[post.code] }}
                    </span>
                    <span v-else-if="post.sector_vocabulary === '2'">
                      {{ types.sectorCategory[post.category_code] }}
                    </span>
                    <span v-else-if="post.sector_vocabulary === '7'">
                      {{ types.sdgGoals[post.sdg_goal] }}
                    </span>
                    <span v-else-if="post.sector_vocabulary === '8'">
                      {{ types.sdgTarget[post.sdg_target] }}
                    </span>
                    <span v-else>
                      {{ post.text }}
                    </span>
                  </span>
                </div>
              </li>
              <li>
                <div class="flex gap-1 text-sm font-bold">
                  <span>Percentage: </span>
                  <span class="text-sm font-normal italic text-n-30">
                    {{ post.percentage }}%
                  </span>
                </div>
              </li>
            </ul>
            <div class="country_budget_item-content">
              <div
                v-for="(i, k) in post.narrative"
                :key="k"
                class="country_budget_items description"
                :class="{ 'mb-4': k !== post.narrative - 1 }"
              >
                <div class="language mb-1.5">(Language: {{ i.language }})</div>
                <div v-if="i.narrative" class="text-sm">
                  {{ i.narrative }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'recipient_region'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="tb-title text-xs font-bold">
            {{ types.regionVocabulary[post.region_vocabulary] }}
          </div>
          <div class="tb-content px-6 py-2">
            <ul class="mb-4 inline-flex flex-wrap gap-1">
              <li>
                <div class="flex gap-1 text-sm font-bold">
                  <span class="text-sm font-normal text-n-50">
                    <span v-if="post.region_vocabulary === '1'">
                      {{ types.region[post.region_code] }}
                    </span>
                    <span v-else>
                      {{ post.custom_code }}
                    </span>
                  </span>
                </div>
              </li>
              <li v-if="post.region_vocabulary === '99'">
                <div class="flex gap-1 text-xs">
                  <span>Vocabulary-uri: </span>
                  <span class="">
                    {{ post.vocabulary_uri }}
                  </span>
                </div>
              </li>
              <li>
                <div class="flex gap-1 text-sm font-bold">
                  <span class="text-sm font-normal text-n-50">
                    ({{ post.percentage }}%)
                  </span>
                </div>
              </li>
            </ul>
            <div class="content">
              <div
                v-for="(i, k) in post.narrative"
                :key="k"
                class="item description"
                :class="{ 'mb-4': k !== post.narrative - 1 }"
              >
                <div class="language mb-1.5">(Language: {{ i.language }})</div>
                <div v-if="i.narrative" class="text-sm">
                  {{ i.narrative }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'other_identifier'">
        <ul class="mb-4 inline-flex flex-wrap gap-3">
          <li class="inline-block">
            <div class="date-type flex gap-1 text-sm font-bold">
              <span>Reference: </span>
              <span class="text-sm font-normal italic text-n-30">
                {{ data.content.reference }}
              </span>
            </div>
          </li>
          <li class="inline-block">
            <div class="date-type flex gap-1 text-sm font-bold">
              <span>Type: </span>
              <span class="text-sm font-normal italic text-n-30">
                {{ data.content.reference }}
              </span>
            </div>
          </li>
        </ul>
        <div class="mb-4">
          <div class="tb-title py-2 text-xs font-bold">Owner org</div>
          <div class="tb-content px-6 py-2">
            <div
              v-for="(post, key) in data.content.owner_org"
              :key="key"
              :class="{ 'mb-4': key !== data.content.owner_org.length - 1 }"
            >
              <ul class="mb-4 inline-flex flex-wrap gap-3">
                <li class="inline-block">
                  <div class="date-type flex gap-1 text-sm font-bold">
                    <span>Reference: </span>
                    <span class="text-sm font-normal italic text-n-30">
                      {{ post.ref }}
                    </span>
                  </div>
                </li>
              </ul>
              <div
                v-for="(i, k) in post.narrative"
                :key="k"
                class="item description"
                :class="{ 'mb-4': k !== post.narrative.length - 1 }"
              >
                <div class="language mb-1.5">(Language: {{ i.language }})</div>
                <div v-if="i.narrative" class="text-sm">
                  {{ i.narrative }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'policy_marker'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="overflow-hidden rounded-lg border border-n-20"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="tb-title bg-n-10 px-6 py-2 text-xs font-bold">
            {{ types.policyMarkerVocabulary[post.policymarker_vocabulary] }}
          </div>
          <div class="tb-content px-6 py-2">
            <ul class="mb-4 inline-flex flex-wrap gap-2">
              <li>
                <div class="flex gap-1 text-sm font-bold">
                  <span>Significance: </span>
                  <span class="text-sm font-normal italic text-n-30">
                    {{ types.policySignificance[post.significance] }}
                  </span>
                </div>
              </li>
              <li v-if="post.policymarker_vocabulary === '99'">
                <div class="flex gap-1 text-sm font-bold">
                  <span>Vocabulary-uri: </span>
                  <span class="text-sm font-normal italic text-n-30">
                    {{ post.vocabulary_uri }}
                  </span>
                </div>
              </li>
              <li>
                <div class="flex gap-1 text-sm font-bold">
                  <span>Code: </span>
                  <span class="text-sm font-normal italic text-n-30">
                    <span v-if="post.policymarker_vocabulary === '1'">
                      {{ types.policyMarker[post.policy_marker] }}
                    </span>
                    <span v-else>
                      {{ post.policy_marker_text }}
                    </span>
                  </span>
                </div>
              </li>
            </ul>
            <div class="content">
              <div
                v-for="(i, k) in post.narrative"
                :key="k"
                class="item description"
                :class="{ 'mb-4': k !== post.narrative.length - 1 }"
              >
                <div class="language mb-1.5">(Language: {{ i.language }})</div>
                <div v-if="i.narrative" class="text-sm">
                  {{ i.narrative }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'tag'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="overflow-hidden rounded-lg border border-n-20"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="tb-title bg-n-10 px-6 py-2 text-xs font-bold">
            {{ types.tagVocabulary[post.tag_vocabulary] }}
          </div>
          <div class="tb-content px-6 py-2">
            <ul class="mb-4 inline-flex flex-wrap gap-2">
              <li>
                <div class="flex gap-1 text-sm font-bold">
                  <span>Code: </span>
                  <span class="text-sm font-normal italic text-n-30">
                    <span
                      v-if="
                        post.tag_vocabulary === '1' ||
                        post.tag_vocabulary === '99'
                      "
                    >
                      {{ post.tag_text }}
                    </span>
                    <span v-if="post.tag_vocabulary === '2'">
                      {{ types.sdgGoals[post.goals_tag_code] }}
                    </span>
                    <span v-if="post.tag_vocabulary === '3'">
                      {{ types.sdgTarget[post.targets_tag_code] }}
                    </span>
                  </span>
                </div>
              </li>
              <li v-if="post.tag_vocabulary === '99'">
                <div class="flex gap-1 text-sm font-bold">
                  <span>Vocabulary-uri: </span>
                  <span class="text-sm font-normal italic text-n-30">
                    {{ post.vocabulary_uri }}
                  </span>
                </div>
              </li>
            </ul>
            <div class="content">
              <div
                v-for="(i, k) in post.narrative"
                :key="k"
                class="item description"
                :class="{ 'mb-4': k !== post.narrative.length - 1 }"
              >
                <div class="language mb-1.5">(Language: {{ i.language }})</div>
                <div v-if="i.narrative" class="text-sm">
                  {{ i.narrative }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'budget'">
        {{ post }}
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="text-xs leading-5 text-n-50"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="space text-sm font-bold">
            {{ post.budget_type }}
          </div>
          <div class="space text-sm">
            {{ post.budget_status }}
          </div>
          <div
            v-for="(item, i) in post.period_start"
            :key="i"
            class="space"
            :class="{ 'mb-4': i !== post.period_start.length - 1 }"
          >
            <div v-if="item.date" class="flex flex-col text-sm">
              <div class="font-bold text-n-50">Period start</div>
              <span>{{ item.date }}</span>
            </div>
          </div>
          <div
            v-for="(item, i) in post.period_end"
            :key="i"
            class="space"
            :class="{ 'mb-4': i !== post.period_end.length - 1 }"
          >
            <div v-if="item.date" class="flex flex-col text-sm">
              <div class="font-bold text-n-50">Period end</div>
              <span>{{ item.date }}</span>
            </div>
          </div>
          <div
            v-for="(item, i) in post.budget_value"
            :key="i"
            class="space flex flex-col"
            :class="{ 'mb-4': i !== post.budget_value.length - 1 }"
          >
            <div class="text-sm font-bold text-n-50">Budget value</div>
            <div v-if="item.amount" class="flex space-x-2">
              <span>Amount</span>
              <span>{{ item.amount }}</span>
            </div>
            <div v-if="item.currency" class="flex space-x-2">
              <span>currency</span>
              <span>{{ item.currency }}</span>
            </div>
            <div v-if="item.value_date" class="flex space-x-2">
              <span>Value date</span>
              <span>{{ item.value_date }}</span>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'contact_info'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="contact-info"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="space text-sm font-bold">
            {{ post.type }}
          </div>
          <div
            v-for="(item, i) in post.organisation"
            :key="i"
            :class="{ 'mb-4': i !== post.organisation.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              :class="{ 'mb-4': j !== item.narrative.length - 1 }"
            >
              <table v-if="narrative.narrative" class="flex flex-col">
                <tr>
                  <td>Organisation</td>
                  <td>
                    <span class="language"
                      >(Language: {{ narrative.language }})</span
                    >
                    <span>{{ narrative.narrative }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div
            v-for="(item, i) in post.department"
            :key="i"
            :class="{ 'mb-4': i !== post.department.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              :class="{ 'mb-4': j !== item.narrative.length - 1 }"
            >
              <table v-if="narrative.narrative" class="flex flex-col">
                <tr>
                  <td>Department</td>
                  <td>
                    <span class="language"
                      >(Language: {{ narrative.language }})</span
                    >
                    <span>{{ narrative.narrative }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div
            v-for="(item, i) in post.person_name"
            :key="i"
            :class="{ 'mb-4': i !== post.person_name.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              :class="{ 'mb-4': j !== item.narrative.length - 1 }"
            >
              <table v-if="narrative.narrative" class="flex flex-col">
                <tr>
                  <td>Person Name</td>
                  <td>
                    <span class="language"
                      >(Language: {{ narrative.language }})</span
                    >
                    <span>{{ narrative.narrative }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div
            v-for="(item, i) in post.job_title"
            :key="i"
            :class="{ 'mb-4': i !== post.job_title.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              :class="{ 'mb-4': j !== item.narrative.length - 1 }"
            >
              <table v-if="narrative.narrative" class="flex flex-col">
                <tr>
                  <td>Job Title</td>
                  <td>
                    <span class="language"
                      >(Language: {{ narrative.language }})</span
                    >
                    <span>{{ narrative.narrative }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>

          <div
            v-for="(item, i) in post.telephone"
            :key="i"
            :class="{ 'mb-4': i !== post.telephone.length - 1 }"
          >
            <table v-if="item.telephone" class="flex flex-col">
              <tr>
                <td>Telephone</td>
                <td>
                  <span>{{ item.telephone }}</span>
                </td>
              </tr>
            </table>
          </div>

          <div
            v-for="(item, i) in post.email"
            :key="i"
            :class="{ 'mb-4': i !== post.email.length - 1 }"
          >
            <table v-if="item.email" class="flex flex-col">
              <tr>
                <td>Email</td>
                <td>
                  <span>{{ item.email }}</span>
                </td>
              </tr>
            </table>
          </div>

          <div
            v-for="(item, i) in post.website"
            :key="i"
            :class="{ 'mb-4': i !== post.website.length - 1 }"
          >
            <table v-if="item.website" class="flex flex-col">
              <tr>
                <td>Website</td>
                <td>
                  <span>{{ item.website }}</span>
                </td>
              </tr>
            </table>
          </div>

          <div
            v-for="(item, i) in post.mailing_address"
            :key="i"
            :class="{ 'mb-4': i !== post.mailing_address.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              :class="{ 'mb-4': j !== item.narrative.length - 1 }"
            >
              <table v-if="narrative.narrative" class="flex flex-col">
                <tr>
                  <td>Mailing Address</td>
                  <td>
                    <span
                      >{{ narrative.narrative }} (Language:
                      {{ narrative.language }})</span
                    >
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </template>

      <template v-else-if="title === 'location'">
        <!-- { "ref": "1", "location_reach": [ { "code": "1" } ], "location_id": [ {
        "vocabulary": "A1", "code": "123" } ], "name": [ { "narrative": [ {
        "narrative": "afsdgdfhffh", "language": "aa" } ] } ], "description": [ {
        "narrative": [ { "narrative": "asfgdhhghkh", "language": "aa" } ] } ],
        "activity_description": [ { "narrative": [ { "narrative": "gddfhfjghk",
        "language": "ab" } ] } ], "administrative": [ { "vocabulary": "A2",
        "code": "123", "level": "2" } ], "point": [ { "srs_name": "FRMQ", "pos":
        [ { "latitude": "dsfdsgsgsg", "longitude": "dg" } ] } ], "exactness": [
        { "code": "CMPQ" } ], "location_class": [ { "code": "AIRQ" } ],
        "feature_designation": [ { "code": "FRMQ" } ] } -->
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="contact-info"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <table>
            <tr>
              <td>Reference</td>
              <td>{{ post.ref }}</td>
            </tr>
          </table>

          <div
            v-for="(item, i) in post.location_reach"
            :key="i"
            :class="{ 'mb-4': i !== post.location_reach.length - 1 }"
          >
            <table v-if="item.code" class="flex flex-col">
              <tr>
                <td>Location Reach</td>
                <td>
                  <span>{{ item.code }}</span>
                </td>
              </tr>
            </table>
          </div>

          <div
            v-for="(item, i) in post.location_id"
            :key="i"
            :class="{ 'mb-4': i !== post.location_id.length - 1 }"
          >
            <table v-if="item.vocabulary" class="flex flex-col">
              <tr>
                <td>Location Id</td>
                <td>
                  <span>{{ item.vocabulary }}</span>
                </td>
              </tr>
            </table>
            <table v-if="item.code" class="flex flex-col">
              <tr>
                <td></td>
                <td>
                  <span>{{ item.code }}</span>
                </td>
              </tr>
            </table>
          </div>

          <div
            v-for="(item, i) in post.name"
            :key="i"
            :class="{ 'mb-4': i !== post.name.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              :class="{ 'mb-4': j !== item.narrative.length - 1 }"
            >
              <table v-if="narrative.narrative" class="flex flex-col">
                <tr>
                  <td>Name</td>
                  <td>
                    <span class="language"
                      >(Language: {{ narrative.language }})</span
                    >
                    <span>{{ narrative.narrative }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </template>

      <template v-else>
        <div class="content text-sm">
          <template v-if="title === 'activity_status'">
            {{ props.types.activityStatus[data.content] }}
          </template>

          <template v-else-if="title === 'activity_scope'">
            {{ props.types.activityScope[data.content] }}
          </template>

          <template v-else-if="title === 'collaboration_type'">
            {{ props.types.collaborationType[data.content] }}
          </template>

          <template v-else-if="title === 'default_flow_type'">
            {{ props.types.flowType[data.content] }}
          </template>

          <template v-else-if="title === 'default_tied_status'">
            {{ props.types.tiedStatus[data.content] }}
          </template>

          <template v-else-if="title === 'capital_spend'">
            <span>{{ data.content }}%</span>
          </template>

          <template v-else-if="title === 'default_finance_type'">
            <span> {{ props.types.financeType[data.content] }}</span>
          </template>

          <template v-else>
            <span>No content</span>
          </template>
        </div>
      </template>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import HoverText from '../../../components/HoverText.vue';

export default defineComponent({
  name: 'ActivityElement',
  components: { HoverText },
  props: {
    data: {
      type: Object,
      required: true,
    },
    activityId: {
      type: Number,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
    tooltip: {
      type: String,
      required: false,
      default: '',
    },
    width: {
      type: String,
      required: false,
      default: '',
    },
    types: {
      type: Object,
      required: true,
    },
    completed: {
      type: Boolean,
      required: true,
    },
  },
  setup(props) {
    const status = '';
    let layout = 'basis-6/12';
    if (props.width === 'full') {
      layout = 'basis-full';
    }

    return { layout, status, props };
  },
});
</script>

<style lang="scss" scoped>
.activities__content--element > div {
  .edit-button {
    opacity: 0;
    visibility: hidden;
    transition: all 0.4s ease;
  }

  &:hover .edit-button {
    opacity: 1;
    visibility: visible;
  }
}
.description {
  width: 575px;
}
.space {
  @apply mb-4;

  span:nth-child(1) {
    @apply text-n-40;
    width: 100px;
  }
}
.contact-info {
  @apply flex flex-col text-xs text-n-50;

  & * {
    @apply leading-5;
  }

  td:nth-child(1) {
    @apply text-n-40;
    width: 100px;
  }
  td:nth-child(2) {
    @apply flex flex-col text-xs;
  }
  tr {
    @apply mb-1 flex space-x-2;
  }
}
.language {
  @apply text-xs italic text-n-30;
}
.title-border::after {
  content: '';
  @apply absolute top-2 left-4 h-px bg-n-30;
  width: 932px;
}
</style>
