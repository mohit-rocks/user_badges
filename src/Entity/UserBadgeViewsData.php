<?php

/**
 * @file
 * Contains \Drupal\user_badges\Entity\UserBadge.
 */

namespace Drupal\user_badges\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for User Badge entities.
 */
class UserBadgeViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['user_badge']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('User Badge'),
      'help' => $this->t('The User Badge ID.'),
    );

    return $data;
  }

}
