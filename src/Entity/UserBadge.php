<?php
/**
 * @file
 * Contains \Drupal\user_badges\Entity\UserBadge.
 */

namespace Drupal\user_badges\Entity;

use Drupal\Component\Datetime\DateTimePlus;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityMalformedException;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Field\FieldDefinition;
use Drupal\user\UserInterface;

/**
 * Defines the User Badge entity.
 *
 * @ingroup userbadge
 *
 * @ContentEntityType(
 *   id = "badge",
 *   label = @Translation("User Badge"),
 *   handlers = {
 *     "storage" = "Drupal\user_badges\BadgeStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\user_badges\BadgeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\user_badges\Form\UserBadgeAddForm",
 *       "edit" = "Drupal\user_badges\Form\UserBadgeEditForm",
 *       "delete" = "Drupal\user_badges\Form\UserBadgeDeleteForm"
 *     },
 *     "access" = "Drupal\rewards\UserBadgeAccessController",
 *   },
 *   base_table = "user_badge",
 *   admin_permission = "administer user badge entities",
 *   fieldable = TRUE,
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "bid",
 *     "label" = "description",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "user_badges.view",
 *     "edit-form" = "user_badges.edit",
 *     "admin-form" = "user_badges.settings",
 *     "delete-form" = "user_badges.delete"
 *   }
 * )
 */
class UserBadge extends ContentEntityBase Implements FieldableEntityInterface  {
  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->get('bid')->value;
  }

    /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);

    $giver = $this->getOwner();
    $receiver = $this->getReceiverUser();

    if (!static::canSendBonus($giver, $receiver, $this->getBonusAmount(), $error)) {
      // @TODO: Use a better exception.
      throw new EntityMalformedException($error);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields['bid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Badge ID'))
      ->setDescription(t('The ID of the User badge entity.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The badge UUID.'))
      ->setReadOnly(TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language'))
      ->setDescription(t('The term language code.'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'type' => 'hidden',
      ))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 2,
      ));

    $fields['created'] = FieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = FieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }
}
