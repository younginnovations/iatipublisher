import $ from 'jquery';
import 'select2';
import { DynamicField } from './DynamicField';

const dynamicField = new DynamicField();
class FormBuilder
{

  // adds new collection of sub-element
  public addForm(ev: Event): void {
    ev.preventDefault();
    const target = ev.target as EventTarget;
    const container = $(target).attr('form_type')
      ? $(`.collection-container[form_type ='${$(target).attr('form_type')}']`)
      : $('.collection-container');

    const count = $(target).attr('child_count')
      ? parseInt($(target).attr('child_count') as string) + 1
      : $(target).parent().find('.form-child-body').length;

    const parent_count = $(target).attr('parent_count')
      ? parseInt($(target).attr('parent_count') as string)
      : $(target).parent('.subelement').prevAll('.multi-form').length;

    const wrapper_parent_count = $(target).attr('wrapped_parent_count')
      ? parseInt($(target).attr('wrapped_parent_count') as string)
      : $(target).parent('.subelement').find('.wrapped-child-body').length;

    let proto = container
      .data('prototype')
      .replace(/__PARENT_NAME__/g, parent_count);

    if ($(target).attr('has_child_collection')) {
      proto = proto.replace(/__WRAPPER_NAME__/g, count);
      proto = proto.replace(/__NAME__/g, 0);
    } else {
      proto = proto.replace(/__NAME__/g, count);
      proto = proto.replace(/__WRAPPER_NAME__/g, wrapper_parent_count);
    }

    $(target).prev().append($(proto));
    if ($(target).attr('has_child_collection')) {
      $(target)
        .prev('.subelement')
        .children('.wrapped-child-body')
        .last()
        .find('.add_to_collection')
        .attr('wrapped_parent_count', count);
      $(target)
        .prev('.subelement')
        .children('.wrapped-child-body')
        .last()
        .find('.add_to_collection')
        .attr('parent_count', parent_count);
    }

    $(target)
      .prev()
      .find('.wrapped-child-body')
      .last()
      .find('.add_to_collection')
      .attr('wrapper_parent_count', wrapper_parent_count ?? 0);

    if ($(target).attr('form_type')) {
      $(target).prev().last().find('.select2').select2({
        placeholder: 'Select an option',
      });

      $(this)
        .find('.sub-attribute')
        .wrapAll(
          $(
            '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper"></div>'
          )
        );

      $(target)
        .prev('.subelement')
        .children('.wrapped-child-body')
        .last()
        .find('.sub-attribute')
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
    dynamicField.aidTypeVocabularyHideField();
    dynamicField.sectorVocabularyHideField();
  }

  // adds parent collection
  public addParentForm(ev: Event): void {
    ev.preventDefault();
    const target = ev.target as EventTarget;
    const container = $(target).attr('form_type')
      ? $(`.parent-collection[form_type ='${$(target).attr('form_type')}']`)
      : $('.parent-collection');

    const count = $(target).attr('parent_count')
      ? parseInt($(target).attr('parent_count') as string) + 1
      : ($(target).prev().find('.multi-form').length ? $(target).prev().find('.multi-form').length : $(target).prev().find('.wrapped-child-body').length) + 1;

    let proto = container.data('prototype').replace(/__PARENT_NAME__/g, count);
    proto = proto.replace(/__NAME__/g, 0);

    $(target).prev().append($(proto));
    $(target).prev().find('.multi-form').last().find('.select2').select2({
      placeholder: 'Select an option',
    });
    $(target)
      .prev()
      .find('.multi-form')
      .last()
      .find('.add_to_collection')
      .attr('parent_count', count);

    this.addWrapperOnAdd(target);

    $(target).attr('parent_count', count);

    dynamicField.humanitarianScopeHideVocabularyUri();
    dynamicField.countryBudgetHideCodeField();
    dynamicField.sectorVocabularyHideField();
    dynamicField.recipientVocabularyHideField();
    dynamicField.policyVocabularyHideField();
    dynamicField.tagVocabularyHideField();
    dynamicField.transactionAidTypeVocabularyHideField();
    dynamicField.indicatorReferenceHideFieldUri();
  }

  // deletes collection
  public deleteForm(ev: Event): void {
    ev.preventDefault();
    const target = ev.target as EventTarget;
    const collectionLength = $('.multi-form').length
      ? $(target).closest('.subelement').find('.form-child-body').length
      : $('.form-child-body').length;
    const count = $('.add_to_collection').attr('child_count')
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
    const target = ev.target as EventTarget;
    const collectionLength = $('.subelement').length;
    const count = $('.add_to_parent').attr('child_count')
      ? parseInt($('.add_to_parent').attr('child_count') as string) + 1
      : collectionLength;
    $('.add_to_parent').attr('child_count', count);
    $('.add_to_parent').attr('parent_count', count);

    if (collectionLength > 2) {
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
            '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 attribute-wrapper mb-4"></div>'
          )
        );
    });

    $('.subelement')
      .find('.wrapped-child-body')
      .each(function () {
        $(this)
          .find('.sub-attribute')
          .wrapAll(
            $(
              '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper mb-4"></div>'
            )
          );
      });
  }

  public addWrapperOnAdd(target: EventTarget): void {
    $(target)
      .prev()
      .find('.multi-form')
      .last()
      .find('.attribute')
      .wrapAll(
        $(
          '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 attribute-wrapper mb-4"></div>'
        )
      );

    $(target)
      .prev()
      .find('.multi-form')
      .last()
      .find('.subelement')
      .find('.wrapped-child-body')
      .each(function () {
        $(this)
          .find('.sub-attribute')
          .wrapAll(
            $(
              '<div class="form-field-group flex flex-wrap rounded-br-lg border-y border-r border-spring-50 sub-attribute-wrapper mb-4"></div>'
            )
          );
      });
  }

  public textAreaHeight(ev: Event) {
    const target = ev.target as HTMLElement;
    const height = target.scrollHeight;
    $(target).css('height', height);
  }

  public addToCollection() {
    $('body').on('click', '.add_to_collection', (event: Event) => {
      this.addForm(event);
    });

    $('.add_to_parent').on('click', (event: Event) => {
      this.addParentForm(event);
    });
  }

  public deleteCollection() {
    const deleteConfirmation = $('.delete-confirmation'),
      cancelPopup = '.cancel-popup',
      deleteConfirm = '.delete-confirm';
    let deleteIndex = {},
      childOrParent = '';

    $('body').on('click', '.delete', (event: Event) => {
      deleteConfirmation.fadeIn();
      deleteIndex = event;
      childOrParent = 'child';
    });

    $('body').on('click', cancelPopup, () => {
      deleteConfirmation.fadeOut();
      deleteIndex = {};
      childOrParent = '';
    });

    $('body').on('click', deleteConfirm, () => {
      if (childOrParent === 'child') {
        this.deleteForm(deleteIndex as Event);
      } else if (childOrParent === 'parent') {
        this.deleteParentForm(deleteIndex as Event);
      }

      deleteConfirmation.fadeOut();
      deleteIndex = {};
      childOrParent = '';
    });

    $('body').on('click', '.delete-parent', (event: Event) => {
      deleteConfirmation.fadeIn();
      deleteIndex = event;
      childOrParent = 'parent';
    });

    $('.select2').select2({
      placeholder: 'Select an option',
      allowClear: true,
    });

    $('body').on('change', 'input[id*="[document]"]', function () {
      const endpoint = $('.endpoint').attr('endpoint') ?? '';
      const file_name = ($(this).val() ?? '').toString();
      $(this)
        .closest('.form-field-group')
        .find('input[id*="[url]"]')
        .val(`${endpoint}/${file_name?.split('\\').pop()?.replace(' ', '_')}`);
    });
  }
}

$(function () {
  const formBuilder = new FormBuilder();
  formBuilder.addWrapper();
  dynamicField.hideShowFormFields();
  dynamicField.updateActivityIdentifier();
  formBuilder.addToCollection();
  formBuilder.deleteCollection();

  /**
   * Text area height on typing
   */
  const textAreaTarget = $('textarea.form__input');
  if (textAreaTarget.length > 0) {
    $('body').on('input', 'textarea.form__input', (event: Event) => {
      formBuilder.textAreaHeight(event);
    });
  }

  $('body').on('select2:open', '.select2', () => {
    const select_search = document.querySelector('.select2-search__field') as HTMLElement;

    if (select_search) {
      select_search.focus();
    }
  })

  /**
   * checks registration agency, country and registration number to deduce identifier
   */
  updateRegistrationAgency($('#organization_country'));
  console.log($('#organisation_identifier'));
  $('#organisation_identifier').attr('disabled', 'disabled');

  function updateRegistrationAgency(country: JQuery){
     if(country.val()){
      $.ajax({ url: '/organisation/agency/' + country.val() })
      .then((response) => {
        const current_val = $('#organization_registration_agency').val()??'';
        let val = false;

        $('#organization_registration_agency').empty();

        for (const data in response.data) {
          if(data===current_val){
            val=true;
          }

          $('#organization_registration_agency').append(new Option(response.data[data], data, true, true)).val('').trigger('change');
        }

        $('#organization_registration_agency').val(val?current_val:'').trigger('change');
      });
    }
  }

  $('body').on('select2:select', '#organization_country', function () {
    updateRegistrationAgency($(this));
  })

  $('body').on('select2:select', '#organization_registration_agency', function () {
    const identifier = $(this).val() + '-' + $('#registration_number').val();
    $('#organisation_identifier').val(identifier);
  })

  $('body').on('select2:clear', '#organization_registration_agency', function () {
    const identifier = '-' + $('#registration_number').val();
    $('#organisation_identifier').val(identifier);
  })

  $('body').on('keyup', '#registration_number', function () {
    const identifier = $('#organization_registration_agency').val() + '-' + $(this).val();
    $('#organisation_identifier').val(identifier);
  })

});
