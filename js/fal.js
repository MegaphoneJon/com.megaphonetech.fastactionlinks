CRM.$(function ($) {
  $('.fast-action-link').click(function () {
    // Suppress the link-following behavior
    var falId = $(this)[0].getAttribute('falid');
    var entityId = $(this)[0].getAttribute('entityid');
    var params = {"id": falId, "entity_id": entityId};
    CRM.api3('FastActionLink', 'execute', params).done(function (result) {
      console.log(result);
    });
    return false;
  });
});
