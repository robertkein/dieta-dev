<?php

/*
 * Dieta_recipe node form 
 */
//if ($_GET['dk']) {
//      print drupal_render_children($form);
//}
?>
<div class="form-sidebars-wrapper">
	<div class="content-dieta-recipe">
		<?php print drupal_render($form['title']); ?>
		<div  id="img-and-fields" class="fields-block">
			<table>
				<tr>
					<td class="image">
						<?php print drupal_render($form['field_image']); ?>
					</td>
					<td class="fields">
						<?php print drupal_render($form['dieta_recipe_yield']); ?>
						<?php print drupal_render($form['dieta_recipe_preptime']); ?>
						<?php print drupal_render($form['dieta_recipe_description']); ?>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="fields-block">
			<?php print drupal_render($form['dieta_recipe_ingredients']); ?>
		</div>

		<div class="fields-block">
			<?php print drupal_render($form['field_recipe_steps']); ?>
		</div>

		<?php print drupal_render($form['dieta_recipe_source']); ?>
	</div>
	<div class="right-sidebar-recipe">  
		<div class="fields-block">
      <div class="nutritional-value-receipe">
        <div class="sidebar-title title-2">
            Пищевая ценность <span class="portions-value">1</span> порции
        </div>
        <table>
            <tr class="field-proteins"><td class="title"><label><?php print $form['field_proteins']['und'][0]['value']['#title']; ?></label></td>	<td><span class="value"><?php print round($form['field_proteins']['und'][0]['value']['#default_value'], 0); ?></span> <span><?php print $form['field_proteins']['und'][0]['value']['#field_suffix'] ?></span></td></tr>
						<tr class="field-fats"><td class="title"><label><?php print $form['field_fats']['und'][0]['value']['#title']; ?></label></td>	<td><span class="value"><?php print round($form['field_fats']['und'][0]['value']['#default_value'], 0); ?></span> <span><?php print $form['field_fats']['und'][0]['value']['#field_suffix'] ?></span></td></tr>
            <tr class="field-carbohydrates"><td class="title"><label><?php print $form['field_carbohydrates']['und'][0]['value']['#title']; ?></label></td>	<td><span class="value"><?php print round($form['field_carbohydrates']['und'][0]['value']['#default_value'], 0); ?></span> <span><?php print $form['field_carbohydrates']['und'][0]['value']['#field_suffix'] ?></span></td></tr>
            <tr class="field-caloric-effect"><td class="title"><label><?php print $form['field_caloric_effect']['und'][0]['value']['#title']; ?></label></td>	<td><span class="value"><?php print round($form['field_caloric_effect']['und'][0]['value']['#default_value'], 0); ?></span> <span><?php print $form['field_caloric_effect']['und'][0]['value']['#field_suffix'] ?></span></td></tr>
            <?php	
              if (!empty($form['field_product_price']['und'][0]['value']['#default_value'])) {
                $price = round($form['field_product_price']['und'][0]['value']['#default_value'], 2);
              } else {
                $price = 0;
              }
            ?>
            <tr class="price"><td class="title"><label>Стоимость <span class="portions-value"><?php print $form['dieta_recipe_yield']['#default_value']; ?></span> порций</label></td><td><span class="value"><?php print $price; ?></span> <span><?php print $form['field_product_price']['und'][0]['value']['#field_suffix']; ?></span></td></tr>
        </table>
      </div>
      <div id="ingestion-fields">
        <?php print drupal_render($form['field_recipe_ingestion']); ?>
        <?php print drupal_render($form['field_recipe_classifier']); ?>
        <?php print drupal_render($form['field_recipe_preferences']); ?>
      </div>
		</div>
	</div>
</div>
<?php	unset($form['field_product_price']); ?>
<?php	unset($form['dieta_recipe_notes']); ?>
<?php	unset($form['dieta_recipe_yield_unit']); ?>

<?php if($form): ?>
      <?php print drupal_render_children($form); ?>
<?php endif; ?>
