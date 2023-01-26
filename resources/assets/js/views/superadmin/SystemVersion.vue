<template>
  <div class="page-height bg-paper px-5 pt-4 pb-[71px] xl:px-10">
    <div class="title shrink-0 grow-0">
      <div class="mb-2 text-caption-c1 text-n-40 xl:mb-4">
        <nav aria-label="breadcrumbs" class="breadcrumb">
          <p>
            <span class="last font-bold">System Details</span>
          </p>
        </nav>
      </div>
      <div
        class="inline-flex flex-col space-y-2 py-4 md:flex-row md:items-center"
      >
        <h4 class="mr-4 text-3xl font-bold xl:text-heading-4">
          System Details
        </h4>
      </div>
    </div>

    <hr class="my-1" />

    <h4 class="text-header-2 text-bold text-primary my-2">
      System version information
    </h4>
    <div class="iati-list-table my-3">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="sn" scope="col">SN</th>
            <th id="" scope="col">Name</th>
            <th id="" scope="col">Current Version</th>
            <th id="" scope="col">Latest Version</th>
          </tr>
        </thead>
        <tbody v-if="!isEmpty(packageManagerVersion)">
          <tr v-for="(item, key, index) in packageManagerVersion" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ key }}</td>
            <td>{{ item }}</td>
            <td>{{ resolveLatestVersion(latestManagerVersion, key) }}</td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="5" class="text-center">
              System version details not found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <hr class="my-1" />

    <h4 class="text-header-2 text-bold text-primary my-2">
      Current Composer Package Version
    </h4>
    <div class="iati-list-table my-3">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="sn" scope="col">SN</th>
            <th id="" scope="col">Head</th>
            <th id="" scope="col">Current Version</th>
            <th id="" scope="col">Latest Version</th>
            <th id="" scope="col">Update status</th>
          </tr>
        </thead>
        <tbody v-if="!isEmpty(phpDependencies)">
          <tr v-for="(pkg, index) in phpDependencies" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ pkg.name }}</td>
            <td>{{ pkg.version }}</td>
            <td>{{ pkg.latest }}</td>
            <td>
              <div :class="getStatusClass(pkg['latest-status'])">
                <strong>{{ getStatusMessage(pkg['latest-status']) }}</strong>
              </div>
            </td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="5" class="text-center">
              PHP package details not found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <hr class="my-1" />

    <h4 class="text-header-2 text-bold text-primary my-2">
      Current NPM Package Version
    </h4>
    <div class="iati-list-table my-3">
      <table>
        <thead>
          <tr class="bg-n-10">
            <th id="sn" scope="col">SN</th>
            <th id="" scope="col">Name</th>
            <th id="" scope="col">Current Version</th>
            <th id="" scope="col">Latest Version</th>
          </tr>
        </thead>
        <tbody v-if="!isEmpty(nodeDependencies)">
          <tr v-for="(pkg, key, index) in nodeDependencies" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ key }}</td>
            <td>{{ pkg['current'] }}</td>
            <td>{{ pkg['latest'] }}</td>
          </tr>
        </tbody>
        <tbody v-else>
          <tr>
            <td colspan="5" class="text-center">
              NPM package details not found.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';
import { isEmpty } from 'lodash/lang';

defineProps({
  phpDependencies: { type: Object, required: true },
  nodeDependencies: { type: Object, required: true },
  packageManagerVersion: { type: Object, required: true },
  latestManagerVersion: { type: Object, required: true },
});

/* Sets Update status class */
const getStatusClass = (updateStatus) => {
  if (updateStatus == 'semver-safe-update') {
    return 'rounded-full bg-spring-50 border border-spring-50 px-5 py-1 inline-flex items-center space-x-1 text-sm leading-normal text-white';
  }
  return 'rounded-full bg-salmon-50 border border-salmon-50 px-5 py-1 inline-flex items-center space-x-1 text-sm leading-normal text-white';
};

/* Returns Update status */
const getStatusMessage = (updateStatus) => {
  if (updateStatus == 'semver-safe-update') {
    return 'Safe update';
  }
  return 'May break system';
};

/* Returns Latest version of package manager */
const resolveLatestVersion = (latestManagerVersion, key) => {
  if (key in latestManagerVersion) {
    return latestManagerVersion[key];
  } else if (key == 'composer') {
    return '2.1.4';
  }
  return 'NA';
};
</script>
