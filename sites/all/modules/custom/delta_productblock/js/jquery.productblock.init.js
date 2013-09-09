(function ($){
  $(function() {
    run_rotator_in_block();

    function run_rotator_in_block(){
      setTimeout(switch_divs_in_blockrotator, 7000);
    }

    function switch_divs_in_blockrotator(){
      jQuery('.content-productblock > .content-productblock-inner > .content-productblock-item').removeClass('content-productblock-item-show').addClass('content-productblock-item-hide');
      var $subject_child = jQuery('.content-productblock > .content-productblock-inner > .content-productblock-item:first');
      $subject_child.removeClass('content-productblock-item-hide').addClass('content-productblock-item-show');
      $subject_child.parent().append($subject_child);
      setTimeout(switch_divs_in_blockrotator, 7000);
    }
  });
})(jQuery);

	


