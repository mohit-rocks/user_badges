<?php

/**
 * @file
 * Contains \Drupal\user_badges\Form\RoleBadgeSettingsForm.
 */

namespace Drupal\user_badges\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RoleBadgeSettingsForm.
 *
 * @package Drupal\user_badges\Form
 *
 * @ingroup user_badges
 */
class RoleBadgeSettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'RoleBadge_settings';
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }


  /**
   * Defines the settings form for Role badge entities.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Form definition array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['RoleBadge_settings']['#markup'] = 'Settings form for Role badge entities. Manage field settings here.';
    return $form;
  }

}
