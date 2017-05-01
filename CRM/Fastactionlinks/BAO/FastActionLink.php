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
    if ($result['count'] && !$result['is_error']) {
      foreach ($result['values'] as $k => $fal) {
        $urls[$k] = $this->createFastActionLinkUrl($fal);
      }
    }
    return $urls;
  }

  /**
   * Takes an array of FastActionLinks from the API and formats them the way
   * hook_civicrm_buildForm (NOT hook_civicrm_links) expects.
   *
   * @param array $fastActionLinks API-formatted FastActionLinks
   * @return array Links formatted for hook_buildForm or hook_links
   */
  private function formatFastActionLinks($fastActionLinks) {
    foreach ($fastActionLinks as $k => $fastActionLink) {
      $formattedLinks[$k] = array(
        'name' => $fastActionLink['label'],
        'url' => '#',
        'qs' => "action=${fastActionLink['action']}&action_entity_id=${fastActionLink['action']}&cid=%%id%%",
        'title' => $fastActionLink['hovertext'],
        'ref' => "fast-action-link-${fastActionLink['id']}",
        'class' => 'fast-action-link',
      );
    }
    return $formattedLinks;
  }

  /**
   * Takes an FastActionLink from the API and returns a URL
   * ready to insert.
   *
   * @param array $fal API-formatted FastActionLink
   * @return string URLs for the FAL in question
   */
  private function createFastActionLinkUrl($fal) {
    $config = CRM_Core_Config::singleton();
    $redirect = $config->userFrameworkResourceURL . "extern/placeholder.php?u=${fal['id']}";
    //$url = CRM_Utils_System::url();
    $url = $redirect;
    return $url;
  }

}
