import { ref } from 'vue';
import axios from 'axios';

export function useApi(url: RequestInfo, options?: RequestInit) {
  const response = ref();

  const request = async () => {
    const res = await fetch(url, options);
    const data = await res.json();
    response.value = data;
  };

  return { response, request };
}

export function fetchListingData(end_point: string, active_page?: number) {
  const response = ref();
  let endPoint = end_point;
  if (active_page) {
    endPoint = end_point + '/' + active_page;
  }
  axios.get(endPoint).then((res) => {
    response.value = res.data;
  });

  return response;
}
