CRM.$(function ($) {
  displayActionEntity();
  $('#action_type').change(function () {
    displayActionEntity();
  });

});

/**
 * Set up the display of the action_entity_id field.
 * Hide if this action doesn't use it; if it does, set the label correctly,
 *
 * @returns {undefined}
 */
function displayActionEntity() {
  action_type = CRM.$('#action_type').val();
  params = {'action': action_type};
  entity = CRM.api3('FastActionLink', 'getactionentity', params)
    .done(function (result) {
      if (result.is_error) {
        CRM.$('#action_entity_id').parent().parent().hide();
      } else {
        CRM.$("label[for='action_entity_id']").html("Select a " + result.result);
        CRM.$('#action_entity_id').val("");

        CRM.$('#action_entity_id').crmEntityRef({
          entity: result.result,
          create: false,
          select: {'minimumInputLength': 0},
        });
        CRM.$('#action_entity_id').parent().parent().show();
      }

    });

}