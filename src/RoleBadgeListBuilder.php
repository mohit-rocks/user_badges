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
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\user_badges\Entity\RoleBadge */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.role_badge.edit_form', array(
          'role_badge' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
