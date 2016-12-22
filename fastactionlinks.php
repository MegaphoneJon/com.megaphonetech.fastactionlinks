<?php

require_once 'fastactionlinks.civix.php';

/**
 * Implements hook_civicrm_links().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_links
 */
function fastactionlinks_civicrm_links($op, $objectName, $objectId, &$links, &$mask, &$values) {
  if ($op == 'contact.selector.actions' && $objectId == 202) {

//    CRM_Core_Error::debug('objectId', $objectId);
    $links = array();
    $actionLinks[] = array(
        'name' => 'Test Link 2',
        'url' => 'civicrm/contact/view/group',
        'qs' => 'cid=%%id%%',
        'title' => 'Alt Text Here',
        'ref' => 'fast-action-link-2',
        'class' => 'fast-action-link',
    );
    $actionLinks[] = array(
      'name' => 'Test Link 1',
      'url' => 'civicrm/contact/view/group',
      'qs' => 'cid=%%id%%',
        'title' => 'Alt Text Here',
        'ref' => 'fast-action-link-1',
        'class' => 'fast-action-link',
    );

    foreach ($actionLinks as $actionLink) {
      array_unshift($links, $actionLink);
    }
    CRM_Core_Error::debug('links', $links);
    CRM_Core_Error::debug('mask', $mask);
    CRM_Core_Error::debug('values', $values);
  }
}

/**
 * Implementation of hook_civicrm_buildForm
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function fastactionlinks_civicrm_buildForm($formName, &$form) {
  if (strpos($formName, 'CRM_Contact_Form_Search_') === 0) {
    CRM_Core_Resources::singleton()->addScriptFile('org.takethestreets.fastactionlinks', 'js/fal.js');
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function fastactionlinks_civicrm_config(&$config) {
  _fastactionlinks_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function fastactionlinks_civicrm_xmlMenu(&$files) {
  _fastactionlinks_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function fastactionlinks_civicrm_install() {
  _fastactionlinks_civix_civicrm_install();
}

/**
* Implements hook_civicrm_postInstall().
*
* @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
*/
function fastactionlinks_civicrm_postInstall() {
  _fastactionlinks_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function fastactionlinks_civicrm_uninstall() {
  _fastactionlinks_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function fastactionlinks_civicrm_enable() {
  _fastactionlinks_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function fastactionlinks_civicrm_disable() {
  _fastactionlinks_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function fastactionlinks_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _fastactionlinks_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function fastactionlinks_civicrm_managed(&$entities) {
  _fastactionlinks_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function fastactionlinks_civicrm_caseTypes(&$caseTypes) {
  _fastactionlinks_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function fastactionlinks_civicrm_angularModules(&$angularModules) {
_fastactionlinks_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function fastactionlinks_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _fastactionlinks_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function fastactionlinks_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function fastactionlinks_civicrm_navigationMenu(&$menu) {
  _fastactionlinks_civix_insert_navigation_menu($menu, NULL, array(
    'label' => ts('The Page', array('domain' => 'org.takethestreets.fastactionlinks')),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _fastactionlinks_civix_navigationMenu($menu);
} // */
