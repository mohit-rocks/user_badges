<?php

/**
 * @file
 * Contains \Drupal\user_badges\Entity\UserBadgeType.
 */

namespace Drupal\user_badges\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\user_badges\UserBadgeTypeInterface;

/**
 * Defines the User badge type entity.
 *
 * @ConfigEntityType(
 *   id = "user_badge_type",
 *   label = @Translation("User badge type"),
 *   handlers = {
 *     "list_builder" = "Drupal\user_badges\UserBadgeTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\user_badges\Form\UserBadgeTypeForm",
 *       "edit" = "Drupal\user_badges\Form\UserBadgeTypeForm",
 *       "delete" = "Drupal\user_badges\Form\UserBadgeTypeDeleteForm"
 *     }
 *   },
 *   config_prefix = "user_badge_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "user_badge",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/user_badge_type/{user_badge_type}",
 *     "edit-form" = "/admin/structure/user_badge_type/{user_badge_type}/edit",
 *     "delete-form" = "/admin/structure/user_badge_type/{user_badge_type}/delete",
 *     "collection" = "/admin/structure/visibility_group"
 *   }
 * )
 */
class UserBadgeType extends ConfigEntityBase implements UserBadgeTypeInterface {
  /**
   * The User badge type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The User badge type label.
   *
   * @var string
   */
  protected $label;

}
