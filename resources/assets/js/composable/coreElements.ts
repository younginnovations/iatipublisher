import CoreElementsJson from '../../../../public/Data/coreElements.json';

export function activityCoreElements() {
  return Object.keys(CoreElementsJson);
}

export function orgMandatoryElements() {
  const elements = ['reporting_org', 'name'];

  return elements;
}
