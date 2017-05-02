<?php

class CRM_Fastactionlinks_Action {

  /**
   * Add the user with cid of "entityId" to group with gid of "actionEntityId"
   * @param array $falData has elements entityId and actionEntityId
   * @return array $result
   */
  public static function addToGroup($falData) {
    $params = array(
      'contact_id' => $falData['entityId'],
      'group_id' => $falData['actionEntityId'],
    );
    $result = civicrm_api3('GroupContact', 'create', $params);
    return $result;
  }

  /**
   * Add the user with cid of "entityId" to group with gid of "actionEntityId"
   * @param array $falData has elements entityId and actionEntityId
   * @return array $result
   */
  public static function civirule($falData) {
    CRM_Civirules_Trigger_Manual::process($falData['actionEntityId'], $falData['entityId'], 'Contact');
    // TODO: FALs only support contacts for now.  Maybe we can change this.
    CRM_Core_Error::debug_var('civiruleParams', $falData);
    return $result;
  }

}
