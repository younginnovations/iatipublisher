export class Translate {
  lang;

  private languageSources = [
    'about',
    'activities',
    'activity_default',
    'activity_detail',
    'admin',
    'auth',
    'buttons',
    'common',
    'element_labels',
    'elements',
    'elements_common',
    'email_verification',
    'events',
    'home',
    'iati_standard',
    'middleware',
    'missing',
    'organisation',
    'pagination',
    'password_recovery',
    'passwords',
    'publishing_checklist',
    'register',
    'requests',
    'responses',
    'setting',
    'settings',
    'support',
    'user',
    'validation',
    'web',
    'sticky',
  ];

  constructor() {
    this.lang = window['globalLang'];
  }

  button(buttonKey: string, elementKey = '') {
    const baseMessage = this.lang.buttons[buttonKey];

    if (!elementKey) {
      return baseMessage;
    }

    const value = this.textFromKey(elementKey);

    return baseMessage.replace(':element', value);
  }

  event(key: string): string {
    return this.lang.events[key] ?? key;
  }

  element(key, parentKey = 'elements_common') {
    return this.lang[parentKey][key];
  }

  error(errorKey, elementKey = '') {
    const baseMessage = this.lang.common.error[errorKey];

    if (!elementKey) {
      return baseMessage;
    }

    const value = this.textFromKey(elementKey);

    return baseMessage.replace(':element', value);
  }

  commonText(key: string): string {
    let translatedString = this.lang.common;
    const keys = this.explode(key);

    for (const innerKey of keys) {
      translatedString = translatedString[innerKey] ?? key;
    }

    return translatedString;
  }

  elementLabel(key) {
    let translatedString = this.lang.element_labels;
    const keys = this.explode(key);

    for (const innerKey of keys) {
      translatedString = translatedString[innerKey] ?? key;
    }

    return translatedString;
  }

  elementFromElementName(elementName) {
    return (
      this.lang.elements_common[elementName] ?? elementName.replace(/_/g, '-')
    );
  }

  missing(key = '', element = '') {
    if (key) {
      let baseMessage = this.lang.missing[key];

      if (element) {
        element = this.textFromKey(element);
        baseMessage = baseMessage.replace(':element', element);
      }

      return baseMessage;
    }

    return this.lang.missing.default;
  }

  stickyText(key, outerKey = ''): string {
    if (outerKey) {
      return this.lang.sticky[outerKey][key];
    }

    return this.lang.sticky[key];
  }

  logText(key) {
    return this.lang.common.logs[key];
  }

  webText(key) {
    return this.lang.web[key];
  }

  adminText(key, parentKey = 'header') {
    return this.lang.admin[parentKey][key];
  }

  registerText(key) {
    return this.translate(this.lang.register, key);
  }

  aboutText(key) {
    return this.translate(this.lang.about, key);
  }

  iatiStandardText(key) {
    return this.translate(this.lang.iati_standard, key);
  }

  publishingChecklistText(key) {
    return this.translate(this.lang.publishing_checklist, key);
  }

  getStickyObject(innerKey = '') {
    if (innerKey) {
      return this.lang.sticky[innerKey];
    }

    return this.lang.sticky;
  }

  public textFromKey(elementKey): string {
    let value = this.lang;
    const elementKeysArray = this.explode(elementKey);

    if (elementKeysArray.length > 1) {
      const leadingKey = elementKeysArray[0];

      if (this.languageSources.includes(leadingKey)) {
        value = this.lang[leadingKey];
        elementKeysArray.shift();

        for (const elementKey of elementKeysArray) {
          value = value[elementKey] ?? elementKey;
        }
      }

      return value;
    }

    return value[elementKey];
  }

  translate(translationSource, key) {
    const keys = this.explode(key);

    for (const innerKey of keys) {
      translationSource = translationSource[innerKey];
    }

    return translationSource;
  }

  explode(key) {
    return key.split('.');
  }
}
