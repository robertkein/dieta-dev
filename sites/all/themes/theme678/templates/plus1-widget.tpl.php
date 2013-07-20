<?php
/**
 * @file
 * Template implementation to display the node widget.
 */
?>
<span class="plus1-widget">
  <?php if (!isset($use_arrow_down)) : ?>
      <?php if($can_vote) : ?>
        <span class="<?php if (!$voted) print 'plus1-vote'; else print 'plus1-undo-vote'; ?>">
          <?php print $widget_message; ?>
        </span>
      <?php else: ?>
        <small><?php print $widget_message; ?></small>
      <?php endif; ?>
  <?php endif;?>

  <?php if (isset($use_arrow_down)) : ?>
      <span class="plus1-undo-vote">
        <?php print $widget_message; ?>
      </span>
<?php endif;?>

  <span class="plus1-score">
    <?php print $score; ?>
  </span>

</span>
