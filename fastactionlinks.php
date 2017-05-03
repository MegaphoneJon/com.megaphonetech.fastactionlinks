<?php

require_once 'fastactionlinks.civix.php';

function fastactionlinks_civicrm_entityTypes(&$entityTypes) {
  _fastactionlinks_civix_civicrm_entityTypes($entityTypes);
}
/**
 * Hook the search results to in Inject the links.
 * There's hook_civicrm_links which is much nicer, but it can't determine which search view is
 * in use.  Also we'd have to make API calls for every single row, not one per search result.
 */
function fastactionlinks_civicrm_alterContent(&$content, $context, $tplName, &$object) {
  // Only hook advanced search.
  if ($tplName != 'CRM/Contact/Form/Search/Advanced.tpl') {
    return;
  }
  // Make sure we have search results.
  $renderer = $object->getVar('_renderer');
  $rows = $renderer->_tpl->_tpl_vars['rows'];
  if (!isset($rows)) {
    return;
  }
  // We have search results.  Get FALs, filtered by the Search View.
  $searchViewId = $object->getVar('_ufGroupID');
  $fal = new CRM_Fastactionlinks_BAO_FastActionLink($searchViewId);
  $actionLinks = $fal->getFastActionLinks($searchViewId);
  // Create links for each FAL.
  foreach ($rows as $cid => $row) {
    $newActions = "<span>";
    foreach ($actionLinks as $actionLink) {
      $actionLink = str_replace('%%id%%', $cid, $actionLink);
      $newActions .= $actionLink;
    }
    $newActions .= str_replace("<span>", "", $row['action']);
    $actions[$cid] = $row['action'];
    $actions2[$cid] = $newActions;
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
  if (strpos($formName, 'CRM_Contact_Form_Search_') === 0) {
    CRM_Core_Resources::singleton()->addScriptFile('org.takethestreets.fastactionlinks', 'js/fal.js');
    CRM_Core_Resources::singleton()->addStyleFile('org.takethestreets.fastactionlinks', 'css/fal.css');
  }
}

/**
 * Used for conditionally adding a managed entity if CiviRules is installed.
 * @return boolean
 */
function _fastactionlinks_is_civirules_installed() {
  $installed = false;
  try {
    $extensions = civicrm_api3('Extension', 'get');
    foreach ($extensions['values'] as $ext) {
      if ($ext['key'] == 'org.civicoop.civirules' && ($ext['status'] == 'installed' || $ext['status'] == 'disabled')) {
        $installed = true;
      }
    }
    return $installed;
  } catch (Exception $e) {
    return false;
  }
  return false;
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
