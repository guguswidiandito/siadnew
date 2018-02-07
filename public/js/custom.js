$(document).ready(function () {
$(document.body).on('click', '.js-submit-confirm', function (event) {
event.preventDefault()
var $form = $(this).closest('form')
var $el = $(this)
var text = $el.data('confirm-message') ? $el.data('confirm-message') : "You can't cancel this process!"
swal({
title: 'Are you sure?',
text: text,
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#DD6B55',
confirmButtonText: 'Yes',
cancelButtonText: 'Cancel',
closeOnConfirm: true
},
function () {
$form.submit()
});
});
});