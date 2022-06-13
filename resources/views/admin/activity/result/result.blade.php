@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="result-form-layout mb-20">
            <div class="pt-4 pb-6 max-w-[1000px] mx-auto">

                <div class="page-title mb-6">
                    <div class="flex items-end gap-4">
                        <div class="title grow-0">
                            <div class="mb-4 text-caption-c1 text-n-40">
                                <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
                                    <p>
                                        <a href="/activities" class="font-bold">
                                            Your Activities
                                        </a>
                                        <span class="separator mx-4"> / </span>
                                        <span class="last text-n-30">
                                            <a href="/activities/1">Activity Name</a>
                                        </span>
                                        <span class="separator mx-4"> / </span>
                                        <span class="last text-n-30">
                                            Add Result
                                        </span>
                                    </p>
                                </nav>
                            </div>
                            <div class="inline-flex items-center">
                                <a class="mr-3" href="/activities/1">
                                    <svg-vue icon="arrow-short-left"></svg-vue>
                                </a>
                                <h4 class="mr-4 font-bold">Result</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <div class="rounded-lg py-[6.06%] px-[12%] bg-white">


                        <form method="POST" action="" accept-charset="UTF-8">
                            <div class="title mb-14">
                                <div class="title flex items-center mb-4">
                                    <div class="text-sm shrink-0 uppercase text-n-40 font-bold">Title</div>
                                    <div class="line grow h-px border-b border-n-40 ml-4"></div>
                                </div>
                                <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
                                    <label for="description"
                                           class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                        Title
                                    </label>
                                    <div class="multi-form relative">
                                        <div class="form-field basis-6/12 max-w-half attribute">
                                            <div class="form-field-label">
                                                <label for="">
                                                    narrative
                                                    <span class="text-salmon-40"> *</span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" placeholder="Type narrative here" value="">
                                            </div>
                                        </div>
                                        <div class="form-field basis-6/12 max-w-half attribute">
                                            <div class="form-field-label">
                                                <label for="">@xml:lang<span
                                                        class="text-salmon-40"> *</span></label>
                                            </div>
                                            <div>
                                                <select class="" required="" id="" name="" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option value="">Select language</option>
                                                    <option value="1">EN</option>
                                                    <option value="2">FR</option>
                                                    <option value="3">ES</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="add_to_parent add_more button relative text-xs font-bold text-spring-50 text-bluecoral uppercase leading-normal -translate-y-1/2 pl-3.5"
                                    type="button" icon="">
                                    <span class="mr-1.5 text-lg">
                                        <svg-vue icon="add-more"></svg-vue>
                                    </span>
                                    ADD NARRATIVE IN OTHER LANGUAGE
                                </button>
                            </div>

                            <div class="description mb-14">
                                <div class="title flex items-center mb-4">
                                    <div class="text-sm shrink-0 uppercase text-n-40 font-bold">Description</div>
                                    <div class="line grow h-px border-b border-n-40 ml-4"></div>
                                </div>
                                <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
                                    <label for="description"
                                           class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                        description
                                    </label>
                                    <div class="multi-form relative">
                                        <div class="form-field basis-6/12 max-w-half attribute">
                                            <div class="form-field-label">
                                                <label for="">
                                                    narrative
                                                    <span class="text-salmon-40"> *</span>
                                                </label>
                                            </div>
                                            <div>
                                                <input type="text" placeholder="Type narrative here" value="">
                                            </div>
                                        </div>
                                        <div class="form-field basis-6/12 max-w-half attribute">
                                            <div class="form-field-label">
                                                <label for="">@xml:lang<span
                                                        class="text-salmon-40"> *</span></label>
                                            </div>
                                            <div>
                                                <select class="" required="" id="" name="" tabindex="-1"
                                                        aria-hidden="true">
                                                    <option value="">Select language</option>
                                                    <option value="1">EN</option>
                                                    <option value="2">FR</option>
                                                    <option value="3">ES</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="add_to_parent add_more button relative text-xs font-bold text-spring-50 text-bluecoral uppercase leading-normal -translate-y-1/2 pl-3.5"
                                    type="button" icon="">
                                    <span class="mr-1.5 text-lg">
{{--                                        <svg-vue icon="add-more"></svg-vue>--}}
                                        <svg-vue icon="add-more"></svg-vue>
                                    </span>
                                    ADD NARRATIVE IN OTHER LANGUAGE
                                </button>
                            </div>

                            <div class="document_link mb-14">
                                <div class="title flex items-center mb-4">
                                    <div class="text-sm shrink-0 uppercase text-n-40 font-bold">DOCUMENT LINK</div>
                                    <div class="line grow h-px border-b border-n-40 ml-4"></div>
                                </div>
                                <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
                                    <label for="description"
                                           class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                        document Link
                                    </label>
                                    <div class="multi-form relative">
                                        <div
                                            class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6 attribute-wrapper">
                                            <div class="form-field basis-6/12 max-w-half">
                                                <div class="form-field-label">
                                                    <label for="">
                                                        narrative
                                                        <span class="text-salmon-40"> *</span>
                                                    </label>
                                                </div>
                                                <div>
                                                    <input type="text" placeholder="Type narrative here" value="">
                                                </div>
                                            </div>
                                            <div class="form-field basis-6/12 max-w-half">
                                                <div class="form-field-label">
                                                    <label for="">@xml:lang<span
                                                            class="text-salmon-40"> *</span></label>
                                                </div>
                                                <div>
                                                    <select class="" required="" id="" name="" tabindex="-1"
                                                            aria-hidden="true">
                                                        <option value="">Select language</option>
                                                        <option value="1">EN</option>
                                                        <option value="2">FR</option>
                                                        <option value="3">ES</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- title --}}
                                        <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
                                            <label for="description"
                                                   class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                                title
                                            </label>
                                            <div
                                                class="form-field-group form-child-body flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6">
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">
                                                            narrative
                                                            <span class="text-salmon-40"> *</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="text" placeholder="Type narrative here"
                                                               value="">
                                                    </div>
                                                </div>
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">@xml:lang<span
                                                                class="text-salmon-40"> *</span></label>
                                                    </div>
                                                    <div>
                                                        <select class="" required="" id="" name="" tabindex="-1"
                                                                aria-hidden="true">
                                                            <option value="">Select language</option>
                                                            <option value="1">EN</option>
                                                            <option value="2">FR</option>
                                                            <option value="3">ES</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="add_to_collection add_more button relative ml-6 -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral"
                                            type="button">
                                            <span class="mr-1.5 text-lg">
                                                {{-- <svg-vue icon="add-more"></svg-vue>--}}
                                                <svg-vue icon="add-more"></svg-vue>
                                            </span>
                                            ADD NARRATIVE IN OTHER LANGUAGE
                                        </button>

                                        {{-- description --}}
                                        <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
                                            <label for="description"
                                                   class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                                description
                                            </label>
                                            <div
                                                class="form-field-group form-child-body flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6">
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">
                                                            narrative
                                                            <span class="text-salmon-40"> *</span>
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="text" placeholder="Type narrative here"
                                                               value="">
                                                    </div>
                                                </div>
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">@xml:lang<span
                                                                class="text-salmon-40"> *</span></label>
                                                    </div>
                                                    <div>
                                                        <select class="" required="" id="" name="" tabindex="-1"
                                                                aria-hidden="true">
                                                            <option value="">Select language</option>
                                                            <option value="1">EN</option>
                                                            <option value="2">FR</option>
                                                            <option value="3">ES</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="add_to_collection add_more button relative ml-6 -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral"
                                            type="button">
                                            <span class="mr-1.5 text-lg">
                                                <svg-vue icon="add-more"></svg-vue>
                                            </span>
                                            ADD NARRATIVE IN OTHER LANGUAGE
                                        </button>

                                        {{-- category --}}
                                        <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
                                            <label for="description"
                                                   class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                                language
                                            </label>
                                            <div
                                                class="form-field-group form-child-body flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6">
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">
                                                            @code
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="text" placeholder="Type code here" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="add_to_collection add_more button relative ml-6 -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral"
                                            type="button">
                                            <span class="mr-1.5 text-lg">
                                                <svg-vue icon="add-more"></svg-vue>
                                            </span>
                                            ADD MORE CATEGORY
                                        </button>

                                        {{-- language --}}
                                        <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
                                            <label for="description"
                                                   class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                                language
                                            </label>
                                            <div
                                                class="form-field-group form-child-body flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6">
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">
                                                            @code
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="text" placeholder="Type code here" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="add_to_collection add_more button relative ml-6 -translate-y-1/2 pl-3.5 text-xs font-bold uppercase leading-normal text-spring-50 text-bluecoral"
                                            type="button">
                                            <span class="mr-1.5 text-lg">
                                                <svg-vue icon="add-more"></svg-vue>
                                            </span>
                                            ADD NARRATIVE IN OTHER LANGUAGE
                                        </button>

                                        {{-- document-date --}}
                                        <div class="subelement rounded-tl-lg border-l border-spring-50">
                                            <label for="description"
                                                   class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                                document-date
                                            </label>
                                            <div
                                                class="form-field-group form-child-body flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6">
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">
                                                            @iso-date
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="text" placeholder="Type code here" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="add_to_parent add_more button relative text-xs font-bold text-spring-50 text-bluecoral uppercase leading-normal -translate-y-1/2 pl-3.5"
                                    type="button">
                                    <span class="mr-1.5 text-lg">
                                        <svg-vue icon="add-more"></svg-vue>
                                    </span>
                                    ADD MORE DOCUMENT LINK
                                </button>
                            </div>

                            <div class="reference">
                                <div class="title flex items-center mb-4">
                                    <div class="text-sm shrink-0 uppercase text-n-40 font-bold">Reference</div>
                                    <div class="line grow h-px border-b border-n-40 ml-4"></div>
                                </div>
                                <div class="subelement rounded-tl-lg border-l border-spring-50 pb-11">
                                    <label for="description"
                                           class="flex control-label py-4 px-6 font-bold text-sm leading-relaxed rounded-tl-lg rounded-tr-lg border-spring-50 border-t border-r">
                                        reference
                                    </label>
                                    <div class="multi-form relative">
                                        <div
                                            class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 p-6 attribute-wrapper">
                                            <div class="form-field basis-6/12 max-w-half">
                                                <div class="form-field-label">
                                                    <label for="">
                                                        @code
                                                    </label>
                                                </div>
                                                <div>
                                                    <input type="text" placeholder="Type narrative here" value="">
                                                </div>
                                            </div>
                                            <div class="form-field basis-6/12 max-w-half">
                                                <div class="form-field-label">
                                                    <label for="">
                                                        @vocabulary
                                                    </label>
                                                </div>
                                                <div>
                                                    <select class="" required="" id="" name="" tabindex="-1"
                                                            aria-hidden="true">
                                                        <option value="">Type @provider-activity-id here</option>
                                                        <option value="1">EN</option>
                                                        <option value="2">FR</option>
                                                        <option value="3">ES</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-field basis-6/12 max-w-half">
                                                <div class="form-field-label">
                                                    <label for="">
                                                        @vocabulary-uri
                                                        <span class="text-salmon-40"> *</span>
                                                    </label>
                                                </div>
                                                <div>
                                                    <select class="" required="" id="" name="" tabindex="-1"
                                                            aria-hidden="true">
                                                        <option value="">Type @provider-activity-id here</option>
                                                        <option value="1">EN</option>
                                                        <option value="2">FR</option>
                                                        <option value="3">ES</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button
                                    class="add_to_parent add_more button relative text-xs font-bold text-spring-50 text-bluecoral uppercase leading-normal -translate-y-1/2 pl-3.5"
                                    type="button">
                                    <span class="mr-1.5 text-lg">
                                        <svg-vue icon="add-more"></svg-vue>
                                    </span>
                                    ADD MORE REFERENCE
                                </button>
                            </div>

                            <div
                                class="fixed left-0 bottom-0 w-full bg-eggshell py-5 shadow-dropdown z-50">
                                <div class="flex max-w-[1000px] mx-auto items-center">
                                    <div class="grow text-xs text-n-40">
                                        Note: After this step you will have to add indicactor.
                                    </div>
                                    <div class="flex items-center justify-end shrink-0">
                                        <button type="clear" class="ghost-btn mr-8">Cancel</button>
                                        <button type="submit" class="primary-btn save-btn">Save AND EXIT</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
