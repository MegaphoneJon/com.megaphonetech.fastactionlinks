CRM.$(function ($) {
  $('.fast-action-link').click(function () {

    var falId = $(this)[0].getAttribute('falid');
    var entityId = $(this)[0].getAttribute('entityid');
    var params = {"id": falId, "entity_id": entityId};
    // Show a confirmation dialog if appropriate
    if ($(this).hasClass('fast-action-link-confirm')) {
    CRM.confirm("Are you sure you want to take this action?")
      .on('crmConfirm:yes', function () {
        execute(falId, entityId, params)
        });
    } else {
      execute(falId, entityId, params);
    }
    // Suppress the link-following behavior
    return false;
  });
});

function execute(falId, entityId, params) {
  CRM.api3('FastActionLink', 'execute', params).done(function (result) {
    CRM.alert(result.success_message, "", "success");
    console.log(result);
  });
}