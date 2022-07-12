import $ from 'jquery';
import 'select2';


$(document).ready(() => {
  console.log('hi');
   $(document).on('select2:select', '#vocabulary', function () {
   console.log('inside select');
  });
  console.log('event');
  $('#vocabulary').on('change', () => {
    console.log('change');
  });
  $('#vocabulary').on('focus', () => {
    console.log('focus');
  });
  $(document).on('focus', '.select2', function () {
    console.log('hi hello select2');
  });
  $(document).on('selecting', '.select2', function () {
    console.log('change');
  });
});
