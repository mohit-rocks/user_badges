<?php

/**
 * @file
 * Contains \Drupal\user_badges\Entity\Form\UserBadgeSettingsForm.
 */

namespace Drupal\user_badges\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class UserBadgeSettingsForm.
 *
 * @package Drupal\user_badges\Form
 *
 * @ingroup user_badges
 */
class UserBadgeSettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'UserBadge_settings';
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
   * Defines the settings form for User Badge entities.
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
    $form['UserBadge_settings']['#markup'] = 'Settings form for User Badge entities. Manage field settings here.';
    return $form;
  }

}
