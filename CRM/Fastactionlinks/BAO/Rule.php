<?php

/**
 * BAO Rule for CiviRule Rule
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */
class CRM_Fastactionlinks_BAO_Rule extends CRM_Civirules_DAO_Rule {

  /**
   * Returns an trigger object corresponding to the rule ID passed in.
   * @param int $ruleId The rule to return
   * @return object $trigger CRM_Civirules_Trigger (or a subclass)
   */
  public static function findRuleById($ruleId) {
    $sql = "SELECT r.id AS rule_id, t.id AS trigger_id, t.class_name, r.trigger_params
            FROM `civirule_rule` r
            INNER JOIN `civirule_trigger` t ON r.trigger_id = t.id AND t.is_active = 1
            WHERE r.`is_active` = 1 AND r.id = %1";
    $params[1] = array($ruleId, 'Integer');
    $dao = CRM_Core_DAO::executeQuery($sql, $params);
    if ($dao->fetch()) {
      $triggerObject = CRM_Civirules_BAO_Trigger::getTriggerObjectByClassName($dao->class_name, false);
      if ($triggerObject !== false) {
        $triggerObject->setTriggerId($dao->trigger_id);
        $triggerObject->setRuleId($dao->rule_id);
        $triggerObject->setTriggerParams($dao->trigger_params);
      }
    }
    return $triggerObject;
  }

}
