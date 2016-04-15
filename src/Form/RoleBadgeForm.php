<?php

/**
 * @file
 * Contains \Drupal\user_badges\Form\RoleBadgeForm.
 */

namespace Drupal\user_badges\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Role badge edit forms.
 *
 * @ingroup user_badges
 */
class RoleBadgeForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\user_badges\Entity\RoleBadge */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Role badge.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Role badge.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.role_badge.canonical', ['role_badge' => $entity->id()]);
  }

}
