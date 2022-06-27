<div class="delete-confirmation fixed top-0 left-0 flex items-center justify-center w-screen h-screen p-8 modal z-[60]"
    style="display:none;">
    <div class="flex items-center justify-center w-full h-full">
        <div class="absolute top-0 left-0 w-full h-full opacity-50 modal-backdrop bg-n-50"></div>
        <div class="relative w-full max-h-full p-8 overflow-x-hidden bg-white rounded-lg modal-inner"
            style="max-width: 583px;">
            <div class="mb-4">
                <div class="flex mb-6 title">
                    <svg-vue icon="alert" class="mr-2 mt-0.5 text-lg text-crimson-40"></svg-vue>
                    <b>Delete Alert</b>
                </div>
                <div class="p-4 rounded-lg bg-rose">Are you sure you want to delete this item?</div>
            </div>
            <div class="flex justify-end">
                <div class="inline-flex">
                    <button class="relative px-6 font-bold uppercase bg-white cancel-popup button text-n-40">
                        <span>Go Back</span>
                    </button>
                    <button class="relative font-bold delete-confirm button text-n-40 primary-btn space">
                        <span>Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-title">
    <div class="flex mb-4">
        <div class="flex title grow">
            <span class="text-bluecoral text-xl mr-1.5">
                @if ($data['name'] === 'reporting_org' || $data['name'] === 'default_tied_status' || $data['name'] === 'crs_add' || $data['name'] === 'fss')
                    <svg-vue icon="activity-elements/building"></svg-vue>
                @else
                    <svg-vue icon="activity-elements/{{ $data['name'] }}"></svg-vue>
                @endif
            </span>
            <div class="text-sm font-bold title"> {{ str_replace(' ', '-', strtolower($data['title'])) }}</div>
            <div
                class="{{ $data['status'] ? 'text-spring-50' : 'text-crimson-50' }} flex status text-xs leading-5 ml-2.5 mr-2.5">
                <b class="mr-2 text-base leading-3">.</b>
                <span>{{ $data['status'] ? 'completed' : 'not completed' }}</span>
            </div>
            @if ($data['core'])
                <svg-vue icon="core"></svg-vue>
            @endif
        </div>
        <div class="flex icons">
            <span class="text-xs"><sup class="text-salmon-50">*</sup> Mandatory fields</span>
            <hover-text hover_text="tooltip" class="ml-1" />
        </div>
    </div>
    <div class="w-full h-px mb-4 divider bg-n-20"></div>
</div>
