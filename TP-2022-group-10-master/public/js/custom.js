// TODO jquery validate i18n
$.validator.addMethod("exactlength", function (value, element, param) {
  return this.optional(element) || value.length == param;
}, $.validator.format("Please enter exactly {0} characters."));

$.validator.addMethod("time24", function (value, element) {
  if (!/^\d{2}:\d{2}$/.test(value)) return false;
  var parts = value.split(':');
  if (parts[0] > 23 || parts[1] > 59) return false;
  return true;
}, "Invalid time format.");


$(document).ready(function () {
  let options = {
    highlightClass: 'text-success'
  };

  $("[data-widget='sidebar-search']").SidebarSearch(options);
});
