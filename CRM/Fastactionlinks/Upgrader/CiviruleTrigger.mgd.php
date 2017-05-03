<?php

if (_fastactionlinks_is_civirules_installed()) {
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
        'op' => 'manual',
        'class_name' => 'CRM_Civirules_Trigger_Manual',
        'is_active' => 1
      ),
    ),
  );
}
 else {
  return array();
}
