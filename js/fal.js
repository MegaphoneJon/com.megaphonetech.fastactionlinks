CRM.$(function ($) {
  $('.fast-action-link').off().click(function () {

    link = $(this)[0];
    // Show a confirmation dialog if appropriate
    if ($(this).hasClass('fast-action-link-confirm')) {
    CRM.confirm(ts('Are you sure you want to take this action?'))
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

/*
 * Make an API call to FastActionLink.execute and update search results with
 * notifications and/or dimming the search result.
 */
function execute(link) {
  var falId = link.getAttribute('falid');
  var entityId = link.getAttribute('entityid');
  var params = {"id": falId, "entity_id": entityId};
  CRM.api3('FastActionLink', 'execute', params)
    .done(function (result) {
      if (result.is_error) {
        CRM.alert(result.error_message, "", "error");
      } else {
        if (result.url) {
          window.open(result.url);
        }
        if (!result.success_message) {
          result.success_message = ts('Action was successful');
        }
        CRM.alert(result.success_message, "", "success");
        if (result.dim_on_use == 1) {
          CRM.$(link).parents('tr').addClass('disabled');
        }
      }
    });
}
