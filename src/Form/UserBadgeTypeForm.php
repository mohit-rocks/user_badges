<?php

/**
 * @file
 * Contains \Drupal\user_badges\Form\UserBadgeTypeForm.
 */

namespace Drupal\user_badges\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class UserBadgeTypeForm.
 *
 * @package Drupal\user_badges\Form
 */
class UserBadgeTypeForm extends EntityForm {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $user_badge_type = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $user_badge_type->label(),
      '#description' => $this->t("Label for the User badge type."),
      '#required' => TRUE,
    );

    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $user_badge_type->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\user_badges\Entity\UserBadgeType::load',
      ),
      '#disabled' => !$user_badge_type->isNew(),
    );

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $user_badge_type = $this->entity;
    $status = $user_badge_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label User badge type.', [
          '%label' => $user_badge_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label User badge type.', [
          '%label' => $user_badge_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($user_badge_type->urlInfo('collection'));
  }

}
