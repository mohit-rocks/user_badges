<?php

/**
 * @file
 * Contains user_badge.page.inc..
 *
 * Page callback for User badge entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for User badge templates.
 *
 * Default template: user_badge.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_user_badge(array &$variables) {
  // Fetch UserBadge Entity Object.
  $user_badge = $variables['elements']['#user_badge'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}

/**
* Prepares variables for a custom entity type creation list templates.
*
* Default template: user_badge-content-add-list.html.twig.
*
* @param array $variables
*   An associative array containing:
*   - content: An array of user_badge-types.
*
* @see block_content_add_page()
*/
function template_preprocess_user_badge_content_add_list(&$variables) {
  $variables['types'] = array();
  $query = \Drupal::request()->query->all();
  foreach ($variables['content'] as $type) {
    $variables['types'][$type->id()] = array(
      'link' => \Drupal::l($type->label(), new \Drupal\Core\Url('entity.user_badge.add_form', array(
        'user_badge_type' => $type->id()
      ), array('query' => $query))),
      'description' => array(
      '#markup' => $type->label(),
      ),
      'title' => $type->label(),
      'localized_options' => array(
      'query' => $query,
      ),
    );
  }
}
