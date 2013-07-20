/*
 * 
 */
(function ($) {
  Drupal.behaviors.recipe_form_chosen = {
    attach: function (context, settings) {      
      $('#dieta-recipe-node-form .field-name-field-recipe-preferences select').chosen({width: "100%", height: "27px", placeholder_text: 'Выберите кухню'});
      
      $('#dieta-recipe-node-form #edit-field-recipe-ingestion-und').chosen({width: "100%", height: "27px", placeholder_text: 'Выберите приемы пищи'});
      
      $('#dieta-recipe-node-form #edit-field-recipe-classifier-und').chosen({width: "100%", height: "27px", placeholder_text: 'Выберите категорию'});
    }
  };
})(jQuery);