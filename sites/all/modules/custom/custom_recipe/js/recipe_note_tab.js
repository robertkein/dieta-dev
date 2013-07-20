/* 
 * работа с заметкой рецепта через аякс
 */

(function ($) {
  Drupal.behaviors.recipe_note_tab = {
    attach : function(context, settings) 
    {
      var content       = $('.node-type-dieta-recipe .region-content', context);
      
      /*
       * При клике по ссылке "редактировать" скрываем текст заметки и показываем форму
       */
      content.find('.note-edit').live('click', function(event){
          event.preventDefault();
          event.stopPropagation();
          $('form#custom-recipe-note-form').removeClass('only-text').addClass('only-form'); 
          return false;
      });
      
      /*
       * При клике по ссылке "сохранить" посылаем на сервер новый текст для записи в заметку и скрываем форму
       */
      content.find('.form-submit').live('click', function(event){
          event.preventDefault();
          event.stopPropagation();
          var ajax_wait = '<div style="text-align:center; padding: 20px;"><img src="/sites/all/modules/custom/custom_recipe/images/ajax_wait.gif"></div>';
          $(content).find('#note').html(ajax_wait);
          $('form#custom-recipe-note-form').addClass('only-text').removeClass('only-form');
          var new_text = $('form#custom-recipe-note-form').find('#edit-note-body').val();
          $.ajax({
              type: "POST",
              url: $(this).attr('href'),
              data: {note_body: new_text},
              success: function(data) {
                $(content).find('#note').html(new_text);
              }
          });
          return false;
      });
      
      /*
       * При клике по ссылке "удалить" посылаем на сервер запрос на очищение заметки и показываем форму
       */
      content.find('.note-delete').live('click', function(event){
          event.preventDefault();
          event.stopPropagation();
          var ajax_wait = '<div style="text-align:center; padding: 20px;"><img src="/sites/all/modules/custom/custom_recipe/images/ajax_wait.gif"></div>';
          $(content).find('#note').html(ajax_wait);
          $.ajax({
              type: "POST",
              url: $(this).attr('href'),
              success: function(data) {
                $(content).find('#note').html('');
                $('form#custom-recipe-note-form').find('#edit-note-body').val('');
                $('form#custom-recipe-note-form').removeClass('only-text').addClass('only-form');
              }
          });
          return false;
      });
      
      
    }
  }
})(jQuery);

