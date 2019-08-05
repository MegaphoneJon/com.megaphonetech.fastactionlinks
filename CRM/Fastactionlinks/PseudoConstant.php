<?php

/**
 * Pseudoconstant lookups for the FastActionLink entity.
 */
class CRM_Fastactionlinks_PseudoConstant {

  public static function actionTypes() {
    $actions = CRM_Fastactionlinks_Action::getActionLabels();
    return $actions;
  }

  public static function searchViews() {
    $types = array('Participant', 'Contribution', 'Membership');
    $componentProfiles = CRM_Core_BAO_UFGroup::getProfiles($types);

    $ufGroups = CRM_Core_BAO_UFGroup::getModuleUFGroup('Search Profile', 1);
    $accessibleUfGroups = CRM_Core_Permission::ufGroup(CRM_Core_Permission::VIEW);
    $searchProfiles = array();
    foreach ($ufGroups as $key => $var) {
      if (!array_key_exists($key, $componentProfiles) && in_array($key, $accessibleUfGroups)) {
        $searchProfiles[$key] = $var['title'];
      }
    }
    return $searchProfiles;
  }

  public static function supportedLocations() {
    $locations = [
      'CRM/Contact/Form/Search/Advanced.tpl' => 'Search Results',
      'CRM/Contribute/Page/Tab.tpl' => 'Contact Contribution Tab',
    ];
    return $locations;
  }

  public static function entityIdFields() {
    return [
      'CRM/Contact/Form/Search/Advanced.tpl' => 'contact_id',
      'CRM/Contribute/Page/Tab.tpl' => 'contribution_id',
    ];
  }

}
