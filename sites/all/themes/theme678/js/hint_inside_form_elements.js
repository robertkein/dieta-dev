/*
 *    Вставка поясняющего текста поверх элементов формы.
 *    Текст таких подсказок берется из переменной Drupal.settings.hint_inside_form_elements
 *    Переменная представляет из себя массив вида array('.node-form input.field-first' => 'Введите текст...')
 */

(function ($) {
  Drupal.behaviors.hint_inside_form_elements = {
    attach: function (context, settings) {
//      hints = Drupal.settings.hint_inside_form_elements;
      // @TODO вынести отдельно
      hints = {
        '#dieta-recipe-node-form .form-item-title input' : 'Например: Карпачо из лосося',
        '#dieta-recipe-node-form textarea#edit-dieta-recipe-description-value' : 'Расскажите о вашем рецепте',
        '#dieta-recipe-node-form input.form-item-dieta-recipe-ingredients-quantity' : 'Количество',
        '#dieta-recipe-node-form select.form-item-dieta-recipe-ingredients-unit-key' : 'грамм',
        '#dieta-recipe-node-form input.form-item-dieta-recipe-ingredients-name' : 'Выберите продукт',
        '#dieta-recipe-node-form input.form-item-dieta-recipe-ingredients-note' : 'Можно использовать лайм вместо лимона',
        '#dieta-recipe-node-form .field-name-field-recipe-step-desc textarea' : 'Описание шага приготовления блюда. Например, мелко нарезать лук и обжарить его до золотистой корочки.',
        '#dieta-recipe-node-form input#edit-dieta-recipe-source' : 'Укажите автора рецепта или ссылку на источник',
      };
      
      $.each(hints, function(form_element, hint_text){
        $(form_element).each(function(){
          add_hint($(this), hint_text);
        });        
      });

      function add_hint(form_element, hint_text) {
        if ($(form_element).hasClass('hint-added')) {
          return;
        }

        var elem_width  = $(form_element).width();
        var elem_height  = $(form_element).height();
        var elem_margin_left = $(form_element).css('margin-left');
        var elem_padding_left = $(form_element).css('padding-left');
        
        var $hint = $('<div class="hint-inside-form-elements" style="white-space: normal;">' + hint_text + '</div>');
        
        $hint.css('margin-left', elem_margin_left + 'px');
        $hint.css('margin-top', '-' + elem_height + 'px');
        var hint_padding_left = elem_padding_left;
        if ('0px' == hint_padding_left) {
          hint_padding_left = '5px';
        }
        $hint.css('padding-left', hint_padding_left);
        $hint.width(elem_width + 'px');
        $hint.height(elem_height + 'px');

        $(form_element).after($hint);
        
        if ('' == $(form_element).val())  $hint.show(); 
        else  $hint.hide();

        $hint.bind('click', function(){
          $(this).hide();
          $(form_element).focus();
        });

        $(form_element).bind('blur', function(){
          if ('' == $(this).val()) {
            $hint.show();
          }
        });
        
        $(form_element).bind('click', function(){
          $hint.hide();
        });

        $(form_element).addClass( 'hint-added' );
      }
    }
  };
})(jQuery);
