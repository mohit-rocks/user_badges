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
  /**
   * Gets the Badge type.
   *
   * @return string
   *   The Badge type.
   */
  public function getType();
  /**
   * Gets the Badge name.
   *
   * @return string
   *   Name of the Badge.
   */
  public function getName();
  /**
   * Sets the Badge name.
   *
   * @param string $name
   *   The Badge name.
   *
   * @return \Drupal\user_badges\BadgeInterface
   *   The called Badge entity.
   */
  public function setName($name);
  /**
   * Gets the Badge weight.
   *
   * @return integer
   *   Weight of the Badge.
   */
  public function getBadgeWeight();
  /**
   * Sets the Badge weight.
   *
   * @param string $weight
   *   The Badge weight.
   *
   * @return \Drupal\user_badges\BadgeInterface
   *   The called Badge entity.
   */
  public function setBadgeWeight($weight);


}
