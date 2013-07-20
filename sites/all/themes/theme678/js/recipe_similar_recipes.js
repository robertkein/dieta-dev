(function ($) {
  Drupal.behaviors.recipe_similar_recipes = {
    attach: function (context, settings) {	
			/*
			 * Требуется библиотека jquery-ui
			 */ 
			var title_class = '.title-similar-recipe';
			var similar_recipe_class = '.block_similar_recipe';
			$(title_class).hide();
			$(similar_recipe_class).bind('mouseleave', function(){
				var $title = $(this).find(title_class);
				$title.hide('blind', 400);
      });
			$(similar_recipe_class).bind('mouseover', function(){
				var $title = $(this).find(title_class);
				$title.show('blind', 400);
      });
    }	
  };
})(jQuery);

