export function activityCoreElements() {
  const elements = [
    'reporting_org',
    'iati_identifier',
    'title',
    'description',
    'participating_org',
    'activity_status',
    'activity_date',
    'recipient_country',
    'recipient_region',
    'sector',
    'collaboration_type',
    'default_flow_type',
    'default_finance_type',
    'default_aid_type',
    'budget',
    'transactions',
  ];

  return elements;
}

export function orgMandatoryElements() {
  const elements = ['reporting_org', 'name'];

  return elements;
}
