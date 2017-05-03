<?php

class CRM_Fastactionlinks_BAO_FastActionLink extends CRM_Fastactionlinks_DAO_FastActionLink {

  /**
   * Create a new FastActionLink based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Fastactionlinks_DAO_FastActionLink|NULL
   *
   */
  public static function create($params) {
    $className = 'CRM_Fastactionlinks_DAO_FastActionLink';
    $entityName = 'FastActionLink';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }

  /**
   * Return an array of fast action links, filtered by profile ID.
   * FIXME: The next line is false.
   * No $profileId = return links for default search
   *
   * @param int $profileId
   * @return array
   */
  public function getFastActionLinks($profileId = NULL) {
    $params = array(
      'is_active' => 1,
      'options' => array('sort' => "weight"),
    );
    // Get all FALs if no profile ID is set.
    if ($profileId) {
      $params['uf_group_id'] = $profileId;
    }
    $result = civicrm_api3('FastActionLink', 'get', $params);
    $urls = array();
    if ($result['count'] && !$result['is_error']) {
      foreach ($result['values'] as $k => $fal) {
        $urls[$k] = $this->createFastActionLinkUrl($fal);
      }
    }
    return $urls;
  }

  /**
   * Takes a FastActionLink record from the API and returns a URL
   * ready to insert.
   * NOTE: substituting in the entity ID happens in the parent function.
   *
   * @param array $fal API-formatted FastActionLink
   * @return string $link URLs for the FAL in question
   */
  private function createFastActionLinkUrl($fal) {
    $falId = $fal['id'];
    $url = CRM_Utils_System::url('#');
    $class = "action-item crm-hover-button no-popup fast-action-link fast-action-link-$falId";
    //Add a confirmation link class if we need it.
    $class .= $fal['confirm'] ? " fast-action-link-confirm" : "";
    $link = "<a href=$url title=\"${fal['hovertext']}\" class=\"$class\" entityid=\"%%id%%\" falid=\"$falId\">${fal['label']}</a>";
    return $link;
  }

  /**
   * Given an entity Id (currently contact IDs only) and a fast action link ID,
   * perform the task that the FAL is intended to perform.
   *
   * @param int $entityId The ID of the entity to act on.
   * @param int $falId The FAL we're executing.
   * @return array $result Success/failure info; a redirect URL?
   */
  public static function execute($entityId, $falId) {
    $params = array(
      'id' => $falId,
    );
    try {
      $apiResult = civicrm_api3('FastActionLink', 'getsingle', $params);
    }
    catch (CiviCRM_API3_Exception $e) {
      return $e;
    }
    $falData['entityId'] = $entityId;
    $falData['actionEntityId'] = $apiResult['action_entity_id'];
    $result = call_user_func('CRM_Fastactionlinks_Action::' . $apiResult['action'], $falData);
    $result['success_message'] = $apiResult['success_message'];
    $result['dim_on_use'] = $apiResult['dim_on_use'];
    return $result;
  }

}
