<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Util
 *
 * @author jon
 */
class CRM_Fastactionlinks_Util {
  public static function isCivirulesInstalled() {
    $installed = FALSE;
    try {
      $extensions = civicrm_api3('Extension', 'get', ['options' => ['limit' => 0]]);
      foreach ($extensions['values'] as $ext) {
        if ($ext['key'] == 'org.civicoop.civirules' && ($ext['status'] == 'installed' || $ext['status'] == 'disabled')) {
          $installed = TRUE;
        }
      }
      return $installed;
    }
    catch (Exception $e) {
      return FALSE;
    }
    return FALSE;
  }

}
