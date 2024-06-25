import axios from 'axios';

export const checkBulkPublish = () => {
  const response = axios.get('activities/checks-for-activity-bulk-validation');
  return response;
};
