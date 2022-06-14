class Select2 {
  initialize = (cmp, placeholder, allowClear = true) => {
    cmp.select2({
      placeholder: placeholder,
      minimumResultsForSearch: 7,
      width: '100%',
      allowClear: allowClear,
    });
  };
}

export default Select2;
