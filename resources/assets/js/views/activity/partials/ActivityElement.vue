<template>
  <div :class="layout" class="activities__content--element px-3 py-3 text-n-50">
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
            ></svg-vue>
          </template>

          <template v-else-if="title === 'identifier'">
            <svg-vue
              class="mr-1.5 text-xl text-bluecoral"
              icon="activity-elements/iati_identifier"
            ></svg-vue>
          </template>

          <template v-else>
            <svg-vue
              :icon="'activity-elements/' + title"
              class="mr-1.5 text-xl text-bluecoral"
            ></svg-vue>
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

        <div class="icons flex items-center">
          <a
            :href="`/activities/${activityId}/${title}`"
            class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
            <span>Edit</span>
          </a>

          <template v-if="'core' in data">
            <svg-vue v-if="data.core" class="mr-1.5" icon="core"></svg-vue>
          </template>

          <HoverText
            v-if="tooltip"
            :hover_text="tooltip"
            class="text-n-40"
          ></HoverText>
        </div>
      </div>

      <div class="divider mb-4 h-px w-full bg-n-20"></div>

      <!-- Title -->
      <template v-if="title === 'title'">
        <div v-for="(post, i) in data.content" :key="i" class="title-content">
          <div v-if="post.language" class="language mb-1.5">
            (Language: {{ types.languages[post.language] }})
          </div>
          <div v-if="post.narrative" class="description text-sm">
            {{ post.narrative }}
          </div>
          <div v-if="i !== data.content.length - 1" class="mb-4"></div>
        </div>
      </template>

      <!-- Identifier -->
      <template v-else-if="title === 'identifier'">
        <div class="identifier-content">
          <div v-if="data.content.activity_identifier" class="text-sm">
            {{ data.content.activity_identifier }}
          </div>
          <div v-if="data.content.iati_identifier_text" class="text-sm">
            {{ data.content.iati_identifier_text }}
          </div>
        </div>
      </template>

      <!-- Description -->
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
            <div v-if="item.language" class="language mb-1.5">
              (Language: {{ types.languages[item.language] }})
            </div>
            <div v-if="item.narrative" class="w-[887px] text-sm">
              {{ item.narrative }}
            </div>
          </div>
        </div>
      </template>

      <!-- Activity Date -->
      <template v-else-if="title === 'activity_date'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="date-type mb-1 flex flex-col space-y-2 text-sm font-bold">
            <span>{{ props.types.activityDate[post.type] }}</span>
            <span class="text-sm font-normal">{{ post.date }}</span>
          </div>
          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="date-content elements-detail"
          >
            <div class="flex flex-col">
              <span v-if="item.language" class="language mb-1.5"
                >(Language: {{ types.languages[item.language] }})</span
              >
              <span v-if="item.narrative" class="description text-sm">{{
                item.narrative
              }}</span>
            </div>
          </div>
        </div>
      </template>

      <!-- Recipient Country -->
      <template v-else-if="title === 'recipient_country'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="recipient_country-code mb-4 flex gap-1 text-sm">
            <span>{{ types.country[post.country_code] }}</span>
            <span v-if="post.percentage" class="text-sm font-normal"
              >({{ post.percentage }}%)</span
            >
          </div>

          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="recipient_country-content"
          >
            <div v-if="item.language" class="language mb-1.5">
              (Language: {{ types.languages[item.language] }})
            </div>
            <div v-if="item.narrative" class="w-[887px] text-sm">
              {{ item.narrative }}
            </div>
          </div>
        </div>
      </template>

      <!-- Related Activity -->
      <template v-else-if="title === 'related_activity'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="related-content text-sm">
            <div>{{ post.activity_identifier }}</div>
            <div>
              {{ props.types.relatedActivityType[post.relationship_type] }}
            </div>
          </div>
        </div>
      </template>

      <!-- Legacy Data -->
      <template v-else-if="title === 'legacy_data'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div v-if="post.name" class="mb-1 text-sm">{{ post.name }}</div>
          <div class="ml-5">
            <table>
              <tr>
                <td v-if="post.value">Value</td>
                <td>{{ post.value }}</td>
              </tr>
            </table>
            <table>
              <tr>
                <td v-if="post.iati_equivalent">Iati-Equivalent</td>
                <td>{{ post.iati_equivalent }}</td>
              </tr>
            </table>
          </div>
        </div>
      </template>

      <!-- Conditions -->
      <template v-else-if="title === 'conditions'">
        <div class="elements-detail">
          <div
            v-for="(post, key) in data.content.condition"
            :key="key"
            :class="{ 'mb-4': key !== data.content.condition.length - 1 }"
          >
            <div class="mb-4 text-sm font-bold">
              {{ props.types.conditionType[post.condition_type] }}
            </div>
            <table class="ml-5">
              <tr v-if="data.content.condition_attached">
                <td>Attached</td>
                <td>
                  <span v-if="data.content.condition_attached === '0'">No</span>
                  <span v-else-if="data.content.condition_attached === '1'"
                    >Yes</span
                  >
                </td>
              </tr>
              <tr
                v-for="(item, i) in post.narrative"
                :key="i"
                class="multiline"
                :class="{ 'mb-4': i !== post.narrative.length - 1 }"
              >
                <td v-if="item.narrative">Narrative</td>
                <td>
                  <span v-if="item.language" class="language top"
                    >(Language: {{ types.languages[item.language] }})</span
                  >
                  <span v-if="item.narrative">{{ item.narrative }}</span>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </template>

      <!-- Humanitarian Scope -->
      <template v-else-if="title === 'humanitarian_scope'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="category">
            {{ types.humanitarianScopeType[post.type] }}
          </div>
          <table class="ml-5">
            <tr v-if="post.vocabulary">
              <td>Vocabulary</td>
              <td>{{ types.humanitarianScopeVocabulary[post.vocabulary] }}</td>
            </tr>
            <tr
              v-for="(item, i) in post.narrative"
              :key="i"
              class="multiline"
              :class="{ 'mb-0': i !== post.narrative.length - 1 }"
            >
              <td v-if="item.narrative">Description</td>
              <td>
                <span v-if="item.language" class="language top">
                  (Language: {{ types.languages[item.language] }})
                </span>
                <span v-if="item.narrative" class="description">
                  {{ item.narrative }}
                </span>
              </td>
            </tr>
            <tr v-if="post.vocabulary_uri">
              <td>Vocabulary URI</td>
              <td>{{ post.vocabulary_uri }}</td>
            </tr>
            <tr v-if="post.code">
              <td>Code</td>
              <td>{{ post.code }}</td>
            </tr>
          </table>
        </div>
      </template>

      <!-- Default Aid Type -->
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
              {{ types.aidType[post.default_aid_type] }}
            </div>
          </div>
        </div>
      </template>

      <!-- Country Budget Items -->
      <template v-else-if="title === 'country_budget_items'">
        <div
          v-for="(post, key) in data.content.budget_item"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.budget_item.length - 1 }"
        >
          <div
            class="flex space-x-1 text-sm"
            v-if="data.content.country_budget_vocabulary === '1'"
          >
            <span>
              {{ types.budgetIdentifier[post.code] }}
            </span>
            <span>({{ post.percentage }}%)</span>
          </div>
          <div v-else class="text-sm">
            <span>{{ post.code_text }}</span>
          </div>
          <template v-for="(post, i) in post.description" :key="i">
            <div
              v-for="(narrative, k) in post.narrative"
              :key="k"
              class="elements-detail ml-5"
              :class="{ 'mb-0': k !== post.narrative - 1 }"
            >
              <table>
                <tr
                  v-if="data.content.country_budget_vocabulary"
                  class="multiline"
                >
                  <td>Vocabulary</td>
                  <td>
                    <span v-if="narrative.language" class="language top"
                      >(Language:
                      {{ types.languages[narrative.language] }})</span
                    >
                    <span>
                      {{
                        props.types.budgetIdentifierVocabulary[
                          data.content.country_budget_vocabulary
                        ]
                      }}
                    </span>
                  </td>
                </tr>
                <tr class="multiline">
                  <td v-if="narrative.narrative">Description</td>
                  <td>
                    <span v-if="narrative.language" class="language top"
                      >(Language:
                      {{ types.languages[narrative.language] }})</span
                    >
                    <span v-if="narrative.narrative" class="description">{{
                      narrative.narrative
                    }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </template>
        </div>
      </template>

      <!-- Sector -->
      <template v-else-if="title === 'sector'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="country_budget_items elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="tb-title category">
            {{ types.sectorVocabulary[post.sector_vocabulary] }}
          </div>
          <div class="mb-1 flex space-x-1 text-sm">
            <div>
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
            </div>
            <span v-if="post.percentage" class="text-sm"
              >({{ post.percentage }}%)</span
            >
          </div>
          <div
            v-for="(narrative, k) in post.narrative"
            :key="k"
            class="country_budget_items ml-5"
            :class="{ 'mb-0': k !== post.narrative - 1 }"
          >
            <table>
              <tr class="multiline">
                <td v-if="narrative.narrative">Description</td>
                <td>
                  <span v-if="narrative.language" class="language top"
                    >(Language: {{ types.languages[narrative.language] }})</span
                  >
                  <span v-if="narrative.narrative" class="description">{{
                    narrative.narrative
                  }}</span>
                </td>
              </tr>
              <tr
                v-if="
                  post.sector_vocabulary === '98' ||
                  post.sector_vocabulary === '99'
                "
              >
                <td>Vocabulary URI</td>
                <td>{{ post.vocabulary_uri }}</td>
              </tr>
            </table>
          </div>
        </div>
      </template>

      <!-- Recipient Region -->
      <template v-else-if="title === 'recipient_region'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="category">
            {{ types.regionVocabulary[post.region_vocabulary] }}
          </div>
          <div class="elements-detail ml-5">
            <table>
              <tr>
                <td>
                  <span v-if="post.region_vocabulary === '1'">Code</span>
                  <span v-else-if="post.region_vocabulary">Code</span>
                  <span v-else></span>
                </td>
                <td>
                  <span v-if="post.region_vocabulary === '1'">
                    {{ types.region[post.region_code] }}
                  </span>
                  <span v-else>
                    {{ post.custom_code }}
                  </span>
                </td>
              </tr>
              <tr v-if="post.percentage">
                <td>Percentage</td>
                <td>{{ post.percentage }}%</td>
              </tr>
              <tr>
                <td v-if="post.vocabulary_uri">Vocabulary-uri</td>
                <td v-if="post.region_vocabulary === '99'">
                  {{ post.vocabulary_uri }}
                </td>
              </tr>
            </table>
          </div>

          <div
            v-for="(narrative, k) in post.narrative"
            :key="k"
            class="item elements-detail ml-5"
            :class="{ 'mb-4': k !== post.narrative - 1 }"
          >
            <table class="flex flex-col">
              <tr class="multiline">
                <td v-if="narrative.narrative">Description</td>
                <td>
                  <span v-if="narrative.language" class="language"
                    >(Language: {{ types.languages[narrative.language] }})</span
                  >
                  <span v-if="narrative.narrative" class="description">{{
                    narrative.narrative
                  }}</span>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </template>

      <!-- Other Identifier -->
      <template v-else-if="title === 'other_identifier'">
        <div class="elements-detail">
          <div class="category">
            {{ types.otherIdentifierType[data.content.reference_type] }}
          </div>
          <div class="mb-1 text-sm">
            {{ data.content.reference }}
          </div>
          <div>
            <div class="tb-content px-6">
              <div
                v-for="(post, key) in data.content.owner_org"
                :key="key"
                :class="{ 'mb-4': key !== data.content.owner_org.length - 1 }"
              >
                <table v-if="post.ref">
                  <tr>
                    <th>
                      <span class="category -ml-6">Owner org</span>
                    </th>
                  </tr>
                  <tr>
                    <td>Reference</td>
                    <td>{{ post.ref }}</td>
                  </tr>
                </table>
                <div
                  v-for="(i, k) in post.narrative"
                  :key="k"
                  class="item"
                  :class="{ 'mb-4': k !== post.narrative.length - 1 }"
                >
                  <table class="flex flex-col">
                    <tr class="multiline">
                      <td v-if="i.narrative">Narrative</td>
                      <td>
                        <span v-if="i.language" class="language"
                          >(Language: {{ types.languages[i.language] }})</span
                        >
                        <span v-if="i.narrative" class="description">{{
                          i.narrative
                        }}</span>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- Policy Marker -->
      <template v-else-if="title === 'policy_marker'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="category">
            {{ types.policyMarkerVocabulary[post.policymarker_vocabulary] }}
          </div>
          <div class="text-sm">
            <span v-if="post.policymarker_vocabulary === '1'">
              {{ types.policyMarker[post.policy_marker] }}
            </span>
            <span v-else>
              {{ post.policy_marker_text }}
            </span>
          </div>
          <table class="ml-5">
            <tr v-if="post.policymarker_vocabulary === '99'">
              <td>Vocabulary URI</td>
              <td>{{ post.vocabulary_uri }}</td>
            </tr>
            <tr v-if="post.significance">
              <td>Significance</td>
              <td>{{ types.policySignificance[post.significance] }}</td>
            </tr>
            <tr
              v-for="(narrative, k) in post.narrative"
              :key="k"
              class="multiline"
              :class="{ 'mb-4': k !== post.narrative.length - 1 }"
            >
              <td v-if="narrative.narrative">Description</td>
              <td>
                <span v-if="narrative.language" class="language top"
                  >(Language: {{ types.languages[narrative.language] }})</span
                >
                <span v-if="narrative.narrative" class="description">{{
                  narrative.narrative
                }}</span>
              </td>
            </tr>
          </table>
        </div>
      </template>

      <!-- Tag -->
      <template v-else-if="title === 'tag'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="category">
            {{ types.tagVocabulary[post.tag_vocabulary] }}
          </div>
          <div class="text-sm">
            <span
              v-if="post.tag_vocabulary === '1' || post.tag_vocabulary === '99'"
            >
              {{ post.tag_text }}
            </span>
            <span v-if="post.tag_vocabulary === '2'">
              {{ types.sdgGoals[post.goals_tag_code] }}
            </span>
            <span v-if="post.tag_vocabulary === '3'">
              {{ types.sdgTarget[post.targets_tag_code] }}
            </span>
          </div>
          <table
            v-for="(narrative, k) in post.narrative"
            :key="k"
            class="ml-5"
            :class="{ 'mb-4': k !== post.narrative.length - 1 }"
          >
            <tr class="multiline">
              <td v-if="narrative.narrative">Description</td>
              <td>
                <span v-if="narrative.language" class="language top"
                  >(Language: {{ types.languages[narrative.language] }})</span
                >
                <span v-if="narrative.narrative" class="description">{{
                  narrative.narrative
                }}</span>
              </td>
            </tr>
            <tr v-if="post.tag_vocabulary === '99'">
              <td>Vocabulary URI</td>
              <td>
                {{ post.vocabulary_uri }}
              </td>
            </tr>
          </table>
        </div>
      </template>

      <!-- Budget -->
      <template v-else-if="title === 'budget'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="space text-sm font-bold">
            {{ types.budgetType[post.budget_type] }}
          </div>
          <div class="mb-2 text-sm">
            {{ types.budgetStatus[post.budget_status] }}
          </div>

          <div
            v-for="(item, i) in post.budget_value"
            :key="i"
            class="elements-detail mb-1"
            :class="{ 'mb-4': i !== post.budget_value.length - 1 }"
          >
            <div class="value text-sm">
              <span>{{ item.amount }}</span>
              <span>{{ item.currency }}</span>
              <span v-if="item.value_date">({{ item.value_date }})</span>
            </div>
          </div>
          <div class="ml-5">
            <div
              v-for="(item, i) in post.period_start"
              :key="i"
              :class="{ 'mb-4': i !== post.period_start.length - 1 }"
            >
              <table v-if="item.date">
                <tr>
                  <td>Period Start</td>
                  <td>{{ item.date }}</td>
                </tr>
              </table>
            </div>
            <div
              v-for="(item, i) in post.period_end"
              :key="i"
              :class="{ 'mb-4': i !== post.period_end.length - 1 }"
            >
              <table v-if="item.date">
                <tr>
                  <td>Period end</td>
                  <td>{{ item.date }}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </template>

      <!-- Contact Info -->
      <template v-else-if="title === 'contact_info'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div class="category text-sm font-bold">
            {{ types.contactType[post.type] }}
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
              <div class="value items-center text-sm">
                <span v-if="narrative.narrative">{{
                  narrative.narrative
                }}</span>
                <span v-if="narrative.language" class="language"
                  >(Language: {{ types.languages[narrative.language] }})</span
                >
              </div>
            </div>
          </div>

          <div class="ml-5">
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
                <table class="flex flex-col">
                  <tr class="multiline">
                    <td v-if="narrative.narrative">Organisation</td>
                    <td>
                      <span v-if="narrative.language" class="language"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span v-if="narrative.narrative" class="description">{{
                        narrative.narrative
                      }}</span>
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
                <table class="flex flex-col">
                  <tr class="multiline">
                    <td v-if="narrative.narrative">Department</td>
                    <td>
                      <span v-if="narrative.language" class="language"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span v-if="narrative.narrative" class="description">{{
                        narrative.narrative
                      }}</span>
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
                <table class="flex flex-col">
                  <tr class="multiline">
                    <td v-if="narrative.narrative">Job Title</td>
                    <td>
                      <span v-if="narrative.language" class="language"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span v-if="narrative.narrative" class="description">{{
                        narrative.narrative
                      }}</span>
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
                <table class="flex">
                  <tr class="multiline">
                    <td v-if="narrative.narrative">Mailing Address</td>
                    <td>
                      <span v-if="narrative.narrative" class="description"
                        >{{ narrative.narrative }}
                        <span v-if="narrative.language"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        ></span
                      >
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- Location -->
      <template v-else-if="title === 'location'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div v-if="post.ref" class="category">
            {{ types.contactType[post.ref] }}
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
              <div class="flex items-center space-x-1 text-sm">
                <span v-if="narrative.narrative">{{
                  narrative.narrative
                }}</span>
                <span v-if="narrative.language"
                  >({{ types.languages[narrative.language] }})</span
                >
              </div>
            </div>
          </div>

          <div
            v-for="(item, i) in post.location_reach"
            :key="i"
            class="ml-5"
            :class="{ 'mb-4': i !== post.location_reach.length - 1 }"
          >
            <table v-if="item.code">
              <tr>
                <td>Location Reach</td>
                <td class="text-sm">
                  {{ types.geographicLocationReach[item.code] }}
                </td>
              </tr>
            </table>
          </div>

          <div class="ml-5">
            <div
              v-for="(item, i) in post.location_id"
              :key="i"
              :class="{ 'mb-4': i !== post.location_id.length - 1 }"
            >
              <table class="flex flex-col">
                <tr>
                  <td v-if="item.vocabulary">Location Id</td>
                  <td>
                    <div class="value">
                      <span v-if="item.vocabulary"
                        >{{ types.geographicVocabulary[item.vocabulary] }},
                      </span>
                      <span v-if="item.code">code {{ item.code }}</span>
                    </div>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.description"
              :key="i"
              :class="{ 'mb-4': i !== post.description.length - 1 }"
            >
              <div
                v-for="(narrative, j) in item.narrative"
                :key="j"
                :class="{ 'mb-4': j !== item.narrative.length - 1 }"
              >
                <table class="flex flex-col">
                  <tr class="multiline">
                    <td v-if="narrative.narrative">Description</td>
                    <td>
                      <span v-if="narrative.language" class="language"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span v-if="narrative.narrative" class="description">{{
                        narrative.narrative
                      }}</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div
              v-for="(item, i) in post.activity_description"
              :key="i"
              :class="{ 'mb-4': i !== post.activity_description.length - 1 }"
            >
              <div
                v-for="(narrative, j) in item.narrative"
                :key="j"
                :class="{ 'mb-4': j !== item.narrative.length - 1 }"
              >
                <table class="flex flex-col">
                  <tr class="multiline">
                    <td v-if="narrative.narrative">Activity Description</td>
                    <td>
                      <span v-if="narrative.language" class="language"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span v-if="narrative.narrative" class="description">{{
                        narrative.narrative
                      }}</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <div
              v-for="(item, i) in post.administrative"
              :key="i"
              :class="{ 'mb-4': i !== post.administrative.length - 1 }"
            >
              <table>
                <tr>
                  <td v-if="item.vocabulary">Administrative</td>
                  <td>
                    <div class="flex space-x-1">
                      <span v-if="item.vocabulary"
                        >vocabulary -
                        {{ types.geographicVocabulary[item.vocabulary] }},
                      </span>
                      <span v-if="item.code">code {{ item.code }}, </span>
                      <span v-if="item.level">level {{ item.level }}</span>
                    </div>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.point"
              :key="i"
              class="flex space-x-1"
              :class="{ 'mb-4': i !== post.point.length - 1 }"
            >
              <table v-if="item.srs_name">
                <tr>
                  <td>Point</td>
                  <td>{{ types.locationType[item.srs_name] }},</td>
                </tr>
              </table>
              <div
                v-for="(pos, j) in item.pos"
                :key="j"
                class="top flex space-x-1"
                :class="{ 'mb-4': j !== item.pos.length - 1 }"
              >
                <span v-if="pos.latitude">latitude {{ pos.latitude }}, </span>
                <span v-if="pos.longitude">longitude {{ pos.longitude }}</span>
              </div>
            </div>

            <div
              v-for="(item, i) in post.exactness"
              :key="i"
              :class="{ 'mb-4': i !== post.exactness.length - 1 }"
            >
              <table v-if="item.code" class="flex flex-col">
                <tr>
                  <td>Exactness</td>
                  <td>
                    <span>{{ types.locationType[item.code] }}</span>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.location_class"
              :key="i"
              :class="{ 'mb-4': i !== post.location_class.length - 1 }"
            >
              <table v-if="item.code" class="flex flex-col">
                <tr>
                  <td>Location Class</td>
                  <td>
                    <span>{{ types.locationType[item.code] }}</span>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.feature_designation"
              :key="i"
              :class="{ 'mb-4': i !== post.feature_designation.length - 1 }"
            >
              <table v-if="item.code" class="flex flex-col">
                <tr>
                  <td>Feature Designation</td>
                  <td>
                    <span>{{ types.locationType[item.code] }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </template>

      <!-- Planned Disbursement -->
      <template v-else-if="title === 'planned_disbursement'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div v-if="post.planned_disbursement_type" class="category">
            {{ types.budgetType[post.planned_disbursement_type] }}
          </div>

          <div
            v-for="(item, i) in post.value"
            :key="i"
            :class="{ 'mb-0': i !== post.value.length - 1 }"
          >
            <div class="value text-sm">
              <span>{{ item.amount }}</span>
              <span>{{ types.currency[item.currency] }}</span>
              <span v-if="item.value_date">({{ item.value_date }})</span>
            </div>
          </div>
          <div class="ml-5">
            <div
              v-for="(item, i) in post.period_start"
              :key="i"
              :class="{ 'mb-0': i !== post.period_start.length - 1 }"
            >
              <table v-if="item.iso_date" class="flex flex-col">
                <tr>
                  <td>Period Start</td>
                  <td>
                    <span>{{ item.iso_date }}</span>
                  </td>
                </tr>
              </table>
            </div>
            <div
              v-for="(item, i) in post.period_end"
              :key="i"
              class="mb-4"
              :class="{ 'mb-4': i !== post.period_end.length - 1 }"
            >
              <table v-if="item.iso_date" class="flex flex-col">
                <tr>
                  <td>Period End</td>
                  <td>
                    <span>{{ item.iso_date }}</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div
            v-for="(item, i) in post.provider_org"
            :key="i"
            :class="{ 'mb-4': i !== post.provider_org.length - 1 }"
          >
            <div v-if="item.type" class="category">
              {{ types.organizationType[item.type] }}
            </div>
            <div class="ml-5">
              <table>
                <tr>
                  <td v-if="item.provider_activity_id">Provider Org</td>
                  <td>
                    <div class="value">
                      <span v-if="item.provider_activity_id">{{
                        item.provider_activity_id
                      }}</span>
                      <span v-if="item.ref">({{ item.ref }})</span>
                    </div>
                  </td>
                </tr>
              </table>
              <div
                v-for="(narrative, j) in item.narrative"
                :key="j"
                class="mb-2"
                :class="{ 'mb-4': j !== item.narrative.length - 1 }"
              >
                <table class="flex flex-col">
                  <tr class="multiline">
                    <td v-if="narrative.narrative">Narrative</td>
                    <td>
                      <span v-if="narrative.language" class="language"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span v-if="narrative.narrative" class="description">{{
                        narrative.narrative
                      }}</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div
            v-for="(item, i) in post.receiver_org"
            :key="i"
            :class="{ 'mb-4': i !== post.receiver_org.length - 1 }"
          >
            <div v-if="item.type" class="category">
              {{ types.organizationType[item.type] }}
            </div>
            <div class="ml-5">
              <table>
                <tr>
                  <td v-if="item.provider_activity_id">Receiver Org</td>
                  <td>
                    <div class="value">
                      <span v-if="item.provider_activity_id">{{
                        item.provider_activity_id
                      }}</span>
                      <span v-if="item.ref">({{ item.ref }})</span>
                    </div>
                  </td>
                </tr>
              </table>
              <div
                v-for="(narrative, j) in item.narrative"
                :key="j"
                :class="{ 'mb-4': j !== item.narrative.length - 1 }"
              >
                <table class="flex flex-col">
                  <tr class="multiline">
                    <td v-if="narrative.narrative">Narrative</td>
                    <td>
                      <span v-if="narrative.language" class="language"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span v-if="narrative.narrative" class="description">{{
                        narrative.narrative
                      }}</span>
                    </td>
                  </tr>
                </table>
              </div>
              <div
                v-for="(item, i) in post.capital_spend"
                :key="i"
                :class="{ 'mb-4': i !== post.capital_spend.length - 1 }"
              >
                <table v-if="item.percentage" class="flex flex-col">
                  <tr>
                    <td>Capital Spend</td>
                    <td>
                      <span>{{ item.percentage }}%</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </template>

      <!-- Participating Org -->
      <template v-else-if="title === 'participating_org'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div v-if="post.organization_role" class="category">
            {{ types.organisationRole[post.organization_role] }}
          </div>

          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
          >
            <div v-if="item.narrative" class="text-sm">
              {{ item.narrative }}
            </div>
          </div>

          <div
            v-for="(narrative, i) in post.narrative"
            :key="i"
            class="ml-5"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
          >
            <table class="flex flex-col">
              <tr class="multiline">
                <td v-if="narrative.narrative">Organisation Name</td>
                <td>
                  <span v-if="narrative.language" class="language top"
                    >(Language: {{ types.languages[narrative.language] }})</span
                  >
                  <span v-if="narrative.narrative" class="description">{{
                    narrative.narrative
                  }}</span>
                </td>
              </tr>
              <tr v-if="post.identifier">
                <td>Identifier</td>
                <td>{{ post.identifier }}</td>
              </tr>
              <tr v-if="post.type">
                <td>Organisation Type</td>
                <td>{{ types.organizationType[post.type] }}</td>
              </tr>
              <tr v-if="post.organization_role">
                <td>Organisation Role</td>
                <td>{{ types.organisationRole[post.organization_role] }}</td>
              </tr>
              <tr v-if="post.ref">
                <td>Ref</td>
                <td>{{ types.humanitarianScopeType[post.ref] }}</td>
              </tr>
              <tr>
                <td v-if="post.identifier">Activity Id</td>
                <td>
                  <div>
                    <span v-if="post.identifier">{{ post.identifier }}</span>
                  </div>
                </td>
              </tr>
              <tr v-if="post.crs_channel_code">
                <td>CRS Channel Code</td>
                <td>{{ post.crs_channel_code }}</td>
              </tr>
            </table>
          </div>
        </div>
      </template>

      <!-- Document Link -->
      <template v-else-if="title === 'document_link'">
        <div
          v-for="(post, key) in data.content"
          :key="key"
          class="elements-detail"
          :class="{ 'mb-4': key !== data.content.length - 1 }"
        >
          <div v-for="(category, i) in post.category" :key="i">
            <div v-if="category.code" class="category">
              {{ types.documentCategory[category.code] }}
            </div>
          </div>
          <div class="ml-5">
            <div v-for="(language, i) in post.language" :key="i">
              <table v-if="language.code">
                <tr>
                  <td>Language</td>
                  <td>
                    {{ types.languages[language.code] }}
                  </td>
                </tr>
              </table>
            </div>
            <div v-for="(document_date, i) in post.document_date" :key="i">
              <table v-if="document_date.date">
                <tr>
                  <td>Date</td>
                  <td>
                    {{ document_date.date }}
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div v-for="(title, i) in post.title" :key="i" class="text-sm">
            <div
              v-for="(narrative, j) in title.narrative"
              :key="j"
              class="mb-1 flex items-center space-x-1"
            >
              <div v-if="narrative.narrative">
                {{ narrative.narrative }}
              </div>
              <div v-if="narrative.language">
                ({{ types.languages[narrative.language] }})
              </div>
            </div>
          </div>
          <table class="ml-5">
            <tr v-if="post.url">
              <td>URL</td>
              <td>{{ post.url }}</td>
            </tr>
            <tr v-if="post.format">
              <td>Format</td>
              <td>{{ post.format }}</td>
            </tr>
          </table>
          <div v-for="(description, i) in post.description" :key="i">
            <div v-for="(narrative, j) in description.narrative" :key="j">
              <table class="ml-5">
                <tr class="multiline">
                  <td v-if="narrative.narrative">Description</td>
                  <td>
                    <span v-if="narrative.language" class="language"
                      >(Language:
                      {{ types.languages[narrative.language] }})</span
                    >
                    <span v-if="narrative.narrative" class="description">{{
                      narrative.narrative
                    }}</span>
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
            <span>{{ data.content.toString() }}%</span>
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
  name: 'activity-element',
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
  width: 775px;
}
.space {
  @apply mb-4;

  span:nth-child(1) {
    @apply text-n-40;
    width: 100px;
  }
}

.elements-detail {
  @apply flex flex-col text-xs text-n-50;

  & * {
    @apply leading-5;
  }

  td:nth-child(1) {
    @apply whitespace-nowrap text-n-40;
    width: 100px;
  }
  td:nth-child(2) {
    @apply flex flex-col text-xs;
  }
  tr {
    @apply mb-1 flex items-center space-x-2;
  }
  .multiline {
    @apply items-start;
  }
}
.value {
  @apply flex space-x-1 text-n-50;
}
.category {
  @apply mb-2 text-sm font-bold text-n-50;
}
.language {
  @apply text-xs italic text-n-30;
}
.title-border::after {
  content: '';
  @apply absolute top-2 left-4 h-px bg-n-30;
  width: 932px;
}
.top {
  margin-top: 1px;
}
</style>
