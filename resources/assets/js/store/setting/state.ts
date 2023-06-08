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
    linked_data_uri: '',
    humanitarian: '',
    budget_not_provided: '',
    default_collaboration_type: '',
    default_flow_type: '',
    default_finance_type: '',
    default_aid_type: '',
    default_tied_status: '',
  },
  publishingError: {
    api_token: '',
  },
  defaultError: {
    default_currency: '',
    default_language: '',
    hierarchy: '',
    linked_data_uri: '',
    humanitarian: '',
    budget_not_provided: '',
    default_collaboration_type: '',
    default_flow_type: '',
    default_finance_type: '',
    default_aid_type: '',
    default_tied_status: ''
  },
  isLoading: {},
};

export type State = typeof state;
