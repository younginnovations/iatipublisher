import axios from 'axios';
import $ from 'jquery';
import 'select2';
import { DynamicField } from './DynamicField';

const dynamicField = new DynamicField();
class FormBuilder {
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
      : $(target).parents('.multi-form').index() - 1;

    const wrapper_parent_count = $(target).attr('wrapped_parent_count')
      ? parseInt($(target).attr('wrapped_parent_count') as string)
      : $(target).parents('.wrapped-child-body').index() - 1;

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
        allowClear: true,
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
          allowClear: true,
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
      : ($(target).prev().find('.multi-form').length
          ? $(target).prev().find('.multi-form').length
          : $(target).prev().find('.wrapped-child-body').length) + 1;

    let proto = container.data('prototype').replace(/__PARENT_NAME__/g, count);
    proto = proto.replace(/__NAME__/g, 0);

    $(target).prev().append($(proto));
    $(target).prev().find('.multi-form').last().find('.select2').select2({
      placeholder: 'Select an option',
      allowClear: true,
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
      const tg = $(target).closest('.form-child-body');
      tg.next('.error').remove();
      tg.remove();
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

    const formField = $('form>.form-field');

    if (formField.length > 0) {
      formField.wrapAll(
        '<div class="form-field-group-outer grid xl:grid-cols-2 mb-6 -mx-3 gap-y-6"></div>'
      );
    }
  }

  public addWrapperOnAdd(target: EventTarget): void {
    $(target)
      .prev()
      .find('.multi-form')
      .last()
      .find('.attribute')
      .wrapAll(
        $(
          '<div class="form-field-group grid xl:grid-cols-2 rounded-br-lg border-y border-r border-spring-50 attribute-wrapper mb-4"></div>'
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
      if ($(event.target as EventTarget).hasClass('add-icon')) {
        event.stopPropagation();
        $(event.target as EventTarget)
          .parent('button')
          .trigger('click');
      } else {
        this.addForm(event);
      }
    });

    $('.add_to_parent').on('click', (event: Event) => {
      if ($(event.target as EventTarget).hasClass('add-icon')) {
        event.stopPropagation();
        $(event.target as EventTarget)
          .parent('button')
          .trigger('click');
      } else {
        this.addParentForm(event);
      }
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

    // update format on change of document link
    $('body').on('change', 'input[id*="[url]"]', function () {
      const filePath = ($(this).val() ?? '').toString();
      const document = $(this)
        .closest('.form-field-group')
        .find('input[id*="[document]"]')
        .val();
      const url = `/mimetype?url=${filePath}&type=url`;
      $(this).closest('.form-field').find('.text-danger').remove();

      if (filePath !== '') {
        axios.get(url).then((response) => {
          if (response.data.success) {
            const format = response.data.data.mimetype;
            $(this)
              .closest('.form-field-group')
              .find('select[id*="[format]"]')
              .val(format)
              .trigger('change');
          } else {
            $(this).closest('.form-field').find('.text-danger').remove();
            $(this)
              .closest('.form-field')
              .append(
                "<div class='text-danger error'>" +
                  response.data.message +
                  '</div>'
              );

            $(this)
              .closest('.form-field-group')
              .find('select[id*="[format]"]')
              .val('')
              .trigger('change');
          }
          $(this)
            .closest('.form-field-group')
            .find('input[id*="[document]"]')
            .val('')
            .trigger('change');
        });
      } else if (!document || document === '') {
        $(this)
          .closest('.form-field-group')
          .find('select[id*="[format]"]')
          .val('')
          .trigger('change');
      }
    });

    $('body').on('change', 'input[id*="[document]"]', function () {
      const filePath = ($(this).val() ?? '').toString();
      const url = `/mimetype?url=${filePath}&&type=document`;
      const fileUrl = $(this)
        .closest('.form-field-group')
        .find('input[id*="[url]"]')
        .val();

      $(this).closest('.form-field').find('.text-danger').remove();

      if (filePath !== '') {
        axios.get(url).then((response) => {
          if (response.data.success) {
            const format = response.data.data.mimetype;
            $(this)
              .closest('.form-field-group')
              .find('select[id*="[format]"]')
              .val(format)
              .trigger('change');
          } else {
            $(this)
              .closest('.form-field-group')
              .find('select[id*="[format]"]')
              .val('')
              .trigger('change');
          }
        });
        $(this)
          .closest('.form-field-group')
          .find('input[id*="[url]"]')
          .val('')
          .trigger('change');
      } else if (!fileUrl || fileUrl === '') {
        $(this)
          .closest('.form-field-group')
          .find('select[id*="[format]"]')
          .val('')
          .trigger('change');
      }
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
    const select_search = document.querySelector(
      '.select2-search__field'
    ) as HTMLElement;

    if (select_search) {
      select_search.focus();
    }
  });

  /**
   * checks registration agency, country and registration number to deduce identifier
   */
  updateRegistrationAgency($('#organization_country'));
  $('#organisation_identifier').attr('disabled', 'disabled');

  function updateRegistrationAgency(country: JQuery) {
    const endpoint = country.val()
      ? '/organisation/agency/' + country.val()
      : '/organisation/agency/';
    $.ajax({ url: endpoint }).then((response) => {
      const current_val = $('#organization_registration_agency').val() ?? '';
      let val = false;

      $('#organization_registration_agency').empty();

      for (const data in response.data) {
        if (data === current_val) {
          val = true;
        }

        $('#organization_registration_agency')
          .append(new Option(response.data[data], data, true, true))
          .val('')
          .trigger('change');
      }

      $('#organization_registration_agency')
        .val(val ? current_val : '')
        .trigger('change');
    });
  }

  $('body').on('select2:select', '#organization_country', function () {
    updateRegistrationAgency($(this));
  });
  $('body').on('select2:clear', '#organization_country', function () {
    updateRegistrationAgency($(this));
  });

  $('body').on(
    'select2:select',
    '#organization_registration_agency',
    function () {
      const identifier = $(this).val() + '-' + $('#registration_number').val();
      $('#organisation_identifier').val(identifier);
    }
  );

  $('body').on(
    'select2:clear',
    '#organization_registration_agency',
    function () {
      const identifier = '-' + $('#registration_number').val();
      $('#organisation_identifier').val(identifier);
    }
  );

  $('body').on('keyup', '#registration_number', function () {
    const identifier =
      $('#organization_registration_agency').val() + '-' + $(this).val();
    $('#organisation_identifier').val(identifier);
  });

  // add class to title of collection when validation error occurs on collection level
  const subelement = document.querySelectorAll('.subelement');

  for (let i = 0; i < subelement.length; i++) {
    const title = subelement[i].querySelector('.control-label');
    const errorContainer = subelement[i].querySelector('.collection_error');
    const childCount = errorContainer?.childElementCount;

    if (childCount && childCount > 0) {
      title?.classList.add('error-title');
    }
  }

  // Adding cursor not allowed to <select> where elementJsonSchema read_only : true
  const readOnlySelects = document.querySelectorAll(
    'select.cursor-not-allowed'
  );
  for (let i = 0; i < readOnlySelects.length; i++) {
    const select = readOnlySelects[i];
    const selectElementParentWrapper = select.nextSibling;
    const selectElementParent = selectElementParentWrapper?.firstChild;
    const selectElement = selectElementParent?.firstChild as HTMLElement;
    if (selectElement) {
      selectElement.style.cursor = 'not-allowed';
    }
  }

  /**
   * Change Source: https://github.com/younginnovations/iatipublisher/issues/1501
   *
   * Basically I'm adding expandable behaviour to form
   */

  // interface AddButtonInfo {
  //   dom: HTMLElement | null;
  //   relation: string;
  // }
  // function handleInitialFormLoad() {
  //   const allCollapsable = document.querySelectorAll('.collapsable');
  //   allCollapsable.forEach((element) => {
  //     const htmlElement = element as HTMLElement;
  //     const buttonInfo = getButtonInfo(htmlElement);
  //     const hideButton = renderHideButton(htmlElement, buttonInfo);
  //
  //     /** Click hide button if all values in this collapsable item is empty*/
  //     if (!hasNonEmptyFields(htmlElement)) {
  //       hideButton.click();
  //     }
  //   });
  // }
  //
  // function hasNonEmptyFields(element: HTMLElement): boolean {
  //   // Check if any input, select, or textarea inside the element has a value
  //   const inputs = element.querySelectorAll('input, select, textarea');
  //   return Array.from(inputs).some((input) => {
  //     if (
  //       input instanceof HTMLInputElement ||
  //       input instanceof HTMLSelectElement ||
  //       input instanceof HTMLTextAreaElement
  //     ) {
  //       return input.value.trim() !== '';
  //     }
  //     return false;
  //   });
  // }
  //
  // function handleNewAdditionsToFormViaMutatorsAndObservers() {
  //   const observer = new MutationObserver((mutationsList) => {
  //     for (const mutation of mutationsList) {
  //       if (mutation.type === 'childList') {
  //         const addedNodes = Array.from(mutation.addedNodes);
  //
  //         addedNodes.forEach((node) => {
  //           // Check if the added node is an HTMLElement
  //           if (node instanceof HTMLElement) {
  //             node.querySelectorAll('.collapsable').forEach((element) => {
  //               const htmlElement = element as HTMLElement;
  //               const buttonInfo = getButtonInfo(htmlElement);
  //               renderHideButton(htmlElement, buttonInfo);
  //             });
  //
  //             const newCollapseButtons = node.querySelectorAll(
  //               '.collapsable-hide-button'
  //             );
  //             newCollapseButtons.forEach((button) => {
  //               const buttonElement = button as HTMLElement;
  //               buttonElement.click();
  //             });
  //           }
  //         });
  //       }
  //     }
  //   });
  //
  //   observer.observe(document.body, { childList: true, subtree: true });
  // }
  //
  // function getButtonInfo(collapsableItem: HTMLElement): AddButtonInfo {
  //   let addButton = collapsableItem.nextElementSibling as HTMLElement | null;
  //
  //   if (addButton && addButton.tagName.toLowerCase() === 'button') {
  //     return { dom: addButton, relation: 'sibling' };
  //   }
  //
  //   addButton = collapsableItem.querySelector(
  //     'button.add_more'
  //   ) as HTMLElement | null;
  //
  //   if (addButton) {
  //     return { dom: addButton, relation: 'child' };
  //   }
  //
  //   return { dom: null, relation: 'none' };
  // }
  //
  // function renderHideButton(
  //   collapsableItem: HTMLElement,
  //   buttonInfo: AddButtonInfo
  // ) {
  //   const hideButton = document.createElement('button');
  //   hideButton.className =
  //     'absolute top-0 right-0 bg-spring-50 text-white px-2 collapsable-hide-button';
  //   hideButton.textContent = 'Hide';
  //   hideButton.setAttribute('type', 'button');
  //
  //   const handleHideButtonClick = () => {
  //     hideElement(hideButtonHolder);
  //     hideElement(buttonInfo.dom);
  //     renderPlaceholderCard(collapsableItem, buttonInfo);
  //   };
  //
  //   let hideButtonHolder: HTMLElement | null = null;
  //
  //   if (buttonInfo.dom === null) {
  //     hideButtonHolder = Array.from(collapsableItem.children).find(
  //       (child) => child.tagName === 'DIV'
  //     ) as HTMLElement;
  //   } else if (buttonInfo.relation === 'child') {
  //     hideButtonHolder = buttonInfo.dom.parentElement;
  //   } else {
  //     const previousSibling = buttonInfo.dom
  //       .previousElementSibling as HTMLElement;
  //     hideButtonHolder = Array.from(previousSibling?.children || []).find(
  //       (child) => child.tagName === 'DIV'
  //     ) as HTMLElement;
  //
  //     if (hideButtonHolder) {
  //       hideButton.addEventListener('click', () => {
  //         Array.from(previousSibling.children).forEach((child) => {
  //           if (
  //             child.tagName !== 'LABEL' &&
  //             !child.classList.contains('collapsable-placeholder')
  //           ) {
  //             hideElement(child as HTMLElement);
  //           }
  //         });
  //         hideElement(buttonInfo.dom);
  //       });
  //     }
  //   }
  //
  //   if (hideButtonHolder) {
  //     hideButtonHolder.classList.add('relative');
  //     hideButton.addEventListener('click', handleHideButtonClick);
  //     hideButtonHolder.appendChild(hideButton);
  //   }
  //
  //   return hideButton;
  // }
  //
  // function renderPlaceholderCard(
  //   collapsableItem: HTMLElement,
  //   buttonInfo: AddButtonInfo
  // ): void {
  //   const placeholderDiv = createPlaceholderDiv();
  //
  //   const displayName = getDisplayName(collapsableItem, buttonInfo);
  //   placeholderDiv.innerHTML = `You can expand the optional <strong>${displayName}</strong> field by clicking here.`;
  //
  //   if (buttonInfo.dom === null) {
  //     handleNoButtonInfo(collapsableItem, placeholderDiv);
  //   } else if (buttonInfo.relation === 'child') {
  //     handleChildRelation(collapsableItem, placeholderDiv);
  //   } else {
  //     handleSiblingRelation(collapsableItem, buttonInfo, placeholderDiv);
  //   }
  //
  //   collapsableItem.appendChild(placeholderDiv);
  // }
  //
  // function createPlaceholderDiv(): HTMLDivElement {
  //   const placeholderDiv = document.createElement('div');
  //   placeholderDiv.classList.add(
  //     'border-x',
  //     'border-y',
  //     'border-spring-50',
  //     'px-6',
  //     'py-6',
  //     'text-sm',
  //     'text-n-40',
  //     'cursor-pointer',
  //     'collapsable-placeholder'
  //   );
  //   return placeholderDiv;
  // }
  //
  // function getDisplayName(
  //   collapsableItem: HTMLElement,
  //   buttonInfo: AddButtonInfo
  // ): string {
  //   const displayNameLabel = buttonInfo.dom
  //     ? buttonInfo.dom.previousElementSibling?.querySelector('label')
  //     : collapsableItem.querySelector('label');
  //   const displayName = displayNameLabel?.innerText ?? 'element';
  //   return getFirstWordFromText(displayName);
  // }
  //
  // function handleNoButtonInfo(
  //   collapsableItem: HTMLElement,
  //   placeholderDiv: HTMLDivElement
  // ): void {
  //   adjustBorders(collapsableItem, 'border-l');
  //   adjustPadding(collapsableItem, 'pb-11');
  //   addPlaceholderClickListener(collapsableItem, placeholderDiv);
  // }
  //
  // function handleChildRelation(
  //   collapsableItem: HTMLElement,
  //   placeholderDiv: HTMLDivElement
  // ): void {
  //   adjustBorders(collapsableItem, 'border-l');
  //   adjustPadding(collapsableItem, 'pb-11');
  //   addPlaceholderClickListener(collapsableItem, placeholderDiv);
  // }
  //
  // function handleSiblingRelation(
  //   collapsableItem: HTMLElement,
  //   buttonInfo: AddButtonInfo,
  //   placeholderDiv: HTMLDivElement
  // ): void {
  //   placeholderDiv.classList.add('mb-6');
  //   buttonInfo.dom?.classList.add('mb-6');
  //   adjustBorders(collapsableItem, 'border-l');
  //   adjustPadding(collapsableItem, 'pb-11');
  //   addPlaceholderClickListener(collapsableItem, placeholderDiv, buttonInfo);
  // }
  //
  // function adjustBorders(
  //   collapsableItem: HTMLElement,
  //   borderClass: string
  // ): void {
  //   if (collapsableItem.classList.contains(borderClass)) {
  //     console.log('here', collapsableItem);
  //     collapsableItem.classList.add(`${borderClass}-was-here`);
  //     collapsableItem.classList.remove(borderClass);
  //   } else {
  //     console.log('maru', collapsableItem);
  //   }
  // }
  //
  // function adjustPadding(
  //   collapsableItem: HTMLElement,
  //   paddingClass: string
  // ): void {
  //   if (collapsableItem.classList.contains(paddingClass)) {
  //     collapsableItem.classList.add(`${paddingClass}-was-here`);
  //     collapsableItem.classList.remove(paddingClass);
  //   }
  // }
  //
  // function addPlaceholderClickListener(
  //   collapsableItem: HTMLElement,
  //   placeholderDiv: HTMLDivElement,
  //   buttonInfo?: AddButtonInfo
  // ): void {
  //   placeholderDiv.addEventListener('click', () => {
  //     if (collapsableItem.classList.contains('border-l-was-here')) {
  //       collapsableItem.classList.add('border-l');
  //       collapsableItem.classList.remove('border-l-was-here');
  //     }
  //
  //     if (collapsableItem.classList.contains('pb-11-was-here')) {
  //       collapsableItem.classList.add('pb-11');
  //       collapsableItem.classList.remove('pb-11-was-here');
  //     }
  //
  //     revealHiddenElements(collapsableItem);
  //     if (buttonInfo?.dom) {
  //       buttonInfo.dom.classList.remove('collapsable-hide');
  //     }
  //     removeElement(placeholderDiv);
  //   });
  // }
  //
  // function getFirstWordFromText(text): string {
  //   const trimmedText = text.trim();
  //   const words = trimmedText.split(/\s+/);
  //
  //   return words[0];
  // }
  //
  // function revealHiddenElements(collapsableItem: HTMLElement): void {
  //   collapsableItem.querySelectorAll('.collapsable-hide').forEach((element) => {
  //     (element as HTMLElement).classList.remove('collapsable-hide');
  //   });
  // }
  //
  // function hideElement(element: HTMLElement | null) {
  //   element?.classList?.add('collapsable-hide');
  // }
  //
  // function removeElement(element: HTMLElement) {
  //   element.remove();
  // }

  // handleInitialFormLoad();
  // handleNewAdditionsToFormViaMutatorsAndObservers();
});
