<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 4.7                                                |
+--------------------------------------------------------------------+
| Copyright CiviCRM LLC (c) 2004-2016                                |
+--------------------------------------------------------------------+
| This file is a part of CiviCRM.                                    |
|                                                                    |
| CiviCRM is free software; you can copy, modify, and distribute it  |
| under the terms of the GNU Affero General Public License           |
| Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
|                                                                    |
| CiviCRM is distributed in the hope that it will be useful, but     |
| WITHOUT ANY WARRANTY; without even the implied warranty of         |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
| See the GNU Affero General Public License for more details.        |
|                                                                    |
| You should have received a copy of the GNU Affero General Public   |
| License and the CiviCRM Licensing Exception along                  |
| with this program; if not, contact CiviCRM LLC                     |
| at info[AT]civicrm[DOT]org. If you have questions about the        |
| GNU Affero General Public License or the licensing of CiviCRM,     |
| see the CiviCRM license FAQ at http://civicrm.org/licensing        |
+--------------------------------------------------------------------+
*/
/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2016
 *
 * Generated from xml/schema/CRM/Fastactionlinks/FastActionLink.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:7732803bb65bfff9ea4d11775c709ad5)
 */
require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Fastactionlinks_DAO_FastActionLink extends CRM_Core_DAO {
  /**
   * static instance to hold the table name
   *
   * @var string
   */
  static $_tableName = 'civicrm_fast_action_link';
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   */
  static $_log = true;
  /**
   * Unique FastActionLink ID
   *
   * @var int unsigned
   */
  public $id;
  /**
   * Which profile this link is associated with.  NULL indicates "default search".
   *
   * @var int unsigned
   */
  public $uf_group_id;
  /**
   * The action associated with this link. E.g. addToGroup, removeFromGroup.
   *
   * @var string
   */
  public $action;
  /**
   * This is the displayed text for the link.
   *
   * @var string
   */
  public $label;
  /**
   * This is the text displayed when you hover the mouse over the link.  It's a good place to put a description.
   *
   * @var string
   */
  public $hovertext;
  /**
   * If the action requires an entity ID, it is stored here.
   *
   * @var int unsigned
   */
  public $action_entity_id;
  /**
   * Should this link be disabled and the corresponding search result dimmed on click?
   *
   * @var boolean
   */
  public $dim_on_use;
  /**
   * Is this link currently active?  If not, do not show.
   *
   * @var boolean
   */
  public $is_active;
  /**
   * Controls order in which links appear.
   *
   * @var int
   */
  public $weight;
  /**
   * class constructor
   *
   * @return civicrm_fast_action_link
   */
  function __construct() {
    $this->__table = 'civicrm_fast_action_link';
    parent::__construct();
  }
  /**
   * Returns foreign keys and entity references
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static ::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName() , 'uf_group_id', 'civicrm_uf_group', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }
  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = array(
        'id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'Unique FastActionLink ID',
          'required' => true,
        ) ,
        'uf_group_id' => array(
          'name' => 'uf_group_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Profile ID') ,
          'description' => 'Which profile this link is associated with.  NULL indicates "default search".',
          'FKClassName' => 'CRM_Core_DAO_UFGroup',
          'html' => array(
            'type' => 'Select',
          ) ,
          'pseudoconstant' => array(
            'table' => 'civicrm_uf_group',
            'keyColumn' => 'id',
            'labelColumn' => 'title',
          )
        ) ,
        'action' => array(
          'name' => 'action',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Action') ,
          'description' => 'The action associated with this link. E.g. addToGroup, removeFromGroup.',
          'required' => true,
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
        ) ,
        'label' => array(
          'name' => 'label',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Label') ,
          'description' => 'This is the displayed text for the link.',
          'required' => true,
          'maxlength' => 32,
          'size' => CRM_Utils_Type::MEDIUM,
        ) ,
        'hovertext' => array(
          'name' => 'hovertext',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Hover Text') ,
          'description' => 'This is the text displayed when you hover the mouse over the link.  It\'s a good place to put a description.',
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
        ) ,
        'action_entity_id' => array(
          'name' => 'action_entity_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Action Entity ID') ,
          'description' => 'If the action requires an entity ID, it is stored here.',
        ) ,
        'dim_on_use' => array(
          'name' => 'dim_on_use',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Dim on Use') ,
          'description' => 'Should this link be disabled and the corresponding search result dimmed on click?',
          'default' => '1',
        ) ,
        'is_active' => array(
          'name' => 'is_active',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Action Link Is Active') ,
          'description' => 'Is this link currently active?  If not, do not show.',
          'default' => '1',
        ) ,
        'weight' => array(
          'name' => 'weight',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Order') ,
          'description' => 'Controls order in which links appear.',
          'required' => true,
          'default' => '1',
        ) ,
      );
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }
  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }
  /**
   * Returns the names of this table
   *
   * @return string
   */
  static function getTableName() {
    return self::$_tableName;
  }
  /**
   * Returns if this table needs to be logged
   *
   * @return boolean
   */
  function getLog() {
    return self::$_log;
  }
  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  static function &import($prefix = false) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'fast_action_link', $prefix, array());
    return $r;
  }
  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  static function &export($prefix = false) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'fast_action_link', $prefix, array());
    return $r;
  }
}
