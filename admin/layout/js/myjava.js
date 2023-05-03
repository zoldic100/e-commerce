var input = document.querySelector('#tags');

new Tagify(input, {
  delimiters: ", ", // allow comma or space to trigger input separation
  placeholder: "Type and enter tags",
  dropdown: {
    maxItems: 20, // set maximum number of items in dropdown
    enabled: 0, // always show dropdown suggestions
    highlightFirst: true, // highlight first item in dropdown
  }
});
