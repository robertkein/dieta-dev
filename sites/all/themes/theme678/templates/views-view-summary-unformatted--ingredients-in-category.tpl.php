<?php

/**
 * @file
 * Default simple view template to display a group of summary lines.
 *
 * This wraps items in a span if set to inline, or a div if not.
 *
 * @ingroup views_templates
 */
?>
<?php
// Prepare Russian letters to use
$letters = array();
foreach (range(chr(0xC0), chr(0xDF)) as $letter)  {
  $letters[] = strtolower(drupal_convert_to_utf8($letter, 'CP1251'));
}

// Prepare rows
$url = implode('/', array(
  arg(0), // wiki
  arg(1), // ingredients
  arg(2) // !tid
));
foreach ($rows as $id => $row){
  $existing_letters[] = $row->link;
  $urls[$row->link] = url($url . "/" . $row->link);
}
?>

<span class="views-summary views-summary-unformatted views-summary-all">
  <a href="<?php print url($url); ?>">All</a>
</span>
<?php foreach ($letters as $letter): ?> | 
  <?php if (in_array($letter, $existing_letters)): ?>
      <span class="views-summary views-summary-unformatted views-summary-result">
        <a href="<?php print $urls[$letter];?>"><?php print $letter; ?></a>
      </span>
    <?php else: ?>
      <span class="views-summary views-summary-unformatted views-summary-no-result">
        <?php print $letter; ?>
      </span>
    <?php endif; ?>
  <?php endforeach ?>
</div>
