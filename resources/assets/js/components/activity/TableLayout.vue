<template>
  <div class="table-listing overflow-auto">
    <table class="iati-list-table">
      <thead>
        <tr class="bg-n-10">
          <th scope="col" id="title">
            <a
              href="#"
              class="hover:text-sp50 text-n-50 transition duration-500"
            >
              <span class="sorting-indicator descending text-primary">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 17 16"
                >
                  <g clip-path="url(#a)">
                    <path
                      fill="currentColor"
                      d="M10.624 5.667h-4.67L8.29 3.414l2.335 2.253ZM8.78 2.474a.706.706 0 0 0-.974 0l-3.17 3.06c-.436.413-.132 1.133.483 1.133h6.334c.615 0 .926-.72.49-1.14L8.78 2.474Zm2.68 6.86H5.119c-.615 0-.926.72-.49 1.14l3.17 3.06c.27.26.704.26.974 0l3.17-3.06c.436-.42.132-1.14-.483-1.14Z"
                    />
                  </g>
                  <defs>
                    <clipPath id="a">
                      <path
                        fill="#fff"
                        d="M0 0h16v16.579H0z"
                        transform="rotate(-90 8 8)"
                      />
                    </clipPath>
                  </defs>
                </svg>
              </span>
              <span>Activity Title</span>
            </a>
          </th>
          <th scope="col" id="date">
            <a
              href="#"
              class="hover:text-sp50 text-n-50 transition duration-500"
            >
              <span class="sorting-indicator ascending text-primary">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 17 16"
                >
                  <g clip-path="url(#a)">
                    <path
                      fill="#155366"
                      d="M5.955 10.333h4.67l-2.336 2.253-2.334-2.253Zm1.844 3.194c.27.26.704.26.974 0l3.17-3.06c.436-.414.132-1.134-.483-1.134H5.126c-.615 0-.926.72-.49 1.14l3.163 3.053Zm-2.68-6.86h6.341c.615 0 .926-.72.49-1.14l-3.17-3.06a.706.706 0 0 0-.974 0l-3.17 3.06c-.436.42-.132 1.14.483 1.14Z"
                    />
                  </g>
                  <defs>
                    <clipPath id="a">
                      <path
                        fill="#fff"
                        d="M0 0h16v16.579H0z"
                        transform="rotate(90 8.29 8.29)"
                      />
                    </clipPath>
                  </defs>
                </svg>
              </span>
              <span>Updated On</span>
            </a>
          </th>
          <th scope="col" id="status">
            <span class="hidden">Status</span>
          </th>
          <th scope="col" id="publish">
            <span class="hidden">Status</span>
          </th>
          <th scope="col" id="cb">
            <span class="">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 20"
              >
                <path
                  fill="currentColor"
                  stroke="currentColor"
                  d="M17.167 3.334v-.5h-11v11h11v-10.5ZM8.204 8.75l.463-.466 1.37 1.376.355.357.354-.357 3.92-3.95.463.465-4.737 4.78L8.204 8.75Zm-5.37 7.916v.5H14.5v.667H3.333c-.64 0-1.166-.526-1.166-1.167V5.5h.666v11.167Zm3.833-14.5h10c.64 0 1.166.526 1.166 1.167v10c0 .64-.526 1.166-1.166 1.166h-10c-.64 0-1.167-.526-1.167-1.166v-10c0-.64.526-1.167 1.167-1.167Z"
                /></svg
            ></span>
          </th>
        </tr>
      </thead>
      <tbody>
        <!--      Loop starts here-->

        <!--      ===================================-->
        <!--      First item with "Draft" status-->
        <!--      =======================================-->
        <tr>
          <td class="title">
            <a
              href="#"
              class="hover:text-sp50 text-n-50 transition duration-500"
              >EU-Angola Dialogue Facility</a
            >
          </td>

          <td class="text-n-40">2 days ago</td>

          <td>
            <a
              href="#"
              class="inline-flex items-center text-n-40 transition duration-500 hover:text-spring-50"
            >
              <span class="mr-1 text-base">
                <svg-vue icon="document-write"></svg-vue>
              </span>
              <span class="text-xs leading-5">Draft</span>
            </a>
          </td>

          <td></td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "EU-Angola Dialogue Facility"
            </label>
            <label class="checkbox">
              <input id="" type="checkbox" name="activity[]" value="" />
              <span class="checkmark"></span>
            </label>
          </th>
        </tr>

        <!--      ========================================    -->
        <!--      Second item with "Ready to Publish" button  -->
        <!--      ============================================-->
        <tr>
          <td class="text-n-50">
            <a
              href="#"
              class="hover:text-sp50 text-n-50 transition duration-500"
              >Support Program on Public Finance Management and Financial Sector
              reform</a
            >
          </td>

          <td class="text-n-40">2 days ago</td>

          <td>
            <a
              href="#"
              class="inline-flex items-center text-n-40 transition duration-500 hover:text-spring-50"
            >
              <span class="mr-1 text-base">
                <svg-vue icon="tick"></svg-vue>
              </span>
              <span class="text-xs leading-5">Ready to publish</span>
            </a>
          </td>

          <td>
            <button class="button primary-outline-btn w-20">Publish</button>
          </td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "Support Program on Public Finance Management and Financial
              Sector reform"
            </label>
            <label class="checkbox">
              <input id="" type="checkbox" name="activity[]" value="" />
              <span class="checkmark"></span>
            </label>
          </th>
        </tr>

        <!--      ========================================-->
        <!--        Third item with "Published" Status-->
        <!--      ============================================-->
        <tr>
          <td class="text-n-50">
            <a
              href="#"
              class="hover:text-sp50 text-n-50 transition duration-500"
            >
              UNFPA Angola Improved national population data systems to map and
              address inequalities; to advance the achievement of the
              Sustainable Development Goals and the commitments of the Programme
              of Action of the International Conference on Population and
              Development; and to strengthen interventions in humanitarian
              crises activities
            </a>
          </td>

          <td class="text-n-40">2 days ago</td>

          <td>
            <div
              href="#"
              class="hover:text-sp50 inline-flex items-center text-n-40 transition duration-500"
            >
              <span class="mr-1 text-base text-spring-50">
                <svg-vue icon="tick"></svg-vue>
              </span>
              <span class="text-xs leading-5">Published</span>
            </div>
          </td>

          <td></td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "UNFPA Angola Improved national population data systems to
              map and address inequalities; to advance the achievement of the
              Sustainable Development Goals and the commitments of the Programme
              of Action of the International Conference on Population and
              Development; and to strengthen interventions in humanitarian
              crises activities"
            </label>
            <label class="checkbox">
              <input id="" type="checkbox" name="activity[]" value="" />
              <span class="checkmark"></span>
            </label>
          </th>
        </tr>

        <!--      ========================================-->
        <!--        Fourth item with "Changes made" Status-->
        <!--      ============================================-->
        <tr>
          <td class="text-n-50">
            <a
              href="#"
              class="hover:text-sp50 text-n-50 transition duration-500"
            >
              Programme in support of Higher Education
            </a>
          </td>

          <td class="text-n-40">2 days ago</td>

          <td>
            <div
              href="#"
              class="hover:text-sp50 inline-flex items-center text-n-40 transition duration-500"
            >
              <span class="mr-1 text-base">
                <svg-vue icon="history"></svg-vue>
              </span>
              <span class="text-xs leading-5">Changes made</span>
            </div>
          </td>

          <td>
            <button class="button primary-outline-btn w-20">RePublish</button>
          </td>

          <th class="check-column">
            <label class="sr-only" for="">
              Select "Programme in support of Higher Education"
            </label>
            <label class="checkbox">
              <input id="" type="checkbox" name="activity[]" value="" />
              <span class="checkmark"></span>
            </label>
          </th>
        </tr>

        <!--  Loop ends here  -->
      </tbody>
    </table>
  </div>
</template>
<script>
export default {
  name: 'table-layout',
};
</script>
