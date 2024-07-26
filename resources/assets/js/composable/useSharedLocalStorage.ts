// useSharedState.js
import { useStorage } from '@vueuse/core';
export const useSharedMinimize = () => {
  const isPublishedModalMinimized = useStorage(
    'isPublishedModalMinimized',
    false
  );
  return isPublishedModalMinimized;
};
