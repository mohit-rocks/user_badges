<?php
namespace Drupal\user_badges;

/**
 * Class UserBadgeController.
 */
class UserBadgeController extends EntityAPIController {

  /**
   * Override the save method.
   */
  public function save($entity, DatabaseTransaction $transaction = NULL) {
    if (isset($entity->is_new)) {
      $entity->created = REQUEST_TIME;
    }
    $entity->changed = REQUEST_TIME;
    $result = parent::save($entity, $transaction);
    return $result;
  }

  /**
   * Override the delete method.
   */
  public function delete($ids, DatabaseTransaction $transaction = NULL) {
    foreach ($ids as $id) {
      db_delete('user_badges_assignment')
        ->condition('bid', $id)
        ->execute();
    }
    $result = parent::delete($ids, $transaction);
    return $result;
  }
}
