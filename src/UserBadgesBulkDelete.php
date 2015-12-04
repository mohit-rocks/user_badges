<?php
namespace Drupal\user_badges;

class UserBadgesBulkDelete extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'user_badges_bulk_delete';
  }

  public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state, $bids = NULL) {
    $bids = explode('|', $bids);
    $user_badges = user_badge_load_multiple($bids);
    $form = [];
    $form_state->set(['bids'], $bids);
    $variables = [
      'type' => 'ul',
      'items' => [],
      'title' => '',
      'attributes' => [],
    ];
    foreach ($user_badges as $user_badge) {
      $variables['items'][] = check_plain($user_badge->name);
    }
    $form['summary'] = ['#markup' => theme_item_list($variables)];
    return confirm_form($form, t('Delete these user badges?'), 'admin/content/user_badge', t('Are you sure you want to delete these user badges?'), t('Delete all'), t('Cancel'));
  }

  public function submitForm(array &$form, \Drupal\Core\Form\FormStateInterface $form_state) {
    $bids = $form_state->get(['bids']);
    user_badge_delete_multiple($bids);
    drupal_set_message(t('User Badges deleted'));
    drupal_goto('admin/content/user_badge');
  }

}
