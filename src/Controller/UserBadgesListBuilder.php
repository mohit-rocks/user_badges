<?php

/**
 * @file
 * Contains \Drupal\user_badges\Controller\UserBadgesListBuilder.
 */

namespace Drupal\user_badges\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\UserInterface;
use Drupal\Core\Entity\Controller\EntityListController;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserBadgesListBuilder.
 *
 * @package Drupal\user_badges\Controller
 */
class UserBadgesListBuilder extends EntityListController{

  /**
   * The theme handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * Constructs the BlockListController.
   *
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler.
   */
  public function __construct(ThemeHandlerInterface $theme_handler) {
    $this->themeHandler = $theme_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('theme_handler')
    );
  }

  /**
   * Provides listing of user badges.
   *
   * @param \Drupal\user\UserInterface $user
   *   The user account.
   *
   * @return array
   *   The block list as a renderable array.
   */
  public function badgesListing(UserInterface $user) {
    return $this->entityManager()->getListBuilder('badge')->render($user);
  }

}
