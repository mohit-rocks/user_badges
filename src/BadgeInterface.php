<?php

/**
 * @file
 * Contains \Drupal\user_badges\BadgeInterface.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Badge entities.
 *
 * @ingroup user_badges
 */
interface BadgeInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.

}
