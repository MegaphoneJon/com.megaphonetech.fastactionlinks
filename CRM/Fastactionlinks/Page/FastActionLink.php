<?php

require_once 'CRM/Core/Page.php';

/**
 * Create a page for displaying Fast Action Links.
 *
 * Heart of this class is the run method which checks
 * for action type and then displays the appropriate
 * page.
 *
 */
class CRM_Fastactionlinks_Page_FastActionLink extends CRM_Core_Page {

  public $useLivePageJS = TRUE;

  /**
   * The action links that we need to display for the browse screen.
   *
   * @var array
   */
  private static $_actionLinks;

  /**
   * Get the action links for this page.
   *
   * @return array
   *   array of action links that we need to display for the browse screen
   */
  public static function &actionLinks() {
    if (!isset(self::$_actionLinks)) {
      self::$_actionLinks = array(
        CRM_Core_Action::UPDATE => array(
          'name' => ts('Edit'),
//          'url' => 'civicrm/admin/custom/group/field/update',
//          'qs' => 'action=update&reset=1&gid=%%gid%%&id=%%id%%',
          'title' => ts('Edit'),
        ),
        CRM_Core_Action::DISABLE => array(
          'name' => ts('Disable'),
          'ref' => 'crm-enable-disable',
          'title' => ts('Disable'),
        ),
        CRM_Core_Action::ENABLE => array(
          'name' => ts('Enable'),
          'ref' => 'crm-enable-disable',
          'title' => ts('Enable'),
        ),
        CRM_Core_Action::DELETE => array(
          'name' => ts('Delete'),
          //'url' => 'civicrm/admin/custom/group/field',
          //'qs' => 'action=delete&reset=1&gid=%%gid%%&id=%%id%%',
          'title' => ts('Delete'),
        ),
      );
    }
    return self::$_actionLinks;
  }

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(ts('Fast Action Links'));

    $id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE, 0);

    // Get a single FAL
    if ($id) {
      $values = civicrm_api3('FastActionLink', 'getsingle', array('id' => $id));
    }
    // get all the FALs
    else {
      $values = civicrm_api3('FastActionLink', 'get', array());
    }
    $action = CRM_Utils_Request::retrieve('action', 'String', $this, FALSE, 'browse');

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));

    // assign vars to templates
    $this->assign('action', $action);

    // what action to take ?
    if ($action & (CRM_Core_Action::UPDATE | CRM_Core_Action::ADD)) {
      // no browse for edit/update/view
//      $this->edit($action);
    } elseif ($action & CRM_Core_Action::PREVIEW) {
//    $this->preview($id);
    } else {
      $this->browse();
    }



    parent::run();
  }

  /**
   * Browse all FALs.
   *
   * @return void
   */
  public function browse() {
    $resourceManager = CRM_Core_Resources::singleton();
    if (!empty($_GET['new']) && $resourceManager->ajaxPopupsEnabled) {
      $resourceManager->addScriptFile('civicrm', 'js/crm.addNew.js', 999, 'html-header');
    }

    $fastActionLink = array();
    $fastActionLinkBAO = new CRM_Fastactionlinks_BAO_FastActionLink();

    $fastActionLinkBAO->orderBy('weight, label');
    $fastActionLinkBAO->find();

    while ($fastActionLinkBAO->fetch()) {
      $fastActionLink[$fastActionLinkBAO->id] = array();
      CRM_Core_DAO::storeValues($fastActionLinkBAO, $fastActionLink[$fastActionLinkBAO->id]);
      $action = array_sum(array_keys(self::actionLinks()));
      if ($fastActionLinkBAO->is_active) {
        $action -= CRM_Core_Action::ENABLE;
      } else {
        $action -= CRM_Core_Action::DISABLE;
      }

      $fastActionLink[$fastActionLinkBAO->id]['order'] = $fastActionLink[$fastActionLinkBAO->id]['weight'];
//      $customField[$customFieldBAO->id]['action'] = CRM_Core_Action::formLink(self::actionLinks(), $action, array(
//                'id' => $customFieldBAO->id,
//                'gid' => $this->_gid,
//                      ), ts('more'), FALSE, 'customField.row.actions', 'CustomField', $customFieldBAO->id
//      );
    }

    $returnURL = CRM_Utils_System::url('civicrm/fastactionlink', "reset=1&action=browse");
    CRM_Utils_Weight::addOrder($fastActionLink, 'CRM_Fastactionlinks_DAO_FastActionLink', 'id', $returnURL);
    $searchViews = CRM_Fastactionlinks_SelectValues::searchViews();
    CRM_Core_Error::debug_var('searchViews', $searchViews);
    $this->assign('fastActionLink', $fastActionLink);
  }

}



//
//  /**
//   * Edit custom data.
//   *
//   * editing would involved modifying existing fields + adding data to new fields.
//   *
//   * @param string $action
//   *   The action to be invoked.
//   *
//   * @return void
//   */
//  public function edit($action) {
//    // create a simple controller for editing custom dataCRM/Custom/Page/Field.php
//    $controller = new CRM_Core_Controller_Simple('CRM_Custom_Form_Field', ts('Custom Field'), $action);
//
//    // set the userContext stack
//    $session = CRM_Core_Session::singleton();
//    $session->pushUserContext(CRM_Utils_System::url('civicrm/admin/custom/group/field', 'reset=1&action=browse&gid=' . $this->_gid));
//
//    $controller->set('gid', $this->_gid);
//    $controller->setEmbedded(TRUE);
//    $controller->process();
//    $controller->run();
//  }
//
//  /**
//   * Run the page.
//   *
//   * This method is called after the page is created. It checks for the
//   * type of action and executes that action.
//   *
//   * @return void
//   */
//  public function run() {
//
//
//
//    if ($action & CRM_Core_Action::DELETE) {
//
//      $session = CRM_Core_Session::singleton();
//      $session->pushUserContext(CRM_Utils_System::url('civicrm/admin/custom/group/field', 'reset=1&action=browse&gid=' . $this->_gid));
//      $controller = new CRM_Core_Controller_Simple('CRM_Custom_Form_DeleteField', "Delete Custom Field", '');
//      $id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE, 0
//      );
//      $controller->set('id', $id);
//      $controller->setEmbedded(TRUE);
//      $controller->process();
//      $controller->run();
//      $fieldValues = array('custom_group_id' => $this->_gid);
//      $wt = CRM_Utils_Weight::delWeight('CRM_Core_DAO_CustomField', $id, $fieldValues);
//    }
//
//  }
//
//  /**
//   * Preview custom field.
//   *
//   * @param int $id
//   *   Custom field id.
//   *
//   * @return void
//   */
//  public function preview($id) {
//    $controller = new CRM_Core_Controller_Simple('CRM_Custom_Form_Preview', ts('Preview Custom Data'), CRM_Core_Action::PREVIEW);
//    $session = CRM_Core_Session::singleton();
//    $session->pushUserContext(CRM_Utils_System::url('civicrm/admin/custom/group/field', 'reset=1&action=browse&gid=' . $this->_gid));
//    $controller->set('fieldId', $id);
//    $controller->set('groupId', $this->_gid);
//    $controller->setEmbedded(TRUE);
//    $controller->process();
//    $controller->run();
//  }
//
//}