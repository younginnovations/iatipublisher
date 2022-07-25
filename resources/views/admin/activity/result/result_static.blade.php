@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        <div class="mb-20 result-form-layout">
            <div class="pt-4 pb-6 max-w-[1000px] mx-auto">

                <div class="mb-6 page-title">
                    <div class="flex items-end gap-4">
                        <div class="title grow-0">
                            <div class="mb-4 text-caption-c1 text-n-40">
                                <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
                                    <p>
                                        <a href="/activities" class="font-bold">
                                            Your Activities
                                        </a>
                                        <span class="mx-4 separator"> / </span>
                                        <span class="last text-n-30">
                                            <a href="/activities/1">Activity Name</a>
                                        </span>
                                        <span class="mx-4 separator"> / </span>
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
                                <h4 class="mr-4 font-bold">Static Result Page</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <div class="rounded-lg py-[6.06%] px-[12%] bg-white">


                        <form method="POST" action="" accept-charset="UTF-8">
                            <div class="title mb-14">
                                <div class="flex items-center mb-4 title">
                                    <div class="text-sm font-bold uppercase shrink-0 text-n-40">Title</div>
                                    <div class="h-px ml-4 border-b line grow border-n-40"></div>
                                </div>
                                <div class="border-l rounded-tl-lg subelement border-spring-50 pb-11">
                                    <label for="description"
                                        class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                        Title
                                    </label>
                                    <div class="relative multi-form">
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
                                                <label for="">@xml:lang<span class="text-salmon-40">
                                                        *</span></label>
                                            </div>
                                            <div>
                                                <select class="" required="" id="" name=""
                                                    tabindex="-1" aria-hidden="true">
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
                                <div class="flex items-center mb-4 title">
                                    <div class="text-sm font-bold uppercase shrink-0 text-n-40">Description</div>
                                    <div class="h-px ml-4 border-b line grow border-n-40"></div>
                                </div>
                                <div class="border-l rounded-tl-lg subelement border-spring-50 pb-11">
                                    <label for="description"
                                        class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                        description
                                    </label>
                                    <div class="relative multi-form">
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
                                                <label for="">@xml:lang<span class="text-salmon-40">
                                                        *</span></label>
                                            </div>
                                            <div>
                                                <select class="" required="" id="" name=""
                                                    tabindex="-1" aria-hidden="true">
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
                                        {{-- <svg-vue icon="add-more"></svg-vue> --}}
                                        <svg-vue icon="add-more"></svg-vue>
                                    </span>
                                    ADD NARRATIVE IN OTHER LANGUAGE
                                </button>
                            </div>

                            <div class="document_link mb-14">
                                <div class="flex items-center mb-4 title">
                                    <div class="text-sm font-bold uppercase shrink-0 text-n-40">DOCUMENT LINK</div>
                                    <div class="h-px ml-4 border-b line grow border-n-40"></div>
                                </div>
                                <div class="border-l rounded-tl-lg subelement border-spring-50 pb-11">
                                    <label for="description"
                                        class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                        document Link
                                    </label>
                                    <div class="relative multi-form">
                                        <div
                                            class="flex flex-wrap p-6 border-r rounded-br-lg form-field-group border-y border-spring-50 attribute-wrapper">
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
                                                    <label for="">@xml:lang<span class="text-salmon-40">
                                                            *</span></label>
                                                </div>
                                                <div>
                                                    <select class="" required="" id="" name=""
                                                        tabindex="-1" aria-hidden="true">
                                                        <option value="">Select language</option>
                                                        <option value="1">EN</option>
                                                        <option value="2">FR</option>
                                                        <option value="3">ES</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- title --}}
                                        <div class="border-l rounded-tl-lg subelement border-spring-50 pb-11">
                                            <label for="description"
                                                class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                                title
                                            </label>
                                            <div
                                                class="flex flex-wrap p-6 border-r rounded-br-lg form-field-group form-child-body border-y border-spring-50">
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
                                                        <label for="">@xml:lang<span class="text-salmon-40">
                                                                *</span></label>
                                                    </div>
                                                    <div>
                                                        <select class="" required="" id=""
                                                            name="" tabindex="-1" aria-hidden="true">
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
                                                {{-- <svg-vue icon="add-more"></svg-vue> --}}
                                                <svg-vue icon="add-more"></svg-vue>
                                            </span>
                                            ADD NARRATIVE IN OTHER LANGUAGE
                                        </button>

                                        {{-- description --}}
                                        <div class="border-l rounded-tl-lg subelement border-spring-50 pb-11">
                                            <label for="description"
                                                class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                                description
                                            </label>
                                            <div
                                                class="flex flex-wrap p-6 border-r rounded-br-lg form-field-group form-child-body border-y border-spring-50">
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
                                                        <label for="">@xml:lang<span class="text-salmon-40">
                                                                *</span></label>
                                                    </div>
                                                    <div>
                                                        <select class="" required="" id=""
                                                            name="" tabindex="-1" aria-hidden="true">
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
                                        <div class="border-l rounded-tl-lg subelement border-spring-50 pb-11">
                                            <label for="description"
                                                class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                                language
                                            </label>
                                            <div
                                                class="flex flex-wrap p-6 border-r rounded-br-lg form-field-group form-child-body border-y border-spring-50">
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">
                                                            @code
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="text" placeholder="Type code here"
                                                            value="">
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
                                        <div class="border-l rounded-tl-lg subelement border-spring-50 pb-11">
                                            <label for="description"
                                                class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                                language
                                            </label>
                                            <div
                                                class="flex flex-wrap p-6 border-r rounded-br-lg form-field-group form-child-body border-y border-spring-50">
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">
                                                            @code
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="text" placeholder="Type code here"
                                                            value="">
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
                                        <div class="border-l rounded-tl-lg subelement border-spring-50">
                                            <label for="description"
                                                class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                                document-date
                                            </label>
                                            <div
                                                class="flex flex-wrap p-6 border-r rounded-br-lg form-field-group form-child-body border-y border-spring-50">
                                                <div class="form-field basis-6/12 max-w-half">
                                                    <div class="form-field-label">
                                                        <label for="">
                                                            @iso-date
                                                        </label>
                                                    </div>
                                                    <div>
                                                        <input type="text" placeholder="Type code here"
                                                            value="">
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
                                <div class="flex items-center mb-4 title">
                                    <div class="text-sm font-bold uppercase shrink-0 text-n-40">Reference</div>
                                    <div class="h-px ml-4 border-b line grow border-n-40"></div>
                                </div>
                                <div class="border-l rounded-tl-lg subelement border-spring-50 pb-11">
                                    <label for="description"
                                        class="flex px-6 py-4 text-sm font-bold leading-relaxed border-t border-r rounded-tl-lg rounded-tr-lg control-label border-spring-50">
                                        reference
                                    </label>
                                    <div class="relative multi-form">
                                        <div
                                            class="flex flex-wrap p-6 border-r rounded-br-lg form-field-group border-y border-spring-50 attribute-wrapper">
                                            <div class="form-field basis-6/12 max-w-half">
                                                <div class="form-field-label">
                                                    <label for="">
                                                        @code
                                                    </label>
                                                </div>
                                                <div>
                                                    <input type="text" placeholder="Type narrative here"
                                                        value="">
                                                </div>
                                            </div>
                                            <div class="form-field basis-6/12 max-w-half">
                                                <div class="form-field-label">
                                                    <label for="">
                                                        @vocabulary
                                                    </label>
                                                </div>
                                                <div>
                                                    <select class="" required="" id="" name=""
                                                        tabindex="-1" aria-hidden="true">
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
                                                    <select class="" required="" id="" name=""
                                                        tabindex="-1" aria-hidden="true">
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

                            <div class="fixed bottom-0 left-0 z-50 w-full py-5 bg-eggshell shadow-dropdown">
                                <div class="flex max-w-[1000px] mx-auto items-center">
                                    <div class="text-xs grow text-n-40">
                                        Note: After this step you will have to add indicactor.
                                    </div>
                                    <div class="flex items-center justify-end shrink-0">
                                        <button type="clear" class="mr-8 ghost-btn">Cancel</button>
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
