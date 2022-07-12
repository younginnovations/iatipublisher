<template>
  <div :class="layout" class="activities__content--element p-3 text-n-50">
    <div :id="title" class="rounded-lg bg-white p-4">
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

          <template v-else-if="title === 'iati_identifier'">
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

        <div class="icons flex items-center">
          <a
            :href="`/activities/${activityId}/${title}`"
            class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
          >
            <svg-vue class="mr-0.5 text-base" icon="edit" />
            <span>Edit</span>
          </a>

          <svg-vue v-if="data.core" class="mr-1.5" icon="core"></svg-vue>

          <HoverText v-if="tooltip" :hover-text="tooltip" class="text-n-40" />
        </div>
      </div>

      <div class="divider mb-4 h-px w-full bg-n-20"></div>

      <!-- Title -->
      <template v-if="title === 'title'">
        <div v-for="(post, i) in data.content" :key="i" class="title-content">
          <div v-if="post.narrative" class="flex flex-col">
            <span v-if="post.language" class="language mb-1.5">
              (Language: {{ types.languages[post.language] }})
            </span>
            <span v-if="post.narrative" class="description text-sm">
              {{ post.narrative }}
            </span>
          </div>
          <span v-else class="text-sm italic">Title Not Available</span>
          <div v-if="i !== data.content.length - 1" class="mb-4"></div>
        </div>
      </template>

      <!-- Identifier -->
      <template v-else-if="title === 'iati_identifier'">
        <div class="identifier-content">
          <div v-if="data.content.iati_identifier_text" class="text-sm">
            <pre>{{ data.content.iati_identifier_text }}</pre>
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
            <span v-if="post.type">
              {{ props.types.descriptionType[post.type] }}
            </span>
            <span v-else class="italic">Type Not Available</span>
          </div>
          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="description-content text-sm"
          >
            <div v-if="item.narrative" class="flex flex-col">
              <span v-if="item.language" class="language mb-1.5">
                (Language: {{ types.languages[item.language] }})
              </span>
              <span v-if="item.narrative" class="max-w-[887px]">
                {{ item.narrative }}
              </span>
            </div>
            <span v-else class="italic">Narrative Not Available</span>
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
          <div class="date-type mb-1 flex flex-col space-y-2 text-sm">
            <div>
              <span v-if="post.type" class="font-bold">{{
                props.types.activityDate[post.type]
              }}</span>
              <span v-else class="text-sm font-bold italic"
                >Type Not Available</span
              >
            </div>
            <div>
              <span v-if="post.date" class="text-sm font-normal">{{
                formatDate(post.date)
              }}</span>
              <span v-else class="text-sm italic">Date Not Available</span>
            </div>
          </div>
          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="date-content elements-detail"
          >
            <table class="ml-5">
              <tr class="multiline">
                <td>Narrative</td>
                <td>
                  <div v-if="item.narrative" class="flex flex-col">
                    <span v-if="item.language" class="language top"
                      >(Language: {{ types.languages[item.language] }})</span
                    >
                    <span v-if="item.narrative" class="description">
                      {{ item.narrative }}
                    </span>
                  </div>
                  <span v-else class="italic">Not Available</span>
                </td>
              </tr>
            </table>
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
          <div class="recipient_country-code mb-2 text-sm">
            <div v-if="post.country_code" class="space-x-1">
              <span>{{ types.country[post.country_code] }}</span>
              <span v-if="post.percentage" class="text-sm font-normal"
                >({{ post.percentage }}%)</span
              >
            </div>
            <span v-else class="italic">Not Available</span>
          </div>

          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
            class="recipient_country-content text-sm"
          >
            <div v-if="item.narrative" class="flex max-w-[887px] flex-col">
              <span v-if="item.language" class="language mb-1.5">
                (Language: {{ types.languages[item.language] }})
              </span>
              <span>{{ item.narrative }}</span>
            </div>
            <span v-else class="italic">Narrative Not Available</span>
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
            <div class="category">
              <span v-if="post.relationship_type">{{
                props.types.relatedActivityType[post.relationship_type]
              }}</span>
              <span v-else class="italic">Type Not Available</span>
            </div>
            <div>
              <span v-if="post.activity_identifier">{{
                post.activity_identifier
              }}</span>
              <span v-else class="italic">Reference Not Available</span>
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
          <div class="mb-1 text-sm">
            <div v-if="post.name">{{ post.name }}</div>
            <span v-else class="italic">Name Not Available</span>
          </div>
          <div class="ml-5">
            <table>
              <tr>
                <td>Value</td>
                <td v-if="post.value">{{ post.value }}</td>
                <td v-else class="italic">Not Available</td>
              </tr>
            </table>
            <table>
              <tr>
                <td>Iati-Equivalent</td>
                <td v-if="post.iati_equivalent">{{ post.iati_equivalent }}</td>
                <td v-else class="italic">Not Available</td>
              </tr>
            </table>
          </div>
        </div>
      </template>

      <!-- Conditions -->
      <template v-else-if="title === 'conditions'">
        <div>
          <div
            v-if="data.content.condition_attached === '1'"
            class="elements-detail"
          >
            <div
              v-for="(post, key) in data.content.condition"
              :key="key"
              :class="{ 'mb-4': key !== data.content.condition.length - 1 }"
            >
              <div class="mb-2 text-sm font-bold">
                <div v-if="post.condition_type">
                  {{ props.types.conditionType[post.condition_type] }}
                </div>
                <span v-else class="italic">Type Not Available</span>
              </div>
              <table class="ml-5">
                <tr>
                  <td>Attached</td>
                  <td>
                    <span v-if="data.content.condition_attached === '0'"
                      >No</span
                    >
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
                  <td>Narrative</td>
                  <td>
                    <div v-if="item.narrative" class="flex flex-col">
                      <span v-if="item.language" class="language top"
                        >(Language: {{ types.languages[item.language] }})</span
                      >
                      <span v-if="item.narrative">{{ item.narrative }}</span>
                    </div>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <span v-else class="text-sm italic">Condition not Attached</span>
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
            <span v-if="post.type">{{
              types.humanitarianScopeType[post.type]
            }}</span>
            <span v-else class="italic">Type Not Available</span>
          </div>
          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            class="multiline text-sm"
            :class="{ 'mb-0': i !== post.narrative.length - 1 }"
          >
            <div v-if="item.narrative" class="space-x-1">
              <span class="description">
                {{ item.narrative }}
              </span>
              <span v-if="item.language" class="italic text-n-30">
                (Language: {{ types.languages[item.language] }})
              </span>
            </div>
            <span v-else class="italic">Narrative Not Available</span>
          </div>
          <table class="ml-5">
            <tr>
              <td>Vocabulary</td>
              <td v-if="post.vocabulary">
                {{ types.humanitarianScopeVocabulary[post.vocabulary] }}
              </td>
              <td v-else class="italic">Not Available</td>
            </tr>
            <tr>
              <td>Vocabulary URI</td>
              <td v-if="post.vocabulary_uri">{{ post.vocabulary_uri }}</td>
              <td v-else class="italic">Not Available</td>
            </tr>
            <tr>
              <td>Code</td>
              <td v-if="post.code">{{ post.code }}</td>
              <td v-else class="italic">Not Available</td>
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
            <div class="date-type mb-2 text-sm font-bold">
              <span v-if="post.default_aidtype_vocabulary">{{
                types.aidTypeVocabulary[post.default_aidtype_vocabulary]
              }}</span>
              <span v-else class="italic">Vocabulary Not Available</span>
            </div>

            <div v-if="post.default_aidtype_vocabulary === '2'" class="text-sm">
              <span v-if="post.earmarking_category">{{
                types.earmarkingCategory[post.earmarking_category]
              }}</span>
              <span v-else class="italic">Not Available</span>
            </div>

            <div v-else-if="post.default_aidtype_Code === '3'" class="text-sm">
              <span v-if="post.earmarking_modality">{{
                types.earmarkingModality[post.earmarking_modality]
              }}</span>
              <span v-else class="italic">Not Available</span>
            </div>

            <div v-else-if="post.default_aidtype_Code === '4'" class="text-sm">
              <span v-if="post.cash_and_voucher_modalities">{{
                types.cashandVoucherModalities[post.cash_and_voucher_modalities]
              }}</span>
              <span v-else class="italic">Not Available</span>
            </div>

            <div v-else class="max-w-[887px] text-sm">
              <span v-if="post.default_aid_type">{{
                types.aidType[post.default_aid_type]
              }}</span>
              <span v-else class="italic">Not Available</span>
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
            v-if="data.content.country_budget_vocabulary === '1'"
            class="text-sm"
          >
            <div v-if="post.code" class="flex space-x-1">
              <span>
                {{ types.budgetIdentifier[post.code] }}
              </span>
              <span>({{ post.percentage }}%)</span>
            </div>
            <span v-else class="italic">Not Available</span>
          </div>
          <div v-else class="text-sm">
            <span v-if="post.code_text">{{ post.code_text }}</span>
            <span v-else class="italic">Not Available</span>
          </div>
          <template v-for="(item, i) in post.description" :key="i">
            <div
              v-for="(narrative, k) in item.narrative"
              :key="k"
              class="elements-detail ml-5"
              :class="{ 'mb-0': k !== item.narrative - 1 }"
            >
              <table>
                <tr class="multiline">
                  <td>Vocabulary</td>
                  <td>
                    <span v-if="data.content.country_budget_vocabulary">{{
                      props.types.budgetIdentifierVocabulary[
                        data.content.country_budget_vocabulary
                      ]
                    }}</span>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
                <tr class="multiline">
                  <td>Description</td>
                  <td>
                    <div v-if="narrative.narrative" class="flex flex-col">
                      <span v-if="narrative.language" class="language top"
                        >(Language:
                        {{ types.languages[narrative.language] }})</span
                      >
                      <span class="description">{{ narrative.narrative }}</span>
                    </div>
                    <span v-else class="italic">Not Available</span>
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
            <span v-if="post.sector_vocabulary">{{
              types.sectorVocabulary[post.sector_vocabulary]
            }}</span>
            <span v-else class="italic">Vocabulary Not Available</span>
          </div>
          <div class="mb-1 flex space-x-1 text-sm">
            <div>
              <div v-if="post.sector_vocabulary === '1'">
                <span v-if="post.code">{{ types.sectorCode[post.code] }}</span>
                <span v-else class="italic">Not Available</span>
              </div>
              <div v-else-if="post.sector_vocabulary === '2'">
                <span v-if="post.category_code">{{
                  types.sectorCategory[post.category_code]
                }}</span>
                <span v-else class="italic">Not Available</span>
              </div>
              <div v-else-if="post.sector_vocabulary === '7'">
                <span v-if="post.sdg_goal">{{
                  types.sdgGoals[post.sdg_goal]
                }}</span>
                <span v-else class="italic">Not Available</span>
              </div>
              <div v-else-if="post.sector_vocabulary === '8'">
                <span v-if="post.sdg_target">{{
                  types.sdgTarget[post.sdg_target]
                }}</span>
                <span v-else class="italic">Not Available</span>
              </div>
              <div v-else>
                <span v-if="post.text">{{ post.text }}</span>
                <span v-else class="italic">Not Available</span>
              </div>
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
                <td>Narrative</td>
                <td>
                  <div v-if="narrative.narrative" class="flex flex-col">
                    <span v-if="narrative.language" class="language top"
                      >(Language:
                      {{ types.languages[narrative.language] }})</span
                    >
                    <span class="description">{{ narrative.narrative }}</span>
                  </div>
                  <span v-else class="italic">Not Available</span>
                </td>
              </tr>
              <tr
                v-if="
                  post.sector_vocabulary === '98' ||
                  post.sector_vocabulary === '99'
                "
              >
                <td>Vocabulary URI</td>
                <td>
                  <span v-if="post.vocabulary_uri">{{
                    post.vocabulary_uri
                  }}</span>
                  <span v-else class="italic">Not Available</span>
                </td>
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
            <span v-if="post.region_vocabulary">{{
              types.regionVocabulary[post.region_vocabulary]
            }}</span>
            <span v-else class="italic">Vocabulary Not Available</span>
          </div>
          <div class="flex space-x-1 text-sm">
            <div v-if="post.region_vocabulary === '1'">
              <span v-if="post.region_code">{{
                types.region[post.region_code]
              }}</span>
              <span v-else class="italic">Not Available</span>
            </div>
            <div v-else>
              <span v-if="post.custom_code">{{ post.custom_code }}</span>
              <span v-else class="italic">Not Available</span>
            </div>
            <span v-if="post.percentage">({{ post.percentage }}%)</span>
          </div>
          <div class="elements-detail ml-5">
            <table>
              <tr>
                <td v-if="post.region_vocabulary === '99'">Vocabulary-uri</td>
                <td v-if="post.region_vocabulary === '99'">
                  <span v-if="post.vocabulary_uri">{{
                    post.vocabulary_uri
                  }}</span>
                  <span v-else class="italic">Not Available</span>
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
                <td>Narrative</td>
                <td>
                  <div v-if="narrative.narrative" class="flex flex-col">
                    <span v-if="narrative.language" class="language"
                      >(Language:
                      {{ types.languages[narrative.language] }})</span
                    >
                    <span v-if="narrative.narrative" class="description">{{
                      narrative.narrative
                    }}</span>
                  </div>
                  <span v-else class="italic">Not Available</span>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </template>

      <!-- Other Identifier -->
      <template v-else-if="title === 'other_identifier'">
        <div class="elements-detail other-identifier">
          <div class="category">
            <span v-if="data.content.reference_type">{{
              types.otherIdentifierType[data.content.reference_type]
            }}</span>
            <span v-else class="italic">Type Not Available</span>
          </div>
          <div class="text-sm">
            <span v-if="data.content.reference">{{
              data.content.reference
            }}</span>
            <span v-else class="italic">Reference Not Available</span>
          </div>
          <div>
            <div class="tb-content ml-5">
              <div
                v-for="(post, key) in data.content.owner_org"
                :key="key"
                :class="{ 'mb-4': key !== data.content.owner_org.length - 1 }"
              >
                <table>
                  <tr>
                    <td>Owner Organisation Reference</td>
                    <td v-if="post.ref">{{ post.ref }}</td>
                    <td v-else class="italic">Not Available</td>
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
                      <td>Owner Organisation Narrative</td>
                      <td>
                        <div v-if="i.narrative" class="flex flex-col">
                          <span v-if="i.language" class="language top"
                            >(Language: {{ types.languages[i.language] }})</span
                          >
                          <span v-if="i.narrative" class="description">{{
                            i.narrative
                          }}</span>
                        </div>
                        <span v-else class="italic">Not Available</span>
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
            <span v-if="post.policymarker_vocabulary">{{
              types.policyMarkerVocabulary[post.policymarker_vocabulary]
            }}</span>
            <span v-else class="italic">Vocabulary Not Available</span>
          </div>
          <div class="text-sm">
            <div v-if="post.policymarker_vocabulary === '1'">
              <span v-if="post.policy_marker">
                {{ types.policyMarker[post.policy_marker] }}
              </span>
              <span v-else class="italic">Not Available</span>
            </div>
            <div v-else>
              <span v-if="post.policy_marker_text">{{
                post.policy_marker_text
              }}</span>
              <span v-else class="italic">Not Available</span>
            </div>
          </div>
          <table class="ml-5">
            <tr v-if="post.policymarker_vocabulary === '99'">
              <td>Vocabulary URI</td>
              <td>
                <span v-if="post.vocabulary_uri">{{
                  post.vocabulary_uri
                }}</span>
                <span v-else class="italic">Not Available</span>
              </td>
            </tr>
            <tr>
              <td>Significance</td>
              <td>
                <span v-if="post.significance">{{
                  types.policySignificance[post.significance]
                }}</span>
                <span v-else class="italic">Not Available</span>
              </td>
            </tr>
            <tr
              v-for="(narrative, k) in post.narrative"
              :key="k"
              class="multiline"
              :class="{ 'mb-4': k !== post.narrative.length - 1 }"
            >
              <td>Narrative</td>
              <td>
                <div v-if="narrative.narrative" class="flex flex-col">
                  <span v-if="narrative.language" class="language top"
                    >(Language: {{ types.languages[narrative.language] }})</span
                  >
                  <span class="description">{{ narrative.narrative }}</span>
                </div>
                <span v-else class="italic">Not Available</span>
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
            <span v-if="post.tag_vocabulary">{{
              types.tagVocabulary[post.tag_vocabulary]
            }}</span>
            <span v-else class="italic">Vocabulary Not Available</span>
          </div>
          <div class="max-w-[887px] text-sm">
            <span
              v-if="post.tag_vocabulary === '1' || post.tag_vocabulary === '99'"
            >
              <span v-if="post.tag_text">{{ post.tag_text }}</span>
              <span v-else class="italic">Not Available</span>
            </span>
            <span v-if="post.tag_vocabulary === '2'">
              <span v-if="post.goals_tag_code">{{
                types.sdgGoals[post.goals_tag_code]
              }}</span>
              <span v-else class="italic">Not Available</span>
            </span>
            <span v-if="post.tag_vocabulary === '3'">
              <span v-if="post.targets_tag_code">{{
                types.sdgTarget[post.targets_tag_code]
              }}</span>
              <span v-else class="italic">Not Available</span>
            </span>
          </div>
          <table
            v-for="(narrative, k) in post.narrative"
            :key="k"
            class="ml-5"
            :class="{ 'mb-4': k !== post.narrative.length - 1 }"
          >
            <tr class="multiline">
              <td>Narrative</td>
              <td>
                <div v-if="narrative.narrative" class="flex flex-col">
                  <span v-if="narrative.language" class="language top"
                    >(Language: {{ types.languages[narrative.language] }})</span
                  >
                  <span class="description">{{ narrative.narrative }}</span>
                </div>
                <span v-else class="italic">Not Available</span>
              </td>
            </tr>
            <tr v-if="post.tag_vocabulary === '99'">
              <td>Vocabulary URI</td>
              <td>
                <span v-if="post.vocabulary_uri">
                  {{ post.vocabulary_uri }}
                </span>
                <span v-else class="italic">Not Available</span>
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
          <div class="category">
            <span v-if="post.budget_type">{{
              types.budgetType[post.budget_type]
            }}</span>
            <span v-else class="italic">Type Not Available</span>
          </div>

          <div
            v-for="(item, i) in post.budget_value"
            :key="i"
            class="elements-detail mb-1"
            :class="{ 'mb-4': i !== post.budget_value.length - 1 }"
          >
            <div class="text-sm">
              <div v-if="item.amount" class="value">
                <span>{{ item.amount }}</span>
                <span>{{ item.currency }}</span>
                <span v-if="item.value_date"
                  >(Valued at {{ formatDate(item.value_date) }})</span
                >
              </div>
              <span v-else class="italic">Budget Value Not Available</span>
            </div>
          </div>
          <div class="ml-5">
            <div
              v-for="(item, i) in post.period_start"
              :key="i"
              :class="{ 'mb-4': i !== post.period_start.length - 1 }"
            >
              <table>
                <tr>
                  <td>Period Start</td>
                  <td v-if="item.date">{{ formatDate(item.date) }}</td>
                  <td v-else class="italic">Not Available</td>
                </tr>
              </table>
            </div>
            <div
              v-for="(item, i) in post.period_end"
              :key="i"
              :class="{ 'mb-4': i !== post.period_end.length - 1 }"
            >
              <table>
                <tr>
                  <td>Period end</td>
                  <td v-if="item.date">{{ formatDate(item.date) }}</td>
                  <td v-else class="italic">Not Available</td>
                </tr>
              </table>
            </div>
            <table class="text-sm">
              <tr>
                <td>status</td>
                <td>
                  <span v-if="post.budget_status">{{
                    types.budgetStatus[post.budget_status]
                  }}</span>
                  <span v-else class="italic">Not Available</span>
                </td>
              </tr>
            </table>
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
            <span v-if="post.type">{{ types.contactType[post.type] }}</span>
            <span v-else class="italic">Type Not Available</span>
          </div>

          <div
            v-for="(item, i) in post.person_name"
            :key="i"
            :class="{ 'mb-4': i !== post.person_name.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              class="elements-detail"
              :class="{ 'mb-0': j !== item.narrative.length - 1 }"
            >
              <div v-if="narrative.narrative" class="space-x-1 text-sm">
                <span class="description">{{ narrative.narrative }}</span>
                <span v-if="narrative.language" class="italic text-n-30"
                  >(Language: {{ types.languages[narrative.language] }})</span
                >
              </div>
              <span v-else class="text-sm italic"
                >Person Name Not Available</span
              >
            </div>
          </div>

          <div
            v-for="(item, i) in post.organisation"
            :key="i"
            :class="{ 'mb-4': i !== post.organisation.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              class="text-sm"
              :class="{ 'mb-4': j !== item.narrative.length - 1 }"
            >
              <div v-if="narrative.narrative" class="space-x-1">
                <span class="description">{{ narrative.narrative }}</span>
                <span v-if="narrative.language" class="italic text-n-30"
                  >(Language: {{ types.languages[narrative.language] }})</span
                >
              </div>
              <span v-else class="italic">Organisation Not Available</span>
            </div>
          </div>
          <div class="ml-5">
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
                <table>
                  <tr class="multiline">
                    <td>Department</td>
                    <td>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        >
                        <span class="description">{{
                          narrative.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
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
                <table>
                  <tr class="multiline">
                    <td>Job Title</td>
                    <td>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        >
                        <span class="description">{{
                          narrative.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
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
              <table class="flex flex-col">
                <tr>
                  <td>Telephone</td>
                  <td>
                    <span v-if="item.telephone">{{ item.telephone }}</span>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.email"
              :key="i"
              :class="{ 'mb-4': i !== post.email.length - 1 }"
            >
              <table class="flex flex-col">
                <tr>
                  <td>Email</td>
                  <td>
                    <span v-if="item.email">{{ item.email }}</span>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.website"
              :key="i"
              :class="{ 'mb-4': i !== post.website.length - 1 }"
            >
              <table class="flex flex-col">
                <tr>
                  <td>Website</td>
                  <td>
                    <span v-if="item.website">{{ item.website }}</span>
                    <span v-else class="italic">Not Available</span>
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
                    <td>Mailing Address</td>
                    <td>
                      <div v-if="narrative.narrative">
                        <span class="description"
                          >{{ narrative.narrative }}
                          <span v-if="narrative.language" class="language"
                            >(Language:
                            {{ types.languages[narrative.language] }})</span
                          ></span
                        >
                      </div>
                      <span v-else class="italic">Not Available</span>
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
          <div
            v-for="(item, i) in post.location_reach"
            :key="i"
            :class="{ 'mb-0': i !== post.location_reach.length - 1 }"
          >
            <div class="category">
              <span v-if="item.code">
                {{ types.geographicLocationReach[item.code] }}
              </span>
              <span v-else class="italic">Location Reach Not Available</span>
            </div>
          </div>

          <div
            v-for="(item, i) in post.name"
            :key="i"
            :class="{ 'mb-4': i !== post.name.length - 1 }"
          >
            <div
              v-for="(narrative, j) in item.narrative"
              :key="j"
              class="text-sm"
              :class="{ 'mb-4': j !== item.narrative.length - 1 }"
            >
              <div
                v-if="narrative.narrative"
                class="flex items-center space-x-1"
              >
                <span>{{ narrative.narrative }}</span>
                <span v-if="narrative.language" class="italic text-n-30"
                  >(Language: {{ types.languages[narrative.language] }})</span
                >
              </div>
              <span v-else class="italic">Name Not Available</span>
            </div>
          </div>

          <div class="ml-5">
            <table>
              <tr>
                <td>Reference</td>
                <td class="text-sm">
                  <span v-if="post.ref">{{ types.contactType[post.ref] }}</span>
                  <span v-else class="italic">Not Available</span>
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
                  <td>Location Id</td>
                  <td>
                    <div class="flex space-x-1">
                      <div class="value">
                        <span v-if="item.vocabulary"
                          >{{ types.geographicVocabulary[item.vocabulary] }},
                        </span>
                        <span v-else class="italic"
                          >(Vocabulary Not Available)</span
                        >
                      </div>
                      <div>
                        <span v-if="item.code">code {{ item.code }}</span>
                        <span v-else class="italic">(Not Available)</span>
                      </div>
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
                <table>
                  <tr class="multiline">
                    <td>Description</td>
                    <td>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language top"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        >
                        <span class="description">{{
                          narrative.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
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
                <table>
                  <tr class="multiline">
                    <td>Activity Description</td>
                    <td>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language top"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        >
                        <span class="description">{{
                          narrative.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
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
                  <td>Administrative</td>
                  <td>
                    <div class="flex">
                      <div>
                        <span v-if="item.vocabulary"
                          >Vocabulary -
                          {{ types.geographicVocabulary[item.vocabulary] }}
                        </span>
                        <span v-else class="italic"
                          >(Vocabulary Not Available)</span
                        >
                      </div>
                      <div>
                        <span v-if="item.code">, code {{ item.code }}</span>
                        <span v-else class="ml-1 italic"> (Not Available)</span>
                      </div>
                      <div>
                        <span v-if="item.level">, level {{ item.level }}</span>
                        <span v-else class="ml-1 italic">
                          (Level Not Available)</span
                        >
                      </div>
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
              <table>
                <tr>
                  <td>Point</td>
                  <td>
                    <div class="flex space-x-1">
                      <div>
                        <span v-if="item.srs_name">({{ item.srs_name }})</span>
                        <span v-else class="italic">
                          (SRS Name Not Available)</span
                        >
                      </div>
                      <div>
                        <span v-if="item.pos[0].latitude">
                          latitude {{ item.pos[0].latitude }},
                        </span>
                        <span v-else class="italic">
                          (Latitude Not Available)</span
                        >
                      </div>
                      <div>
                        <span v-if="item.pos[0].longitude"
                          >longitude {{ item.pos[0].longitude }}</span
                        >
                        <span v-else class="italic">
                          (Longitude Not Available)</span
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.exactness"
              :key="i"
              :class="{ 'mb-4': i !== post.exactness.length - 1 }"
            >
              <table class="flex flex-col">
                <tr>
                  <td>Exactness</td>
                  <td>
                    <span v-if="item.code">{{
                      types.geographicExactness[item.code]
                    }}</span>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.location_class"
              :key="i"
              :class="{ 'mb-4': i !== post.location_class.length - 1 }"
            >
              <table class="flex flex-col">
                <tr>
                  <td>Location Class</td>
                  <td>
                    <span v-if="item.code">{{
                      types.geographicLocationClass[item.code]
                    }}</span>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
              </table>
            </div>

            <div
              v-for="(item, i) in post.feature_designation"
              :key="i"
              :class="{ 'mb-4': i !== post.feature_designation.length - 1 }"
            >
              <table class="flex flex-col">
                <tr>
                  <td>Feature Designation</td>
                  <td>
                    <span v-if="item.code">{{
                      types.locationType[item.code]
                    }}</span>
                    <span v-else class="italic">Not Available</span>
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
          <div class="category">
            <span v-if="post.planned_disbursement_type">{{
              types.budgetType[post.planned_disbursement_type]
            }}</span>
            <span v-else class="italic">Type Not Available</span>
          </div>

          <div
            v-for="(item, i) in post.value"
            :key="i"
            :class="{ 'mb-0': i !== post.value.length - 1 }"
          >
            <div class="text-sm">
              <div v-if="item.amount" class="value">
                <span>{{ item.amount }}</span>
                <span>{{ types.currency[item.currency] }}</span>
                <span v-if="item.value_date"
                  >({{ formatDate(item.value_date) }})</span
                >
              </div>
              <span v-else class="italic">Value Not Available</span>
            </div>
          </div>
          <div class="ml-5">
            <div
              v-for="(item, i) in post.period_start"
              :key="i"
              :class="{ 'mb-0': i !== post.period_start.length - 1 }"
            >
              <table class="flex flex-col">
                <tr>
                  <td>Period Start</td>
                  <td>
                    <span v-if="item.iso_date">{{
                      formatDate(item.iso_date)
                    }}</span>
                    <span v-else class="italic">Date Not Available</span>
                  </td>
                </tr>
              </table>
            </div>
            <div
              v-for="(item, i) in post.period_end"
              :key="i"
              :class="{ 'mb-0': i !== post.period_end.length - 1 }"
            >
              <table class="mb-4 flex flex-col">
                <tr>
                  <td>Period End</td>
                  <td>
                    <span v-if="item.iso_date">{{
                      formatDate(item.iso_date)
                    }}</span>
                    <span v-else class="italic">Date Not Available</span>
                  </td>
                </tr>
              </table>
            </div>
          </div>
          <div
            v-for="(item, i) in post.provider_org"
            :key="i"
            class="mb-3"
            :class="{ 'mb-0': i !== post.provider_org.length - 1 }"
          >
            <div class="category">
              <span v-if="item.type">{{
                types.organizationType[item.type]
              }}</span>
              <span v-else class="italic">Type Not Available</span>
            </div>
            <div class="ml-5">
              <table>
                <tr>
                  <td>Provider Org</td>
                  <td>
                    <div class="value">
                      <div>
                        <span v-if="item.provider_activity_id"
                          >Provider Activity Id -
                          {{ item.provider_activity_id }}</span
                        >
                        <span v-else class="italic"
                          >Provider Activity Id Not Available</span
                        >
                      </div>
                      <div>
                        <span v-if="item.ref"
                          >(Reference - {{ item.ref }})</span
                        >
                        <span v-else class="italic"
                          >(Reference Not Available)</span
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
              <div
                v-for="(narrative, j) in item.narrative"
                :key="j"
                :class="{ 'mb-0': j !== item.narrative.length - 1 }"
              >
                <table class="flex flex-col">
                  <tr class="multiline">
                    <td>Narrative</td>
                    <td>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        >
                        <span class="description">{{
                          narrative.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div
            v-for="(item, i) in post.receiver_org"
            :key="i"
            :class="{ 'mb-0': i !== post.receiver_org.length - 1 }"
          >
            <div class="category">
              <span v-if="item.type">{{
                types.organizationType[item.type]
              }}</span>
              <span v-else class="italic">Not Available</span>
            </div>
            <div class="ml-5">
              <table>
                <tr>
                  <td>Receiver Org</td>
                  <td>
                    <div class="value">
                      <div>
                        <span v-if="item.provider_activity_id"
                          >Provider Activity Id -
                          {{ item.provider_activity_id }}</span
                        >
                        <span v-else class="italic"
                          >Provider Activity Id Not Available</span
                        >
                      </div>
                      <div>
                        <span v-if="item.ref"
                          >(Reference - {{ item.ref }})</span
                        >
                        <span v-else class="italic"
                          >(Reference Not Available)</span
                        >
                      </div>
                    </div>
                  </td>
                </tr>
              </table>
              <div
                v-for="(narrative, j) in item.narrative"
                :key="j"
                :class="{ 'mb-0': j !== item.narrative.length - 1 }"
              >
                <table>
                  <tr class="multiline">
                    <td>Narrative</td>
                    <td>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        >
                        <span class="description">{{
                          narrative.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
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
          <div class="category">
            <span v-if="post.organization_role">{{
              types.organisationRole[post.organization_role]
            }}</span>
            <span v-else class="italic">Organization Role Not Available</span>
          </div>

          <div
            v-for="(item, i) in post.narrative"
            :key="i"
            :class="{ 'mb-4': i !== post.narrative.length - 1 }"
          >
            <div class="text-sm">
              <span v-if="item.narrative">{{ item.narrative }}</span>
              <span v-else class="italic">Narrative Not Available</span>
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
                <td>Organisation Name</td>
                <td>
                  <div v-if="narrative.narrative" class="flex flex-col">
                    <span v-if="narrative.language" class="language top"
                      >(Language:
                      {{ types.languages[narrative.language] }})</span
                    >
                    <span v-if="narrative.narrative" class="description">{{
                      narrative.narrative
                    }}</span>
                  </div>
                  <span v-else class="italic">Not Available</span>
                </td>
              </tr>
              <tr>
                <td>Organisation Id</td>
                <td v-if="post.organization">{{ post.organization }}</td>
                <td v-else class="italic">Not Available</td>
              </tr>
              <tr>
                <td>Organisation Type</td>
                <td v-if="post.type">
                  {{ types.organizationType[post.type] }}
                </td>
                <td v-else class="italic">Not Available</td>
              </tr>
              <tr>
                <td>Organisation Role</td>
                <td v-if="post.organization_role">
                  {{ types.organisationRole[post.organization_role] }}
                </td>
                <td v-else class="italic">Not Available</td>
              </tr>
              <tr>
                <td>Ref</td>
                <td v-if="post.ref">
                  {{ types.humanitarianScopeType[post.ref] }}
                </td>
                <td v-else class="italic">Not Available</td>
              </tr>
              <tr>
                <td>Activity Id</td>
                <td>
                  <div>
                    <span v-if="post.identifier">{{ post.identifier }}</span>
                    <span v-else class="italic">Not Available</span>
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
          <div>
            <div v-if="post.url" class="max-w-[887px] text-sm">
              <a href="#">{{ post.url }}</a>
            </div>
            <span v-else class="italic">URL Not Available</span>
          </div>
          <div class="ml-5">
            <div>
              <div v-for="(language, i) in post.language" :key="i">
                <table>
                  <tr>
                    <td>Language</td>
                    <td>
                      <span v-if="language.code">{{
                        types.languages[language.code]
                      }}</span>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
              <div v-for="(document_date, i) in post.document_date" :key="i">
                <table>
                  <tr>
                    <td>Date</td>
                    <td>
                      <span v-if="document_date.date">{{
                        formatDate(document_date.date)
                      }}</span>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div v-for="(title, i) in post.title" :key="i">
              <div
                v-for="(narrative, j) in title.narrative"
                :key="j"
                class="mb-1 flex items-center space-x-1"
              >
                <table>
                  <tr class="multiline">
                    <td>Title</td>
                    <td>
                      <span v-if="narrative.language" class="language">
                        ({{ types.languages[narrative.language] }})
                      </span>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span>
                          {{ narrative.narrative }}
                        </span>
                      </div>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div v-for="(category, i) in post.category" :key="i">
              <table>
                <tr>
                  <td>Category</td>
                  <td>
                    <span v-if="category.code">{{
                      types.documentCategory[category.code]
                    }}</span>
                    <span v-else class="italic">Not Available</span>
                  </td>
                </tr>
              </table>
            </div>
            <table>
              <tr>
                <td>Format</td>
                <td v-if="post.format">{{ post.format }}</td>
                <td v-else class="italic">Not Available</td>
              </tr>
            </table>
            <div v-for="(description, i) in post.description" :key="i">
              <div v-for="(narrative, j) in description.narrative" :key="j">
                <table>
                  <tr class="multiline">
                    <td>Description</td>
                    <td>
                      <div v-if="narrative.narrative" class="flex flex-col">
                        <span v-if="narrative.language" class="language"
                          >(Language:
                          {{ types.languages[narrative.language] }})</span
                        >
                        <span class="description">{{
                          narrative.narrative
                        }}</span>
                      </div>
                      <span v-else class="italic">Not Available</span>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </template>

      <template v-else>
        <div class="content text-sm">
          <template v-if="title === 'activity_status'">
            <span v-if="data.content">{{
              props.types.activityStatus[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <template v-else-if="title === 'activity_scope'">
            <span v-if="data.content">{{
              props.types.activityScope[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <template v-else-if="title === 'collaboration_type'">
            <span v-if="data.content">{{
              props.types.collaborationType[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <template v-else-if="title === 'default_flow_type'">
            <span v-if="data.content">{{
              props.types.flowType[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <template v-else-if="title === 'default_tied_status'">
            <span v-if="data.content">{{
              props.types.tiedStatus[data.content]
            }}</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <template v-else-if="title === 'capital_spend'">
            <span v-if="data.content">{{ data.content.toString() }}%</span>
            <span v-else class="italic">Not Available</span>
          </template>

          <template v-else-if="title === 'default_finance_type'">
            <span v-if="data.content">
              {{ props.types.financeType[data.content] }}</span
            >
            <span v-else class="italic">Not Available</span>
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
import moment from 'moment';

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
      default: 'full',
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

    function formatDate(date: Date) {
      return moment(date).format('LL');
    }

    return { layout, status, props, formatDate };
  },
});
</script>
