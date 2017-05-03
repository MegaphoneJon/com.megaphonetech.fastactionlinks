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
   * Add the tag with id of actionEntityId to the user with cid of "entityId".
   * @param array $falData has elements entityId and actionEntityId
   * @return array $result
   */
  public static function addEntityTag($falData) {
    $params = array(
      'entity_id' => $falData['entityId'],
      'tag_id' => $falData['actionEntityId'],
    );
    try {
      $result = civicrm_api3('EntityTag', 'create', $params);
    } catch (Exception $e) {
      $result['is_error'] = 1;
      $result['error_message'] = $e->getMessage();
      // Give a more useful error when the error is "Unable to remove tags".
      if ($result['error_message'] == 'Unable to add tags') {
        $result['error_message'] = ts("Unable to add tag. Most likely this contact already has that tag.");
      }
    }
    return $result;
  }

  /**
   * Delete the EntityTag with a tag id of actionEntityId and the user with
   * cid of "entityId".
   *
   * @param array $falData has elements entityId and actionEntityId
   * @return array $result
   */
  public static function removeEntityTag($falData) {
    $params = array(
      'entity_id' => $falData['entityId'],
      'tag_id' => $falData['actionEntityId'],
      'entity_table' => "civicrm_contact",
    );
    try {
      $result = civicrm_api3('EntityTag', 'delete', $params);
    } catch (Exception $e) {
      $result['is_error'] = 1;
      $result['error_message'] = $e->getMessage();
      // Give a more useful error when the error is "Unable to remove tags".
      if ($result['error_message'] == 'Unable to remove tags') {
        $result['error_message'] = ts("Unable to remove tag. Most likely this contact doesn't have that tag.");
      }
    }
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
