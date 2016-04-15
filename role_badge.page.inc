<?php

/**
 * @file
 * Contains role_badge.page.inc.
 *
 * Page callback for Role badge entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Role badge templates.
 *
 * Default template: role_badge.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_role_badge(array &$variables) {
  // Fetch RoleBadge Entity Object.
  $role_badge = $variables['elements']['#role_badge'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
