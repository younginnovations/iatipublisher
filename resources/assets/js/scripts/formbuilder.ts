import $ from 'jquery';

class FormBuilder {

  // add new collection
  public addForm(ev: Event): void {
    ev.preventDefault();
    var target = ev.target as EventTarget;
    var container = $('.collection-container');
    var count = $(target).attr('child_count') ? parseInt($(target).attr('child_count') as string) + 1 : $('.form-child-body').length+1;
    var proto = container.data('prototype').replace(/__NAME__/g, count);
    $('.form-child-body').last().after($(proto));
    $('.add_to_collection').attr('child_count', count);
  }

  // delete collection
  public deleteForm(ev: Event): void {
    ev.preventDefault();
    var target = ev.target as EventTarget;
    var collectionLength = $('.form-child-body').length;
    var count = $(target).attr('child_count') ? parseInt($(target).attr('child_count') as string)+1 : collectionLength;
    $('.add_to_collection').attr('child_count', count);

    if(collectionLength > 1) {
      $(target).closest('.form-child-body').remove();
    }
  }
}

$(document).ready(() => {
  let formBuilder = new FormBuilder();
  $('.add_to_collection').on('click', (event: Event) => { formBuilder.addForm(event) });
  $('body').on('click','.delete', (event: Event) => { formBuilder.deleteForm(event) });
});
