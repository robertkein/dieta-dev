/* 
 * Обеспечивает работу блока "dieta_recipe_ingredients_block_names"
 * При клике по категории отображает только продукты данной категории
 */

(function ($) {
  Drupal.behaviors.dieta_recipe_ingredients_block_names = {
    attach : function(context, settings) {
      /*
       * По умолчанию выделяем первую категорию и фильтруем по ней продукты
       */
      $('.dieta-recipe-ingredients-block-names').each(function(i, elem){
        if ($(this).find('.active').length === 0) {
          $(this).find('.categories li.category').removeClass('active');
          $(this).find('.categories li.category').eq(0).addClass('active');
          filter_products(this, $(this).find('.categories li.category').eq(0));
        }
//        $(this).find('input[name="product_name"]').value('');
        $(this).find('input[name="product_name"]').val('');
      });
      
      
      /*
       * обрабатываем клик по категории продуктов
       */
      $('.dieta-recipe-ingredients-block-names .categories li').live('click', function(){
        var current_block = $(this).parents('.dieta-recipe-ingredients-block-names');
        $(current_block).find('.categories li').removeClass('active');
        $(this).addClass('active');
        
        filter_products(current_block, this);
      });
      
      
      /*
       * обрабатываем клик по продукту
       */
      $('.dieta-recipe-ingredients-block-names .products li').live('click', function(){
        $('.current-ingredient-input').val($(this).text());    
        $('.dieta-recipe-ingredients-block-names').hide();
      });
      
      
      /*
       * Фильтруем продукты по выбранной категории
       */
      function filter_products(block, li_category) {
        var li_classes = $(li_category).attr('class');
        var pattern = /tid-(\d+)[\s|\"]/;
        var match = li_classes.match(pattern);
        var tid_category = match[1];
        $(block).find('.products li').hide();
        $(block).find('.products li.category-' + tid_category).show();
      }
      
      
      /*
       * По клику по полю имени ингредиента показывать соответствующий ему блок выбора 
       */
      $('input.form-item-dieta-recipe-ingredients-name').live('click', function(){
        $('input.form-item-dieta-recipe-ingredients-name').removeClass('current-ingredient-input');
        $(this).addClass('current-ingredient-input');
        console.log('live click block');
        $('.dieta-recipe-ingredients-block-names').hide();
        $(this).parents('td').eq(0).find('.dieta-recipe-ingredients-block-names').show();
      });
      
      /*
       * Запрещаем ввод с клавиатуры
       */
      $('input.form-item-dieta-recipe-ingredients-name').live('keypress', function(){
        return false;
      });
      
      /*
       * Кнопка закрыть скрывает блок
       */
      $('.dieta-recipe-ingredients-block-names .close').live('click', function(){
        $(this).parents('.dieta-recipe-ingredients-block-names').eq(0).hide();
      });
      
      /*
       * Ввод поле нового продукта
       */
      $('.dieta-recipe-ingredients-block-names input[name="product_name"]').live('keyup', function(){
        var wrapper = $(this).parents('.dieta-recipe-ingredients-block-names');
        var category = get_tid_from_classes( $(wrapper).find('.categories li.active').attr('class') );
        
//        $(wrapper).find('input[name="category"]').val(category);
        var href = 'http://dieta-abc.ru/dieta_recipe/add_product/nojs/33/jkjkjkjjj'; //Drupal.settings.dieta_recipe.root_path
        $(wrapper).find('.add-product').attr('href', href);  
      });
      
      /*
       * Отправка на сервер нового продукта для добавления
       */
      $('.dieta-recipe-ingredients-block-names .submit').live('click', function(){
        var wrapper = $(this).parents('.dieta-recipe-ingredients-block-names');
        
        category = get_tid_from_classes( $(wrapper).find('.categories li.active').attr('class') );
        product_name = $(wrapper).find('input[name="product_name"]').val();
        
        $(wrapper).find('input[name="product_name"]').val('');
//        var category_li = $(wrapper).find('categories .active')
//        filter_products(current_block, this);
        $.ajax({
            type: 'POST',
            url: 'http://dieta-abc.ru/dieta_recipe/add_product',
            dataType: 'json',
            data: {
              'category' : category,
              'product_name' : product_name
            },
            success: function (data) {
              console.log(data);
              $('.dieta-recipe-ingredients-block-names .products .form-add-product').prepend(data);
            }
        });
      });
      
      
      function get_tid_from_classes(classes) {
        var pattern = /tid-(\d+)[\s|\"]/;
        var match = classes.match(pattern);
        var tid_category = match[1];
        
        return tid_category;
      }
      
    }                
  }
})(jQuery);
