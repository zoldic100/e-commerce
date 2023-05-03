$(function() {
  'use strict';


});
  // hide placeholder on form focus
  $('[placeholder]').on({
    focus: function() {
      $(this).data('text', $(this).attr('placeholder'));
      $(this).attr('placeholder', '');
    },
    blur: function() {
      $(this).attr('placeholder', $(this).data('text'));
    }
  });

$('input').each(function() {
  if($(this).prop('required')){
    $(this).after('<span class="asterisk">*</span>')
  }
});


$(".confirm").click(function() {
  return confirm("Are you sure you want to delete this item?")

});