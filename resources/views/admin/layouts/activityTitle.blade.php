<div class="mb-6 page-title">
    <div class="flex items-end space-x-4">
        <div class="title grow-0">
            <div class="mb-4 activity__title text-caption-c1 text-n-40">
                <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
                    <div class="flex max-w-md">
                        <a class="font-bold whitespace-nowrap" href="/activities">Your Activities</a>
                        <span class="mx-4 separator"> / </span>
                        <div class="breadcrumb__title">
                            <span class="overflow-hidden breadcrumb__title last text-n-30"><a
                                    href="/activity/{{ $activity['id'] }}">{{ $activity->default_title_narrative ?? 'Untitled' }}</a></span>
                            <span
                                class="ellipsis__title--hover w-[calc(100%_+_35px)]">{{ $activity->default_title_narrative ?? 'Untitled' }}</span>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="inline-flex items-center max-w-screen-md activity__title">
                <div class="mr-3">
                    <a href="/activity/{{ $activity['id'] }}">
                        <svg-vue icon="arrow-short-left"></svg-vue>
                    </a>
                </div>
                <div>
                    <h4 class="relative mr-4 text-2xl font-bold ellipsis__title">
                        <span
                            class="overflow-hidden ellipsis__title">{{ $activity->default_title_narrative ?? 'Untitled' }}</span>
                        <span
                            class="ellipsis__title--hover">{{ $activity->default_title_narrative?? 'Untitled' }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
