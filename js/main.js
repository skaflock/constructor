// используем function для изоляции кода
(function(){

'use strict';
/*jslint browser: true*/
/*global $, jQuery, console, flexibility*/

window.devGrid = {
  id: 'devGrid',
  open: false,
  init: function(){
    var _t = this;
    var open = false;
    document.onkeydown = function(e) {
      if (e.ctrlKey && (~[59, 186].indexOf(e.which) || e.code == 'Semicolon')) {
        if (open) {
          _t.destroy();
        } else {
          _t.create();
        }
        open = !open;
        return false;
      }
    };
  },
  create: function(cols, gap){
    cols = typeof cols !== 'undefined' ? cols : 12;
    gap = typeof gap !== 'undefined' ? gap : 20;
    var _t = this;
    var grid = $('<div id="' + _t.id + '" class="wrap" />')
    .appendTo('body')
    .css({
      'display': 'flex',
      'justify-content': 'space-between',
      'position': 'fixed',
      'top': '0',
      'left': '0',
      'right': '0',
      'z-index': '999',
      'margin': '0 auto',
      'height': '100%',
      'pointer-events': 'none'
    });
    while (grid.children().length < cols) {
      $('<div />').appendTo(grid).css({
        'width': 'calc((100% - (' + gap + 'px * 11)) / 12)',
        'background-color': 'rgba(200,0,0,0.1)'
      });
    }
  },
  destroy: function(){
    var _t = this;
    $('body').children('#' + _t.id).remove();
  }
};

// функция для установки одинаковой высоты для указанных блоков
(function($) {
  $.fn.equalHeight = function() {
    var t = $(this);
    var heightArray = t.map(function() {
      return $(this).height();
    }).get();
    var maxHeight = Math.max.apply(Math, heightArray);
    t.height(maxHeight);
    return t;
  };
})(jQuery);

/* document ready
==============================================================================*/
$(function(){
  devGrid.init();
});

/* window load
==============================================================================*/
$(window).on('load', function(){
  $('html').addClass('loaded');
  console.log($('html').attr('class')); // получаем список классов от modernizr

  //
});

}());
