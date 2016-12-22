<?php

class CRM_Fastactionlinks_BAO_FastActionLink extends CRM_Fastactionlinks_DAO_FastActionLink {

  /**
   * Create a new FastActionLink based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Fastactionlinks_DAO_FastActionLink|NULL
   *
  public static function create($params) {
    $className = 'CRM_Fastactionlinks_DAO_FastActionLink';
    $entityName = 'FastActionLink';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */
}
