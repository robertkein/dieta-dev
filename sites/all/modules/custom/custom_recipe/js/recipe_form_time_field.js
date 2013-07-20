/*
 * 
 */
(function ($) {
  Drupal.behaviors.recipe_form_time_field = {
    attach: function (context, settings) {
      $time_field = $('#dieta-recipe-node-form #edit-dieta-recipe-preptime');
      if ($time_field.hasClass('time-field-processed')) {
        return;
      }
      
      var hours_value   = 0;
      var minutes_value = 0;
      var time = $time_field.val();
      if ('' != time && undefined != time) {
        hours_value = Math.floor(time / 60);
        minutes_value = time % 60;
      }
      
      var $hours   = $('<input type="text" id="recipe-preptime-hours" class="form-text" name="recipe_preptime_hours" value="'+hours_value+'" />');
      var $minutes = $('<input type="text" id="recipe-preptime-minutes" class="form-text" name="recipe_preptime_minutes" value="'+minutes_value+'" />');
      
      $time_field.after($hours);
      $hours.after($minutes);
      $hours.after('ч');
      $minutes.after('мин.');
      $time_field.hide();
      $time_field.addClass('time-field-processed');
      
      /*
       * при изменении поля с часами или с минутами обновлять основное поле времени
       */
      $('#dieta-recipe-node-form #recipe-preptime-hours, #dieta-recipe-node-form #recipe-preptime-minutes').live('change', function(){
        var time = get_minutes();
        $time_field.val(time);
      });
            
      /*
       * Возвращает количество минут, содержащихся в полях часов и минут
       */
      function get_minutes() {
        var hours   = $hours.val();
        var minutes = $minutes.val();
        return ((hours * 60) + parseInt(minutes));
      }
      
    }
  };
})(jQuery);