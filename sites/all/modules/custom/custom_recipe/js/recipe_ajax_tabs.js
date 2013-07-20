/* 
 * Открытие вкладок "комментарии", "заметки".. рецепта через аякс.
 */
//                                                        alert('recipe_ajax_tabs');
(function ($) {
  Drupal.behaviors.recipe_ajax_tabs = {
    attach : function(context, settings) 
    {                                                   // alert('behaviors.   recipe_ajax_tabs');
      var content = $('.node-type-dieta-recipe .region-content', context);
      var tabs    = $('.node-type-dieta-recipe ul.tabs li a');
      
      tabs.click(function(event){
//                                                        alert('tabs.click');
          if (!$(this).hasClass('ajax')) {
            return true;
          }
          event.preventDefault();
          event.stopPropagation();
          
          var nid      = null;
          var body_classes = $('body').attr('class');
          var nid_matches = /page-node-(\d+)/.exec(body_classes);
          if (nid_matches[1]) {
            nid = nid_matches[1];
          
            var name_tab = null;
            var link_classes = $(this).attr('class');
            var tab_matches = /tab-(\w+)/.exec(link_classes);
            if (tab_matches[1]) {
              name_tab = tab_matches[1];
              
              var $tab = $(this).parent('li');
              open_tab(name_tab, nid, $tab);
            }
          }
          return false;
      });
      
      $('.comments_block a.tab-comments', context).click(function(event){
        if (!$(this).hasClass('ajax')) {
          return true;
        }
        event.preventDefault();
        event.stopPropagation();
        $('ul.tabs a.tab-comments').click();
        return false;
      });
      
      /*
       * Открытие вкладки
       */
      function open_tab(name, nid, $tab) {
        if (name) {
          var ajax_wait = '<div style="text-align:center; padding: 20px;"><img src="/sites/all/modules/custom/custom_recipe/images/ajax_wait.gif"></div>';
          $(content).html(ajax_wait);
          $.ajax({
            type: "POST",
            url: "/node/" + nid + "/" + name + '/ajax',
            success: function(data) {
              $(content).html(data);
              set_active_tab($tab);
              Drupal.attachBehaviors($(content));
            }
          });
        }
      }
      
      function set_active_tab($tab) {
        var active_class = 'active';
        
        $tab.parent('ul.tabs').find('li, li a').removeClass(active_class);
        $tab.addClass(active_class);        
        $tab.find('a').addClass(active_class);
      }
    }
  }
})(jQuery);

