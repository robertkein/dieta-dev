(function ($){
  Drupal.behaviors.kdtabs = {
    attach: function (context, settings) {
      $('#deltacontenttabs').tabify();
    }
  };
})(jQuery);