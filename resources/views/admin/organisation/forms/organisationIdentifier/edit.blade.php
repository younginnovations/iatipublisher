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
            <div class="modal-dialog p-3 shadow-2xl rounded-lg bg-white" role="document">
                <div class="modal-content p-2">
                    <div class="flex justify-between align-middle mb-3">
                        <h5 class="text-lg font-bold">Save and exit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeSaveAndExitModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="bg-eggshell mb-4 p-3 rounded">
                        Updating the Organization Identifier will update the following elements:
                        <ul class="list-disc p-3">
                            <li>Iati identifier of all non-published activities.</li>
                            <li>Reporting Org of all activities.</li>
                        </ul>

                        You will have to republish affected activities. Are you sure you want to continue?
                    </div>
                    <div class="flex align-end justify-end gap-3">
                        <button type="button" class="p-2 bg-white hover:bg-black hover:text-white rounded uppercase text-n-90 font-bold font-weight-bold" data-dismiss="modal"
                                onclick="closeSaveAndExitModal()">
                            Cancel
                        </button>
                        <button type="submit" id="submitSaveAndExit" class="p-2 uppercase btn primary-btn font-bold" data-loading-text="Loading"
                                onclick="submitSaveAndExit()">
                            Continue
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            const saveAndExitButton = document.querySelector('#save-and-exit-button');

            saveAndExitButton.addEventListener('click', function () {
                openSaveAndExitModal();
            });
        });

        function openSaveAndExitModal() {
            document.querySelector('#save-and-exit-modal').classList.remove('hidden');
        }

        function closeSaveAndExitModal() {
            document.querySelector('#save-and-exit-modal').classList.add('hidden');
        }

        function submitSaveAndExit() {
            document.querySelector('#save-and-exit-organization-identifier-form').submit();
        }
    </script>

@endsection
