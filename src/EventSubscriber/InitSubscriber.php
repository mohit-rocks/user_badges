<?php /**
 * @file
 * Contains \Drupal\user_badges\EventSubscriber\InitSubscriber.
 */

namespace Drupal\user_badges\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InitSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [KernelEvents::REQUEST => ['onEvent', 0]];
  }

  public function onEvent() {
    // Add any other module that can initiate actions.
    if (module_exists('trigger') || module_exists('rules')) {
      module_load_include('inc', 'user_badges', 'user_badges.actions');
    }
    // Attention: Removed autossigned code. Don't know implications.
  }

}
