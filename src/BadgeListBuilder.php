<?php

/**
 * @file
 * Contains \Drupal\user_badges\BadgeListBuilder.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
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
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\user_badges\Entity\Badge */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.badge.edit_form', array(
          'badge' => $entity->id(),
        )
      )
    );
    $image = array(
      '#theme' => 'image_style',
      '#style_name' => 'thumbnail',
      '#uri' => $entity->field_badge_image->entity->getFileUri(),
      '#title' => $entity->label(),
    );
    $row['badge_image'] = render($image);
    return $row + parent::buildRow($entity);
  }

}
