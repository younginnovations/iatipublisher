<template>
  <div class="shimmer__block" style="max-width: 515px"></div>
</template>

<style lang="scss" scoped>
.shimmer__block {
  animation-duration: 2s;
  animation-fill-mode: forwards;
  animation-iteration-count: infinite;
  animation-name: placeHolderShimmer;
  animation-timing-function: linear;
  animation-delay: 0.5s;
  background-color: #ededed;
  background-image: linear-gradient(
    90deg,
    #ededed 14.36%,
    #d7d6d6 56.29%,
    #ededed 100%
  );
  background-repeat: no-repeat;
  background-size: 244px 104px;
  position: relative;
  height: 19px;
  border-radius: 10px;
  width: 100%;
  margin: 3px 6px 3px 0px;
}

@keyframes placeHolderShimmer {
  0% {
    background-position: calc(0% - 300px) 0;
  }

  20% {
    background-position: calc(0% - 300px) 0;
  }

  80% {
    background-position: calc(100% + 300px) 0;
  }

  100% {
    background-position: calc(100% + 300px) 0;
  }
}
</style>
