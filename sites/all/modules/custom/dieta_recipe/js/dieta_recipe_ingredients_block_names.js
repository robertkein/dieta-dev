/* 
 * Обеспечивает работу блока "dieta_recipe_ingredients_block_names"
 * При клике по категории отображает только продукты данной категории
 */

(function ($) {
  Drupal.behaviors.dieta_recipe_ingredients_block_names = {
    attach : function(context, settings) {
      
      /*
       * обрабатываем клик по категории продуктов
       */
      $('.dieta-recipe-ingredients-block-names .categories li').live('click', function(){
        var current_block = $(this).parents('.dieta-recipe-ingredients-block-names');
        $(current_block).find('.categories li').removeClass('active');
        $(this).addClass('active');
        
//        filter_products_by_category(current_block, this);
        // фильтруем все категории и продукты по наличию введенного текста
        var text = $(current_block).parents('td').eq(0).find('input.form-item-dieta-recipe-ingredients-name').val();
        filter_products_by_name(text, current_block);
//        hide_categories_without_products(block);
      });
      
      
      /*
       * обрабатываем клик по продукту
       */
      $('.dieta-recipe-ingredients-block-names .products li').live('click', function(){
        $('.current-ingredient-input').val($(this).text()).change();    
        $('.dieta-recipe-ingredients-block-names').hide();
      });
      
      
      /*
       * Фильтруем продукты по выбранной категории
       */
      function filter_products_by_category(block, li_category) {
        var li_classes = $(li_category).attr('class');
        var pattern = /tid-(\d+)[\s|\"]/;
        var match = li_classes.match(pattern);
        var tid_category = match[1];
        
        if (tid_category == 0) {
          $(block).find('.products li').show();
        }
        else {
          $(block).find('.products li').hide();
          $(block).find('.products li.category-' + tid_category).show();
        }
      }
      
      
      /*
       * По клику по полю имени ингредиента показывать соответствующий ему блок выбора 
       */
      $('input.form-item-dieta-recipe-ingredients-name').live('click', function(){
        var block = $(this).parents('td').eq(0);
        // перед тем как показать блок, восстанавливаем его дефолтное состояние 
        // (отображать все категории и продукты первой в списке категории)
        $(block).find('.categories li.category').removeClass('active');
        first_category = $(block).find('.categories li.category').eq(0);
        $(first_category).addClass('active');
        filter_products_by_category(block, $(first_category));
        hide_categories_without_products(block);
        $(block).find('input[name="product_name"]').val('');
          
        $('input.form-item-dieta-recipe-ingredients-name').removeClass('current-ingredient-input');
        $(this).addClass('current-ingredient-input');
        
        // скрываем все блоки с продуктами, отображем лишь один для данного поля ввода
        $('.dieta-recipe-ingredients-block-names').hide();
        $(this).parents('td').eq(0).find('.dieta-recipe-ingredients-block-names').show();
      });
      
      /*
       * При вводе с клавиатуры фильтруем продукты
       */
      $('input.form-item-dieta-recipe-ingredients-name').live('keyup', function(){
        var block = $(this).parents('td').eq(0);
        var text = $(this).val();
        // фильтруем все категории и продукты по наличию введенного текста
        filter_products_by_name(text, block);
        hide_categories_without_products(block);
//        show_product_add_if_empty_list(block);
        //return false;
      });
      
      function alert_if_product_is_invalid(ingredient_field) {
        var block = $(ingredient_field).parents('td').eq(0).find('.dieta-recipe-ingredients-block-names');
        text = $(ingredient_field).val();
        exist_product = false;
        $(block).find('.products li').each(function(){
          var product_name = $(this).text();
          if (product_name == text) {
            exist_product = true;
          }
        });
        
        if (exist_product == false) {
          $(ingredient_field).val('');
          alert('Вы должны выбрать присутствующий в списке продукт, либо добавить его в этот список через форму под списком.');
        }
      }
      
      /*
       * Кнопка закрыть скрывает блок
       */
      $('.dieta-recipe-ingredients-block-names .close').live('click', function(){
        var block = $(this).parents('.dieta-recipe-ingredients-block-names').eq(0);
        $(block).hide();
        
        ingredient_field = $(block).parents('td').eq(0).find('input.form-item-dieta-recipe-ingredients-name');
        alert_if_product_is_invalid(ingredient_field);
      });
      
      /*
       * Ввод поле нового продукта
       */
      $('.dieta-recipe-ingredients-block-names input[name="product_name"]').live('keyup', function(){
        var wrapper = $(this).parents('.dieta-recipe-ingredients-block-names');
        var category = get_tid_from_classes( $(wrapper).find('.categories li.active').attr('class') );
        
//        $(wrapper).find('input[name="category"]').val(category);
//        var href = 'http://dieta-abc.ru/dieta_recipe/add_product/nojs/33/jkjkjkjjj'; //Drupal.settings.dieta_recipe.root_path
//        $(wrapper).find('.add-product').attr('href', href);  
      });
      
      /*
       * Отправка на сервер нового продукта для добавления
       */
      $('.dieta-recipe-ingredients-block-names .form-submit').live('click', function(){
        wrapper = $(this).parents('.dieta-recipe-ingredients-block-names');
        
        category = $(wrapper).find('select[name="category"] option:selected').val();
        product_name = $(wrapper).find('input[name="product_name"]').val();
        
        $(wrapper).find('input[name="product_name"]').val('');
//        var category_li = $(wrapper).find('categories .active')
//        filter_products_by_category(current_block, this);
        $.ajax({
            type: 'POST',
            url: 'http://dieta-abc.ru/dieta_recipe/add_product',
            dataType: 'json',
            data: {
              'category' : category,
              'product_name' : product_name
            },
            success: function (data) {
              $('.dieta-recipe-ingredients-block-names .products ul li:last').after(data);
              $('.dieta-recipe-ingredients-block-names').each(function(){
                hide_categories_without_products(this);
              });
              $('.dieta-recipe-ingredients-block-names').hide();
              // ставим продукт в поле ввода
              $(wrapper).parents('td').eq(0).find('input.form-item-dieta-recipe-ingredients-name').val(product_name);
              
            }
        });
      });
      
      /*
       * Находит в списке классов tid 
       * @param string classes
       * @returns string
       */      
      function get_tid_from_classes(classes) {
        var pattern = /tid-(\d+)[\s|\"]/;
        var match = classes.match(pattern);
        var tid_category = match[1];
        
        return tid_category;
      }
      
      /*
       * Находит в списке классов category
       * @param string classes
       * @returns string
       */      
      function get_category_from_classes(classes) {
        var pattern = /category-(\d+)/;
        var match = classes.match(pattern);
        var tid_category = match[1];
        
        return tid_category;
      }
      
      /*
       * Фильтрация продуктов по содержанию указанного текста
       */
      function filter_products_by_name(text, block) {
        var active_category = get_tid_from_classes($(block).find('.categories li.active').attr('class'));
        var products = $(block).find('.products li');
        $(products).each(function(i, e){
          var product_name = $(this).text().toLowerCase();
          text = text.toLowerCase();
          var find_position = product_name.indexOf(text);
          if (find_position == -1) {
            $(this).hide();
          }
          else {
            $(this).show();
          }
          category_of_product = get_category_from_classes($(this).attr('class'));
          if (category_of_product != active_category && active_category != 0) {
            $(this).hide();
          }
        });
      }
      
      /*
       * Скрывает категории продуктов, в которых не отображается продуктов в данный момент
       * и обновляет количество отображаемых продуктов данной категории.
       */
      function hide_categories_without_products(block) {
        // формируем массив количеств для категорий, в которых отображаются продукты
        categories_with_products = new Array();
        $(block).find('.products li').each(function(i, e){
              if ($(this).css('display') != 'none') {
                var category_tid = get_category_from_classes($(this).attr('class'));       
                // если категория уже была добавлена, то увеличиваем количество продуктов, относящихся к ней
                if (categories_with_products[category_tid] === undefined) {
                  categories_with_products[category_tid] = 1;
                }
                else {
                  categories_with_products[category_tid] += 1;
                }   
              }
        });
        
        $(block).find('.categories li').hide();
        var full_count = 0;
        for (var cat_tid in categories_with_products) {
          count_products = categories_with_products[cat_tid];
          full_count += count_products;
          if (count_products > 0) {
            $(block).find('.categories li.tid-' + cat_tid).show();
          }
          $(block).find('.categories li.tid-' + cat_tid + ' .count').html('(' + count_products + ')');
        }
        // показываем и устанавливаем количество для категории "Все"
        $(block).find('.categories li.tid-0').show();
        $(block).find('.categories li.tid-0 .count').html('(' + full_count + ')');
      }
    
//      function show_product_add_if_empty_list(block) {
//        if ($(block).find('.products li').not('li[style*="display: none"], li[style*="display:none"]').length == 0) {
//          $(block).find('.add-product').show();
//        }
//      }
      
    }                
  }
})(jQuery);
