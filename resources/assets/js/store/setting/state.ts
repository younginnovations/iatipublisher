export const state = {
  publishingForm: {
    publisher_id: '',
    api_token: '',
  },
  publishingInfo: {
    publisher_verification: false,
    token_verification: false,
    isVerificationRequested: false,
  },
  defaultForm: {
    default_currency: '',
    default_language: '',
    hierarchy: '',
    linked_data_url: '',
    humanitarian: 'no',
  },
  publishingError: {
    publisher_id: '',
    api_token: '',
  },
  defaultError: {
    default_currency: '',
    default_language: '',
    hierarchy: '',
    linked_data_url: '',
    humanitarian: '',
  },
};

export type State = typeof state
