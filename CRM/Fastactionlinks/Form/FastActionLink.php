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

  public function buildQuickForm() {

    // add form elements and help text.
    $this->add('text', 'label', ts('Link Text'), NULL, TRUE);

    $this->add('text', 'description', ts('Description'), array('size' => 60));
    $this->addHelp('description', 'id-description', 'CRM/Fastactionlinks/Form/FastActionLink.hlp');

    $this->add('text', 'hovertext', ts('Hover Text'), array('size' => 60));
    $this->addHelp('hovertext', 'id-hovertext', 'CRM/Fastactionlinks/Form/FastActionLink.hlp');

    $this->add('text', 'success_message', ts('Success Message'), array('size' => 60));
    $this->addHelp('success_message', 'id-success_message', 'CRM/Fastactionlinks/Form/FastActionLink.hlp');

    $this->add('text', 'weight', ts('Order'), CRM_Core_DAO::getAttribute('CRM_Fastactionlinks_DAO_FastActionLink', 'weight'), TRUE);
    $this->addRule('weight', ts('is a numeric field'), 'numeric');

    $this->add('checkbox', 'is_active', ts('Is this link active?'));
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('help', $this->_help);
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /* Set variables up before form is built.
   *
   *
   * @return void
   * @throws CRM_Core_Exception
   */
  public function preProcess() {
    // Check permission for action.
    if (!CRM_Core_Permission::check('administer CiviCRM')) {
      throw new CRM_Core_Exception('You do not have permission to access this page.');
    }

    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive');
    $this->set('BAOName', 'CRM_CiviDiscount_BAO_Item');
    // setting title for html page
    if ($this->_action == CRM_Core_Action::UPDATE) {
      CRM_Utils_System::setTitle(ts('Edit Fast Action Link'));
    } else {
      CRM_Utils_System::setTitle(ts('New Fast Action Link'));
    }
    parent::preProcess();
  }

  public function setDefaultValues() {
    if ($this->_id) {
      $params = array('id' => $this->_id);
      CRM_Core_DAO::commonRetrieve('CRM_Fastactionlinks_DAO_FastActionLink', $params, $defaults);
      return $defaults;
    }
  }

  public function postProcess() {
    $values = $this->exportValues();
    parent::postProcess();
  }

  //FIXME: PR submitted to move this to CRM_Core_Form.  Remove this when that's merged.
  public function addHelp($name, $id, $hlpFile = null) {
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
