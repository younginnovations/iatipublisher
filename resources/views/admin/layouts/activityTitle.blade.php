<div class="page-title mb-6">
  <div class="flex items-end space-x-4">
    <div class="title grow-0">
      <div class="activity__title mb-4 text-caption-c1 text-n-40 w-80">
        <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">
          <p class="whitespace-nowrap text-ellipsis overflow-hidden">
            <a class="font-bold" href="/activities">Your Activities</a>
            <span class="separator mx-4"> / </span>
            <span class="last text-n-30"><a
                href="/activities/{{ $activity['id'] }}">{{ $activity['title'][0]['narrative'] }}</a></span>
          </p>
        </nav>
      </div>
      <div class="activity__title inline-flex items-center w-[615px]">
        <div class="mr-3">
          <a href="/activities/{{ $activity['id'] }}">
            <svg-vue icon="arrow-short-left"></svg-vue>
          </a>
        </div>
        <h4 class="mr-4 font-bold whitespace-nowrap text-ellipsis overflow-hidden">
          <span>{{ $activity['title'][0]['narrative'] }}</span>
        </h4>
      </div>
    </div>
  </div>
</div>
