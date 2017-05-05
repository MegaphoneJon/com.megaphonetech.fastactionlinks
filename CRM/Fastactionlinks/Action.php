<?php

class CRM_Fastactionlinks_Action {

  /**
   * An array of all the actions available.
   *
   * @var array
   */
  static $_actions;

  /**
   * Get the entity name that an action connects to.
   *
   * @param type $action
   * @return string
   */
  public static function getAction($action) {
    self::actions();
    return self::$_actions[$action];
  }

  public static function getActionLabels() {
    self::actions();
    $actions = array();
    foreach (self::$_actions as $key => $value) {
      $actions[$key] = $value['label'];
    }
    return $actions;
  }

  public static function actions() {
    if (!(self::$_actions)) {
      // Get the CiviRuleTrigger id for the Fast Action Link trigger.
      $triggerId = CRM_Fastactionlinks_BAO_Rule::getTriggerId();
      self::$_actions = array(
        'addToGroup' => array(
          'label' => ts('Add to Group'),
          'entityName' => 'Group',
          'entityLabel' => 'Group',
          'functionName' => 'CRM_Fastactionlinks_Action::addToGroup',
        ),
        'addEntityTag' => array(
          'label' => ts('Add a Tag'),
          'entityName' => 'Tag',
          'entityLabel' => 'Tag',
          'functionName' => 'CRM_Fastactionlinks_Action::addEntityTag',
        ),
        'removeEntityTag' => array(
          'label' => ts('Remove a Tag'),
          'entityName' => 'Tag',
          'entityLabel' => 'Tag',
          'functionName' => 'CRM_Fastactionlinks_Action::removeEntityTag',
        ),
        'civirule' => array(
          'label' => ts('Trigger a CiviRule'),
          'entityName' => 'CiviRuleRule',
          'entityLabel' => 'CiviRule',
          'apiParams' => array('trigger_id' => $triggerId),
          'functionName' => 'CRM_Fastactionlinks_Action::civirule',
        ),
      );
    }
  }

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
      // Give a more useful error when the error is "Unable to add tags".
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
    // TODO: FALs only support contacts for now.  Maybe later we'll change this.
    CRM_Fastactionlinks_Trigger_Manual::process($falData['actionEntityId'], $falData['entityId'], 'Contact');
    return $result;
  }

}
