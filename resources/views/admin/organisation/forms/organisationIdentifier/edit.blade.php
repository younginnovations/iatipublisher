@extends('admin.layouts.app')

@section('content')
    <section class="section min-h-[calc(100vh_-_60px)]">
        @include('web.components.loader')
        <div class="px-5 xl:px-10 pt-4 pb-[71px]">
            @include('admin.layouts.organizationTitle')
            <div class="activities">
                <aside class="activities__sidebar activities__sidebar-inner">
                    @include('admin.organisation.partial.form-sidebar')
                </aside>
                <div class="activities__content">
                    <div class="py-[6.06%] px-[6%] min-w-[300px] lg:min-w-[300px] xl:px-[12%] bg-white">

                        @include('admin.organisation.partial.form-title')

                        @if (Session::has('error'))
                            <p class='error'>{{ Session::get('error') }}</p>
                        @endif

                        {!! form($form) !!}

                    </div>
                </div>
            </div>
        </div>

        <div id="save-and-exit-modal" class="hidden modal fade fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-40" tabindex="-1" role="dialog">
            <div class="modal-dialog p-3 shadow-2xl rounded-lg bg-white max-w-xl" role="document">
                <div class="modal-content py-3 px-6">

                    <div class="flex justify-between pb-4 relative"> <!-- Remove align-middle class -->
                        <div class="flex gap-2.5 items-center">
                            <div class="flex items-center justify-center"> <!-- Added flex and justify-center -->
                                <img src="{{ url('/images/warning-activity-salmon.svg') }}" alt="" class="h-[18px]">
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">Organisation-Identifier has changed</h4>
                            </div>
                        </div>
                    </div>

                    <div class="bg-eggshell mb-4 p-4 rounded  px-5">
                        <div class="pb-3">
                            <p class="text-sm">Updating the organisation-identifier will update the following elements:</p>
                            <ul class="list-disc px-3 ml-2 text-n-50">
                                <li class="text-sm">iati-identifier of all non-published activities.</li>
                                <li class="text-sm">reporting-org of all activities.</li>
                            </ul>
                        </div>

                        <p class="text-sm">Are you sure you want to save the change ?</p>
                    </div>
                    <div class="flex align-end justify-end gap-3">
                        <button type="button" class="px-2 py-1 bg-white hover:bg-black hover:text-white rounded uppercase text-n-40 font-bold font-weight-bold" data-dismiss="modal"
                                onclick="closeSaveAndExitModal()">
                            Cancel
                        </button>
                        <button type="submit" id="submitSaveAndExit" class="px-2 py-1 uppercase btn primary-btn font-bold" data-loading-text="Loading"
                                onclick="submitSaveAndExit()">
                            SAVE AND EXIT
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('additional-scripts')
<script defer>
    document.addEventListener('DOMContentLoaded', function () {
        const saveAndExitButton = document.querySelector('#save-and-exit-button');
        const organizationIdentifier = document.querySelector('#organisation_identifier');
        const initialOrganizationIdentifier = organizationIdentifier.value;

        if(saveAndExitButton){
            saveAndExitButton.addEventListener('click', function () {
                const organizationIdentifierBeforeSave = organizationIdentifier.value;
                const identifierHasChanged = organizationIdentifierBeforeSave !== initialOrganizationIdentifier;

                if(identifierHasChanged){
                    openSaveAndExitModal();
                }else{
                    submitSaveAndExit();
                }
            });
        }
    });

    function openSaveAndExitModal() {
        document.querySelector('#save-and-exit-modal')?.classList.remove('hidden');
    }

    function closeSaveAndExitModal() {
        document.querySelector('#save-and-exit-modal')?.classList.add('hidden');
    }

    function submitSaveAndExit() {
        document.querySelector('#save-and-exit-organization-identifier-form')?.submit();
    }
</script>
@endsection
