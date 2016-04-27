<?php

/**
 * @file
 * Contains \Drupal\user_badges\BadgeListBuilder.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Badge entities.
 *
 * @ingroup user_badges
 */
class BadgeListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Badge ID');
    $header['name'] = $this->t('Name');
    $header['badge_image'] = $this->t('Badge Image');
    $header['weight'] = $this->t('Weight');
    $header['role_id'] = $this->t('Role');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\user_badges\Entity\Badge */
    $row['id'] = $entity->id();
    $row['name'] = Link::fromTextAndUrl(
      $entity->label(),
      new Url(
        'entity.badge.edit_form', array(
          'badge' => $entity->id(),
        )
      )
    );
    $row['badge_image'] = array(
      '#theme' => 'image_style',
      '#style_name' => 'thumbnail',
      '#uri' => $entity->image->entity->getFileUri(),
      '#title' => $entity->label(),
    );
    $row['weight'] = $entity->getBadgeWeight();
    $role_id = $entity->getBadgeRoleId();
    if ($role_id) {
      /** @var \Drupal\User\Entity\Role $role */
      $role = \Drupal::entityManager()->getStorage('user')->load($role_id);
      $role_name = $role->label();
    }
    else {
      $role_name = '';
    }
    $row['role_id'] = $role_name;
    return $row + parent::buildRow($entity);
  }

}
