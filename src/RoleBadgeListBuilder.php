<?php

/**
 * @file
 * Contains \Drupal\user_badges\RoleBadgeListBuilder.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Role badge entities.
 *
 * @ingroup user_badges
 */
class RoleBadgeListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Role badge ID');
    $header['badge_name'] = $this->t('Badge Name');
    $header['role_name'] = $this->t('Role Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\user_badges\Entity\RoleBadge */
    $row['id'] = $entity->id();
    /* @var \Drupal\user_badges\Entity\Badge $badge_entity */
    $badge_entity = \Drupal::entityManager()->getStorage('badge')->load($entity->badge_id);
    $row['badage_name'] = $badge_entity->name();

    /* @var \Drupal\user\Entity\Role $role_entity */
    $role_entity = \Drupal::entityManager()->getStorage('user_role')->load($entity->role_id);
    $row['role_name'] = $role_entity->label();

    return $row + parent::buildRow($entity);
  }

}
