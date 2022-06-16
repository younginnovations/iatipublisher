import $ from 'jquery';
import 'select2';

class FormBuilder {
  // adds new collection of sub-element
  public addForm(ev: Event): void {
    ev.preventDefault();
    let target = ev.target as EventTarget;
    let container = $('.collection-container');
    let count = $(target).attr('child_count')
      ? parseInt($(target).attr('child_count') as string) + 1
      : $(target).parent().find('.form-child-body').length;
    let parent_count = $(target).attr('parent_count')
      ? parseInt($(target).attr('parent_count') as string)
      : $(target).parent().prevAll('.multi-form').length;
    let proto = container
      .data('prototype')
      .replace(/__PARENT_NAME__/g, parent_count);
    proto = proto.replace(/__NAME__/g, count);
    $(target).prev().append($(proto));
    $(target)
      .parent()
      .find('.form-child-body')
      .last()
      .find('.select2')
      .select2({
        placeholder: 'Select an option',
      });
    $(target).attr('child_count', count);
  }

  // adds parent collection
  public addParentForm(ev: Event): void {
    ev.preventDefault();
    let target = ev.target as EventTarget;
    let container = $('.parent-collection');
    let count = $(target).attr('child_count')
      ? parseInt($(target).attr('child_count') as string) + 1
      : $('.multi-form').length;
    let proto = container.data('prototype').replace(/__PARENT_NAME__/g, count);
    proto = proto.replace(/__NAME__/g, 0);
    $('.multi-form').last().after($(proto));
    $('.multi-form').last().find('.select2').select2({
      placeholder: 'Select an option',
    });
    $('.multi-form')
      .last()
      .find('.add_to_collection')
      .attr('parent_count', count);
    $('.multi-form')
      .last()
      .find('.attribute')
      .wrapAll(
        $(
          '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 attribute-wrapper"></div>'
        )
      );
    $(target).attr('child_count', count);

    this.humanitarianScopeVocabularyUri();
    this.countryBudgetCodeField();
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
      console.log($(target).parent());
      $(target).parent().remove();
    }
  }

  //add wrapper div around the attributes
  public addWrapper() {
    $('.multi-form').each(function () {
      $(this)
        .find('.attribute')
        .wrapAll(
          $(
            '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 attribute-wrapper"></div>'
          )
        );
    });
  }

  /**
   * Humanitarian Scope Form Page
   *
   * @Logic hide vocabulary-uri field based on '@vocabulary' field value
   */
  public humanitarianScopeVocabularyUri() {
    var humanitarianScopeVocabulary = $(
        'select[id^="humanitarian_scope"][id*="[vocabulary]"]'
      ),
      humanitarianScopeVocabularyUri =
        'input[id^="humanitarian_scope"][id*="[vocabulary_uri]"]';

    if (humanitarianScopeVocabulary.length > 0) {
      // hide fields on page load
      $.each(humanitarianScopeVocabulary, function () {
        var val = humanitarianScopeVocabulary.val() ?? '';
        var index = $(this);

        if (val === '99') {
          index
            .closest('.form-field-group')
            .find(humanitarianScopeVocabularyUri)
            .show()
            .closest('.form-field')
            .show();
        } else {
          index
            .closest('.form-field-group')
            .find(humanitarianScopeVocabularyUri)
            .hide()
            .closest('.form-field')
            .hide();
        }
      });

      // hide/show fields on value change
      humanitarianScopeVocabulary.on('select2:select', function (e) {
        var val = e.params.data.id;
        var index = $(this);

        if (val === '99') {
          index
            .closest('.form-field-group')
            .find(humanitarianScopeVocabularyUri)
            .show()
            .closest('.form-field')
            .show();
        } else {
          index
            .closest('.form-field-group')
            .find(humanitarianScopeVocabularyUri)
            .hide()
            .closest('.form-field')
            .hide();
        }
      });
    }
  }

  /**
   * Country Budget Form Page
   *
   * @Logic show/hide 'code' field based on '@vocabulary' field value
   */
  public countryBudgetCodeField() {
    var countryBudgetVocabulary = $('select#country_budget_vocabulary'),
      countryBudgetCodeInput = 'input[id^="budget_item"][id*="[code_text]"]',
      countryBudgetCodeSelect = 'select[id^="budget_item"][id*="[code]"]';

    if (countryBudgetVocabulary.length > 0) {
      // hide/show on page load
      var val = countryBudgetVocabulary.val() ?? '1';

      if (val === '1') {
        $(countryBudgetCodeInput).closest('.form-field').hide();
        $(countryBudgetCodeSelect).closest('.form-field').show();
      } else {
        $(countryBudgetCodeInput).closest('.form-field').show();
        $(countryBudgetCodeSelect).closest('.form-field').hide();
      }

      // hide/show on value change
      countryBudgetVocabulary.on('select2:select', function (e) {
        var val = e.params.data.id;
        if (val === '1') {
          $(countryBudgetCodeInput).closest('.form-field').hide();
          $(countryBudgetCodeSelect).closest('.form-field').show();
        } else {
          $(countryBudgetCodeInput).closest('.form-field').show();
          $(countryBudgetCodeSelect).closest('.form-field').hide();
        }
      });
    }
  }
}

$(function () {
  let formBuilder = new FormBuilder();
  formBuilder.addWrapper();

  $('body').on('click', '.add_to_collection', (event: Event) => {
    formBuilder.addForm(event);
  });

  $('.add_to_parent').on('click', (event: Event) => {
    formBuilder.addParentForm(event);
  });

  $('body').on('click', '.delete', (event: Event) => {
    formBuilder.deleteForm(event);
  });

  $('body').on('click', '.delete-parent', (event: Event) => {
    formBuilder.deleteParentForm(event);
  });

  $('.select2').select2({
    placeholder: 'Select an option',
    allowClear: true,
  });

  /**
   * Default Aid Type Form Page
   *
   * @Logic hide select fields based on '@vocabulary' field value
   */
  var aidtype_vocabulary = $('select[id*="default_aidtype_vocabulary"]');

  //run code only if vocabulary select field exist in page
  if (aidtype_vocabulary.length > 0) {
    // hide fields on page load
    $.each(aidtype_vocabulary, function () {
      var data = $(this).val() ?? '1';
      defaultAidtypeHideSelectField($(this), data.toString());
    });

    // hide fields based on vocabulary value change
    aidtype_vocabulary.on('select2:select', function (e) {
      var data = e.params.data.id;
      defaultAidtypeHideSelectField($(this), data);
    });
  }

  function defaultAidtypeHideSelectField(index: JQuery, value: string) {
    var default_aid_type = 'select[id*="[default_aid_type]"]',
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
        //show fields
        index
          .closest('.form-field-group')
          .find(earmarking_category)
          .show()
          .closest('.form-field')
          .show();

        // //hide fields
        index
          .closest('.form-field-group')
          .find(case2)
          .hide()
          .closest('.form-field')
          .hide();
        break;
      case '3':
        //show fields
        index
          .closest('.form-field-group')
          .find(earmarking_modality)
          .show()
          .closest('.form-field')
          .show();

        //hide fields
        index
          .closest('.form-field-group')
          .find(case3)
          .hide()
          .closest('.form-field')
          .hide();
        break;

      case '4':
        //show fields
        index
          .closest('.form-field-group')
          .find(cash_and_voucher_modalities)
          .show()
          .closest('.form-field')
          .show();

        //hide fields
        index
          .closest('.form-field-group')
          .find(case4)
          .hide()
          .closest('.form-field')
          .hide();
        break;
      default:
        //show fields
        index
          .closest('.form-field-group')
          .find(default_aid_type)
          .show()
          .closest('.form-field')
          .show();

        //hide fields
        index
          .closest('.form-field-group')
          .find(case1)
          .hide()
          .closest('.form-field')
          .hide();
    }
  }

  formBuilder.humanitarianScopeVocabularyUri();
  formBuilder.countryBudgetCodeField();
});
