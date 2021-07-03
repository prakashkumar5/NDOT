
$(document).ready(function() {   
    $( ".fleet_models" ).click(function(){    
        alert("click");
        $(".fleet_models").removeClass('active');   
        $(this).addClass('active');    
    });
});