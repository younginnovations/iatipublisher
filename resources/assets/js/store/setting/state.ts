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
    humanitarian: '',
    budget_not_provided: '',
    defaultCollaborationType: ''
  },
  publishingError: {
    api_token: '',
  },
  defaultError: {
    default_currency: '',
    default_language: '',
    hierarchy: '',
    humanitarian: '',
    budget_not_provided: '',
    defaultCollaborationType: ''
  },
  isLoading: {},
};

export type State = typeof state;
