/* 
 * Пересчет полей рецепта на странице при изменении кол-ва порций.
 */

(function ($) {
  Drupal.behaviors.dieta_recipe_calculate_by_portions_count = {
    attach : function(context, settings) { 
      // массив дефолтных параметров ингредиентов, указанных в сохраненном рецепте
      ings = Drupal.settings.dieta_recipe.ingredients;
      //  дефолтное кол-во порций, указанных в сохраненном рецепте
      portions_default = Drupal.settings.dieta_recipe.portions;
      //  цена за одну порцию
      price_of_one_portion = Drupal.settings.dieta_recipe.price_of_one_portion;
      
      field_caloric_effect_of_one_portion = Drupal.settings.dieta_recipe.field_caloric_effect_of_one_portion;
      field_carbohydrates_of_one_portion  = Drupal.settings.dieta_recipe.field_carbohydrates_of_one_portion;
      field_fats_of_one_portion           = Drupal.settings.dieta_recipe.field_fats_of_one_portion;
      field_proteins_of_one_portion       = Drupal.settings.dieta_recipe.field_proteins_of_one_portion;
      
      // css-селектор, указывающий относительный путь до поля "количества" в строке ингредиента
      ing_quantity_in_row_selector = '.quantity';
      
//      $(context).once('#sl', function(){
        mysl = new slider('sl', 132, 1, 10, 1, portions_default);
//      });
      
			/**
			 * После клика по ползунку количества порций пересчитываем все необходимые данные
			 */
      $('#sl > *', context).live('mouseup', function(){
        current_portions = $('#sl').has(this).find('.knob').html();
        calculate_product_fields(current_portions);
        calculate_price(current_portions);
        //calculate_nutritional(current_portions);
      });
      
			/**
			 * Пересчитывает количество ингредиентов в зависимости от кол-ва порций
			 */
      function calculate_product_fields(current_portions) {
        for (var i = 0; i < ings.length; i++) {
          ing = ings[i];
          var ing_row = get_css_id_of_ing_row(ing.ri_id);
          var current_quantity = (ing['quantity_of_one_portion'] * current_portions);
          current_quantity = current_quantity.toFixed(0);
          $(ing_row).find(ing_quantity_in_row_selector).html( current_quantity );
        }
      }
      
      /**
       * Возвращает css id строки в html-коде страницы, 
       * содержащий информацию по ингредиенту указанного id
       * @param {int} id
       * @returns {string}
       */
      function get_css_id_of_ing_row(id) {
        return $('#ingredient' + id);
      }     
      
      /*
       * пересчитывает цену рецепта для указанного кол-ва порций
       */
      function calculate_price(current_portions) {
        $('.price_value_receipe h2 .value').html(current_portions);
        
        var new_price = price_of_one_portion * current_portions;
        new_price = new_price.toFixed(0);
        $('.price_value_receipe .price_value').html(new_price + ' руб.');
      }
      
      /*
       * пересчитывает пищевую ценность рецепта для указанного кол-ва порций
       */
      function calculate_nutritional(current_portions) {
        $('.nutritional_value_receipe h2 .value').html(current_portions);
        
        var new_field_caloric_effect = field_caloric_effect_of_one_portion * current_portions;
        new_field_caloric_effect = new_field_caloric_effect.toFixed(0);
        $('.nutritional_value_receipe .field-caloric-effect .value').html(new_field_caloric_effect + ' ккал.');
                
        var new_field_carbohydrates = field_carbohydrates_of_one_portion * current_portions;
        new_field_carbohydrates = new_field_carbohydrates.toFixed(0);
        $('.nutritional_value_receipe .field-carbohydrates .value').html(new_field_carbohydrates + ' мг.');
        
        var new_field_proteins = field_proteins_of_one_portion * current_portions;
        new_field_proteins = new_field_proteins.toFixed(0);
        $('.nutritional_value_receipe .field-proteins .value').html(new_field_proteins + ' мг.');
        
        var new_field_fats = field_fats_of_one_portion * current_portions;
        new_field_fats = new_field_fats.toFixed(0);
        $('.nutritional_value_receipe .field-fats .value').html(new_field_fats + ' мг.');
      }
    }                
  }
})(jQuery);
