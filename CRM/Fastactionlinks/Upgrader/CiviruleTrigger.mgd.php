<?php
// Create a CiviRuleTrigger for fast action links if CiviRules is installed.
if (CRM_Fastactionlinks_Util::isCivirulesInstalled()) {
  return array(
    0 =>
    array(
      'name' => 'fastactionlinks_civirule_trigger',
      'entity' => 'CiviRuleTrigger',
      'params' =>
      array(
        'version' => 3,
        'name' => 'fast_action_link',
        'label' => 'Fast Action Link',
        'class_name' => 'CRM_Fastactionlinks_Trigger_Manual',
        'is_active' => 1
      ),
    ),
  );
}
 else {
  return array();
}
