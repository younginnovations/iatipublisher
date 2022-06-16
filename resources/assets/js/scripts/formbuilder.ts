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
  public addWrapper(): void {
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
  //hide and show aid type fields
  public hideAidTypeSelectField(index: JQuery, value: string) {
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
        index.closest('.form-field-group').find(earmarking_category).show().closest('.form-field').show();

        // //hide fields
        index.closest('.form-field-group').find(case2).hide().closest('.form-field').hide();
        break;
      case '3':
        //show fields
        index.closest('.form-field-group').find(earmarking_modality).show().closest('.form-field').show();

        //hide fields
        index.closest('.form-field-group').find(case3).hide().closest('.form-field').hide();
        break;

      case '4':
        //show fields
        index.closest('.form-field-group').find(cash_and_voucher_modalities).show().closest('.form-field').show();

        //hide fields
        index.closest('.form-field-group').find(case4).hide().closest('.form-field').hide();
        break;
      default:
        //show fields
        index.closest('.form-field-group').find(default_aid_type).show().closest('.form-field').show();

        //hide fields
        index.closest('.form-field-group').find(case1).hide().closest('.form-field').hide();
    }



  }

  public hidePolicyMakerField(index: JQuery, value: string) {
    let case1_show = 'select[id*="[policy_marker]"]',
      case2_show = 'input[id*="[policy_marker_text]"],input[id*="[vocabulary_uri]"]',
      case1 =
        'input[id*="[policy_marker_text]"],input[id*="[vocabulary_uri]"]',
      case2 =
        'select[id*="[policy_marker]"]';

    console.log('here');

    switch (value) {
      case '1':
        index.closest('.form-field-group').find(case1_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case1).hide().closest('.form-field').hide();
        break;
      case '99':
        index.closest('.form-field-group').find(case2_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case2).hide().closest('.form-field').hide();
        break;
      default:
        index.closest('.form-field-group').find(case1).hide().closest('.form-field').hide();
    }
  }

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
      default_hide = 'select[id*="[category_code]"],select[id*="[sdg_goal]"],select[id*="[sdg_target]"],select[id*="[code]"],input[id*="[vocabulary_uri]"]';


    switch (value) {
      case '1':
        index.closest('.form-field-group').find(case1_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case1).hide().closest('.form-field').hide();
        break;
      case '2':
        index.closest('.form-field-group').find(case2_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case2).hide().closest('.form-field').hide();
        break;
      case '7':
        index.closest('.form-field-group').find(case7_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case7).hide().closest('.form-field').hide();
        break;
      case '8':
        index.closest('.form-field-group').find(case8_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case8).hide().closest('.form-field').hide();
        break;
      case '98':
        index.closest('.form-field-group').find(case98_99_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case98_99).hide().closest('.form-field').hide();
        break;
      case '99':
        index.closest('.form-field-group').find(case98_99_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case98_99).hide().closest('.form-field').hide();
        break;
      default:
        index.closest('.form-field-group').find(default_show).show().closest('.form-field').show();

        index.closest('.form-field-group').find(default_hide).hide().closest('.form-field').hide();
    }
  }

  public hideRecipientRegionField(index: JQuery, value: string) {
    let case1_show = 'select[id*="[region_code]"],input[id*="[custom_code]"]',
      case2_show = 'input[id*="[custom_code]"]',
      case99_show = 'input[id*="[custom_code]"],input[id*="[vocabulary_uri]"]',
      case1 =
        'input[id*="[custom_code]"],input[id*="[vocabulary_uri]"]',
      case2 =
        'select[id*="[region_code]"],input[id*="[vocabulary_uri]"]',
      case99 =
        'select[id*="[region_code]"]';

    console.log(index.closest('.form-field-group').find(case1_show));

    console.log(value);


    switch (value) {
      case '1':
        index.closest('.form-field-group').find(case1_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case1).hide().closest('.form-field').hide();
        break;
      case '2':
        index.closest('.form-field-group').find(case2_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case2).hide().closest('.form-field').hide();
        break;
      case '99':
        index.closest('.form-field-group').find(case99_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case99).hide().closest('.form-field').hide();
        break;
      default:
        index.closest('.form-field-group').find(case2_show).show().closest('.form-field').show();
        index.closest('.form-field-group').find(case2).hide().closest('.form-field').hide();
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

  //aidtype_vocabulary
  var aidtype_vocabulary = $('select[id*="default_aidtype_vocabulary"]');

  //run code only if vocabulary select field exist in page
  if (aidtype_vocabulary.length > 0) {
    // hide fields on page load
    $.each(aidtype_vocabulary, function () {
      var data = $(this).val() ?? '1';
      formBuilder.hideAidTypeSelectField($(this), data.toString());
    });

    // hide fields based on vocabulary value change
    aidtype_vocabulary.on('select2:select', function (e) {
      var data = e.params.data.id;
      formBuilder.hideAidTypeSelectField($(this), data);
    });
  }



  //policy maker
  var policymaker_vocabulary = $('select[id*="policymarker_vocabulary"]');

  //run code only if vocabulary select field exist in page
  if (policymaker_vocabulary.length > 0) {
    console.log('here');
    //loop through all vocabulary
    $.each(policymaker_vocabulary, function () {
      var data = $(this).val() ?? '1';
      formBuilder.hidePolicyMakerField($(this), data.toString());
    });

    /**
     * Hide and show select field based on vocabulary value
     */

    policymaker_vocabulary.on('select2:select', function (e) {
      var data = e.params.data.id;
      formBuilder.hidePolicyMakerField($(this), data);
    });
  }

  //sector
  var sector_vocabulary = $('select[id*="sector_vocabulary"]');

  //run code only if vocabulary select field exist in page
  if (sector_vocabulary.length > 0) {
    //loop through all vocabulary
    $.each(sector_vocabulary, function () {
      var data = $(this).val() ?? '1';
      formBuilder.hideSectorField($(this), data.toString());
    });

    /**
     * Hide and show select field based on vocabulary value
     */

    sector_vocabulary.on('select2:select', function (e) {
      var data = e.params.data.id;
      formBuilder.hideSectorField($(this), data);
    });
  }

  //recipient_region
  var region_vocabulary = $('select[id*="region_vocabulary"]');

  //run code only if vocabulary select field exist in page
  if (region_vocabulary.length > 0) {
    //loop through all vocabulary
    $.each(region_vocabulary, function () {
      var data = $(this).val() ?? '1';
      formBuilder.hideRecipientRegionField($(this), data.toString());
    });

    /**
     * Hide and show select field based on vocabulary value
     */

    region_vocabulary.on('select2:select', function (e) {
      var data = e.params.data.id;
      formBuilder.hideRecipientRegionField($(this), data);
    });
  }

  formBuilder.humanitarianScopeVocabularyUri();
  formBuilder.countryBudgetCodeField();
});
