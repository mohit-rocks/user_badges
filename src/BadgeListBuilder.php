<?php

/**
 * @file
 * Contains \Drupal\user_badges\BadgeListBuilder.
 */

namespace Drupal\user_badges;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a class to build a listing of Badge entities.
 *
 * @ingroup user_badges
 */
class BadgeListBuilder extends EntityListBuilder implements FormInterface{
  use LinkGeneratorTrait;

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Badge ID');
    $header['name'] = $this->t('Name');
    $header['badge_image'] = $this->t('Badge Image');
    $header['weight'] = $this->t('Weight');
    $header['roles']['data'] = $this->t('Role');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\user_badges\Entity\Badge */
    $row['id'] = $entity->id();
    $row['name'] = Link::fromTextAndUrl(
      $entity->label(),
      new Url(
        'entity.badge.edit_form', array(
          'badge' => $entity->id(),
        )
      )
    );
    $row['badge_image'] = array(
      '#theme' => 'image_style',
      '#style_name' => 'thumbnail',
      '#uri' => $entity->image->entity->getFileUri(),
      '#title' => $entity->label(),
    );
    $row['weight'] = $entity->getBadgeWeight();

    $users_roles = $entity->getBadgeRoleIds();
    $row['roles']['data'] = array(
      '#theme' => 'item_list',
      '#items' => $users_roles,
    );
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   *
   * @param string|null $theme
   *   (optional) The theme to display the blocks for. If NULL, the current
   *   theme will be used.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   *
   * @return array
   *   The block list as a renderable array.
   */
  public function render($user) {

    return $this->formBuilder->getForm($this);
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'badge_arrange_form_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attached']['library'][] = 'core/drupal.tableheader';
    $form['#attached']['library'][] = 'block/drupal.block';
    $form['#attached']['library'][] = 'block/drupal.block.admin';
    $form['#attributes']['class'][] = 'clearfix';

    // Build the form tree.


    $form['actions'] = array(
      '#tree' => FALSE,
      '#type' => 'actions',
    );
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save blocks'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // No validation.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }

}
