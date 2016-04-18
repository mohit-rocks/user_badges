<?php

/**
 * @file
 * Contains \Drupal\user_badges\Entity\BadgeType.
 */

namespace Drupal\user_badges\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\user_badges\BadgeTypeInterface;

/**
 * Defines the Badge type entity.
 *
 * @ConfigEntityType(
 *   id = "badge_type",
 *   label = @Translation("Badge type"),
 *   handlers = {
 *     "list_builder" = "Drupal\user_badges\BadgeTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\user_badges\Form\BadgeTypeForm",
 *       "edit" = "Drupal\user_badges\Form\BadgeTypeForm",
 *       "delete" = "Drupal\user_badges\Form\BadgeTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\user_badges\BadgeTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "badge_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "badge",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/badge_type/{badge_type}",
 *     "add-form" = "/admin/structure/badge_type/add",
 *     "edit-form" = "/admin/structure/badge_type/{badge_type}/edit",
 *     "delete-form" = "/admin/structure/badge_type/{badge_type}/delete",
 *     "collection" = "/admin/structure/badge_type"
 *   }
 * )
 */
class BadgeType extends ConfigEntityBase implements BadgeTypeInterface {
  /**
   * The Badge type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Badge type label.
   *
   * @var string
   */
  protected $label;

}