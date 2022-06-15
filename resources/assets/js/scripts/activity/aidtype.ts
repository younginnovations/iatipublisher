import $ from 'jquery';
import 'select2';

class DynamicSelect {

  // add new collection
  public updateSelect(ev: Event): void {
    console.log('selected');
  }
}

$(document).ready(() => {
  console.log('hi');
   $(document).on('select2:select', '#vocabulary', function (event) {
   console.log('inside select');
  });
  console.log('event');
  $('#vocabulary').on('change', (event: Event) => {
    console.log('change');
  });
  $('#vocabulary').on('focus', (event: Event) => {
    console.log('focus');
  });
  $(document).on('focus', '.select2', function (e) {
    console.log('hi hello select2');
  });
  $(document).on('selecting', '.select2', function (e) {
    console.log('change');
  });
  let formBuilder = new DynamicSelect();
});
