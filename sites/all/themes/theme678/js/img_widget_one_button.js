/* 
 * Темизация виджета подгрузки фото, чтобы была только одна кнопка.
 * При нажатии на нее отображается диалог выбора файлов, 
 * а при выборе файла картинка подгружается и отображается на месте кнопки.
 * При клике на превьюшку картинка удаляется и снова отображается кнопка добавления картинки как и в начале.
 */

(function ($) {
  Drupal.behaviors.img_widget_one_button = {
    attach: function (context, settings) {	
      // @TODO вынести
      $('.field-name-field-image', context).not('.upload-one-button').each(function(i, elem){
          $(this).addClass('upload-one-button').addClass('big');
      });
      $('.field-name-field-recipe-step-image', context).not('.upload-one-button').each(function(i, elem){
          $(this).addClass('upload-one-button').addClass('small');
      });
      
      $('.field-type-image.upload-one-button').each(function(i, e){
        if (!$(this).hasClass('upload-one-button-processed')) {
          $(this).find('.form-type-managed-file > label').live('click', function(){
              $(this).parents('.field-type-image.upload-one-button').find('input[type="file"]').click();
          });
          $(this).find('input[type="file"]').live('change', function(){
              $(this).parents('.image-widget-data').find('.form-submit[name$="upload_button"]').delay(200).mousedown().click().mouseup();
          });
          $(this).addClass('upload-one-button-processed');
        }
      });
      
//      $('.field-type-image.upload-one-button').find('.form-type-managed-file > label').live('click', function(){
//          $(this).parents('.field-type-image.upload-one-button').find('input[type="file"]').click();
//          console.log($(this).attr('for'));
//      });
      
      
      $('.field-type-image.upload-one-button').find('input[type="file"]').live('change', function(){
          $(this).parents('.image-widget-data').find('.form-submit[id$="upload-button"]').delay(200).mousedown();
//          $(this).addClass('upload-one-button-processed');
      });
      
      $('.field-type-image.upload-one-button').addClass('upload-one-button-processed');
    }	
  };
})(jQuery);
