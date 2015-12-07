<?php

/**
 * @file
 * Contains user_badge.page.inc..
 *
 * Page callback for User Badge entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for User Badge templates.
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
