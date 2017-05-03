<?php
/**
 * Class for CiviRules manual trigger handling
 *
 * @author Jon Goldberg <work@takethestreets.org>
 * @license AGPL-3.0
 */

class CRM_Fastactionlinks_Trigger_Manual extends CRM_Civirules_Trigger {

  public function setTriggerId($triggerId) {
    parent::setTriggerId($triggerId);

    $trigger = new CRM_Civirules_BAO_Trigger();
    $trigger->id = $this->triggerId;
    if (!$trigger->find(true)) {
      throw new Exception('Civirules: could not find trigger with ID: '.$this->triggerId);
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
   * @param string $op
   * @param string $objectName
   * @param int $objectId
   * @param object $objectRef
   * @access public
   * @static
   */
  public static function process($ruleId, $objectId, $objectName) {
    // Find the rule corresponding to this ruleId.
    $trigger = CRM_Fastactionlinks_BAO_Rule::findRuleById($ruleId);
    if ($trigger instanceof CRM_Fastactionlinks_Trigger_Manual) {
      $trigger->triggerTrigger($objectId, $objectName);
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
  public function triggerTrigger($objectId, $objectName) {
    $objectRef = $this->getEntityData($objectId, $objectName);
    $triggerData = $this->getTriggerDataFromManual($objectName, $objectId, $objectRef);
    CRM_Civirules_Engine::triggerRule($this, clone $triggerData);
  }

  protected function getEntityData($objectId, $objectName) {
    try {
      $result = civicrm_api3($objectName, 'getsingle', array('id' => $objectId));
    } catch (Exception $e) {
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
    } elseif (is_array($objectRef)) {
      $data = $objectRef;
    }

    return $data;
  }

}