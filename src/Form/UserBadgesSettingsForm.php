<?php

/**
 * @file
 * Contains \Drupal\user_badges\Form\UserBadgesSettingsForm.
 */

namespace Drupal\user_badges\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class UserBadgesSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_badges_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('user_badges.settings');

    foreach (Element::children($form) as $variable) {
      $config->set($variable, $form_state->getValue($form[$variable]['#parents']));
    }
    $config->save();

    if (method_exists($this, '_submitForm')) {
      $this->_submitForm($form, $form_state);
    }

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['user_badges.settings'];
  }

  public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state) {
    $noyes = [t('No'), t('Yes')];

    /*$form['user_badges_showblocked'] = array(
    '#type' => 'radios',
    '#options' => $noyes,
    '#title' => t('Only show blocked user badge'),
    '#default_value' => variable_get('user_badges_showblocked', 0),
    '#description' => t('If checked, only the badge associated to blocked users will be shown, overriding other badges the user eventually has as well as any other settings.') . ' ' .
    t('Note that if there is no badge associated to blocked users, no badges will appear.') . ' ' .
    t('This option only acts on blocked users and has no repercussions on active user badges.'),
    '#attributes' => array('class' => array('container-inline')),
  );*/

    $form['user_badges_userweight'] = [
      '#type' => 'radios',
      '#options' => $noyes,
      '#title' => t('Allow users to reorder badges'),
      '#default_value' => \Drupal::config('user_badges.settings')->get('user_badges_userweight'),
      '#description' => t('If checked, users will have the ability to reweight their badges in their profile, enabling them to set what order their badges display, and also which badges will display if a limit is set above.') . ' ' . t('Note that you can make individual badges exempt from this function, allowing you to force them to the top or bottom of the list by giving them a very high or low weight value.'),
      '#attributes' => [
        'class' => [
          'container-inline'
          ]
        ],
    ];

    $form['user_badges_selector_type'] = [
      '#type' => 'select',
      '#options' => [
        0 => t('drop-down multi-select'),
        1 => t('autocomplete'),
      ],
      '#title' => t('Selector to set a badge'),
      '#default_value' => \Drupal::config('user_badges.settings')->get('user_badges_selector_type'),
      '#description' => t('Select which type of selector to use to set a badge.'),
      '#attributes' => [
        'class' => [
          'container-inline'
          ]
        ],
    ];

    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form, \Drupal\Core\Form\FormStateInterface $form_state) {
  }

}
