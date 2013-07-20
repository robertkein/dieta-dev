<?php


/**
 * @file
 * dieta_recipe.admin.inc -contains all admin pages, settings, and validate.
 *
 * This file will only be parsed when processing admin menu options.
 * See http://drupal.org/node/146172
 */


/**
 * Settings form for menu callback
 */
function dieta_recipe_admin_settings() {
  $form['dieta_recipe_help'] = array(
    '#type' => 'textarea',
    '#title' => t('Explanation or submission guidelines'),
    '#default_value' => variable_get('dieta_recipe_help', ''),
    '#cols' => 55,
    '#rows' => 4,
    '#description' => t('This text will be displayed at the top of the dieta recipe submission form. Useful for helping or instructing your users.'),
  );

  $vocabularies = taxonomy_vocabulary_get_names();
  $options = array();
  foreach ($vocabularies as $machine_name => $vocabulary) {
    $options[$machine_name] = $vocabulary->name;
  }

  // Ingredient section
  $form['dieta_recipe_ingredients'] = array(
    '#type' => 'fieldset',
    '#title' => t('Recipe ingredient section'),
  );
  $form['dieta_recipe_ingredients']['dieta_recipe_taxonomy_vocabulary'] = array(
    '#type' => 'select',
    '#title' => t('Taxonomy vocabulary'),
    '#default_value' => DIETA_RECIPE_TAXONOMY_VOCABULARY,
    '#options' => $options,
    '#description' => t('Taxonomy vocabulary where to store recipe ingredients.'),
    '#required' => TRUE,
  );
  $form['dieta_recipe_ingredients']['dieta_recipe_fraction_display'] = array(
    '#type' => 'textfield',
    '#title' => t('Fractions display string'),
    '#default_value' => variable_get('dieta_recipe_fraction_display', t('{%d }%d&frasl;%d')),
    '#size' => 35,
    '#maxlength' => 255,
    '#description' => t('How fractions should be displayed. Leave blank to display as decimals. Each incidence of %d will be replaced by the whole number, the numerator, and the denominator in that order. Anything between curly braces will not be displayed when the whole number is equal to 0. Recommended settings are "{%d }%d&amp;frasl;%d" or "{%d }&lt;sup&gt;%d&lt;/sup&gt;/&lt;sub&gt;%d&lt;/sub&gt;"'),
  );
  $form['dieta_recipe_ingredients']['dieta_recipe_unit_display'] = array(
    '#type' => 'radios',
    '#title' => t('Ingredient unit display'),
    '#default_value' => variable_get('dieta_recipe_unit_display', 0),
    '#options' => array(t('Abbreviation'), t('Full name')),
    '#description' => t('Display ingredient units like Tbsp or Tablespoon.'),
    '#required' => TRUE,
  );

  // System of measurement section
  $form['dieta_recipe_ingredients']['system_of_measurement'] = array(
    '#type' => 'fieldset',
    '#title' => t('System of measurement'),
    '#theme' => 'dieta_recipe_system_of_measurement',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['dieta_recipe_ingredients']['system_of_measurement']['name'] = array(
    '#type' => 'textfield',
    '#size' => 10,
  );
  $form['dieta_recipe_ingredients']['system_of_measurement']['key'] = array(
    '#type' => 'machine_name',
    '#title' => FALSE,
    '#required' => FALSE,
    '#machine_name' => array(
      'exists' => 'dieta_recipe_unit_exists',
      'source' => array('dieta_recipe_ingredients', 'system_of_measurement', 'name'),
    ),
    '#description' => FALSE,
    '#size' => 10,
  );
  $form['dieta_recipe_ingredients']['system_of_measurement']['plural'] = array(
    '#type' => 'textfield',
    '#size' => 10,
  );
  $form['dieta_recipe_ingredients']['system_of_measurement']['abbreviation'] = array(
    '#type' => 'textfield',
    '#size' => 10,
  );
  $form['dieta_recipe_ingredients']['system_of_measurement']['weight'] = array(
    '#type' => 'textfield',
    '#size' => 10,
  );
  $form['dieta_recipe_ingredients']['system_of_measurement']['add'] = array(
    '#type' => 'submit',
    '#value' => t('Add'),
    '#submit' => array('dieta_recipe_system_of_measurement_submit'),
    '#validate' => array('dieta_recipe_system_of_measurement_validate'),
  );

  $form['dieta_recipe_ingredients']['dieta_recipe_ingredient_name_normalize'] = array(
    '#type' => 'radios',
    '#title' => t('Ingredient name normalization'),
    '#default_value' => variable_get('dieta_recipe_ingredient_name_normalize', 0),
    '#options' => array(t('Leave as entered'), t('Convert to lowercase')),
    '#description' => t('When recipes are entered, should ingredient names be converted or left alone?'),
    '#required' => TRUE,
  );
  $form['dieta_recipe_ingredients']['dieta_recipe_add_more_count'] = array(
    '#type' => 'textfield',
    '#title' => t('Add more ingredient count'),
    '#default_value' => variable_get('dieta_recipe_add_more_count', 5),
    '#size' => 5,
    '#maxlength' => 5,
    '#description' => t('How many ingredients to add when you click "more ingredients" on the recipe edit screen.'),
  );


  // Summary Section
  $form['dieta_recipe_summary'] = array(
    '#type' => 'fieldset',
    '#title' => t('Recipe summary'),
    '#description' => t('The recipe summary contains the yield, source, and prep time values.')
  );
  $form['dieta_recipe_summary']['dieta_recipe_summary_location'] = array(
    '#type' => 'radios',
    '#title' => t('Recipe summary location'),
    '#return_value' => 1,
    '#default_value' => variable_get('dieta_recipe_summary_location', 0),
    '#options' => array(t('Node content'), t('Block'), t('Hidden')),
    '#description' => t('Where to show the recipe summary information.'),
    '#required' => TRUE
  );
  $form['dieta_recipe_summary']['dieta_recipe_summary_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Recipe summary title'),
    '#default_value' => variable_get('dieta_recipe_summary_title', t('Summary')),
    '#size' => 35,
    '#maxlength' => 255,
    '#description' => t('The title shown above the recipe summary.'),
  );


  $form['dieta_recipe_recent_box'] = array(
    '#type' => 'fieldset',
    '#title' => t('Recent recipe box'),
  );
  $form['dieta_recipe_recent_box']['dieta_recipe_recent_box_enable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show recent recipes box'),
    '#return_value' => 1,
    '#default_value' => variable_get('dieta_recipe_recent_box_enable', 1),
    '#description' => t('Show the recent recipes box on the recipes menu page.'),
    '#required' => FALSE,
  );
  $form['dieta_recipe_recent_box']['dieta_recipe_recent_box_title'] = array(
    '#type' => 'textfield',
    '#title' => t('Box title'),
    '#default_value' => variable_get('dieta_recipe_recent_box_title', t('Latest recipes')),
    '#size' => 35,
    '#maxlength' => 255,
    '#description' => t('Title of the recent recipes box.'),
  );
  $form['dieta_recipe_recent_box']['dieta_recipe_recent_display'] = array(
    '#type' => 'select',
    '#title' => t('Recipes to display'),
    '#default_value' => variable_get('dieta_recipe_recent_display', 5),
    '#options' => drupal_map_assoc(array(0, 5, 10, 15)),
    '#description' => t('Sets the number of recent recipes that will be displayed in the Recent Recipes box. (0 = not displayed).'),
  );

  return system_settings_form($form);
}


function dieta_recipe_export_multi($type = NULL) {

  // load supported formats
  $formats = module_invoke_all('dieta_recipeio', 'export_multi');
  $o = t('Supported bulk output formats:');
  if ( $type === NULL ) {
    foreach ( $formats as $key => $format ) {
      $format_count = 0;
      if ($format) {
        $o .= '<br/>' . l($format['format_name'], "admin/content/dieta_recipe/export_multi/$key");
        $format_count++;
      }
    }
    if ( $format_count == 0 ) {
      $o .= '<br/><p>' . t('You have no export formats available with the bulk export feature.') . '</p>';
    }
    return $o;
  }

  // normalize typed urls
  $type = drupal_strtolower($type);

  // If callback exists, call it, otherwise error out.
  if (isset($formats[$type]) && function_exists($formats[$type]['callback'])) {
    $o = call_user_func($formats[$type]['callback']);
    return $o;
  }
  else {
    drupal_set_message(t('Unknown export format(%the_format).', array('%the_format' => $type)), 'error');
    drupal_not_found();
  }
}

function dieta_recipe_import_multi($type = NULL) {

  // load supported formats
  $formats = module_invoke_all('dieta_recipeio', 'import_multi');
  $o = t('Supported bulk input formats:');
  if ( $type === NULL ) {
    $format_count = 0;
    foreach ( $formats as $key => $format ) {
      if ($format) {
        $o .= '<br/>' . l($format['format_name'], "admin/content/dieta_recipe/import_multi/$key");
        $format_count++;
      }
    }
    if ( $format_count == 0 ) {
      $o .= '<br/><p>' . t('You have no import formats available with the bulk export feature.') . '</p>';
    }
    return $o;
  }

  // normalize typed urls
  $type = drupal_strtolower($type);

  // If callback exists, call it, otherwise error out.
  if (isset($formats[$type]) && function_exists($formats[$type]['callback'])) {
    $o = call_user_func($formats[$type]['callback']);
    return $o;
  }
  else {
    drupal_set_message(t('Unknown export format(%the_format).', array('%the_format' => $type)), 'error');
    drupal_not_found();
  }
}


function theme_dieta_recipe_system_of_measurement($variables) {
  $form = $variables['form'];

  $header = array(t('Name'), t('Key'), t('Plural'), t('Abbreviation'), t('Weight'), t('Operations'));
  $rows = array(array(
    drupal_render($form['name']),
    drupal_render($form['key']),
    drupal_render($form['plural']),
    drupal_render($form['abbreviation']),
    drupal_render($form['weight']),
    drupal_render($form['add']),
  ));

  $unit_list = dieta_recipe_get_units();
  foreach ($unit_list as $key => $unit) {
    $rows[] = array(
      $key,
      $unit->name,
      $unit->plural,
      $unit->abbreviation,
      $unit->weight,
      l(t('delete'), 'dieta_recipe/' . $key . '/delete', array('query' => drupal_get_destination())),
    );
  }

  $output = theme('table', array('header' => $header, 'rows' => $rows));
  $output .= drupal_render_children($form);

  return $output;
}

function dieta_recipe_system_of_measurement_validate($form, &$form_state) {
  $values = $form_state['values'];

  if (empty($values['key'])) {
    form_set_error('key', t('Field key is required.'));
  }
  if (empty($values['name'])) {
    form_set_error('name', t('Field name is required.'));
  }
  if (empty($values['plural'])) {
    form_set_error('plural', t('Field plural is required.'));
  }
  if (empty($values['abbreviation'])) {
    form_set_error('abbreviation', t('Field abbreviation is required.'));
  }
  if (empty($values['weight'])) {
    form_set_error('weight', t('Field weight is required.'));
  }
}


function dieta_recipe_system_of_measurement_submit($form, &$form_state) {
  db_insert('dieta_recipe_unit')
    ->fields(array(
      'unit_key' => $form_state['values']['key'],
      'name' => $form_state['values']['name'],
      'plural' => $form_state['values']['plural'],
      'abbreviation' => $form_state['values']['abbreviation'],
      'weight' => (int) $form_state['values']['weight'],
    ))
    ->execute();

  drupal_set_message(t('Unit %unit successfully added.', array('%unit' => $form_state['values']['name'])));
}

function dieta_recipe_unit_exists($key) {
  $unit_list = dieta_recipe_get_units();

  return isset($unit_list[$key]);
}
