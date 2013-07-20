<?php

/**
 * Implements hook_views_default_views().
 * Generated using Views "export" with minor manual edits.
 */
function fivestar_rec_views_default_views() {
  $views = array();

  $view = _fivestar_rec_views_similar_nodes();
  $views[$view->name] = $view;

  $view = _fivestar_rec_views_recommendation_by_items();
  $views[$view->name] = $view;

  $view = _fivestar_rec_views_similar_users();
  $views[$view->name] = $view;

  $view = _fivestar_rec_views_recommendation_by_users();
  $views[$view->name] = $view;

  return $views;
}


function _fivestar_rec_views_similar_nodes() {
  $view = new view;
  $view->name = 'fivestar_rec_similar_nodes';
  $view->description = 'Display nodes that received similar votes from the same users to the current node.';
  $view->tag = 'recommendation';
  $view->base_table = 'recommender_similarity';
  $view->human_name = 'Fivestar recommender: similar nodes (by votes)';
  $view->core = 7;
  $view->api_version = '3.0-alpha1';
  $view->disabled = TRUE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Fivestar recommender: similar nodes (by votes)';
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '5';
  $handler->display->display_options['style_plugin'] = 'list';
  $handler->display->display_options['row_plugin'] = 'fields';
  /* Relationship: Recommender Similarity: Entity ID (Target) */
  $handler->display->display_options['relationships']['target_eid']['id'] = 'target_eid';
  $handler->display->display_options['relationships']['target_eid']['table'] = 'recommender_similarity';
  $handler->display->display_options['relationships']['target_eid']['field'] = 'target_eid';
  $handler->display->display_options['relationships']['target_eid']['required'] = 1;
  $handler->display->display_options['relationships']['target_eid']['base_entity_type'] = 'node';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['relationship'] = 'target_eid';
  $handler->display->display_options['fields']['title']['label'] = '';
  $handler->display->display_options['fields']['title']['alter']['alter_text'] = 0;
  $handler->display->display_options['fields']['title']['alter']['make_link'] = 0;
  $handler->display->display_options['fields']['title']['alter']['absolute'] = 0;
  $handler->display->display_options['fields']['title']['alter']['external'] = 0;
  $handler->display->display_options['fields']['title']['alter']['replace_spaces'] = 0;
  $handler->display->display_options['fields']['title']['alter']['trim'] = 0;
  $handler->display->display_options['fields']['title']['alter']['nl2br'] = 0;
  $handler->display->display_options['fields']['title']['alter']['word_boundary'] = 1;
  $handler->display->display_options['fields']['title']['alter']['ellipsis'] = 1;
  $handler->display->display_options['fields']['title']['alter']['strip_tags'] = 0;
  $handler->display->display_options['fields']['title']['alter']['html'] = 0;
  $handler->display->display_options['fields']['title']['element_label_colon'] = 0;
  $handler->display->display_options['fields']['title']['element_default_classes'] = 1;
  $handler->display->display_options['fields']['title']['hide_empty'] = 1;
  $handler->display->display_options['fields']['title']['empty_zero'] = 0;
  $handler->display->display_options['fields']['title']['link_to_node'] = 1;
  /* Sort criterion: Recommender Similarity: Similarity score */
  $handler->display->display_options['sorts']['score']['id'] = 'score';
  $handler->display->display_options['sorts']['score']['table'] = 'recommender_similarity';
  $handler->display->display_options['sorts']['score']['field'] = 'score';
  $handler->display->display_options['sorts']['score']['order'] = 'DESC';
  /* Sort criterion: Content: Updated/commented date */
  $handler->display->display_options['sorts']['last_updated']['id'] = 'last_updated';
  $handler->display->display_options['sorts']['last_updated']['table'] = 'node_comment_statistics';
  $handler->display->display_options['sorts']['last_updated']['field'] = 'last_updated';
  $handler->display->display_options['sorts']['last_updated']['relationship'] = 'target_eid';
  $handler->display->display_options['sorts']['last_updated']['order'] = 'DESC';
  /* Contextual filter: Recommender Similarity: Entity ID (Source) */
  $handler->display->display_options['arguments']['source_eid']['id'] = 'source_eid';
  $handler->display->display_options['arguments']['source_eid']['table'] = 'recommender_similarity';
  $handler->display->display_options['arguments']['source_eid']['field'] = 'source_eid';
  $handler->display->display_options['arguments']['source_eid']['default_action'] = 'default';
  $handler->display->display_options['arguments']['source_eid']['default_argument_type'] = 'node';
  $handler->display->display_options['arguments']['source_eid']['default_argument_skip_url'] = 0;
  $handler->display->display_options['arguments']['source_eid']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['source_eid']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['source_eid']['summary_options']['items_per_page'] = '25';
  $handler->display->display_options['arguments']['source_eid']['break_phrase'] = 0;
  $handler->display->display_options['arguments']['source_eid']['not'] = 0;
  /* Filter criterion: Recommender Application: Application name */
  $handler->display->display_options['filters']['name']['id'] = 'name';
  $handler->display->display_options['filters']['name']['table'] = 'recommender_app';
  $handler->display->display_options['filters']['name']['field'] = 'name';
  $handler->display->display_options['filters']['name']['value'] = array(
    'fivestar_rec_i2i' => 'fivestar_rec_i2i',
  );
  /* Filter criterion: Recommender Similarity: Similarity score */
  $handler->display->display_options['filters']['score']['id'] = 'score';
  $handler->display->display_options['filters']['score']['table'] = 'recommender_similarity';
  $handler->display->display_options['filters']['score']['field'] = 'score';
  $handler->display->display_options['filters']['score']['operator'] = '>';
  $handler->display->display_options['filters']['score']['value']['value'] = '0';

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block');

  return $view;
}

function _fivestar_rec_views_recommendation_by_items() {
  $view = new view;
  $view->name = 'fivestar_rec_recommendation_by_items';
  $view->description = 'Display recommended nodes based on users\' preference on similar nodes.';
  $view->tag = 'recommendation';
  $view->base_table = 'recommender_prediction';
  $view->human_name = 'Fivestar recommender: recommendations (from similar nodes)';
  $view->core = 7;
  $view->api_version = '3.0-alpha1';
  $view->disabled = TRUE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Fivestar recommender: recommendations (from similar nodes)';
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '5';
  $handler->display->display_options['style_plugin'] = 'list';
  $handler->display->display_options['row_plugin'] = 'fields';
  /* Relationship: Recommender Prediction: Entity ID (Target) */
  $handler->display->display_options['relationships']['target_eid']['id'] = 'target_eid';
  $handler->display->display_options['relationships']['target_eid']['table'] = 'recommender_prediction';
  $handler->display->display_options['relationships']['target_eid']['field'] = 'target_eid';
  $handler->display->display_options['relationships']['target_eid']['required'] = 1;
  $handler->display->display_options['relationships']['target_eid']['base_entity_type'] = 'node';
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['relationship'] = 'target_eid';
  $handler->display->display_options['fields']['title']['label'] = '';
  $handler->display->display_options['fields']['title']['alter']['alter_text'] = 0;
  $handler->display->display_options['fields']['title']['alter']['make_link'] = 0;
  $handler->display->display_options['fields']['title']['alter']['absolute'] = 0;
  $handler->display->display_options['fields']['title']['alter']['external'] = 0;
  $handler->display->display_options['fields']['title']['alter']['replace_spaces'] = 0;
  $handler->display->display_options['fields']['title']['alter']['trim'] = 0;
  $handler->display->display_options['fields']['title']['alter']['nl2br'] = 0;
  $handler->display->display_options['fields']['title']['alter']['word_boundary'] = 1;
  $handler->display->display_options['fields']['title']['alter']['ellipsis'] = 1;
  $handler->display->display_options['fields']['title']['alter']['strip_tags'] = 0;
  $handler->display->display_options['fields']['title']['alter']['html'] = 0;
  $handler->display->display_options['fields']['title']['element_label_colon'] = 0;
  $handler->display->display_options['fields']['title']['element_default_classes'] = 1;
  $handler->display->display_options['fields']['title']['hide_empty'] = 1;
  $handler->display->display_options['fields']['title']['empty_zero'] = 0;
  $handler->display->display_options['fields']['title']['link_to_node'] = 1;
  /* Sort criterion: Recommender Prediction: Prediction score */
  $handler->display->display_options['sorts']['score']['id'] = 'score';
  $handler->display->display_options['sorts']['score']['table'] = 'recommender_prediction';
  $handler->display->display_options['sorts']['score']['field'] = 'score';
  $handler->display->display_options['sorts']['score']['order'] = 'DESC';
  /* Sort criterion: Content: Updated/commented date */
  $handler->display->display_options['sorts']['last_updated']['id'] = 'last_updated';
  $handler->display->display_options['sorts']['last_updated']['table'] = 'node_comment_statistics';
  $handler->display->display_options['sorts']['last_updated']['field'] = 'last_updated';
  $handler->display->display_options['sorts']['last_updated']['relationship'] = 'target_eid';
  $handler->display->display_options['sorts']['last_updated']['order'] = 'DESC';
  /* Contextual filter: Recommender Prediction: Entity ID (Source) */
  $handler->display->display_options['arguments']['source_eid']['id'] = 'source_eid';
  $handler->display->display_options['arguments']['source_eid']['table'] = 'recommender_prediction';
  $handler->display->display_options['arguments']['source_eid']['field'] = 'source_eid';
  $handler->display->display_options['arguments']['source_eid']['default_action'] = 'default';
  $handler->display->display_options['arguments']['source_eid']['default_argument_type'] = 'current_user';
  $handler->display->display_options['arguments']['source_eid']['default_argument_skip_url'] = 0;
  $handler->display->display_options['arguments']['source_eid']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['source_eid']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['source_eid']['summary_options']['items_per_page'] = '25';
  $handler->display->display_options['arguments']['source_eid']['break_phrase'] = 0;
  $handler->display->display_options['arguments']['source_eid']['not'] = 0;
  /* Filter criterion: Recommender Application: Application name */
  $handler->display->display_options['filters']['name']['id'] = 'name';
  $handler->display->display_options['filters']['name']['table'] = 'recommender_app';
  $handler->display->display_options['filters']['name']['field'] = 'name';
  $handler->display->display_options['filters']['name']['value'] = array(
    'fivestar_rec_i2i' => 'fivestar_rec_i2i',
  );
  /* Filter criterion: Recommender Prediction: Prediction score */
  $handler->display->display_options['filters']['score']['id'] = 'score';
  $handler->display->display_options['filters']['score']['table'] = 'recommender_prediction';
  $handler->display->display_options['filters']['score']['field'] = 'score';
  $handler->display->display_options['filters']['score']['operator'] = '>';
  $handler->display->display_options['filters']['score']['value']['value'] = '0';

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block');

  return $view;
}

function _fivestar_rec_views_similar_users() {
  $view = new view;
  $view->name = 'fivestar_rec_similar_users';
  $view->description = 'Display users who have similar votes as the current user.';
  $view->tag = 'recommendation';
  $view->base_table = 'recommender_similarity';
  $view->human_name = 'Fivestar recommender: similar users (by votes)';
  $view->core = 7;
  $view->api_version = '3.0-alpha1';
  $view->disabled = TRUE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Fivestar recommender: similar users (by votes)';
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '5';
  $handler->display->display_options['style_plugin'] = 'list';
  $handler->display->display_options['row_plugin'] = 'fields';
  /* Relationship: Recommender Similarity: Entity ID (Target) */
  $handler->display->display_options['relationships']['target_eid']['id'] = 'target_eid';
  $handler->display->display_options['relationships']['target_eid']['table'] = 'recommender_similarity';
  $handler->display->display_options['relationships']['target_eid']['field'] = 'target_eid';
  $handler->display->display_options['relationships']['target_eid']['required'] = 1;
  $handler->display->display_options['relationships']['target_eid']['base_entity_type'] = 'users';
  /* Field: User: Name */
  $handler->display->display_options['fields']['name']['id'] = 'name';
  $handler->display->display_options['fields']['name']['table'] = 'users';
  $handler->display->display_options['fields']['name']['field'] = 'name';
  $handler->display->display_options['fields']['name']['relationship'] = 'target_eid';
  $handler->display->display_options['fields']['name']['label'] = '';
  $handler->display->display_options['fields']['name']['alter']['alter_text'] = 0;
  $handler->display->display_options['fields']['name']['alter']['make_link'] = 0;
  $handler->display->display_options['fields']['name']['alter']['absolute'] = 0;
  $handler->display->display_options['fields']['name']['alter']['external'] = 0;
  $handler->display->display_options['fields']['name']['alter']['replace_spaces'] = 0;
  $handler->display->display_options['fields']['name']['alter']['trim'] = 0;
  $handler->display->display_options['fields']['name']['alter']['nl2br'] = 0;
  $handler->display->display_options['fields']['name']['alter']['word_boundary'] = 1;
  $handler->display->display_options['fields']['name']['alter']['ellipsis'] = 1;
  $handler->display->display_options['fields']['name']['alter']['strip_tags'] = 0;
  $handler->display->display_options['fields']['name']['alter']['html'] = 0;
  $handler->display->display_options['fields']['name']['element_label_colon'] = 0;
  $handler->display->display_options['fields']['name']['element_default_classes'] = 1;
  $handler->display->display_options['fields']['name']['hide_empty'] = 1;
  $handler->display->display_options['fields']['name']['empty_zero'] = 0;
  $handler->display->display_options['fields']['name']['link_to_user'] = 1;
  $handler->display->display_options['fields']['name']['overwrite_anonymous'] = 0;
  /* Sort criterion: Recommender Similarity: Similarity score */
  $handler->display->display_options['sorts']['score']['id'] = 'score';
  $handler->display->display_options['sorts']['score']['table'] = 'recommender_similarity';
  $handler->display->display_options['sorts']['score']['field'] = 'score';
  $handler->display->display_options['sorts']['score']['order'] = 'DESC';
  /* Sort criterion: User: Last login */
  $handler->display->display_options['sorts']['login']['id'] = 'login';
  $handler->display->display_options['sorts']['login']['table'] = 'users';
  $handler->display->display_options['sorts']['login']['field'] = 'login';
  $handler->display->display_options['sorts']['login']['relationship'] = 'target_eid';
  $handler->display->display_options['sorts']['login']['order'] = 'DESC';
  /* Contextual filter: Recommender Similarity: Entity ID (Source) */
  $handler->display->display_options['arguments']['source_eid']['id'] = 'source_eid';
  $handler->display->display_options['arguments']['source_eid']['table'] = 'recommender_similarity';
  $handler->display->display_options['arguments']['source_eid']['field'] = 'source_eid';
  $handler->display->display_options['arguments']['source_eid']['default_action'] = 'default';
  $handler->display->display_options['arguments']['source_eid']['default_argument_type'] = 'current_user';
  $handler->display->display_options['arguments']['source_eid']['default_argument_skip_url'] = 0;
  $handler->display->display_options['arguments']['source_eid']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['source_eid']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['source_eid']['summary_options']['items_per_page'] = '25';
  $handler->display->display_options['arguments']['source_eid']['break_phrase'] = 0;
  $handler->display->display_options['arguments']['source_eid']['not'] = 0;
  /* Filter criterion: Recommender Application: Application name */
  $handler->display->display_options['filters']['name']['id'] = 'name';
  $handler->display->display_options['filters']['name']['table'] = 'recommender_app';
  $handler->display->display_options['filters']['name']['field'] = 'name';
  $handler->display->display_options['filters']['name']['value'] = array(
    'fivestar_rec_u2u' => 'fivestar_rec_u2u',
  );
  /* Filter criterion: Recommender Similarity: Similarity score */
  $handler->display->display_options['filters']['score']['id'] = 'score';
  $handler->display->display_options['filters']['score']['table'] = 'recommender_similarity';
  $handler->display->display_options['filters']['score']['field'] = 'score';
  $handler->display->display_options['filters']['score']['operator'] = '>';
  $handler->display->display_options['filters']['score']['value']['value'] = '0';

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block');

  return $view;
}

function _fivestar_rec_views_recommendation_by_users() {
  $view = new view;
  $view->name = 'fivestar_rec_recommendation_by_users';
  $view->description = 'Display recommended nodes to the current user based on similar users\' preferences.';
  $view->tag = 'recommendation';
  $view->base_table = 'recommender_prediction';
  $view->human_name = 'Fivestar recommender: recommendations (from similar users)';
  $view->core = 7;
  $view->api_version = '3.0-alpha1';
  $view->disabled = TRUE; /* Edit this to true to make a default view disabled initially */

  /* Display: Master */
  $handler = $view->new_display('default', 'Master', 'default');
  $handler->display->display_options['title'] = 'Fivestar recommender: recommendations (from similar users)';
  $handler->display->display_options['access']['type'] = 'none';
  $handler->display->display_options['cache']['type'] = 'none';
  $handler->display->display_options['query']['type'] = 'views_query';
  $handler->display->display_options['exposed_form']['type'] = 'basic';
  $handler->display->display_options['pager']['type'] = 'full';
  $handler->display->display_options['pager']['options']['items_per_page'] = '5';
  $handler->display->display_options['style_plugin'] = 'list';
  $handler->display->display_options['row_plugin'] = 'fields';
  /* Relationship: Recommender Prediction: Entity ID (Target) */
  $handler->display->display_options['relationships']['target_eid']['id'] = 'target_eid';
  $handler->display->display_options['relationships']['target_eid']['table'] = 'recommender_prediction';
  $handler->display->display_options['relationships']['target_eid']['field'] = 'target_eid';
  $handler->display->display_options['relationships']['target_eid']['required'] = 1;
  /* Field: Content: Title */
  $handler->display->display_options['fields']['title']['id'] = 'title';
  $handler->display->display_options['fields']['title']['table'] = 'node';
  $handler->display->display_options['fields']['title']['field'] = 'title';
  $handler->display->display_options['fields']['title']['relationship'] = 'target_eid';
  $handler->display->display_options['fields']['title']['label'] = '';
  $handler->display->display_options['fields']['title']['alter']['alter_text'] = 0;
  $handler->display->display_options['fields']['title']['alter']['make_link'] = 0;
  $handler->display->display_options['fields']['title']['alter']['absolute'] = 0;
  $handler->display->display_options['fields']['title']['alter']['external'] = 0;
  $handler->display->display_options['fields']['title']['alter']['replace_spaces'] = 0;
  $handler->display->display_options['fields']['title']['alter']['trim'] = 0;
  $handler->display->display_options['fields']['title']['alter']['nl2br'] = 0;
  $handler->display->display_options['fields']['title']['alter']['word_boundary'] = 1;
  $handler->display->display_options['fields']['title']['alter']['ellipsis'] = 1;
  $handler->display->display_options['fields']['title']['alter']['strip_tags'] = 0;
  $handler->display->display_options['fields']['title']['alter']['html'] = 0;
  $handler->display->display_options['fields']['title']['element_label_colon'] = 0;
  $handler->display->display_options['fields']['title']['element_default_classes'] = 1;
  $handler->display->display_options['fields']['title']['hide_empty'] = 1;
  $handler->display->display_options['fields']['title']['empty_zero'] = 0;
  $handler->display->display_options['fields']['title']['link_to_node'] = 1;
  /* Sort criterion: Recommender Prediction: Prediction score */
  $handler->display->display_options['sorts']['score']['id'] = 'score';
  $handler->display->display_options['sorts']['score']['table'] = 'recommender_prediction';
  $handler->display->display_options['sorts']['score']['field'] = 'score';
  $handler->display->display_options['sorts']['score']['order'] = 'DESC';
  /* Sort criterion: Content: Updated/commented date */
  $handler->display->display_options['sorts']['last_updated']['id'] = 'last_updated';
  $handler->display->display_options['sorts']['last_updated']['table'] = 'node_comment_statistics';
  $handler->display->display_options['sorts']['last_updated']['field'] = 'last_updated';
  $handler->display->display_options['sorts']['last_updated']['relationship'] = 'target_eid';
  $handler->display->display_options['sorts']['last_updated']['order'] = 'DESC';
  /* Contextual filter: Recommender Prediction: Entity ID (Source) */
  $handler->display->display_options['arguments']['source_eid']['id'] = 'source_eid';
  $handler->display->display_options['arguments']['source_eid']['table'] = 'recommender_prediction';
  $handler->display->display_options['arguments']['source_eid']['field'] = 'source_eid';
  $handler->display->display_options['arguments']['source_eid']['default_action'] = 'default';
  $handler->display->display_options['arguments']['source_eid']['default_argument_type'] = 'current_user';
  $handler->display->display_options['arguments']['source_eid']['default_argument_skip_url'] = 0;
  $handler->display->display_options['arguments']['source_eid']['summary']['number_of_records'] = '0';
  $handler->display->display_options['arguments']['source_eid']['summary']['format'] = 'default_summary';
  $handler->display->display_options['arguments']['source_eid']['summary_options']['items_per_page'] = '25';
  $handler->display->display_options['arguments']['source_eid']['break_phrase'] = 0;
  $handler->display->display_options['arguments']['source_eid']['not'] = 0;
  /* Filter criterion: Recommender Application: Application name */
  $handler->display->display_options['filters']['name']['id'] = 'name';
  $handler->display->display_options['filters']['name']['table'] = 'recommender_app';
  $handler->display->display_options['filters']['name']['field'] = 'name';
  $handler->display->display_options['filters']['name']['value'] = array(
    'fivestar_rec_u2u' => 'fivestar_rec_u2u',
  );
  /* Filter criterion: Recommender Prediction: Prediction score */
  $handler->display->display_options['filters']['score']['id'] = 'score';
  $handler->display->display_options['filters']['score']['table'] = 'recommender_prediction';
  $handler->display->display_options['filters']['score']['field'] = 'score';
  $handler->display->display_options['filters']['score']['operator'] = '>';
  $handler->display->display_options['filters']['score']['value']['value'] = '0';

  /* Display: Block */
  $handler = $view->new_display('block', 'Block', 'block');

  return $view;
}