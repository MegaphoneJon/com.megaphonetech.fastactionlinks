<?php

require_once 'CRM/Core/Form.php';

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Fastactionlinks_Form_FastActionLink extends CRM_Core_Form {

  //FIXME: PR submitted to move this to CRM_Core_Form.  Remove this when that's merged.
  protected $_help;

  /**
   * Explicitly declare the entity api name.
   */
  public function getDefaultEntity() {
    return 'FastActionLink';
  }

  public function buildQuickForm() {
    if ($this->_action == CRM_Core_Action::DELETE) {
      $this->addButtons(array(
        array(
          'type' => 'submit',
          'name' => ts('Delete Link'),
          'isDefault' => TRUE,
        ),
        array(
          'type' => 'cancel',
          'name' => ts('Cancel'),
        ),
      ));
    }
    else {
      // add form elements and help text.
      $this->add('text', 'label', ts('Link Text'), NULL, TRUE);

      $this->add('text', 'description', ts('Description'), array('size' => 60));
      $this->addHelp('description', 'id-description', 'CRM/Fastactionlinks/Form/FastActionLink.hlp');

      $this->addSelect('uf_group_id', array('label' => 'Search View'), TRUE);
      $this->addHelp('uf_group_id', 'id-uf_group_id', 'CRM/Fastactionlinks/Form/FastActionLink.hlp');

      $this->addSelect('action_type', array('label' => 'Action'));
      $this->addHelp('action_type', 'id-action_type', 'CRM/Fastactionlinks/Form/FastActionLink.hlp');

      $this->add('text', 'action_entity_id', ts('Select an entity'));

      $this->add('text', 'hovertext', ts('Hover Text'), array('size' => 60));
      $this->addHelp('hovertext', 'id-hovertext', 'CRM/Fastactionlinks/Form/FastActionLink.hlp');

      $this->add('text', 'success_message', ts('Success Message'), array('size' => 60));
      $this->addHelp('success_message', 'id-success_message', 'CRM/Fastactionlinks/Form/FastActionLink.hlp');

      $this->add('text', 'weight', ts('Order'), CRM_Core_DAO::getAttribute('CRM_Fastactionlinks_DAO_FastActionLink', 'weight'), TRUE);
      $this->addRule('weight', ts('is a numeric field'), 'numeric');

      $this->add('checkbox', 'is_active', ts('Is this link active?'));

      $this->addButtons(array(
        array(
          'type' => 'done',
          'name' => ts('Submit'),
          'isDefault' => TRUE,
        ),
        array(
          'type' => 'cancel',
          'name' => ts('Cancel'),
        ),
      ));
    }
    // export form elements
    $this->assign('help', $this->_help);
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * Set variables up before form is built.
   *
   * @return void
   * @throws CRM_Core_Exception
   */
  public function preProcess() {
    // Check permission for action.
    if (!CRM_Core_Permission::check('administer CiviCRM')) {
      throw new CRM_Core_Exception('You do not have permission to access this page.');
    }

    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, FALSE);
    $this->setPageTitle('Fast Action Link');

    $session = CRM_Core_Session::singleton();
    $url = CRM_Utils_System::url('civicrm/fastactionlink', 'reset=1');
    $session->pushUserContext($url);
  }

  public function setDefaultValues() {
    $defaults['weight'] = CRM_Utils_Weight::getDefaultWeight('CRM_Fastactionlinks_DAO_FastActionLink');
    CRM_Core_Error::debug_var('postweight', $defaults['weight']);

    if ($this->_id) {
      CRM_Core_Error::debug_var('1', 'hi');
      $params = array('id' => $this->_id);
      CRM_Core_DAO::commonRetrieve('CRM_Fastactionlinks_DAO_FastActionLink', $params, $defaults);
      return $defaults;
    }
  }

  public function postProcess() {
    // store the submitted values in an array
    $params = $this->exportValues();
    if ($this->_action == CRM_Core_Action::DELETE) {
      if ($this->_id) {
        CRM_Fastactionlinks_BAO_FastActionLink::del($this->_id);
        CRM_Core_Session::setStatus(ts('Fast Action Link has been deleted.'), ts('Deleted'), 'success');
      }
    }
    else {
      if ($this->_id) {
        $params['id'] = $this->_id;
      }
      CRM_Fastactionlinks_BAO_FastActionLink::create($params);
      CRM_Core_Session::setStatus(ts('Fast Action Link has been saved.'), ts('Saved'), 'success');
    }
  }

  /**
   * FIXME: PR submitted to move this to CRM_Core_Form.  Remove this when that's merged.
   *
   */
  public function addHelp($name, $id, $hlpFile = NULL) {
    $this->_help[$name]['id'] = $id;
    $this->_help[$name]['hlpFile'] = $hlpFile;
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
