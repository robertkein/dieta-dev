<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<div class="views-ingridient-image">
  <!-- field_image -->
  <?php $field = $fields['field_image']; ?>
  <?php unset($fields['field_image']); ?>

  <?php print $field->wrapper_prefix; ?>
  <?php print $field->label_html; ?>
  <?php print $field->content; ?>
  <?php print $field->wrapper_suffix; ?>
</div>

<div class="views-ingridient-name">
  <!-- field_name -->
  <?php
    $path = drupal_get_path('module', 'pathauto');
    include_once $path . '/pathauto.inc'; 
  ?>
  <?php $field = $fields['name'];
    $transliteration_name =  pathauto_cleanstring($field->content);
    $term = taxonomy_term_load($fields['tid']->raw);
    $parent_term = array_shift(taxonomy_get_parents($term->tid));
    $parent_name = pathauto_cleanstring($parent_term->name);
  ?>
  <?php unset($fields['name']); ?>
  <a href="/wiki/<?php print $parent_name."/".$transliteration_name;?>">
    <?php // print $field->wrapper_prefix; ?>
    <?php // print $field->label_html; ?>
    <?php print $field->content;?>
  <?php // print $field->wrapper_suffix; ?>
  </a>
</div>

<div class="views-ingridient-data">
  <!-- data -->
  <?php if (!empty($fields['description']->content)): ?>
    <!-- description -->
    <?php $field = $fields['description']; ?>
    <?php unset($fields['description']); ?>
    
    <?php print $field->wrapper_prefix; ?>
    <?php print $field->label_html; ?>
    <?php print $field->content; ?>
    <?php print $field->wrapper_suffix; ?>
  <?php else: ?>
    <?php foreach ($fields as $id => $field): ?>
      <?php if (!empty($field->separator)): ?>
        <?php print $field->separator; ?>
      <?php endif; ?>
      <?php print $field->wrapper_prefix; ?>
     <?php print $field->label_html; ?>
     <?php print $field->content; ?>
     <?php print $field->wrapper_suffix; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<div class="views-ingridient-recipes">
  <?php print dieta_recipe_count_recipes($row->tid); ?>
</div>

<div style="clear:both;"></div>

