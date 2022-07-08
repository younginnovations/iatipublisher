import $ from 'jquery';
import 'select2';

class FormBuilder {
  // adds new collection of sub-element
  public addForm(ev: Event): void {
    ev.preventDefault();
    console.log('here');
    let target = ev.target as EventTarget;
    let container = $(target).attr('form_type') ? $(`.collection-container[form_type ='${$(target).attr('form_type')}']`) : $('.collection-container');

    let count = $(target).attr('child_count')
      ? parseInt($(target).attr('child_count') as string) + 1
      : $(target).parent().find('.form-child-body').length;

    let parent_count = $(target).attr('parent_count')
      ? parseInt($(target).attr('parent_count') as string)
      : $(target).parent().prevAll('.multi-form').length;

    let wrapper_parent_count = $(target).attr('wrapped_parent_count') ?
      parseInt($(target).attr('wrapped_parent_count') as string) :
      $(target).parent('.subelement').find('.wrapped-child-body').length;

    console.log(parent_count, wrapper_parent_count, count);

    let proto = container
      .data('prototype')
      .replace(/__PARENT_NAME__/g, parent_count);
    console.log(proto);

    if ($(target).attr('has_child_collection')) {
      console.log('here');
      proto = proto.replace(/__WRAPPER_NAME__/g, count);
      proto = proto.replace(/__NAME__/g, 0);
    } else {
      proto = proto.replace(/__NAME__/g, count);
      proto = proto.replace(/__WRAPPER_NAME__/g, wrapper_parent_count);
    }

    $(target).prev().append($(proto));
    if ($(target).attr('has_child_collection')) {
      console.log('here has child collection');
      let child = $(target).prev('.subelement').children('.wrapped-child-body').last();
      $(target).prev('.subelement').children('.wrapped-child-body').last().find('.add_to_collection').attr('wrapped_parent_count', count);
      $(target).prev('.subelement').children('.wrapped-child-body').last().find('.add_to_collection').attr('parent_count', parent_count);
    }



    $(target).prev().find('.wrapped-child-body').last().find('.add_to_collection').attr('wrapper_parent_count', wrapper_parent_count ?? 0);

    if ($(target).attr('form_type')) {
      $(target).prev().last().find('.select2').select2({
        placeholder: 'Select an option'
      });

      $(this).find('.sub-attribute')
        .wrapAll(
          $(
            '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper"></div>'
          )
        );

      $(target).prev('.subelement').children('.wrapped-child-body').last().find('.sub-attribute')
        .wrapAll(
          $(
            '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper mt-6"></div>'
          )
        );
    } else {
      $(target)
        .parent()
        .find('.form-child-body')
        .last()
        .find('.select2')
        .select2({
          placeholder: 'Select an option',
        });
    }


    $(target).attr('child_count', count);
    this.aidTypeVocabularyHideField();
    this.sectorVocabularyHideField();
  }

  // adds parent collection
  public addParentForm(ev: Event): void {
    ev.preventDefault();
    let target = ev.target as EventTarget;
    let container = $(target).attr('form_type') ? $(`.parent-collection[form_type ='${$(target).attr('form_type')}']`) : $('.parent-collection');

    let count = $(target).attr('parent_count')
      ? parseInt($(target).attr('parent_count') as string) + 1
      : ($(target).prev().find('.multi-form').length ? $(target).prev().find('.multi-form').length : $(target).prev().find('.wrapped-child-body').length);
    let proto = container.data('prototype').replace(/__PARENT_NAME__/g, count);
    proto = proto.replace(/__NAME__/g, 0);

    $(target).prev().append($(proto));
    $(target).prev().find('.multi-form').last().find('.select2').select2({
      placeholder: 'Select an option',
    });
    $(target).prev().find('.multi-form').last().find('.add_to_collection').attr('parent_count', count);

    this.addWrapperOnAdd(target);

    $(target).attr('parent_count', count);

    this.humanitarianScopeHideVocabularyUri();
    this.countryBudgetHideCodeField();
    this.sectorVocabularyHideField();
    this.recipientVocabularyHideField();
    this.policyVocabularyHideField();
    this.tagVocabularyHideField();
    this.transactionAidTypeVocabularyHideField();
  }

  // deletes collection
  public deleteForm(ev: Event): void {
    ev.preventDefault();
    let target = ev.target as EventTarget;
    let collectionLength = $('.multi-form').length
      ? $(target).closest('.subelement').find('.form-child-body').length
      : $('.form-child-body').length;
    let count = $('.add_to_collection').attr('child_count')
      ? parseInt($('.add_to_collection').attr('child_count') as string) + 1
      : collectionLength;
    $('.add_to_collection').attr('child_count', count);

    if (collectionLength > 1) {
      $(target).closest('.form-child-body').remove();
    }
  }

  // deletes parent collection
  public deleteParentForm(ev: Event): void {
    ev.preventDefault();
    let target = ev.target as EventTarget;
    let collectionLength = $('.subelement').length;
    let count = $('.add_to_parent').attr('child_count')
      ? parseInt($('.add_to_parent').attr('child_count') as string) + 1
      : collectionLength;
    $('.add_to_parent').attr('child_count', count);

    if (collectionLength > 2) {
      $(target).parent().remove();
    }
  }

  //add wrapper div around the attributes
  public addWrapper(): void {
    $('.multi-form').each(function () {

      $(this).find('.attribute')
        .wrapAll(
          $(
            '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 attribute-wrapper mb-4"></div>'
          )
        );
    })

    $('.subelement').find('.wrapped-child-body').each(function () {
      $(this).find('.sub-attribute')
        .wrapAll(
          $(
            '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper mb-4"></div>'
          )
        );
    });
  }

  public addWrapperOnAdd(target: EventTarget): void {
    $(target).prev().find('.multi-form').last()
      .find('.attribute')
      .wrapAll(
        $(
          '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 attribute-wrapper mb-4"></div>'
        )
      );

    $(target).prev().find('.multi-form').last().find('.subelement').find('.wrapped-child-body').each(function () {
      $(this).find('.sub-attribute')
        .wrapAll(
          $(
            '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper mb-4"></div>'
          )
        );
    });
  }

  /**
   * Hide and Show different form fields based on vocabulary and other types
   */
  public hideShowFormFields() {
    this.humanitarianScopeHideVocabularyUri();
    this.countryBudgetHideCodeField();
    this.aidTypeVocabularyHideField();
    this.sectorVocabularyHideField();
    this.policyVocabularyHideField();
    this.recipientVocabularyHideField();
    this.sectorVocabularyHideField();
    this.tagVocabularyHideField();
    this.transactionAidTypeVocabularyHideField();
  }

  /**
   * Humanitarian Scope Form Page
   *
   * @Logic hide vocabulary-uri field based on '@vocabulary' field value
   */
  public humanitarianScopeHideVocabularyUri() {
    let humanitarianScopeVocabulary = $(
      'select[id^="humanitarian_scope"][id*="[vocabulary]"]'
    );

    if (humanitarianScopeVocabulary.length > 0) {
      // hide fields on page load
      $.each(humanitarianScopeVocabulary, (index, scope) => {
        let val = $(scope).val() ?? '';
        this.hideHumanitarianScopeField($(scope), val.toString());
      });

      // hide/show fields on value change
      humanitarianScopeVocabulary.on('select2:select', (e) => {
        let val = e.params.data.id;
        let index = e.target as HTMLElement;

        this.hideHumanitarianScopeField($(index), val);
      });

      // hide/show fields on value clear
      humanitarianScopeVocabulary.on('select2:clear', (e) => {
        let index = e.target as HTMLElement;

        this.hideHumanitarianScopeField($(index), '');
      });
    }
  }

  // hide country budget based on vocabulary
  public hideHumanitarianScopeField(index: JQuery, value: string) {
    let humanitarianScopeHideVocabularyUri =
      'input[id^="humanitarian_scope"][id*="[vocabulary_uri]"]';

    if (value === '99') {
      index
        .closest('.form-field-group')
        .find(humanitarianScopeHideVocabularyUri)
        .show()
        .closest('.form-field')
        .show();
    } else {
      index
        .closest('.form-field-group')
        .find(humanitarianScopeHideVocabularyUri)
        .val('')
        .trigger('change')
        .hide()
        .closest('.form-field')
        .hide();
    }
  }

  /**
   * Country Budget Form Page
   *
   * @Logic show/hide 'code' field based on '@vocabulary' field value
   */
  public countryBudgetHideCodeField() {
    let countryBudgetVocabulary = $('select#country_budget_vocabulary');

    if (countryBudgetVocabulary.length > 0) {
      // hide/show on page load
      let val = countryBudgetVocabulary.val() ?? '1';
      this.hideCountryBudgetField(val.toString());

      // hide/show on value change
      countryBudgetVocabulary.on('select2:select', (e) => {
        let val = e.params.data.id;
        this.hideCountryBudgetField(val);
      });

      //hide/show based on value cleared
      countryBudgetVocabulary.on('select2:clear', (e) => {
        let index = e.target as HTMLElement;

        this.hideCountryBudgetField('');
      });
    }
  }

  /**
   * Hide Country Budget Fields
   */
  public hideCountryBudgetField(value: string) {
    let countryBudgetVocabulary = $('select#country_budget_vocabulary'),
      countryBudgetCodeInput = 'input[id^="budget_item"][id*="[code_text]"]',
      countryBudgetCodeSelect = 'select[id^="budget_item"][id*="[code]"]';

    if (value === '1') {
      $(countryBudgetCodeInput)
        .val('')
        .trigger('change')
        .closest('.form-field')
        .hide();
      $(countryBudgetCodeSelect).closest('.form-field').show();
    } else {
      $(countryBudgetCodeInput).closest('.form-field').show();
      $(countryBudgetCodeSelect)
        .val('')
        .trigger('change')
        .closest('.form-field')
        .hide();
    }
  }

  /**
   * AidType Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */
  public aidTypeVocabularyHideField() {
    let aidtype_vocabulary = $('select[id*="default_aidtype_vocabulary"]');
    let index = $(this);

    if (aidtype_vocabulary.length > 0) {
      $.each(aidtype_vocabulary, (index, item) => {
        let data = $(item).val() ?? '1';
        this.hideAidTypeSelectField($(item), data.toString());
      });

      aidtype_vocabulary.on('select2:select', (e) => {
        let data = e.params.data.id;
        let target = e.target as HTMLElement;

        this.hideAidTypeSelectField($(target), data);
      });

      aidtype_vocabulary.on('select2:clear', (e) => {
        let target = e.target as HTMLElement;

        this.hideAidTypeSelectField($(target), '');
      });
    }
  }

  /**
   * AidType Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */
  public transactionAidTypeVocabularyHideField() {
    let aidtype_vocabulary = $('select[id*="aidtype_vocabulary"]');
    let index = $(this);

    if (aidtype_vocabulary.length > 0) {
      $.each(aidtype_vocabulary, (index, item) => {
        let data = $(item).val() ?? '1';
        this.hideTransactionAidTypeSelectField($(item), data.toString());
      });

      aidtype_vocabulary.on('select2:select', (e) => {
        let data = e.params.data.id;
        let target = e.target as HTMLElement;

        this.hideTransactionAidTypeSelectField($(target), data);
      });

      aidtype_vocabulary.on('select2:clear', (e) => {
        let target = e.target as HTMLElement;

        this.hideTransactionAidTypeSelectField($(target), '');
      });
    }
  }

  /**
   * Hide Aid Type Select Fields
   */
  public hideAidTypeSelectField(index: JQuery, value: string) {
    let default_aid_type = 'select[id*="[default_aid_type]"]',
      earmarking_category = 'select[id*="[earmarking_category]"]',
      earmarking_modality = 'select[id*="[earmarking_modality]"]',
      cash_and_voucher_modalities =
        'select[id*="[cash_and_voucher_modalities]"]',
      case1 =
        'select[id*="[earmarking_category]"],select[id*="[earmarking_modality]"],select[id*="[cash_and_voucher_modalities]"]',
      case2 =
        'select[id*="[default_aid_type]"],select[id*="[earmarking_modality]"],select[id*="[cash_and_voucher_modalities]"]',
      case3 =
        'select[id*="[default_aid_type]"],select[id*="[earmarking_category]"],select[id*="[cash_and_voucher_modalities]"]',
      case4 =
        'select[id*="[default_aid_type]"],select[id*="[earmarking_category]"],select[id*="[earmarking_modality]"]';

    switch (value) {
      case '2':
        index
          .closest('.form-field-group')
          .find(earmarking_category)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case2)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '3':
        index
          .closest('.form-field-group')
          .find(earmarking_modality)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case3)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;

      case '4':
        index
          .closest('.form-field-group')
          .find(cash_and_voucher_modalities)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case4)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      default:
        index
          .closest('.form-field-group')
          .find(default_aid_type)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case1)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
    }
  }

  /**
   * Hide Transaction Aid Type Select Fields
   */
  public hideTransactionAidTypeSelectField(index: JQuery, value: string) {
    let aid_type = 'select[id*="[aid_type_code]"]',
      earmarking_category = 'select[id*="[earmarking_category]"]',
      earmarking_modality = 'select[id*="[earmarking_modality]"]',
      cash_and_voucher_modalities =
        'select[id*="[cash_and_voucher_modalities]"]',
      case1 =
        'select[id*="[earmarking_category]"],select[id*="[earmarking_modality]"],select[id*="[cash_and_voucher_modalities]"]',
      case2 =
        'select[id*="[aid_type_code]"],select[id*="[earmarking_modality]"],select[id*="[cash_and_voucher_modalities]"]',
      case3 =
        'select[id*="[aid_type_code]"],select[id*="[earmarking_category]"],select[id*="[cash_and_voucher_modalities]"]',
      case4 =
        'select[id*="[aid_type_code]"],select[id*="[earmarking_category]"],select[id*="[earmarking_modality]"]';

    switch (value) {
      case '2':
        index
          .closest('.form-field-group')
          .find(earmarking_category)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case2)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '3':
        index
          .closest('.form-field-group')
          .find(earmarking_modality)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case3)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;

      case '4':
        index
          .closest('.form-field-group')
          .find(cash_and_voucher_modalities)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case4)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      default:
        index
          .closest('.form-field-group')
          .find(aid_type)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case1)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
    }
  }

  /**
   * Policy Marker Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */
  public policyVocabularyHideField() {
    let policymaker_vocabulary = $('select[id*="policymarker_vocabulary"]');

    if (policymaker_vocabulary.length > 0) {
      $.each(policymaker_vocabulary, (index, policy_marker) => {
        let data = $(policy_marker).val() ?? '1';
        this.hidePolicyMakerField($(policy_marker), data.toString());
      });

      policymaker_vocabulary.on('select2:select', (e) => {
        let data = e.params.data.id;
        let target = e.target as HTMLElement;

        this.hidePolicyMakerField($(target), data);
      });

      policymaker_vocabulary.on('select2:clear', (e) => {
        let target = e.target as HTMLElement;

        this.hidePolicyMakerField($(target), '1');
      });
    }
  }

  /**
   * Hides Policy Marker Form Fields
   */
  public hidePolicyMakerField(index: JQuery, value: string) {
    let case1_show = 'select[id*="[policy_marker]"]',
      case2_show =
        'input[id*="[policy_marker_text]"],input[id*="[vocabulary_uri]"]',
      case1 = 'input[id*="[policy_marker_text]"],input[id*="[vocabulary_uri]"]',
      case2 = 'select[id*="[policy_marker]"]';

    switch (value) {
      case '1':
        index
          .closest('.form-field-group')
          .find(case1_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case1)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '99':
        index
          .closest('.form-field-group')
          .find(case2_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case2)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      default:
        index
          .closest('.form-field-group')
          .find(case1_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case1)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
    }
  }

  /**
   * Sector Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */
  public sectorVocabularyHideField() {
    let sector_vocabulary = $('select[id*="sector_vocabulary"]');

    if (sector_vocabulary.length > 0) {
      $.each(sector_vocabulary, (index, sector) => {
        let data = $(sector).val() ?? '1';
        this.hideSectorField($(sector), data.toString());
      });

      sector_vocabulary.on('select2:select', (e) => {
        let data = e.params.data.id;
        let target = e.target as HTMLElement;

        this.hideSectorField($(target), data);
      });

      sector_vocabulary.on('select2:clear', (e) => {
        let target = e.target as HTMLElement;

        this.hideSectorField($(target), '1');
      });
    }
  }

  /**
   * Hide Sector Form fields
   */
  public hideSectorField(index: JQuery, value: string) {
    let case1_show = 'select[id*="[code]"]',
      case2_show = 'select[id*="[category_code]"]',
      case7_show = 'select[id*="[sdg_goal]"]',
      case8_show = 'select[id*="[sdg_target]"]',
      case98_99_show = 'input[id*="[text]"],input[id*="[vocabulary_uri]"]',
      default_show = 'input[id*="[text]"]',
      case1 =
        'select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],input[id*="[vocabulary_uri]"],input[id*="[text]"]',
      case2 =
        'input[id*="[vocabulary_uri]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],select[id*="[code]"],input[id*="[text]"]',
      case7 =
        'input[id*="[vocabulary_uri]"],select[id*="[category_code]"],select[id*="[sdg_target]"],select[id*="[code]"],input[id*="[text]"]',
      case8 =
        'input[id*="[vocabulary_uri]"],select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[code]"],input[id*="[text]"]',
      case98_99 =
        'select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],select[id*="[code]"]',
      default_hide =
        'select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],select[id*="[code]"],input[id*="[vocabulary_uri]"]';

    switch (value) {
      case '1':
        index
          .closest('.form-field-group')
          .find(case1_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case1)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '2':
        index
          .closest('.form-field-group')
          .find(case2_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case2)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '7':
        index
          .closest('.form-field-group')
          .find(case7_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case7)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '8':
        index
          .closest('.form-field-group')
          .find(case8_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case8)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '98':
        index
          .closest('.form-field-group')
          .find(case98_99_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case98_99)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '99':
        index
          .closest('.form-field-group')
          .find(case98_99_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case98_99)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      default:
        index
          .closest('.form-field-group')
          .find(default_show)
          .show()
          .closest('.form-field')
          .show();

        index
          .closest('.form-field-group')
          .find(default_hide)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
    }
  }

  /**
   *  Recipient Vocabulary Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */
  public recipientVocabularyHideField() {
    let region_vocabulary = $('select[id*="region_vocabulary"]');

    if (region_vocabulary.length > 0) {
      $.each(region_vocabulary, (index, region_vocab) => {
        let data = $(region_vocab).val() ?? '1';
        this.hideRecipientRegionField($(region_vocab), data.toString());
      });

      region_vocabulary.on('select2:select', (e) => {
        let data = e.params.data.id;
        let target = e.target as HTMLElement;

        this.hideRecipientRegionField($(target), data);
      });

      region_vocabulary.on('select2:clear', (e) => {
        let target = e.target as HTMLElement;

        this.hideRecipientRegionField($(target), '1');
      });
    }
  }

  /**
   * Hides Recipient Region Form Fields
   */
  public hideRecipientRegionField(index: JQuery, value: string) {
    let case1_show = 'select[id*="[region_code]"],input[id*="[custom_code]"]',
      case2_show = 'input[id*="[custom_code]"]',
      case99_show = 'input[id*="[custom_code]"],input[id*="[vocabulary_uri]"]',
      case1 = 'input[id*="[custom_code]"],input[id*="[vocabulary_uri]"]',
      case2 = 'select[id*="[region_code]"],input[id*="[vocabulary_uri]"]',
      case99 = 'select[id*="[region_code]"]';

    switch (value) {
      case '1':
        index
          .closest('.form-field-group')
          .find(case1_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case1)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '2':
        index
          .closest('.form-field-group')
          .find(case2_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case2)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '99':
        index
          .closest('.form-field-group')
          .find(case99_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case99)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      default:
        index
          .closest('.form-field-group')
          .find(case2_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case2)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
    }
  }

  /**
   * Updates Activity identifier
   */
  public updateActivityIdentifier() {
    let activity_identifier = $('#activity_identifier');

    if (activity_identifier.length > 0) {
      activity_identifier.on('keyup', function () {
        $('#iati_identifier_text').val(
          $('.identifier').attr('activity_identifier') + `-${$(this).val()}`
        );
      });
    }
  }

  /**
   * Tag Form Page
   *
   * @Logic hide vocabulary-uri and codes field based on '@vocabulary' field value
   */
  public tagVocabularyHideField() {
    let tag_vocabulary = $('select[id*="tag_vocabulary"]');

    if (tag_vocabulary.length > 0) {
      $.each(tag_vocabulary, (index, tag) => {
        let data = $(tag).val() ?? '1';
        this.hideTagField($(tag), data.toString());
      });

      tag_vocabulary.on('select2:select', (e) => {
        let data = e.params.data.id;
        let target = e.target as HTMLElement;

        this.hideTagField($(target), data);
      });

      tag_vocabulary.on('select2:clear', (e) => {
        let target = e.target as HTMLElement;

        this.hideTagField($(target), '1');
      });
    }
  }

  /**
   * Hide Tag Form fields
   */
  public hideTagField(index: JQuery, value: string) {
    let case1_show = 'input[id*="[tag_text]"]',
      case2_show = 'select[id*="[goals_tag_code]"]',
      case3_show = 'select[id*="[targets_tag_code]"]',
      case99_show = 'input[id*="[tag_text]"], input[id*="[vocabulary_uri]"]',
      case1 =
        'select[id*="[goals_tag_code]"],select[id*="[targets_tag_code]"],input[id*="[vocabulary_uri]"]',
      case2 =
        'input[id*="[vocabulary_uri]"],select[id*="[targets_tag_code]"],select[id*="[targets_tag_code]"],input[id*="[tag_text]"]',
      case3 =
        'input[id*="[vocabulary_uri]"],select[id*="[goals_tag_code]"],input[id*="[tag_text]"]',
      case99 =
        'select[id*="[goals_tag_code]"],select[id*="[targets_tag_code]"]';

    switch (value) {
      case '1':
        index
          .closest('.form-field-group')
          .find(case1_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case1)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '2':
        index
          .closest('.form-field-group')
          .find(case2_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case2)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '3':
        index
          .closest('.form-field-group')
          .find(case3_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case3)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '99':
        index
          .closest('.form-field-group')
          .find(case99_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case99)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
        break;
      default:
        index
          .closest('.form-field-group')
          .find(case1_show)
          .show()
          .closest('.form-field')
          .show();
        index
          .closest('.form-field-group')
          .find(case1)
          .val('')
          .trigger('change')
          .hide()
          .closest('.form-field')
          .hide();
    }
  }
}

$(function () {
  let formBuilder = new FormBuilder();
  formBuilder.addWrapper();
  formBuilder.hideShowFormFields();
  formBuilder.updateActivityIdentifier();

  $('.delete').on('click', () => {
    // console.log('clicked');
  })

  $('body').on('click', '.add_to_collection', (event: Event) => {
    formBuilder.addForm(event);
  });

  $('.add_to_parent').on('click', (event: Event) => {
    formBuilder.addParentForm(event);
  });

  /**
   * Delete function
   *
   */
  var deleteConfirmation = $('.delete-confirmation'),
    cancelPopup = '.cancel-popup',
    deleteConfirm = '.delete-confirm',
    deleteIndex = {},
    childOrParent = '';

  $('body').on('click', '.delete', (event: Event) => {
    deleteConfirmation.fadeIn();
    deleteIndex = event;
    childOrParent = 'child';
  });

  $('body').on('click', cancelPopup, (event: Event) => {
    deleteConfirmation.fadeOut();
    deleteIndex = {};
    childOrParent = '';
  });

  $('body').on('click', deleteConfirm, (event: Event) => {
    if (childOrParent === 'child') {
      formBuilder.deleteForm(deleteIndex as Event);
    } else if (childOrParent === 'parent') {
      formBuilder.deleteParentForm(deleteIndex as Event);
    }

    deleteConfirmation.fadeOut();
    deleteIndex = {};
    childOrParent = '';
  });

  /**
   * Delete parent element
   */
  $('body').on('click', '.delete-parent', (event: Event) => {
    deleteConfirmation.fadeIn();
    deleteIndex = event;
    childOrParent = 'parent';
  });

  $('.select2').select2({
    placeholder: 'Select an option',
    allowClear: true,

  });

  let file = 'input[id*="[document]"]';

  $('body').on('change', 'input[id*="document"]', function () {
    let endpoint = $('.endpoint').attr('endpoint') ?? '';
    let file_name = ($(this).val() ?? '').toString();
    $(this).closest('.form-field-group').find('input[id*="[url]"]').val(`${endpoint}/${(file_name?.split('\\').pop())?.replace(' ', '_')}`);
  })

  $('body').on('select2:open', '.select2', (e) => {
    let target = e.target;
    $('.select2-search__field').trigger("focus");
  })

});


