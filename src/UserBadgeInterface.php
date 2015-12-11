<?php

/**
 * @file
 * Contains \Drupal\user_badges\UserBadgeInterface.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining User badge entities.
 *
 * @ingroup user_badges
 */
interface UserBadgeInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.

}
