<?php

/**
 * Implements hook_views_default_views().
 */
function history_rec_views_default_views() {
  return array(
    'history_rec_similar_nodes' => recommender_default_view_template(
      'history_rec_similar_nodes',
      'Browsing History Recommender: similar nodes',
      'Display on a node page "users who have browsed this node also browsed".',
      'recommender_similarity',
      'node',
      'title',
      'node',
      'history_rec'
    ),
    'history_rec_personal_recommendations' => recommender_default_view_template(
      'history_rec_personal_recommendations',
      'Browsing History Recommender: personal recommendations',
      'Recommend to the current user other nodes this user might be interested based on the users browsing history',
      'recommender_prediction',
      'node',
      'title',
      'current_user',
      'history_rec'
    ),
  );
}