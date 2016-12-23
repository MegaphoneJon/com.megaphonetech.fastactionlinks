<?php

class CRM_Fastactionlinks_BAO_FastActionLink extends CRM_Fastactionlinks_DAO_FastActionLink {

  /**
   * Create a new FastActionLink based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Fastactionlinks_DAO_FastActionLink|NULL
   *
   */
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
  }

  /**
   * Return an array of fast action links, filtered by profile ID.
   * No $profileId = return links for default search
   *
   * @param integer $profileId
   * @return array
   */
  public function getLinks($profileId) {
    $result = civicrm_api3('FastActionLink', 'get', array(
        'sequential' => 1,
        'uf_group_id' => $profileId,
    ));
    return $result;
  }

}
