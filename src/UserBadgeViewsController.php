<?php
namespace Drupal\user_badges;

/**
 * Custom controller for the views
 */
class UserBadgeViewsController extends EntityDefaultViewsController {

  /**
   * Extra data to views_data().
   */
  public function views_data() {
    $data = parent::views_data();

    // Replace Created and Changed handler by views data handler.
    $data['user_badge']['created']['field']['handler'] = 'views_handler_field_date';
    $data['user_badge']['changed']['field']['handler'] = 'views_handler_field_date';
    $data['user_badge']['created']['filter']['handler'] = 'views_handler_filter_date';
    $data['user_badge']['changed']['filter']['handler'] = 'views_handler_filter_date';

    $data['user_badges_assignment']['table']['group']  = t('User Badges Assignments');

    $data['user_badges_assignment']['table']['base'] = array(
      'field' => 'uba_id',
      'title' => t('User Badges Assignments'),
      'help' => t('Assignments of user badges to users'),
      'weight' => -10,
      'defaults' => array(
        'field' => 'uba_id',
      ),
    );

    $data['user_badges_assignment']['uba_id'] = array(
      'title' => t('User Badge Assignment ID'),
      'help' => t('The raw numeric ID.'),
      'real field' => 'uba_id',
      'field' => array(
        'title' => t('User Badge Assignment ID'),
        'uba_id' => t('User Badges Assignments ID'),
        'handler' => 'views_handler_field',
      ),
      'filter' => array(
        'title' => t('User Badge Assignment ID'),
        'uba_id' => t('User Badges Assignments ID'),
        'handler' => 'views_handler_filter_numeric',
      ),
      'sort' => array(
        'title' => t('User Badge Assignment ID'),
        'uba_id' => t('User Badges Assignments ID'),
        'handler' => 'views_handler_sort_numeric',
      ),
    );

    $data['user_badges_assignment']['uid'] = array(
      'title' => t('Assigned user'),
      'help' => t('The user assigned'),
      'relationship' => array(
        'title' => t('User'),
        'help' => t('Relate with assigned user.'),
        'handler' => 'views_handler_relationship',
        'base' => 'users',
        'field' => 'uid',
        'label' => t('Assigned user'),
      ),
      'filter' => array(
        'handler' => 'views_handler_filter_user_name',
      ),
      'argument' => array(
        'handler' => 'views_handler_argument_numeric',
      ),
      'field' => array(
        'handler' => 'views_handler_field_user',
      ),
    );

    $data['user_badges_assignment']['bid'] = array(
      'title' => t('User Badge'),
      'help' => t('User Badge'),
      'relationship' => array(
        'handler' => 'views_handler_relationship',
        'base' => 'user_badge',
        'base_field' => 'bid',
        'label' => t('User Badge'),
      ),
      'filter' => array(
        'handler' => 'views_handler_filter_numeric',
      ),
      'field' => array(
        'handler' => 'views_handler_field',
      ),
    );

    $data['user_badges_assignment']['weight'] = array(
      'title' => t('User Badge Assignment Weight'),
      'help' => t('User Badge'),
      'filter' => array(
        'handler' => 'views_handler_filter_numeric',
      ),
      'field' => array(
        'handler' => 'views_handler_field',
      ),
      'sort' => array(
        'handler' => 'views_handler_sort',
      ),
    );

    $data['user_badges_assignment']['type'] = array(
      'title' => t('Type'),
      'help' => t('Type of the assigment.'),
      'field' => array(
        'field' => 'Type',
        'handler' => 'user_badge_assignment_type',
        'click sortable' => TRUE,
      ),
      'sort' => array(
        'handler' => 'views_handler_sort',
      ),
      'filter' => array(
        'handler' => 'views_handler_filter_string',
      ),
      'argument' => array(
        'handler' => 'views_handler_argument_string',
      ),
    );

    $data['user_badges_assignment']['table']['join'] = array(
      'user_badge' => array(
        'left_field' => 'bid',
        'field' => 'bid',
        'handler' => 'views_join',
        'left_table' => 'user_badge',
      ),
    );

    return $data;
  }

}
