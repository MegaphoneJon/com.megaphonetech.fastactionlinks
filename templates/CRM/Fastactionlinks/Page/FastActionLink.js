CRM.$(function ($) {
  displayActionEntity();
  $('#action_type').change(function () {
    CRM.$('#action_entity_id').val("");
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
  params = {'action_type': action_type};
  entity = CRM.api3('FastActionLink', 'getaction', params)
    .done(function (result) {
      if (result.is_error) {
        CRM.$('#action_entity_id').parent().parent().hide();
      } else {
        entityLabel = ts("Select a") + " " + ts(result.entityLabel);
        CRM.$("label[for='action_entity_id']").html(entityLabel);

        CRM.$('#action_entity_id').crmEntityRef({
          entity: result.entityName,
          placeholder: entityLabel,
          create: false,
          select: {'minimumInputLength': 0, 'width': 'resolve'},
          api: {params: result.apiParams},
        });
        CRM.$('#action_entity_id').parent().parent().show();
      }

    });

}
