<?php
namespace Drupal\user_badges;

/**
 * Custom controller for the administrator UI
 */
class UserBadgeUIController extends EntityDefaultUIController {

  /**
   * Override the menu hook for default ui controller.
   */
  public function hook_menu() {
    $items = parent::hook_menu();
    $items[$this->path]['description'] = t('Manage User Badge');
    $items[$this->path]['title'] = t('User Badges');
    return $items;
  }


  /**
   * Admin form for searching and doing bulk operations.
   */
  public function overviewForm($form, &$form_state) {
    $form['pager'] = array('#theme' => 'pager');
    $header = array(
      'name' => array('data' => t('Name'), 'field' => 'name'),
      'weight' => array('data' => t('Weight'), 'field' => 'weight'),
      'operations' => array('data' => t('Operations'), 'field' => 'operations'),
    );

    $items = array();
    $search_term = !empty($_GET['search']) ? $_GET['search'] : NULL;
    $query = new EntityFieldQuery();
    $query->entityCondition('entity_type', 'user_badge');
    if (!empty($search_term)) {
      $query->propertyCondition('name', '%' . $search_term . '%', 'like');
    }

    // Check for sort order and sort key.
    if (!empty($_GET['sort']) && !empty($_GET['order'])) {
      $sort = strtoupper($_GET['sort']);
      $order = strtolower($_GET['order']);
      $order = str_replace(' ', '_', $order);
      if ($order != 'operations') {
        $query->propertyOrderBy($order, $sort);
      }
    }
    $query->pager(10);
    $result = $query->execute();

    $user_badge_results = !empty($result['user_badge']) ? $result['user_badge'] : array();
    $user_badge_array = !empty($user_badge_results) ? user_badge_load_multiple(array_keys($user_badge_results)) : array();

    foreach ($user_badge_array as $bid => $user_badge) {
      // @FIXME
// l() expects a Url object, created from a route name or external URI.
// $items['bid-' . $bid] = array(
//         'name' => l($user_badge->name, 'user-badge/' . $user_badge->bid),
//         'weight' => $user_badge->weight,
//         'operations' =>
//         l(t('View'), 'user-badge/' . $user_badge->bid) . ' ' .
//         l(t('Edit'), 'admin/content/user_badge/manage/' . $bid, array('query' => array('destination' => 'admin/content/user_badge'))) . ' ' .
//         l(t('Delete'), 'admin/content/user_badge/manage/' . $bid . '/delete',
//           array(
//             'attributes' => array(
//               'class' => array('user_badge_delete-' . $user_badge->bid),
//             ),
//             'query' => array('destination' => 'admin/content/user_badge'))),
//       );

    }
    $form['search'] = array(
      '#type' => 'fieldset',
      '#title' => t('Basic Search'),
      '#collapsible' => TRUE,
      '#collapsed' => !empty($search_term) ? FALSE : TRUE,
    );
    $form['search']['search_text'] = array(
      '#type' => 'textfield',
      '#title' => t('Search Term'),
      '#default_value' => !empty($search_term) ? $search_term : '',
    );
    $form['search']['search_submit'] = array(
      '#type' => 'submit',
      '#value' => t('Search'),
    );
    $form['bulk_operations'] = array(
      '#type' => 'fieldset',
      '#title' => t('Bulk Operations'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );
    $form['bulk_operations']['operations'] = array(
      '#type' => 'select',
      '#options' => array(
        0 => t('Select a bulk operation'),
        'delete' => t('Delete selected user badge'),
      ),
    );
    $form['bulk_operations']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    $form['entities'] = array(
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $items,
      '#attributes' => array('class' => array('entity-sort-table')),
      '#empty' => t('There are no user badge.'),
    );
    return $form;
  }
  /**
   * Form Submit method.
   */
  public function overviewFormSubmit($form, &$form_state) {
    $values = $form_state['values'];
    $bids = array();
    if (!empty($values['entities'])) {
      foreach ($values['entities'] as $index => $value) {
        if (!empty($value)) {
          $bids[] = str_replace('bid-', '', $value);
        }
      }
      switch ($values['operations']) {
        case 'delete':
          drupal_goto('admin/content/user_badge/bulk/delete/' . implode('|', $bids));
          break;
      }
    }
    if (!empty($values['search_text'])) {
      drupal_goto('admin/content/user_badge', array('query' => array('search' => $values['search_text'])));
    }
  }

}
