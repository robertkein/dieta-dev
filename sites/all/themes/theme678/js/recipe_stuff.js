(function ($) {
  Drupal.behaviors.recipe_slider = {
    attach: function (context, settings) {	
      
      $("#lightbox #imageDataContainer").css("background","rgba(255,255,255,0)");      

      //Добавляем свои кнопки прокурутки
      $('.jcarousel-container.jcarousel-container-horizontal').append($('<a class="next_photo_recipe"></a>'));
      $('.jcarousel-container.jcarousel-container-horizontal').append($('<a class="prev_photo_recipe"></a>'));
      $(".tooltip_carousel").hover(
          function () {            
            console.log('hover');
		//получаем количество картинок
		var count_li = $(this).find('ul li').size();
		//Получаем номер картинки из названия  
               var name_step = $(this).parent().attr('class');                  
               var number_step = name_step.replace("instruction step_",""); 
		 var number_int = parseInt(number_step)+1;
  	        $(this).find('.jcarousel-skin-default').once('processed').append($('<div class="number_photo_recipe">Фотография <span class="current_step_slider">'+number_int+'</span> из '+count_li+'</div>'));
               $(this).find('.current_step_slider').html(number_int);

                //Устанавливаем ul длину равную сумме длин картинок, чтоб выстроить в линию картинки
		  var width_li = $(this).find('ul li img').width();
		  
		  var width_ul = (width_li+10) * count_li;
                  console.log(width_li);
                  $(this).find('ul').width(width_ul);

                //Высчитываем положение слайдера относительно родительского блока, если выходит за границы - сдвигаем
		  var left_offset = $(this).position().left;	                         
                  if(left_offset > 350){
			var width_carousel_block = $(this).find(".carousel_block").width(); 			  
			$(this).find(".carousel_block").css('left',"-"+width_carousel_block+"px"); 			  
		   }		   
                 
		   //Получаем номер картинки из названия  
                  var name_step = $(this).parent().attr('class');                  
                  var number_step = name_step.replace("instruction step_","");                  
                  //Делаем смещение на длину равную сумме длин предшествующих ей картинок
                  var offset_ul = "-"+(number_step*(width_li+10))+"px";                   
		  $(this).find('ul').css("left",offset_ul);
          },
          function () {
            console.log('hover_out');
          }
     );
      $(".next_photo_recipe").click(function(){
         console.log('next'); 
	 var left =  $(this).parent().find(".recipe_carousel").css('left');
	 var width_px =  $(this).parent().find(".recipe_carousel").css('width');
	 width_px = width_px.replace("px","");
	 var width = parseInt(width_px);
	 console.log(width);
	 console.log(left);
	 left = left.replace("px","");
         left = parseInt(left);
	 console.log(left);
	 var width_li = $('.recipe_carousel li img').width();
	 console.log(width_li);
	 var new_left = left - 270;
	 new_left = new_left +"px";
	 console.log(new_left);
         if(((left)*(-1)+270) < width){
            $(this).parent().find(".recipe_carousel").css('left',new_left);
  	     var current_step = parseInt($(this).parent().parent().find('.current_step_slider').html()) + 1;
	     $(this).parent().parent().find('.current_step_slider').html(current_step);
         } 	 
	 return false;

      });
      
      $(".prev_photo_recipe").click(function(){
          console.log('prev'); 
	  var left =  $(this).parent().find(".recipe_carousel").css('left');	  
	  left = left.replace("px","");
	  console.log('left');
         left = parseInt(left);
	  console.log(left);
	  var width_li = $('.recipe_carousel li img').width();
	  console.log('width_li');
	  console.log(width_li);
  	  console.log('new_left');	
	  var new_left = left + 270;	  
	  console.log(new_left);
         if(new_left <= 0){
           new_left = new_left +"px";
	    $(this).parent().find(".recipe_carousel").css('left',new_left);
	    var current_step = $(this).parent().parent().find('.current_step_slider').html()-1;
	    console.log(current_step);
	    $(this).parent().parent().find('.current_step_slider').html(current_step);
         }      
	  return false;
      });
    }	
  };
})(jQuery);

