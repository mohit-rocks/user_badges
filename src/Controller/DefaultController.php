<?php /**
 * @file
 * Contains \Drupal\user_badges\Controller\DefaultController.
 */

namespace Drupal\user_badges\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Default controller for the user_badges module.
 */
class DefaultController extends ControllerBase {

  public function user_badges_access_menu_callback($op, $user_badge = NULL, Drupal\Core\Session\AccountInterface $account = NULL) {
    switch ($op) {
      case 'view':
        return $account->hasPermission('view user badge entities');

      case 'create':
        return $account->hasPermission('create user badge entities');

      case 'update':
        return $account->hasPermission('edit user badge entities');

      case 'delete':
        return $account->hasPermission('delete user badge entities');

    }
    return FALSE;
  }

  public function user_badges_view_entity($user_badge) {
    $name = $user_badge->name;
    // @FIXME
    // drupal_set_title() has been removed. There are now a few ways to set the title
    // dynamically, depending on the situation.
    // 
    // 
    // @see https://www.drupal.org/node/2067859
    // drupal_set_title($name);

    $uri = entity_uri('user_badge', $user_badge);
    // Set the node path as the canonical URL to prevent duplicate content.
    // @FIXME
    // url() expects a route name or an external URI.
    // drupal_add_html_head_link(array(
    //     'rel' => 'canonical',
    //     'href' => url($uri['path'],
    //     $uri['options'])), TRUE);

    // Set the non-aliased path as a default shortlink.
    // @FIXME
    // url() expects a route name or an external URI.
    // drupal_add_html_head_link(array(
    //     'rel' => 'shortlink',
    //     'href' => url($uri['path'], array_merge($uri['options'], array('alias' => TRUE)))), TRUE);

    return user_badges_show($user_badge);
  }

  public function user_badges_userweight_page(\Drupal\user\UserInterface $account) {
    $user = \Drupal::currentUser();

    // @FIXME
    // drupal_set_title() has been removed. There are now a few ways to set the title
    // dynamically, depending on the situation.
    // 
    // 
    // @see https://www.drupal.org/node/2067859
    // drupal_set_title(t('Badges for %user_name', array('%user_name' => format_username($account))), PASS_THROUGH);


    // Do we have the right to rearrange badges?
    if (\Drupal::config('user_badges.settings')->get('user_badges_userweight') && ($account->id() == $user->uid || \Drupal::currentUser()->hasPermission('change badge assignments'))) {
      // If the setting allows it and we are the badge owner
    // or somebody with permission, yes.
      return drupal_get_form('user_badges_userweight_form', $account);
    }
    else {
      return views_embed_view('user_badges_user', 'badges_list', $account->id());
    }
  }

  public function user_badges_page(\Drupal\user\UserInterface $account) {
    // @FIXME
// drupal_set_title() has been removed. There are now a few ways to set the title
// dynamically, depending on the situation.
// 
// 
// @see https://www.drupal.org/node/2067859
// drupal_set_title(t('Edit badges for %user_name', array('%user_name' => $account->name)), PASS_THROUGH);


    return drupal_get_form('user_badges_change_form', $account);
  }

}
