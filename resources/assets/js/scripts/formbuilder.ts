import $ from 'jquery';
import 'select2';

class FormBuilder {

  // add new collection
  public addForm(ev: Event): void {
    ev.preventDefault();
    let target = ev.target as EventTarget;
    let container = $('.collection-container');
    let count = $(target).attr('child_count') ? parseInt($(target).attr('child_count') as string)+1 : $(target).parent().find('.form-child-body').length;
    let parent_count = $(target).attr('parent_count') ? parseInt($(target).attr('parent_count') as string) :0;
    let proto = container.data('prototype').replace(/__PARENT_NAME__/g, parent_count);
    proto = proto.replace(/__NAME__/g, count);
    $(target).prev().append($(proto));

    $(target).parent().find('.form-child-body').last().find('.select2').select2({
      placeholder: 'Select an option',
    });
    $(target).attr('child_count', count);
  }

    // add parent collection
    public addParentForm(ev: Event): void {
      ev.preventDefault();
      let target = ev.target as EventTarget;
      let container = $('.parent-collection');
      let count = $(target).attr('child_count') ? parseInt($(target).attr('child_count') as string) + 1 : $('.multi-form').length;
      let proto = container.data('prototype').replace(/__PARENT_NAME__/g, count);
      proto = proto.replace(/__NAME__/g, 0);
      $('.multi-form').last().after($(proto));
      $('.multi-form').last().find('.select2').select2({
        placeholder:'Select an option',
      });
      $('.multi-form').last().find('.add_to_collection').attr('parent_count', count);
      $(target).attr('child_count', count);
    }

  // delete collection
  public deleteForm(ev: Event): void {
    ev.preventDefault();
    let target = ev.target as EventTarget;
    let collectionLength = $('.multi-form').length ? $(target).closest('.subelement').find('.form-child-body').length : $('.form-child-body').length;
    let count = $('.add_to_collection').attr('child_count') ? parseInt($('.add_to_collection').attr('child_count') as string)+1 : collectionLength;
    $('.add_to_collection').attr('child_count', count);

    if(collectionLength > 1) {
      $(target).closest('.form-child-body').remove();
    }
  }

  // delete parent collection
  public deleteParentForm(ev: Event): void {
    ev.preventDefault();
    let target = ev.target as EventTarget;
    let collectionLength = $('.subelement').length;
    let count = $('.add_to_parent').attr('child_count') ? parseInt($('.add_to_parent').attr('child_count') as string)+1 : collectionLength;
    $('.add_to_parent').attr('child_count', count);

    if(collectionLength > 2) {
      console.log($(target).parent());
      $(target).parent().remove();
    }
  }
}

$(document).ready(() => {
  let formBuilder = new FormBuilder();
  $('body').on('click', '.add_to_collection', (event: Event) => { formBuilder.addForm(event) });
  $('.add_to_parent').on('click', (event: Event) => { formBuilder.addParentForm(event) });
  $('body').on('click','.delete', (event: Event) => { formBuilder.deleteForm(event) });
  $('body').on('click','.delete-parent', (event: Event) => { formBuilder.deleteParentForm(event) });
});
