<?php

/**
 * @file
 * Contains Drupal\user_badges\Controller\UserBadgeAddController.
 */

namespace Drupal\user_badges\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class UserBadgeAddController.
 *
 * @package Drupal\user_badges\Controller
 */
class UserBadgeAddController extends ControllerBase {
    public function __construct(EntityStorageInterface $storage, EntityStorageInterface $type_storage) {
      $this->storage = $storage;
      $this->typeStorage = $type_storage;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
      /** @var EntityManagerInterface $entity_manager */
      $entity_manager = $container->get('entity.manager');
      return new static(
        $entity_manager->getStorage('user_badge'),
        $entity_manager->getStorage('user_badge_type')
      );
    }
    /**
     * Displays add links for available bundles/types for entity user_badge .
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The current request object.
     *
     * @return array
     *   A render array for a list of the user_badge bundles/types that can be added or
     *   if there is only one type/bunlde defined for the site, the function returns the add page for that bundle/type.
     */
    public function add(Request $request) {
      $types = $this->typeStorage->loadMultiple();
      if ($types && count($types) == 1) {
        $type = reset($types);
        return $this->addForm($type, $request);
      }
      if (count($types) === 0) {
        return array(
          '#markup' => $this->t('You have not created any %bundle types yet. @link to add a new type.', [
            '%bundle' => 'User badge',
            '@link' => $this->l($this->t('Go to the type creation page'), Url::fromRoute('entity.user_badge_type.add_form')),
          ]),
        );
      }
      return array('#theme' => 'user_badge_content_add_list', '#content' => $types);
    }

    /**
     * Presents the creation form for user_badge entities of given bundle/type.
     *
     * @param EntityInterface $user_badge_type
     *   The custom bundle to add.
     * @param \Symfony\Component\HttpFoundation\Request $request
     *   The current request object.
     *
     * @return array
     *   A form array as expected by drupal_render().
     */
    public function addForm(EntityInterface $user_badge_type, Request $request) {
      $entity = $this->storage->create(array(
        'type' => $user_badge_type->id()
      ));
      return $this->entityFormBuilder()->getForm($entity);
    }

    /**
     * Provides the page title for this controller.
     *
     * @param EntityInterface $user_badge_type
     *   The custom bundle/type being added.
     *
     * @return string
     *   The page title.
     */
    public function getAddFormTitle(EntityInterface $user_badge_type) {
      return t('Create of bundle @label',
        array('@label' => $user_badge_type->label())
      );
    }

}
