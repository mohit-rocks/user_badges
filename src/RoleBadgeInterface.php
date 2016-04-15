<?php

/**
 * @file
 * Contains \Drupal\user_badges\RoleBadgeInterface.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Role badge entities.
 *
 * @ingroup user_badges
 */
interface RoleBadgeInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.
  /**
   * Gets the Role badge name.
   *
   * @return string
   *   Name of the Role badge.
   */
  public function getName();

  /**
   * Sets the Role badge name.
   *
   * @param string $name
   *   The Role badge name.
   *
   * @return \Drupal\user_badges\RoleBadgeInterface
   *   The called Role badge entity.
   */
  public function setName($name);

  /**
   * Gets the Role badge creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Role badge.
   */
  public function getCreatedTime();

  /**
   * Sets the Role badge creation timestamp.
   *
   * @param int $timestamp
   *   The Role badge creation timestamp.
   *
   * @return \Drupal\user_badges\RoleBadgeInterface
   *   The called Role badge entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Role badge published status indicator.
   *
   * Unpublished Role badge are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Role badge is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Role badge.
   *
   * @param bool $published
   *   TRUE to set this Role badge to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\user_badges\RoleBadgeInterface
   *   The called Role badge entity.
   */
  public function setPublished($published);

}
