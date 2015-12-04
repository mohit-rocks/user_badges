<?php
namespace Drupal\user_badges;

class UserBadgesRolesForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_badges_roles_form';
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
    // No badges for the anonymous role.
    $roles = user_roles(TRUE);
    $role_badges = user_badges_get_roles(NULL, ['returnbadges' => TRUE]);

    $form['user_badges_role'] = [
      '#type' => 'fieldset',
      '#title' => t('Role Badges'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
      '#tree' => TRUE,
      '#weight' => 10,
    ];
    // Determine which selector type the user wants to use to set badges
    // from their settings.
    // If the user wants to use the drop-down selector,
    // display that if there are records in the db.
    if (\Drupal::config('user_badges.settings')->get('user_badges_selector_type') == 0) {

      // First, load all the available badges from the database
    // by calling the following helper function.
      $result = user_badges_load_badges();

      // Display the drop-down only if we get any records.
      if (count($result)) {
        foreach ($result as $badge) {
          $options[$badge->bid] = t('Badge') . ' ' . $badge->bid . ' ' . '-' . ' ' . check_plain($badge->name);
        }

        $form['user_badges_blocked_badge'] = [
          '#type' => 'select',
          '#title' => t('Blocked user'),
          '#empty_option' => '- None -',
          '#options' => $options,
          '#default_value' => \Drupal::config('user_badges.settings')->get('user_badges_blocked_badge'),
          '#weight' => 0,
        ];

        $user_badge_roles = \Drupal::config('user_badges.settings')->get('user_badges_role');
        foreach ($roles as $rid => $role) {
          $default = '';
          if (isset($user_badge_roles[$rid]) && $user_badge_roles[$rid]) {
            $default = $user_badge_roles[$rid];
          }
          $form['user_badges_role'][$rid] = [
            '#type' => 'select',
            '#title' => check_plain($role),
            '#empty_option' => '- None -',
            '#options' => $options,
            '#default_value' => $default,
          ];
        }
      }
    }
      // Else, if the user wants to use the autocomplete or
      // if there are no records in the db, display that.
    else {
      $default = '';
      $user_badge = user_badge_load(\Drupal::config('user_badges.settings')->get('user_badges_blocked_badge'));
      if ($user_badge) {
        $default = check_plain($user_badge->name) . ' (' . $user_badge->bid . ')';
      }
      $form['user_badges_blocked_badge'] = [
        '#type' => 'textfield',
        '#title' => t('Blocked user'),
        '#size' => 40,
        '#maxlength' => 255,
        '#autocomplete_path' => 'entityreference/autocomplete/single/user_badge_badges/user/user/',
        '#default_value' => $default,
        '#weight' => 0,
      ];

      $user_badge_roles = \Drupal::config('user_badges.settings')->get('user_badges_role');
      foreach ($roles as $rid => $role) {
        $default = '';
        if (isset($user_badge_roles[$rid]) && $user_badge_roles[$rid]) {
          $user_badge = user_badge_load($user_badge_roles[$rid]);
          if ($user_badge) {
            $default = check_plain($user_badge->name) . ' (' . $user_badge->bid . ')';
          }
        }
        $form['user_badges_role'][$rid] = [
          '#type' => 'textfield',
          '#title' => check_plain($role),
          '#maxlength' => 255,
          '#autocomplete_path' => 'entityreference/autocomplete/single/user_badge_badges/user/user/',
          '#default_value' => $default,
        ];
      }
    }

    $form['#submit'][] = 'user_badges_roles_form_add_badges_submit';

    return parent::buildForm($form, $form_state);
  }

  public function validateForm(array &$form, \Drupal\Core\Form\FormStateInterface $form_state) {
    $array = [
      'user_badges_blocked_badge' => $form_state->getValue(['user_badges_blocked_badge'])
      ] + $form_state->getValue(['user_badges_role']);
    $errors = FALSE;
    foreach (array_count_values($array) as $key => $count) {
      if ($key && $count > 1) {
        $form_state->setErrorByName('', t("You shouldn't use same badge for more than one role (or for blocked user and one role)"));
        $errors = TRUE;
        break;
      }
    }

    if (!$errors && \Drupal::config('user_badges.settings')->get('user_badges_selector_type')) {
      $values = &$form_state->getValues();
      if ($values['user_badges_blocked_badge']) {
        $parts = explode('(', $values['user_badges_blocked_badge']);
        $values['user_badges_blocked_badge'] = substr(end($parts), 0, -1);
      }
      foreach ($values['user_badges_role'] as $key => &$value) {
        $parts = explode('(', $value);
        $value = substr(end($parts), 0, -1);
      }
    }
  }

}
