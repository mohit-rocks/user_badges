<?php

/**
 * @file
 * Contains \Drupal\user_badges\Controller\BadgeController.
 */

namespace Drupal\user_badges\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user_badges\BadgeInterface;
use Drupal\user_badges\BadgeTypeInterface;
use Drupal\Core\Url;

/**
 * Class BadgeController.
 *
 * @package Drupal\user_badges\Controller
 */
class BadgeController extends ControllerBase {
  /**
   * Addpage.
   *
   * @return string
   *   Return Hello string.
   */
  public function addPage() {
    /*return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: addPage')
    ];*/
    $build = [
      '#theme' => 'item_list',
    ];

    $content = array();

    // Only use node types the user has access to.
    foreach ($this->entityManager()->getStorage('badge_type')->loadMultiple() as $type) {
      $access = $this->entityManager()->getAccessControlHandler('badge')->createAccess($type->id(), NULL, [], TRUE);
      if ($access->isAllowed()) {
        $content[] = \Drupal::l($type->label(), new Url('user_badges.badge_controller_add', array('badge_type' => $type->id())));
      }
    }

    // Bypass the node/add listing if only one content type is available.
    if (count($content) == 1) {
      $type = array_shift($content);
      return $this->redirect('user_badges.badge_controller_add', array('badge_type' => $type->id()));
    }

    $build['#items'] = $content;

    return $build;
  }
  /**
   * Add.
   *
   * @return string
   *   Return Hello string.
   */
  public function add(BadgeTypeInterface $badge_type) {
    $badge = $this->entityManager()->getStorage('badge')->create(array(
      'type' => $badge_type->id(),
    ));

    $form = $this->entityFormBuilder()->getForm($badge);
    return $form;
  }

  /**
   * The _title_callback for the user_badges.badge_controller_add route.
   *
   * @param \Drupal\user_badges\BadgeTypeInterface $badge_type
   *   The current node.
   *
   * @return string
   *   The page title.
   */
  public function addBadgeTitle(BadgeTypeInterface $badge_type) {
    return $this->t('Create @name', array('@name' => $badge_type->label()));
  }

}
