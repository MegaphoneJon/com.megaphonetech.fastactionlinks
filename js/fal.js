CRM.$(function ($) {
  $('.fast-action-link').click(function () {

    link = $(this)[0];
    // Show a confirmation dialog if appropriate
    if ($(this).hasClass('fast-action-link-confirm')) {
    CRM.confirm("Are you sure you want to take this action?")
      .on('crmConfirm:yes', function () {
          execute(link);
        });
    } else {
      execute(link);
    }
    // Suppress the link-following behavior
    return false;
  });
});

function execute(link) {
  var falId = link.getAttribute('falid');
  var entityId = link.getAttribute('entityid');
  var params = {"id": falId, "entity_id": entityId};
  CRM.api3('FastActionLink', 'execute', params).done(function (result) {
    CRM.alert(result.success_message, "", "success");
    if (result.dim_on_use == 1) {
      CRM.$(link).parents('tr').addClass('disabled');
    }
  });
}