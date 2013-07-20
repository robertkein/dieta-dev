<?php 


function history_rec_settings_form() {
  $form = array();
  
  $form['settings']['source'] = array(
    '#title' => t('Choose the browsing history data'),
    '#description' => t('Table {history} is provided by default, but it does not save data more than 30 days old, and it ignores anonymous users. {accesslog} requires the Statistics module, and it allows anonymous data.'),
    '#type' => 'radios',
    '#default_value' => variable_get('history_rec_source', 'history'),
    '#options' => array(
      'history' => t('Use the built-in {history} table.'),
      'accesslog' => t('Use {accesslog} table in Statistics module.'),
    ),
  );
  
  $form['settings']['save'] = array(
    '#type' => 'submit',
    '#value' => t('Save settings'),
    '#name' => 'save'
  );
  
  return $form;
}



function history_rec_settings_form_submit($form, &$form_state) {
  $source = $form_state['values']['source'];
  if ($source == 'accesslog' && !module_exists('statistics')) {
    drupal_set_message(t('Please enable the Statistics module in order to use {accesslog} table.'));
  }
  
  variable_set('history_rec_source', $source);
  if ($source == 'accesslog') {
    recommender_app_update('history_rec', array(
      'table' => '<BUILTIN>',
      'fields' => array('source_eid', 'target_eid', NULL, 'updated'),
    ));
  }
  else if ($source == 'history') {
    recommender_app_update('history_rec', array(
      'table' => '{history}',
      'fields' => array('uid', 'nid', NULL, 'timestamp'),
    ));
  }
  
  drupal_set_message(t("The settings have been saved."));
}
