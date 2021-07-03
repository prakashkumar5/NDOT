$(document).ready(function () {
  $('.main-nav').scroller();
 
  $(window).scroll(function () {  
  if ($(window).scrollTop() > 500) {
    $(".top_button").show();      
  } 
  else {
    $(".top_button").hide();
  }
  if ($(window).scrollTop() > 100) {
    $(".navbar").addClass("active");      
  } else {
    $(".navbar").removeClass("active");      
  }
 });
  $(".top_button").click(function(){ 
    $('html, body').animate({scrollTop:0}, '300');
  }); 
 
});