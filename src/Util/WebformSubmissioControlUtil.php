<?php

namespace Drupal\webform_submission_control\Util;

class WebformSubmissioControlUtil {

  /**
   * Get the list of webforms.
   */
  public static function getWebformList() {
    $webformOptions = [];
    $webforms = \Drupal::entityTypeManager()
      ->getStorage('webform')
      ->loadMultiple();
    foreach ($webforms as $webform) {
      $webformOptions[$webform->id()] = $webform->label();
    }
    return $webformOptions;

  }

  /**
   * Get the list of roles.
   */
  public static function getRoleList() {
    $roleOptions = [];
    $roles = \Drupal::entityTypeManager()
      ->getStorage('user_role')
      ->loadMultiple();
    foreach ($roles as $role) {
      $roleOptions[$role->id()] = $role->label();
    }
    return $roleOptions;
  }

}
