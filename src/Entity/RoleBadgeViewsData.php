<?php

/**
 * @file
 * Contains \Drupal\user_badges\Entity\RoleBadge.
 */

namespace Drupal\user_badges\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Role badge entities.
 */
class RoleBadgeViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['role_badge']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Role badge'),
      'help' => $this->t('The Role badge ID.'),
    );

    return $data;
  }

}
