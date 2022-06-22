<div class="page-title mb-6">
  <div class="flex items-end space-x-4">
    <div class="title grow-0">
      <div class="activity__title mb-4 text-caption-c1 text-n-40">
        <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
          <div class="flex max-w-md">
            <a class="whitespace-nowrap font-bold" href="/activities">Your Activities</a>
            <span class="separator mx-4"> / </span>
            <div class="breadcrumb__title">
              <span class="breadcrumb__title overflow-hidden last text-n-30"><a
                  href="/activities/{{ $activity['id'] }}">{{ $activity['title'][0]['narrative'] ?? 'Untitled' }}</a></span>
              <span
                class="ellipsis__title--hover w-[calc(100%_+_35px)]">{{ $activity['title'][0]['narrative'] ?? 'Untitled' }}</span>
            </div>
          </div>
        </nav>
      </div>
      <div class="activity__title inline-flex items-center max-w-[768px]">
        <div class="mr-3">
          <a href="/activities/{{ $activity['id'] }}">
            <svg-vue icon="arrow-short-left"></svg-vue>
          </a>
        </div>
        <div>
          <h4 class="ellipsis__title relative mr-4 text-2xl font-bold">
            <span
              class="ellipsis__title overflow-hidden">{{ $activity['title'][0]['narrative'] ?? 'Untitled' }}</span>
            <span class="ellipsis__title--hover">{{ $activity['title'][0]['narrative'] ?? 'Untitled' }}</span>
          </h4>
        </div>
      </div>
    </div>
  </div>
</div>
