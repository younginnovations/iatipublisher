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
  ];

  constructor() {
    this.lang = window['globalLang'];
  }

  button(buttonKey: string, elementKey = '') {
    const baseMessage = this.lang.button_lang[buttonKey];

    if (!elementKey) {
      return baseMessage;
    }

    const value = this.textFromKey(elementKey);

    return baseMessage.replace(':element', value);
  }

  event(key: string): string {
    return this.lang.events_lang[key] ?? key;
  }

  element(key, parentKey = 'elements_common') {
    const sourceKey = this.mappedKeyForSource(parentKey);

    return this.lang[sourceKey][key];
  }

  error(errorKey, elementKey = '') {
    const baseMessage = this.lang.common_lang.error[errorKey];

    if (!elementKey) {
      return baseMessage;
    }

    const value = this.textFromKey(elementKey);

    return baseMessage.replace(':element', value);
  }

  commonText(key: string): string {
    let translatedString = this.lang.common_lang;
    const keys = this.explode(key);

    for (const innerKey of keys) {
      translatedString = translatedString[innerKey] ?? key;
    }

    if (typeof translatedString !== 'string') {
      console.log(key, translatedString, 'commonText');
    }
    return translatedString;
  }

  elementLabel(key) {
    let translatedString = this.lang.element_labels_lang;
    const keys = this.explode(key);

    for (const innerKey of keys) {
      translatedString = translatedString[innerKey] ?? key;
    }

    if (typeof translatedString !== 'string') {
      console.log(key, translatedString, 'elementLabel');
    }
    return translatedString;
  }

  elementFromElementName(elementName) {
    return (
      this.lang.elements_common_lang[elementName] ??
      elementName.replace(/_/g, '-')
    );
  }

  missingText(key = '', element = '') {
    if (key) {
      let baseMessage = this.lang.missing_lang[key];

      if (element) {
        element = this.textFromKey(element);
        baseMessage = baseMessage.replace(':element', element);
      }

      return baseMessage;
    }

    return this.lang.missing_lang.default;
  }

  stickyText(key, outerKey = ''): string {
    if (outerKey) {
      return this.lang.common_lang.sticky[outerKey][key];
    }

    return this.lang.common_lang.sticky[key];
  }

  logText(key) {
    return this.lang.common_lang.logs[key];
  }

  webText(key) {
    return this.lang.web_lang[key];
  }

  adminText(key, parentKey = 'header') {
    return this.lang.admin[parentKey][key];
  }

  registerText(key) {
    return this.translate(this.lang.register_lang, key);
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
      return this.lang.common_lang.sticky[innerKey];
    }

    return this.lang.common_lang.sticky;
  }

  public textFromKey(elementKey): string {
    let value = this.lang;
    const elementKeysArray = this.explode(elementKey);

    if (elementKeysArray.length > 1) {
      const leadingKey = elementKeysArray[0];

      if (this.languageSources.includes(leadingKey)) {
        value = this.lang[this.mappedKeyForSource(leadingKey)];
        elementKeysArray.shift();

        for (const elementKey of elementKeysArray) {
          value = value[elementKey] ?? elementKey;
        }
      }

      return value;
    }

    return value[elementKey];
  }

  private mappedKeyForSource(source: string): string {
    const map = {
      web: 'web_lang',
      home: 'home',
      about: 'about',
      publishing_checklist: 'publishing_checklist',
      iati_standard: 'iati_standard',
      support: 'support',
      password_recovery: 'password_recovery',
      email_verification: 'email_verification',
      register: 'register_lang',
      elements_common: 'elements_common_lang',
      common: 'common_lang',
      buttons: 'button_lang',
      user: 'user_lang',
      validation: 'validation_lang',
      admin: 'admin',
      activities: 'activities_lang',
      activity_detail: 'activity_lang',
      activity_default: 'activity_default_lang',
      settings: 'settings_lang',
      elements: 'elements_lang',
      organisation: 'org_lang',
      events: 'events_lang',
      misc: 'misc_lang',
      element_labels: 'element_labels_lang',
    };

    return map[source];
  }

  translate(translationSource, key) {
    if (key === 'about' || key === 'support') {
      console.log(key, translationSource, 'okok');
    }

    const keys = this.explode(key);
    for (const innerKey of keys) {
      translationSource = translationSource[innerKey];
    }
    if (typeof translationSource !== 'string') {
      console.log(key, translationSource, 'translate');
    }
    return translationSource;
  }

  explode(key) {
    return key.split('.');
  }
}
