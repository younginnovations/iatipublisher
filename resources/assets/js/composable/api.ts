import { ref } from 'vue';

function useApi(url: RequestInfo, options?: RequestInit) {
  const response = ref();

  const request = async () => {
    const res = await fetch(url, options);
    const data = await res.json();
    response.value = data;
  };

  return { response, request };
}

export default useApi;
