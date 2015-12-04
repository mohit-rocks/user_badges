<?php
namespace Drupal\user_badges;

/**
 * Class UserBadge.
 */
class UserBadge extends Entity {
  /**
   * Function defaultUri.
   */
  protected function defaultUri() {
    return array('path' => 'user-badge/' . $this->identifier());
  }
}
