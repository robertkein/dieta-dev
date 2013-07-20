/*
 * 
 */
(function ($) {
  Drupal.behaviors.recipe_form_stuff = {
    attach: function (context, settings) {      
      $('#dieta-recipe-node-form .field-name-field-recipe-preferences select').chosen({width: "100%", height: "27px", placeholder_text: 'Выберите кухню'});
      $('#dieta-recipe-node-form #edit-field-recipe-ingestion-und').chosen({width: "100%", height: "27px", placeholder_text: 'Выберите приемы пищи'});
      $('#dieta-recipe-node-form #edit-field-recipe-classifier-und').chosen({width: "100%", height: "27px", placeholder_text: 'Выберите категорию'});
			

			/*
			 * Если в ингредиентах выбираем меру кол-ва "по вкусу", то количество делать неизменным и равным 0
			 */
			$('#dieta-recipe-node-form .form-item-dieta-recipe-ingredients-unit-key').live('change', function(){
        var $option = $(this).find('option:selected');
				var cur_value = $option.val();
				if ('taste' === cur_value) {
					set_quantity_unchanged_null(this);
				}
				else {
					set_quantity_changed(this);
				}
      });
			
			function set_quantity_unchanged_null(unit_select) {
				var $quantity_field = get_quntity_field(unit_select);
				$quantity_field.val('0');
				$quantity_field.attr('disabled', 'disabled');
			}
			
			function set_quantity_changed(unit_select) {
				var $quantity_field = get_quntity_field(unit_select);
				$quantity_field.removeAttr('disabled');
			}
			
			function get_quntity_field(element) {
				return $('#dieta-recipe-node-form  #ingredient-list tr')
								.has(element)
								.find('input.form-item-dieta-recipe-ingredients-quantity');
			}
    }
  };
})(jQuery);