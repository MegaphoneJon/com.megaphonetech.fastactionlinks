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
          'url' => 'civicrm/fastactionlink',
          'qs' => 'action=update&reset=1&id=%%id%%',
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
          'url' => 'civicrm/fastactionlink',
          'qs' => 'action=delete&reset=1&id=%%id%%',
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

    // assign vars to templates
    $this->assign('action', $action);

    // what action to take ?
    if ($action & (CRM_Core_Action::UPDATE | CRM_Core_Action::ADD | CRM_Core_Action::DELETE)) {
      // No browse for edit/update/delete.
      $this->edit($action);
    } else {
      $this->browse();
    }



    parent::run();
  }

  public function edit($action) {
    // create a simple controller for editing custom dataCRM/Custom/Page/Field.php
    $controller = new CRM_Core_Controller_Simple('CRM_Fastactionlinks_Form_FastActionLink', ts('Fast Action Link'), $action);

    // set the userContext stack
    $session = CRM_Core_Session::singleton();
    $session->pushUserContext(CRM_Utils_System::url('civicrm/fastactionlink', 'reset=1&action=browse'));
    $controller->setEmbedded(TRUE);
    $controller->process();
    $controller->run();
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
      //Pseudoconstant substitutions
      $fastActionLink[$fastActionLinkBAO->id]['uf_group_id'] = CRM_Core_PseudoConstant::getLabel('CRM_Fastactionlinks_BAO_FastActionLink', 'uf_group_id', $fastActionLinkBAO->uf_group_id);
      $fastActionLink[$fastActionLinkBAO->id]['action_type'] = CRM_Core_PseudoConstant::getLabel('CRM_Fastactionlinks_BAO_FastActionLink', 'action_type', $fastActionLinkBAO->action_type);
      $action = array_sum(array_keys(self::actionLinks()));
      if ($fastActionLinkBAO->is_active) {
        $action -= CRM_Core_Action::ENABLE;
      } else {
        $action -= CRM_Core_Action::DISABLE;
      }

      $fastActionLink[$fastActionLinkBAO->id]['order'] = $fastActionLink[$fastActionLinkBAO->id]['weight'];
      $fastActionLink[$fastActionLinkBAO->id]['action'] = CRM_Core_Action::formLink(self::actionLinks(), $action, array(
          'id' => $fastActionLinkBAO->id,
        ), ts('more'), FALSE, 'fastActionLink.row.actions', 'FastActionLink', $fastActionLinkBAO->id);
    }
    $returnURL = CRM_Utils_System::url('civicrm/fastactionlink', "reset=1&action=browse");
    CRM_Utils_Weight::addOrder($fastActionLink, 'CRM_Fastactionlinks_DAO_FastActionLink', 'id', $returnURL);
    $this->assign('fastActionLink', $fastActionLink);
  }

}
