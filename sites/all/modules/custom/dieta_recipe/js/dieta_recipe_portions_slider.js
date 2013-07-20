
//(function ($) {
//  Drupal.behaviors.dieta_recipe_portions_slider = {
//    attach : function(context, settings) { 
            
      /**
       * Создание ползунка
       * @param {string} elemId   - id элемент, внутри которого будет размещаться slider
       * @param {int} sliderWidth - длина slider'а в пикселях
       * @param {int} range1      - нижняя граница значений slider'а 
       * @param {int} range2      - верхняя граница значений slider'а
       * @param {int} step        - шаг изменения значения (0 - шаг 1)
       * @param {int} default_value - начальное значение ползунка
       */
      function slider(elemId, sliderWidth, range1, range2, step, default_value) {
        knobWidth = 9;             // ширина и высота бегунка
        knobHeight = 31;            // изменяются в зависимости от используемых изображений
        sliderHeight = 31;          // высота slider'а


        
        var offsX, tmp;                  // вспомагательные переменные
        var d = document;
        var isIE = d.all || window.opera;   // определяем модель DOM
        var point = (sliderWidth - knobWidth - 3) / (range2 - range1);
      // point - количество пикселей на единицу значения
      
        var smaller = d.createElement('SPAN');  // создаем кнопку "-"
        smaller.id = elemId + '_smaller';
        smaller.className = 'smaller';
        d.getElementById(elemId).appendChild(smaller); // добавляем его в документ
        
        var slider = d.createElement('DIV'); // создаем slider
        slider.id = elemId + '_slider';
        slider.className = 'slider';
        d.getElementById(elemId).appendChild(slider);      

        knob = d.createElement('DIV');  // создаем ползунок
        knob.id = elemId + '_knob';
        knob.className = 'knob yield';
        slider.appendChild(knob); // добавляем его в документ

        bigger = d.createElement('SPAN');  // создаем кнопку "-"
        bigger.id = elemId + '_bigger';
        bigger.className = 'bigger';
        d.getElementById(elemId).appendChild(bigger); // добавляем его в документ

        knob.style.left = 0;            // бегунок в нулевое значение
        knob.style.width = sliderWidth - knobWidth + 'px';
        knob.style.height = knobHeight + 'px';
        slider.style.width = sliderWidth + 'px';
        slider.style.height = sliderHeight + 'px';

        var sliderOffset = slider.offsetLeft;           // sliderOffset - абсолютное смещение slider'а
        tmp = slider.offsetParent;      // от левого края в пикселях (в IE не работает)
        while (tmp.tagName != 'BODY') {
          sliderOffset += tmp.offsetLeft;     // тут его и находим
          tmp = tmp.offsetParent;
        }

        if (isIE)                        // в зависимости от модели DOM
        {                               // назначаем слушателей событий
          knob.onmousedown = startCoord;
          slider.onmousedown = sliderClick;
          smaller.onmousedown = smallerClick
          bigger.onmousedown = biggerClick
          knob.onmouseup = endCoord;
          slider.onmouseup = endCoord;
        }
        else {
          knob.addEventListener("mousedown", startCoord, true);
          slider.addEventListener("onmousedown", sliderClick, true);
          smaller.addEventListener("mousedown", smallerClick, true);
          bigger.addEventListener("mousedown", biggerClick, true);
          knob.addEventListener("mouseup", endCoord, true);
          slider.addEventListener("mouseup", endCoord, true);
        }
        
        // устанавливаем дефолтное значение для ползунка
        if (default_value === undefined) {
          default_value = 0;
        }
        setValue2(default_value);

      // далее подробно не описываю, кто захочет - разберется
      //////////////////// функции установки/получения значения //////////////////////////

        function setValue(x)    // установка по пикселям
        {
          if (x < 0)
            knob.style.left = 0;
          else if (x > sliderWidth - knobWidth - 3)
            knob.style.left = (sliderWidth - 3 - knobWidth) + 'px';
          else {
            if (step == 0) {
              knob.style.left = x + 'px';
              knob.style.width = (sliderWidth - x - knobWidth) + 'px';
            }
            else
              var left = (Math.round(x / (step * point)) * step * point);
              knob.style.left = left + 'px';
              knob.style.width = (sliderWidth - left - knobWidth) + 'px';
							if ( (sliderWidth - left - knobWidth) < knobWidth ) {
								knob.style.width =  knobWidth + 'px';
							}
          }
          d.getElementById(knob.id).innerHTML = getValue();    // это вывод значения для примера
        }
        function setValue2(x)   // установка по значению
        {
          if (x < range1 || x > range2)
            alert('Value is not included into a slider range!');
          else
            setValue((x - range1) * point);
        }

        function getValue()
        {
          return Math.round(parseInt(knob.style.left) / point) + range1;
        }

      //////////////////////////////// слушатели событий ////////////////////////////////////

        function sliderClick(e) {
          var x;
          if (isIE) {
            if (event.srcElement != slider)
              return; //IE onclick bug
            x = event.offsetX - Math.round(knobWidth / 2);
          }
          else
            x = e.pageX - sliderOffset - knobWidth / 2;
          setValue(x);
        }
        
        function smallerClick(e) {
          var x;
          var d = document;
          var current_value = parseInt(d.getElementById(knob.id).innerHTML);
          if (isIE) {
            if (event.srcElement != smaller) {
              return; //IE onclick bug
            }
          }
          x = (current_value - 1);
          if (x > 0) {
            setValue2(x);
          }
        }        
        
        function biggerClick(e) {
          var x;
          var d = document;
          var current_value = parseInt(d.getElementById(knob.id).innerHTML);
          if (isIE) {
            if (event.srcElement != bigger) {
              return; //IE onclick bug
            }
          }
          x = (current_value + 1);
          if (x <= range2) {
            setValue2(x);
          }
        }

        function startCoord(e) {
          if (isIE) {
            offsX = event.clientX - parseInt(knob.style.left);
            slider.onmousemove = mov;
          }
          else {
            slider.addEventListener("mousemove", mov, true);
          }
        }

        function mov(e) {
          var x;
          if (isIE)
            x = event.clientX - offsX;
          else
            x = e.pageX - sliderOffset - knobWidth / 2;
          setValue(x);
        }

        function endCoord() {
          if (isIE)
            slider.onmousemove = null;
          else
            slider.removeEventListener("mousemove", mov, true);
        }

      // объявляем функции setValue2 и getValue как методы класса
        this.setValue = setValue2;
        this.getValue = getValue;
      } // конец класса

//    }                
//  }
//})(jQuery);
