<?php
/**
 * Class for CiviRules manual trigger handling
 *
 * @author Jon Goldberg <jon@megaphonetech.com>
 * @license AGPL-3.0
 */

class CRM_Fastactionlinks_Trigger_Manual extends CRM_Civirules_Trigger {

  public function setTriggerId($triggerId) {
    parent::setTriggerId($triggerId);

    $trigger = new CRM_Civirules_BAO_Trigger();
    $trigger->id = $this->triggerId;
    if (!$trigger->find(TRUE)) {
      throw new Exception('Civirules: could not find trigger with ID: ' . $this->triggerId);
    }
  }

  /**
   * Returns an array of entities on which the trigger reacts
   *
   * @return CRM_Civirules_TriggerData_EntityDefinition
   */
  protected function reactOnEntity() {
    return new CRM_Civirules_TriggerData_EntityDefinition(ts('Person'), 'contact', 'CRM_Contact_DAO_Contact', 'Contact');
  }

  /**
   * Getter for object name
   *
   * @return mixed
   */
  public function getObjectName() {
    return $this->objectName;
  }

  /**
   * Process a manual trigger.
   *
   * @param int $ruleId
   * @param int $objectId
   * @param string $objectName
   * @access public
   * @static
   */
  public static function process($ruleId, $objectId, $objectName, $falId) {
    // Find the rule corresponding to this ruleId.
    $trigger = CRM_Fastactionlinks_BAO_Rule::findRuleById($ruleId);
    if ($trigger instanceof CRM_Fastactionlinks_Trigger_Manual) {
      $trigger->triggerTrigger($objectId, $objectName, $falId);
    }
  }

  /**
   * Trigger a rule for this trigger
   *
   * @param $op
   * @param $objectName
   * @param $objectId
   * @param $objectRef
   */
  public function triggerTrigger($objectId, $objectName, $falId) {
    $objectRef = $this->getEntityData($objectId, $objectName);
    // This probably doesn't belong here, but.
    $objectRef['fast_action_link_id'] = $falId;
    $triggerData = $this->getTriggerDataFromManual($objectName, $objectId, $objectRef);
    try {
      $temp = CRM_Civirules_Engine::triggerRule($this, clone $triggerData);
    }
    catch (Exception $e) {
      $test = 1;
    }
  }

  protected function getEntityData($objectId, $objectName) {
    try {
      $result = civicrm_api3($objectName, 'getsingle', array('id' => $objectId));
    }
    catch (Exception $e) {
      $message = "Error on {file} (Line {line})\r\n\r\n{exception_message}";
      $context = array();
      $context['line'] = $e->getLine();
      $context['file'] = $e->getFile();
      $context['exception_message'] = $e->getMessage();
      CRM_Civirules_Utils_LoggerFactory::logError("Failed to get entity data", $message, $triggerData, $context);
    }
    return $result;
  }

  /**
   * Get trigger data belonging to this specific trigger
   *
   * @param $objectName
   * @param $objectId
   * @param $objectRef
   * @return CRM_Civirules_TriggerData_Manual
   */
  protected function getTriggerDataFromManual($objectName, $objectId, $objectRef) {
    $entity = CRM_Civirules_Utils_ObjectName::convertToEntity($objectName);
    $data = $this->convertObjectRefToDataArray($entity, $objectRef, $objectId);

    $triggerData = new CRM_Fastactionlinks_TriggerData_Manual($entity, $objectId, $data);
    $this->alterTriggerData($triggerData);
    return $triggerData;
  }

  protected function convertObjectRefToDataArray($entity, $objectRef, $id) {
    //set data
    $data = array();
    if (is_object($objectRef)) {
      CRM_Core_DAO::storeValues($objectRef, $data);
    }
    elseif (is_array($objectRef)) {
      $data = $objectRef;
    }

    return $data;
  }

}
