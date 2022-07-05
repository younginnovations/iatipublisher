<template>
  <div class="bg-paper px-10 pt-4 pb-[71px]">
    <div class="page-title mb-6">
      <div class="flex items-end gap-4">
        <div class="title grow-0">
          <div class="mb-4 text-caption-c1 text-n-40">
            <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
              <p>
                <a href="/activities" class="font-bold"> Your Activities </a>
                <span class="separator mx-4"> / </span>
                <span class="text-n-30">
                  <a href="/activities/1">Activity Name</a>
                </span>
                <span class="separator mx-4"> / </span>
                <span class="text-n-30"> Add Result </span>
                <span class="separator mx-4"> / </span>
                <span class="last text-n-30"> Result Detail </span>
              </p>
            </nav>
          </div>
          <div class="inline-flex items-center">
            <div class="mr-3">
              <a href="/activities">
                <svg-vue icon="arrow-short-left"></svg-vue>
              </a>
            </div>
            <h4 class="mr-4 font-bold">Result detail</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="activities">
      <aside class="activities__sidebar">
        <div class="indicator rounded-lg bg-eggshell px-6 py-4 text-n-50">
          <ul class="text-sm font-bold leading-relaxed">
            <li>
              <a href="#" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                title
              </a>
            </li>
            <li>
              <a href="#" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                description
              </a>
            </li>
            <li>
              <a href="#" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                document-link
              </a>
            </li>
            <li>
              <a href="#" :class="linkClasses">
                <svg-vue icon="moon" class="mr-2 text-base"></svg-vue>
                reference
              </a>
            </li>
          </ul>
          <button
            class="flex w-full rounded border border-dashed border-n-40 bg-white p-2 text-sm font-bold leading-relaxed"
          >
            <svg-vue icon="add" class="mr-2 text-n-40"></svg-vue>
            add indicator
          </button>
        </div>
      </aside>
      <div class="activities__content">
        <div class="activities__content--elements -mx-3 -mt-3 flex flex-wrap">
          <!-- title -->
          <div
            class="activities__content--element basis-full px-3 py-3 text-n-50"
            id=""
          >
            <div class="rounded-lg bg-white p-4">
              <div class="mb-4 flex">
                <div class="title flex grow">
                  <div class="title text-sm font-bold">title</div>
                  <div
                    class="status ml-2.5 flex text-xs leading-5 text-spring-50"
                  >
                    <b class="mr-2 text-base leading-3">.</b
                    ><span>completed</span>
                  </div>
                </div>
                <div class="icons flex items-center">
                  <a
                    href="/activities/1/title"
                    class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
                    <span>Edit</span>
                  </a>
                  <svg-vue class="mr-1.5" icon="core"></svg-vue>
                  <div class="help text-n-40">
                    <button>
                      <svg-vue icon="help"></svg-vue>
                    </button>
                    <div class="help__text right-0 w-60">
                      <span class="font-bold text-bluecoral"></span>
                      <p>Example text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider mb-4 h-px w-full bg-n-20"></div>
              <div class="title-content">
                <div class="language mb-1.5">(Language: English)</div>
                <div class="description text-sm">
                  Partnership Against Child Exploitation
                </div>
                <div class="mb-4"></div>
              </div>
              <div class="title-content">
                <div class="language mb-1.5">(Language: French)</div>
                <div class="description text-sm">
                  Partenariat contre l'exploitation des enfants
                </div>
                <div class="mb-4"></div>
              </div>
              <div class="title-content">
                <div class="language mb-1.5">(Language: Nepali)</div>
                <div class="description text-sm">बाल शोषण विरुद्ध साझेदारी</div>
                <div class="mb-4"></div>
              </div>
              <div class="title-content">
                <div class="language mb-1.5">(Language: German)</div>
                <div class="description text-sm">
                  Partnerschaft gegen Kinderausbeutung
                </div>
              </div>
            </div>
          </div>

          <!-- description -->
          <div
            class="activities__content--element basis-full px-3 py-3 text-n-50"
            id="basic_activity_information"
          >
            <div class="rounded-lg bg-white p-4">
              <div class="mb-4 flex">
                <div class="title flex grow">
                  <div class="title text-sm font-bold">description</div>
                  <div
                    class="status ml-2.5 flex text-xs leading-5 text-crimson-50"
                  >
                    <b class="mr-2 text-base leading-3">.</b
                    ><span>not completed</span>
                  </div>
                </div>
                <div class="icons flex items-center">
                  <a
                    href="/activities/1/description"
                    class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
                  >
                    <span>Edit</span>
                  </a>
                  <svg-vue class="mr-1.5" icon="core"></svg-vue>
                  <div class="help text-n-40">
                    <button>
                      <svg-vue icon="help"></svg-vue>
                    </button>
                    <div class="help__text right-0 w-60">
                      <span class="font-bold text-bluecoral"></span>
                      <p>Example text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider mb-4 h-px w-full bg-n-20"></div>
              <div class="description-content mb-4">
                <div class="language mb-1.5">(Language: English)</div>
                <div class="description text-sm">
                  This programme will bring change for boys and girls to enjoy
                  their rights to be protected from the worst forms of child
                  labour in Central African Republic, the Democratic Republic of
                  the Congo (DRC) and Ethiopia.
                </div>
              </div>
              <div class="description-content mb-4">
                <div class="language mb-1.5">(Language: Nepali)</div>
                <div class="description text-sm">
                  यो कार्यक्रमले केटा र केटीहरूलाई मध्य अफ्रिकी गणतन्त्र, कङ्गो
                  प्रजातान्त्रिक गणतन्त्र (DRC) र इथियोपियामा बाल श्रमका
                  सबैभन्दा खराब प्रकारहरूबाट सुरक्षित गर्नको लागि उनीहरूको
                  अधिकारको आनन्द लिनको लागि परिवर्तन ल्याउनेछ।
                </div>
              </div>
            </div>
          </div>

          <!-- aggregation status -->
          <div
            class="activities__content--element basis-6/12 px-3 py-3 text-n-50"
            id=""
          >
            <div class="rounded-lg bg-white p-4">
              <div class="mb-4 flex">
                <div class="title flex grow">
                  <div class="title text-sm font-bold">aggregation status</div>
                  <div
                    class="status ml-2.5 flex text-xs leading-5 text-spring-50"
                  >
                    <b class="mr-2 text-base leading-3">.</b
                    ><span>completed</span>
                  </div>
                </div>
                <div class="icons flex items-center">
                  <a
                    href="/activities/1/title"
                    class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
                    <span>Edit</span>
                  </a>
                  <svg-vue class="mr-1.5" icon="core"></svg-vue>
                  <svg-vue class="mr-1.5" icon="star"></svg-vue>
                  <div class="help text-n-40">
                    <button>
                      <svg-vue icon="help"></svg-vue>
                    </button>
                    <div class="help__text right-0 w-60">
                      <span class="font-bold text-bluecoral"></span>
                      <p>Example text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider mb-4 h-px w-full bg-n-20"></div>
              <div class="content">
                <div class="description text-sm">False</div>
              </div>
            </div>
          </div>

          <!-- Document Link -->
          <div
            class="activities__content--element basis-full px-3 py-3 text-n-50"
            id=""
          >
            <div class="rounded-lg bg-white p-4">
              <div class="mb-4 flex">
                <div class="title flex grow">
                  <div class="title text-sm font-bold">document link</div>
                  <div
                    class="status ml-2.5 flex text-xs leading-5 text-spring-50"
                  >
                    <b class="mr-2 text-base leading-3">.</b
                    ><span>completed</span>
                  </div>
                </div>
                <div class="icons flex items-center">
                  <a
                    href="/activities/1/title"
                    class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
                    <span>Edit</span>
                  </a>
                  <svg-vue class="mr-1.5" icon="core"></svg-vue>
                  <svg-vue class="mr-1.5" icon="star"></svg-vue>
                  <div class="help text-n-40">
                    <button>
                      <svg-vue icon="help"></svg-vue>
                    </button>
                    <div class="help__text right-0 w-60">
                      <span class="font-bold text-bluecoral"></span>
                      <p>Example text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider mb-4 h-px w-full bg-n-20"></div>
              <div class="documents">
                <!-- loop starts here -->
                <div class="item elements-detail">
                  <div class="category flex">Document link title</div>
                  <div class="ml-4">
                    <table class="mb-3">
                      <!-- title -->
                      <tr>
                        <td>Title</td>
                        <td>
                          <div class="title-content mb-1.5">
                            <div class="language mb-1">(Language: English)</div>
                            <div class="description text-xs">
                              Document link title
                            </div>
                          </div>
                          <div class="title-content">
                            <div class="language mb-1">(Language: Nepali)</div>
                            <div class="description text-xs">
                              Document link title
                            </div>
                          </div>
                        </td>
                      </tr>
                      <!-- document link -->
                      <tr>
                        <td>Document Link</td>
                        <td><a href="#">iatipublisher.org</a></td>
                      </tr>
                      <!-- Aggregation Status -->
                      <tr>
                        <td>Aggregation Status</td>
                        <td>False</td>
                      </tr>
                      <!-- Description -->
                      <tr>
                        <td>Description</td>
                        <td>
                          <!-- loop -->
                          <div class="description-content mb-1.5">
                            <div class="language mb-1">(Language: English)</div>
                            <div class="description text-xs">
                              This programme will bring change for boys and
                              girls to enjoy their rights to be protected from
                              the worst forms of child labour in Central African
                              Republic, the Democratic Republic of the Congo
                              (DRC) and Ethiopia.
                            </div>
                          </div>
                          <!-- loop -->
                          <div class="description-content">
                            <div class="language mb-1">(Language: Nepali)</div>
                            <div class="description text-xs">
                              This programme will bring change for boys and
                              girls to enjoy their rights to be protected from
                              the worst forms of child labour in Central African
                              Republic, the Democratic Republic of the Congo
                              (DRC) and Ethiopia.
                            </div>
                          </div>
                        </td>
                      </tr>
                      <!-- Category -->
                      <tr>
                        <td>Category</td>
                        <td>
                          <div class="description mb-1 text-xs">
                            A01 - Pre- and post-project impact appraisal
                          </div>
                          <div class="description text-xs">
                            A01 - Pre- and post-project impact appraisal
                          </div>
                        </td>
                      </tr>
                      <!-- Language -->
                      <tr>
                        <td>Language</td>
                        <td>
                          <div class="text-xs">English, Nepali</div>
                        </td>
                      </tr>
                      <!-- Document Date -->
                      <tr>
                        <td>Document Date</td>
                        <td>
                          <div class="text-xs">November 20,2022</div>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- reference -->
          <div
            class="activities__content--element basis-6/12 px-3 py-3 text-n-50"
            id=""
          >
            <div class="rounded-lg bg-white p-4">
              <div class="mb-4 flex">
                <div class="title flex grow">
                  <div class="title text-sm font-bold">reference</div>
                  <div
                    class="status ml-2.5 flex text-xs leading-5 text-spring-50"
                  >
                    <b class="mr-2 text-base leading-3">.</b
                    ><span>completed</span>
                  </div>
                </div>
                <div class="icons flex items-center">
                  <a
                    href="/activities/1/title"
                    class="edit-button mr-2.5 flex items-center text-tiny font-bold uppercase"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="edit"></svg-vue>
                    <span>Edit</span>
                  </a>
                  <svg-vue class="mr-1.5" icon="core"></svg-vue>
                  <svg-vue class="mr-1.5" icon="star"></svg-vue>
                  <div class="help text-n-40">
                    <button>
                      <svg-vue icon="help"></svg-vue>
                    </button>
                    <div class="help__text right-0 w-60">
                      <span class="font-bold text-bluecoral"></span>
                      <p>Example text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider mb-4 h-px w-full bg-n-20"></div>
              <div class="references">
                <!-- loop item -->
                <div class="item elements-detail mb-4">
                  <div class="category flex">99 - reporting organisation</div>
                  <div class="ml-4">
                    <table class="mb-3">
                      <tbody>
                        <tr>
                          <td>Code</td>
                          <td>Code-reference</td>
                        </tr>
                        <tr>
                          <td>Indicator URI</td>
                          <td><a href="#">iatipublisher.org</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="item elements-detail mb-4">
                  <div class="category flex">99 - reporting organisation</div>
                  <div class="ml-4">
                    <table class="mb-3">
                      <tbody>
                        <tr>
                          <td>Code</td>
                          <td>Code-reference</td>
                        </tr>
                        <tr>
                          <td>Indicator URI</td>
                          <td><a href="#">iatipublisher.org</a></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Indicator -->
          <div
            class="activities__content--element basis-full px-3 py-3 text-n-50"
            id=""
          >
            <div class="rounded-lg bg-white p-4">
              <div class="mb-4 flex">
                <div class="title flex grow items-center">
                  <svg-vue
                    class="mr-1.5 text-xl text-bluecoral"
                    icon="bill"
                  ></svg-vue>
                  <div class="title text-sm font-bold">Indicator</div>
                  <div
                    class="status ml-2.5 flex text-xs leading-5 text-crimson-50"
                  >
                    <b class="mr-2 text-base leading-3">.</b>
                    <span>not completed</span>
                  </div>
                </div>
                <div class="icons flex items-center">
                  <a
                    href="#"
                    class="mr-2.5 flex items-center text-tiny font-bold uppercase"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="add"></svg-vue>
                    <span>ADD NEW indicator</span>
                  </a>
                  <svg-vue class="mr-1.5" icon="moon"></svg-vue>
                  <div class="help text-n-40">
                    <button>
                      <svg-vue icon="help"></svg-vue>
                    </button>
                    <div class="help__text right-0 w-60">
                      <span class="font-bold text-bluecoral"></span>
                      <p>Example text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider mb-4 h-px w-full bg-n-20"></div>
              <div class="indicator">
                <!-- loop item -->
                <div class="item">
                  <div class="elements-detail wider">
                    <div class="category flex">
                      <div class="mr-4">
                        1. WHRDs and WROs are resourced, coordinated and
                        resilient.
                      </div>
                      <div class="flex shrink-0 grow justify-between">
                        <a
                          href="#"
                          class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                        >
                          <svg-vue
                            class="mr-0.5 text-base"
                            icon="edit"
                          ></svg-vue>
                          <span>Edit Indicator</span>
                        </a>
                        <a
                          href="#"
                          class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                        >
                          <svg-vue
                            class="mr-0.5 text-base"
                            icon="add"
                          ></svg-vue>
                          <span>Add Period</span>
                        </a>
                      </div>
                    </div>
                    <div class="ml-4">
                      <!-- for indicators -->
                      <table class="mb-3">
                        <tbody>
                          <tr>
                            <td>Indicator Title</td>
                            <td>
                              <div class="title-content mb-1.5">
                                <div class="language mb-1">
                                  (Language: English)
                                </div>
                                <div class="description text-xs">
                                  Indicator title
                                </div>
                              </div>
                              <div class="title-content">
                                <div class="language mb-1">
                                  (Language: English)
                                </div>
                                <div class="description text-xs">
                                  Indicator title
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>Measure</td>
                            <td>1 - Unit</td>
                          </tr>

                          <tr>
                            <td>Aggregation Status</td>
                            <td>False</td>
                          </tr>

                          <tr>
                            <td>Description</td>
                            <td>
                              <div class="title-content mb-1.5">
                                <div class="language mb-1">
                                  (Language: English)
                                </div>
                                <div class="description text-xs">
                                  The indicator measures the number of laws,
                                  policies and strategies blocked, adopted and
                                  improved
                                </div>
                              </div>
                              <div class="title-content mb-1.5">
                                <div class="language mb-1">
                                  (Language: English)
                                </div>
                                <div class="description text-xs">
                                  The indicator measures the number of laws,
                                  policies and strategies blocked, adopted and
                                  improved
                                </div>
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td>Reference</td>
                            <td>
                              Vocabulary: 99 - Reporting Organisation , Code:
                              SCS021, Indicator URI:
                              https://helpdesk-opendata-minbuza.nl/indicator-codelist/
                            </td>
                          </tr>

                          <tr>
                            <td>Baseline</td>
                            <td>
                              <div>
                                Year: 2021, Date: 2021-01-01, Value: 0 <br />
                                Location: Africa, Asia, Latin America and
                                Europe/International<br />
                                Dimension: Not Available (Not Available)<br />
                                Comment: Not Available (Language: English)
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <!-- for periods -->
                      <table>
                        <tbody>
                          <tr>
                            <td>
                              <div class="category">Period 1</div>
                            </td>
                            <td>
                              <div class="category flex">
                                <div class="mr-10">
                                  January 01, 2021 - December 31, 2025
                                </div>
                                <div class="flex shrink-0 grow justify-between">
                                  <a
                                    href="#"
                                    class="flex items-center text-tiny font-bold uppercase text-bluecoral"
                                  >
                                    <svg-vue
                                      class="mr-0.5 text-base"
                                      icon="edit"
                                    ></svg-vue>
                                    <span>Edit Period</span>
                                  </a>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Target Value</td>
                            <td>
                              <div>
                                73 units<br />
                                Location Reference: Not Available<br />
                                Dimension: Not Available<br />
                                Description: Not Available
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td>Actual Value</td>
                            <td>
                              <div>
                                Not Available<br />
                                Location Reference: Not Available<br />
                                Dimension Not Available<br />
                                Description Not Available
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- static design for results -->
          <div
            class="activities__content--element basis-full px-3 py-3 text-n-50"
            id=""
          >
            <small>Note: Results element is for activity detail page.</small>
            <div class="rounded-lg bg-white p-4">
              <div class="mb-4 flex">
                <div class="title flex grow items-center">
                  <svg-vue
                    class="mr-1.5 text-xl text-bluecoral"
                    icon="bill"
                  ></svg-vue>
                  <div class="title text-sm font-bold">Results</div>
                  <div
                    class="status ml-2.5 flex text-xs leading-5 text-crimson-50"
                  >
                    <b class="mr-2 text-base leading-3">.</b>
                    <span>not completed</span>
                  </div>
                </div>
                <div class="icons flex items-center">
                  <a
                    href="/activities/1/result"
                    class="mr-2.5 flex items-center text-tiny font-bold uppercase"
                  >
                    <svg-vue class="mr-0.5 text-base" icon="add"></svg-vue>
                    <span>Add Result</span>
                  </a>
                  <svg-vue class="mr-1.5" icon="core"></svg-vue>
                  <div class="help text-n-40">
                    <button>
                      <svg-vue icon="help"></svg-vue>
                    </button>
                    <div class="help__text right-0 w-60">
                      <span class="font-bold text-bluecoral"></span>
                      <p>Example text</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="divider mb-4 h-px w-full bg-n-20"></div>
              <div class="results">
                <div class="item">
                  <div class="elements-detail">
                    <div>
                      <!-- title -->
                      <div class="category flex">
                        <div class="mr-4">
                          1. WHRDs and WROs are resourced, coordinated and
                          resilient.
                        </div>
                        <div class="flex shrink-0">
                          <a
                            href="#"
                            class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                          >
                            <svg-vue
                              class="mr-0.5 text-base"
                              icon="eye"
                            ></svg-vue>
                            <span>View Result</span>
                          </a>
                          <a
                            href="#"
                            class="flex items-center text-tiny font-bold uppercase"
                          >
                            <svg-vue
                              class="mr-0.5 text-base"
                              icon="edit"
                            ></svg-vue>
                            <span>Edit Result</span>
                          </a>
                        </div>
                      </div>
                      <!-- content -->
                      <div class="ml-4">
                        <table class="mb-3">
                          <tr>
                            <td>Result Type</td>
                            <td>Outcome</td>
                          </tr>
                          <tr>
                            <td>Description</td>
                            <td>
                              <div class="title-content">
                                <div class="language mb-1.5">
                                  (Language: English)
                                </div>
                                <div class="description text-xs">
                                  This programme will bring change for boys and
                                  girls to enjoy their rights to be protected
                                  from the worst forms of child labour in
                                  Central African Republic, the Democratic
                                  Republic of the Congo (DRC) and Ethiopia.
                                </div>
                              </div>
                            </td>
                          </tr>
                        </table>

                        <!-- indicator -->
                        <div
                          class="indicator overflow-hidden rounded-t-lg border border-n-20"
                        >
                          <div
                            class="head flex justify-between bg-n-10 py-2.5 px-6"
                          >
                            <div class="text-xs font-bold text-n-50">
                              Indicator
                            </div>
                            <div>
                              <a
                                href="#"
                                class="flex items-center text-tiny font-bold uppercase"
                              >
                                <svg-vue
                                  class="mr-0.5 text-base"
                                  icon="add"
                                ></svg-vue>
                                <span>Add New Indicator</span>
                              </a>
                            </div>
                          </div>
                          <div class="body">
                            <!-- loop -->
                            <div
                              class="indicator-content flex border-b border-n-20 px-6 py-2"
                            >
                              <div class="content grow">
                                <div class="mb-0.5 flex">
                                  <div class="mr-4 font-bold">
                                    5.1 # of laws, policies and strategies
                                    blocked, adopted and improved
                                  </div>
                                  <div class="flex shrink-0">
                                    <a
                                      href="#"
                                      class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                                    >
                                      <svg-vue
                                        class="mr-0.5 text-base"
                                        icon="edit"
                                      ></svg-vue>
                                      <span>Edit Indicator</span>
                                    </a>
                                  </div>
                                </div>
                                <table>
                                  <tr>
                                    <td>Baseline:</td>
                                    <td>
                                      <div class="mb-1">
                                        <div class="description text-xs">
                                          Value : 100, Date: September 19, 2021,
                                          Year: 2021
                                        </div>
                                      </div>
                                      <div class="">
                                        <div class="description text-xs">
                                          Value : 100, Date: September 19, 2021,
                                          Year: 2021
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              </div>
                              <div class="add_period shrink-0">
                                <a
                                  href="#"
                                  class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                                >
                                  <svg-vue
                                    class="mr-0.5 text-base"
                                    icon="add"
                                  ></svg-vue>
                                  <span>Add Period</span>
                                </a>
                              </div>
                            </div>
                            <div class="indicator-content flex px-6 py-2">
                              <div class="content grow">
                                <div class="mb-0.5 flex">
                                  <div class="mr-4 font-bold">
                                    5.1 # of laws, policies and strategies
                                    blocked, adopted and improved
                                  </div>
                                  <div class="flex shrink-0">
                                    <a
                                      href="#"
                                      class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                                    >
                                      <svg-vue
                                        class="mr-0.5 text-base"
                                        icon="edit"
                                      ></svg-vue>
                                      <span>Edit Indicator</span>
                                    </a>
                                  </div>
                                </div>
                                <table>
                                  <tr>
                                    <td>Baseline:</td>
                                    <td>
                                      <div class="mb-1">
                                        <div class="description text-xs">
                                          Value : 100, Date: September 19, 2021,
                                          Year: 2021
                                        </div>
                                      </div>
                                      <div class="">
                                        <div class="description text-xs">
                                          Value : 100, Date: September 19, 2021,
                                          Year: 2021
                                        </div>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                              </div>
                              <div class="add_period shrink-0">
                                <a
                                  href="#"
                                  class="mr-2.5 flex items-center text-tiny font-bold uppercase text-bluecoral"
                                >
                                  <svg-vue
                                    class="mr-0.5 text-base"
                                    icon="add"
                                  ></svg-vue>
                                  <span>Add Period</span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- indicator button -->
        <button
          class="add_indicator flex w-full rounded border border-dashed border-n-40 bg-white py-6 px-9 text-xs leading-normal"
        >
          <div class="grow text-left">You haven't added any indicator yet.</div>
          <div
            class="flex shrink-0 items-center font-bold uppercase text-bluecoral"
          >
            <svg-vue icon="add" class="mr-1 shrink-0"></svg-vue>
            <span class="grow">Add new indicator</span>
          </div>
        </button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import ActivityElement from './../partials/ActivityElement.vue';

export default defineComponent({
  name: 'result-detail',
  components: {
    ActivityElement,
  },
  props: {},
  setup(props) {
    const linkClasses =
      'flex items-center w-full bg-white rounded p-2 text-sm text-n-50 font-bold leading-relaxed mb-2 shadow-default';

    return {
      linkClasses,
    };
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
  &.wider {
    td:nth-child(1) {
      @apply whitespace-nowrap text-n-40;
      width: 190px;
    }
  }

  td:nth-child(2) {
    @apply flex flex-col text-xs text-n-50;
  }
  tr {
    @apply mb-1 flex space-x-2;
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
