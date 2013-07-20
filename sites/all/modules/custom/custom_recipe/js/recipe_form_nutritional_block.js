/*
 * Обновление данных пищевой ценности при изменении данных полей ингредиентов 
 * в форме рецепта
 */
(function ($) {
  Drupal.behaviors.recipe_form_nutritional_block = {
    attach: function (context, settings) {
      var $form             = $('#dieta-recipe-node-form');
      var portions_id       = '#edit-dieta-recipe-yield option:selected';
      var $ings             = $form.find('#ingredient-list tr');
      var ing_quantity_id   = 'input.form-item-dieta-recipe-ingredients-quantity';
      var ing_unit_id       = 'select.form-item-dieta-recipe-ingredients-unit-key option:selected';
      var ing_name_id       = 'input.form-item-dieta-recipe-ingredients-name';
      var $products_names   = $ings.find(ing_name_id);
      const get_product_url = '/custom_recipe/get_new_nutritional_and_price';
      var products          = new Array();

      $('#dieta-recipe-node-form .form-item-dieta-recipe-ingredients-quantity').not('.recipe-form-nutritional-block-processed').addClass('recipe-form-nutritional-block-processed').bind('keyup', function(){
        set_new_nutritional_and_price();
      });

      $('#dieta-recipe-node-form select.form-item-dieta-recipe-ingredients-unit-key').not('.recipe-form-nutritional-block-processed').addClass('recipe-form-nutritional-block-processed').bind('change', function(){
        set_new_nutritional_and_price();
      });
      
      $('#dieta-recipe-node-form #edit-dieta-recipe-yield').not('.recipe-form-nutritional-block-processed').addClass('recipe-form-nutritional-block-processed').bind('change', function(){
        set_new_nutritional_and_price();
      });

      $products_names.not('.recipe-form-nutritional-block-processed').addClass('recipe-form-nutritional-block-processed').bind('change', function(){
        set_new_nutritional_and_price();
      });

      function set_new_nutritional_and_price() {
        var ings = get_all_ingredients();
        var ings_serialized =  JSON.stringify(ings);
        var portions = $form.find(portions_id).val();
        $.ajax({
          type: "POST",
          url: get_product_url,
          data: {ings: ings_serialized, portions: portions},
          success: function(data) {
            check_calories(data['caloric_effect']);
            update_nutritional_and_price(data, portions);
          }
        });
  
      }

      /*
       * Обновляет данные в блоке пищевой ценности
       * @param array data
       * @param int portions
       */
      function update_nutritional_and_price(data, portions) {        
        var $block = $form.find('.nutritional-value-receipe');
        
        $block.find('.field-caloric-effect .value').html(data['caloric_effect']);
        $block.find('.field-carbohydrates .value').html(data['carbohydrates']);
        $block.find('.field-fats .value').html(data['fats']);
        $block.find('.field-proteins .value').html(data['proteins']);
        $block.find('.price .value').html(data['price']);
        $block.find('.portions-value').html(portions);
        
      }
      
      /*
       * Проверяет параметр калорийности.
       * Если калорийность превышена, то выводит сообщение
       * @param int caloric_effect
       */
      function check_calories(caloric_effect) {
//        if ($form.hasClass('calories-message-showed')) {
//          return;
//        }
        var $block = $form.find('.nutritional-value-receipe');
        if (caloric_effect > 400) {
          if ($block.find('.field-caloric-effect .value').html() != caloric_effect) {
            $.msgBox({
                title:"Внимание",
                content:"Калорийность блюда больше 400ккал. Мы хотим видеть только здоровую еду!"
            });
            $form.addClass('calories-message-showed');
          }
        }
      }
      
      /*
       * Возвращает массив с указанными ингредиентами 
       * В массиве название, количество и единица измерения.
       */
      function get_all_ingredients() {
        var name = $ings.find(ing_name_id);
        var quantity = $ings.find(ing_quantity_id);
        var unit = $ings.find(ing_unit_id);
        var ings_params = new Array();
        $ings.each(function(i, elem){
          var ing = {};
          ing['quantity'] = $(this).find(ing_quantity_id).val();
          ing['unit']     = $(this).find(ing_unit_id).val();
          ing['name']     = $(this).find(ing_name_id).val();
          if (undefined != ing['name'] && undefined != ing['quantity'] && undefined != ing['unit']) {
            ings_params.push(ing);
          }
        });

        return ings_params;
      }
    }
  };
})(jQuery);
