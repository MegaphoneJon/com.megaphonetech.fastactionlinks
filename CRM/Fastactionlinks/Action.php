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

}
