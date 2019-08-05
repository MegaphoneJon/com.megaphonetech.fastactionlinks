<?php

require_once 'fastactionlinks.civix.php';

function fastactionlinks_civicrm_entityTypes(&$entityTypes) {
  $entityTypes[] = array(
    'name' => 'FastActionLink',
    'class' => 'CRM_Fastactionlinks_DAO_FastActionLink',
    'table' => 'civicrm_fast_action_link',
  );
}

/**
 * Hook the supported locations to inject the links.
 * There's hook_civicrm_links which is much nicer, but it can't determine which search view is
 * in use.  Also we'd have to make API calls for every single row, not one per search result.
 */
function fastactionlinks_civicrm_alterContent(&$content, $context, $tplName, &$object) {
  // Only hook supported locations.
  $supportedLocations = CRM_Fastactionlinks_PseudoConstant::supportedLocations();
  if (!isset($supportedLocations[$tplName])) {
    return;
  }

  // If this is search results, make sure we have search results and that this is a search view.
  if ($supportedLocations[$tplName] == 'Search Results') {
    $searchViewId = $object->getVar('_ufGroupID');
    $templateObject = $object->getVar('_renderer')->_tpl;
  }
  else {
    $searchViewId = NULL;
    $templateObject = $object->getTemplate();
  }
  $rows = $templateObject->_tpl_vars['rows'];
  if (!isset($rows) || ($supportedLocations[$tplName] == 'Search Results' && empty($searchViewId))) {
    return;
  }
  // We have search results and a search view.  Get FALs.
  $fal = new CRM_Fastactionlinks_BAO_FastActionLink();
  $actionLinks = $fal->getFastActionLinks($tplName, $searchViewId);
  // Create links for each FAL.
  if (!$actionLinks) {
    return;
  }
  // We need to know which entity ID to use here.
  $entityIdField = CRM_Fastactionlinks_PseudoConstant::entityIdFields()[$tplName];
  foreach ($rows as $k => $row) {
    $newActions = "<span>";
    foreach ($actionLinks as $actionLink) {
      $actionLink = str_replace('%%id%%', $row[$entityIdField], $actionLink);
      $newActions .= $actionLink;
    }
    $newActions .= str_replace("<span>", "", $row['action']);
    $actions[$k] = $row['action'];
    $actions2[$k] = $newActions;
    $content = str_replace($row['action'], $newActions, $content);
  }
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function fastactionlinks_civicrm_buildForm($formName, &$form) {
  //Inject fal.js and fal.css when viewing search results.
  if (strpos($formName, 'Form_Search')) {
    CRM_Core_Resources::singleton()->addScriptFile('com.megaphonetech.fastactionlinks', 'js/fal.js');
    CRM_Core_Resources::singleton()->addStyleFile('com.megaphonetech.fastactionlinks', 'css/fal.css');
  }
}

/**
 * Implements hook_civicrm_tokens().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokens
 */
function fastactionlinks_civicrm_tokens(&$tokens) {
  // TODO: Create a field in the db schema to indicate whether a token should be created.
  // TODO: Maybe also a "basic" vs. "fancy" token.
  try {
    $params = array(
      'is_active' => 1,
    );
    $result = civicrm_api3('FastActionLink', 'get', $params);
  }
  catch (Exception $e) {
    return $e->getMessage();
  }
  foreach ($result['values'] as $fal) {
    $tokens['fal']['fal_' . $fal['id']] = $fal['label'];
  }
}

/**
 * Implements hook_civicrm_tokenValues().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_tokenValues
 */
// TODO: This doesn't remotely work.
//function fastactionlinks_civicrm_tokenValues(&$values, $cids, $job = null, $tokens = array(), $context = null) {
//  if (!empty($tokens['fal'])) {
//    $falTokens = array(
//      'fal_1' => "https://fal_1_URL",
//      'fal_1' => "https://fal_2_URL",
//      'fal_3' => "https://fal_3_URL",
//      'fal_4' => "https://fal_4_URL",
//      'fal_5' => "https://fal_5_URL",
//      'fal_6' => "https://fal_6_URL",
//      'fal_7' => "https://fal_7_URL",
//    );
//    foreach ($cids as $cid) {
//      $values[$cid] = empty($values[$cid]) ? $falTokens : $values[$cid] + $falTokens;
//    }
//  }
//}

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
 */
function fastactionlinks_civicrm_navigationMenu(&$menu) {
  _fastactionlinks_civix_insert_navigation_menu($menu, 'Administer/Customize Data and Screens', array(
    'label' => ts('Fast Action Links', array('domain' => 'com.megaphonetech.fastactionlinks')),
    'name' => 'fast_action_link',
    'url' => 'civicrm/fastactionlink?reset=1',
    'permission' => 'access CiviCRM, administer CiviCRM',
    'operator' => 'AND',
    'separator' => 0,
  ));
  _fastactionlinks_civix_navigationMenu($menu);
}
