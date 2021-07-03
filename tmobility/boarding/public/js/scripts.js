 
    (function($) {
    "use strict"; // Start of use strict
  
    // Smooth scrolling using jQuery easing
    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: (target.offset().top - 100)
          }, 1000, "easeInOutExpo");
          return false;
        }
      }
    });
  })(jQuery); // End of use strict
  
 
  $('a[data-toggle="formtab"]').click(function(){
    var targetId = $(this).attr('href');

    $('.product_list').removeClass('active')
    $('a[data-toggle="formtab"]').removeClass('active');
    
    $(targetId).addClass('active');
	$('a[href="'+targetId+'"]').addClass('active')
});


// document.querySelector(".file_up").classList.add('js');

var fileInput  = document.querySelector( ".input-file" ),  
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");
      
button.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput.focus();  
    }  
});
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});  
fileInput.addEventListener( "change", function( event ) {  
    the_return.innerHTML = this.value;  
});  

 

$(".onboard_checkboxs input:checkbox").change(function () {
  $(this).parent().parent().parent().toggleClass('active', this.checked);
});