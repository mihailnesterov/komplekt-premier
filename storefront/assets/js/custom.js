/* 
	Mihail custom JavaScript 
	created 29.09.2019 
*/
console.log('scripts.js');


/* toTop Button */
$(function() { 
    $(window).scroll(function() { 
    if($(this).scrollTop() != 0) { 
        $('#toTop').fadeIn(); 
            } else {	 
                    $('#toTop').fadeOut(); 
            }	 
        }); 
        $('#toTop').click(function() { 
        $('body,html').animate({scrollTop:0},800); 
    });
});


/*Fixed top */
/*$(document).ready(function(){
  var $menu = $("#masthead1");
  $(window).scroll(function(){
    if ( $(this).scrollTop() > 100 && $menu.hasClass("default") ){
      $menu.hide().removeClass("default").addClass("fixed");
      $menu.fadeIn(600,function(){
        $(this).show();
      });
    } else if($(this).scrollTop() <= 100 && $menu.hasClass("fixed")) {
      $menu.removeClass("fixed").addClass("default");
    }
  });
});*/