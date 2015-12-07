<?php

/**
 * @file
 * Contains \Drupal\user_badges\UserBadgeAccessControlHandler.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the User Badge entity.
 *
 * @see \Drupal\user_badges\Entity\UserBadge.
 */
class UserBadgeAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view user badge entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit user badge entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete user badge entities');
    }

    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add user badge entities');
  }

}
