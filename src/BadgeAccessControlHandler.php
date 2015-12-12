<?php

/**
 * @file
 * Contains \Drupal\user_badges\BadgeAccessControlHandler.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Badge entity.
 *
 * @see \Drupal\user_badges\Entity\Badge.
 */
class BadgeAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view badge entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit badge entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete badge entities');
    }

    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add badge entities');
  }

}
