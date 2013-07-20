<?php

/**
 * @file
 * recipe.views.inc - Views2 support for Recipe.
 *
 * Views support for the recipe module includes recipe lists, and ingredient lists.
 *
 * Added by Scott Prive Dec 2009
 */


/* Recipe Schema: This will probably get out of date(it already is!), but once this works better let's remove this.

node.nid +--------------+     +------------------+     +-------------+
     ^   | recipe       |     | _node_ingredient |     | _ingredient |
     |   +--------------+     +------------------+     +-------------+
     +---| nid          |<--  | id               |   +-| id          |
         | source       |  +--| nid              |   | | name        |
         | yield        |     | unit_key         |<-+| | link        |
         | yield_unit   |     | weight           |     +-------------+
         | description  |     | note             |
         | instructions |     | quantity         |
         | notes        |     | ingredient_id    |
         | preptime     |     +------------------+
         | cooktime     |
         +--------------+

 TODO:
  1) Impliment a  pre_render_list based handler function, to get all recipe ingredients based on a recipe nid.
  The idea is to have that fetch the ingredients, so I avoid the duplicate fields.
  (Anything that's not an ingredient should appear once, but gets duplicated).
  views_handler_field_amazon_participant.inc contains an example solution.

*/



/**
 * Implementation of hook_views_data().
 */
function dieta_recipe_views_data() {


  /*
   * Recipe table section.
   */

  // Group
  $data['dieta_recipe']['table']['group'] = t('Recipe');

  /* Base
   * It doesn't really make sense to include the recipe table by itself.  It doesn't even include the recipe title.
   * Since we include the recipe table joined to node you get all of the recipe fields anyway.
   */

  // Joins
  $data['dieta_recipe']['table']['join']['node'] = array(
    'left_field'    => 'nid',
    'field'         => 'nid',
  );

  // Fields
  $data['dieta_recipe']['source'] = array(
    'title' => t('Source'),
    'help' => t("Optional. Does anyone else deserve credit for this recipe?"),
    'field' => array(
      'handler' => 'views_handler_field',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  $data['dieta_recipe']['yield'] = array(
    'title' => t('Yield'),
    'help' => t("The number of servings for this recipe."),
    'field' => array(
      'handler' => 'views_handler_field',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_numeric',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_numeric',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  $data['dieta_recipe']['yield_unit'] = array(
    'title' => t('Yield unit'),
    'help' => t("The yield unit for this recipe."),
    'field' => array(
      'handler' => 'views_handler_field',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  $data['dieta_recipe']['description'] = array(
    'title' => t('Description'),
    'help' => t("The description for this recipe."),
    'field' => array(
      'handler' => 'views_handler_field_xss',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  $data['dieta_recipe']['instructions'] = array(
    'title' => t('Instructions'),
    'help' => t("The instructions for this recipe."),
    'field' => array(
      'handler' => 'views_handler_field_xss',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  $data['dieta_recipe']['notes'] = array(
    'title' => t('Notes'),
    'help' => t("The notes for this recipe."),
    'field' => array(
      'handler' => 'views_handler_field_xss',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_string',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_string',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  $data['dieta_recipe']['preptime'] = array(
    'title' => t('Prep time'),
    'help' => t("The prep time for this recipe."),
    'field' => array(
      'handler' => 'views_handler_field',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_numeric',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_numeric',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  $data['dieta_recipe']['cooktime'] = array(
    'title' => t('Cook time'),
    'help' => t("The cook time for this recipe."),
    'field' => array(
      'handler' => 'views_handler_field',
    ),
    'argument' => array(
      'handler' => 'views_handler_argument_numeric',
    ),
    'filter' => array(
      'handler' => 'views_handler_filter_numeric',
    ),
    'sort' => array(
      'handler' => 'views_handler_sort',
    ),
  );

  return $data;
}