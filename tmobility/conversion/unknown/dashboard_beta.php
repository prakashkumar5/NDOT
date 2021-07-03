<?php $google_map_val = 1;
      $defined_map_val = defined('MAPBOX_KEY') ? MAPBOX_KEY : $google_map_val; 
      $dashboad_beta_map_val = defined('DASHBOARD_BETA_MAP_FROM') ? DASHBOARD_BETA_MAP_FROM : $google_map_val;
      $dashboad_autocomplete_map_val = defined('DASHBOARD_BETA_AUTOCOMPLETE_FROM') ? DASHBOARD_BETA_AUTOCOMPLETE_FROM : $google_map_val; 
      $dashboad_direction_map_val = defined('DASHBOARD_BETA_DIRECTIONS_FROM') ? DASHBOARD_BETA_DIRECTIONS_FROM : $google_map_val;
      $later_booking_interval = defined('LATER_BOOKING_INTERVAL') ? LATER_BOOKING_INTERVAL : (int)60; 
      $site_default_unit = defined('DEFAULT_UNIT') ? DEFAULT_UNIT : '';      
	  $is_city_based = defined('IS_CITY_BASED') ? IS_CITY_BASED:0;
	  $location_lati = defined('LOCATION_LATI')?LOCATION_LATI:'11.347834567';
	  $location_long = defined('LOCATION_LONG')?LOCATION_LONG:'76.147834567';
	  $iso_country_code = defined('ISO_COUNTRY_CODE')?ISO_COUNTRY_CODE:'IND';
	  $book_later_hide = defined('BOOKLATER_HIDE') ? BOOKLATER_HIDE : 0;
	  $km_restrict_constant = defined('KM_RESTRICTION_DISTANCE') ? KM_RESTRICTION_DISTANCE : 0;
	  $booking_type_cond = defined('CHANGE_BOOKING_TYPE') ? CHANGE_BOOKING_TYPE : 0;
	  $SITE_NOTIFICATION_SETTING = defined('SITE_NOTIFICATION_SETTING') ? SITE_NOTIFICATION_SETTING : 20;
	  $SCHEDULE_TRIP_NOTIFICATION = defined('SCHEDULE_TRIP_NOTIFICATION') ? SCHEDULE_TRIP_NOTIFICATION : 0;
	 $company_restrict_style = isset($company_add_restrict_style) ? $company_add_restrict_style : "";


	                        $ENABLE_SHOW_MAP_WITH_ALL_DRIVERS=defined('ENABLE_SHOW_MAP_WITH_ALL_DRIVERS')?ENABLE_SHOW_MAP_WITH_ALL_DRIVERS:0;
	                       

if($dashboad_beta_map_val == 2){ ?>
<script type="text/javascript" src="<?php echo URL_BASE;?>public/common/js/mapbox/mapbox.js"></script>
<link rel="stylesheet" href="<?php echo URL_BASE;?>public/common/css/mapbox/mapbox-gl.css" />
<?php } ?>
<script type="text/javascript" src="<?php echo URL_BASE;?>public/dispatch/vendor/bootstrap/js/modernizr.custom.04022.js"></script>
<link rel="stylesheet" href="<?php echo URL_BASE;?>public/chart_new/css/slick.css?t=<?php echo time(); ?>">
<link rel="stylesheet" href="<?php echo URL_BASE;?>public/chart_new/css/slick-theme.css?t=<?php echo time(); ?>">
<script src="<?php echo URL_BASE;?>public/chart_new/js/slick.js?t=<?php echo time(); ?>" type="text/javascript" ></script>
<script src="<?php echo URL_BASE;?>public/admin/js/slider.js?t=<?php echo time(); ?>" type="text/javascript" ></script>
<script type="text/javascript" language="javascript">
	var show_map = "<?php echo SHOW_MAP; ?>";
	var SITE_NOTIFICATION_SETTING = "<?php echo $SITE_NOTIFICATION_SETTING ?>";
	var SCHEDULE_TRIP_NOTIFICATION = "<?php echo $SCHEDULE_TRIP_NOTIFICATION ?>";
	var my_current_location = "<?php echo __('my_current_location'); ?>";
	var want_to_logout = "<?php echo __('are_you_surewanttologout');?>";
	var logout_success = '<?php echo __('logout_success'); ?>';
	var driver_in_trip = '<?php echo __('driver_in_trip'); ?>';
	var GOOGLE_MAP_API_KEY = "<?php echo GOOGLE_MAP_API_KEY; ?>";
	var PUBLIC_IMGPATH = '<?php echo PUBLIC_IMGPATH.'/' ; ?>';
	var select_startdate = "<?php echo __('select_startdate'); ?>";
	var select_enddate = "<?php echo __('select_enddate'); ?>";
	var startdate_greater = "<?php echo __('startdate_greater'); ?>";
	var min_round_trip = '<?php echo DEFAULT_ONEWAY_DURATION * 60; ?>';
	var all_company_drivers = "<?php echo isset($all_comp_drivers)?json_encode($all_comp_drivers):'0'; ?>";
	var tripId = "<?php echo $tripId; ?>";	
	var unitname = "<?php echo UNIT_NAME; ?>";
	
	var taxInclusive = '(<?php echo __("tax_inclusive"); ?>)';
	var taxExclusive = '(<?php echo __("tax_exclusive"); ?>)';

	var dashboard_beta_map_from = <?php echo $dashboad_beta_map_val; ?>;
	var dashboard_beta_autocomplete_from = <?php echo $dashboad_autocomplete_map_val; ?>;
	var dashboard_beta_directions_from = <?php echo $dashboad_direction_map_val; ?>;
	var mapbox_key = '<?php echo $defined_map_val; ?>';
	var email_exists = '<?php echo __('email_exists'); ?>';
	var later_booking_interval= "<?php echo $later_booking_interval; ?>";
	var IS_CITY_BASED =<?php echo $is_city_based; ?>;
    var	LOCATION_LATI = '<?php echo $location_lati; ?>';
	var LOCATION_LONG = '<?php echo $location_long; ?>';
	var ISO_COUNTRY_CODE = '<?php echo $iso_country_code; ?>';
</script>
<style>
.marker_free{
	 color: 'green !important';
}
.marker_active{
	 color: '#ffba07 !important';
}
.marker_busy{
	 color: 'red !important';
}

</style>
<script>
	function promocode_validation(form,type){
		var promocode = $("#promocode").val();	
		var promo_error = 'promocodeError';
			
		if(promocode != ''){
			
			var type = 'add';			
			$("#"+promo_error).hide().html("");
			if( promocode != '' )
			{
				$.ajax ({
					type: "POST",
					url: SrcPath+"taxidispatch/check_promocode",
					//data: dataS, 
					data: $(form).serialize(),
					cache: false, 
					dataType: 'html',
					timeout: 3000,
					success: function(response) 
					{
						if( response != 1 )
						{
							$("#"+promo_error).show().html(response);
							return false;
						}
						else{
							$('#dispatch').attr('disabled','disabled');
							$('#dispatch_id').val("Dispatch");
							form.submit();
						}
					},
					error: function() {
						alert('<?php echo __("network_connection_failed"); ?>');
						return false;
					}
				});
			}
		}else{
			$('#dispatch').attr('disabled','disabled');
			$('#dispatch_id').val("Dispatch");
			form.submit();
		}
		return false;
	}
	
	function edit_promocode_validation(form,type){
		
		var promocode = $("#edit_promocode").val();	
		var promo_error = 'editPromocodeError';				
		$("#"+promo_error).hide().html("");
		
		if( promocode != '' )
		{
			$.ajax ({
				type: "POST",
				url: SrcPath+"taxidispatch/check_promocode",
				//data: dataS, 
				data: $(form).serialize(),
				cache: false, 
				dataType: 'html',
				timeout: 3000,
				success: function(response) 
				{
					if( response != 1 )
					{
						$("#"+promo_error).show().html(response);
						return false;
					}
					else{
						
						return true;                                        
					}
				},
				error: function() {
					alert('<?php echo __("network_connection_failed"); ?>');
					return false;
				}
			});
		}		
		return false;
	}
	
$(document).ready(function() {
	// $(document).on('slick','.center', function(){
	//     slidesToShow: 3,
    //     slidesToScroll: 1,            
    //     arrows: true
	// });
	// $('.center').slick({                    
    //         slidesToShow: 4,   
    //         slidesToScroll: 1,            
    //         arrows: true, 

    //         responsive: [   
    //             {breakpoint: 960,settings: {slidesToShow: 3,slidesToScroll: 1}},   
    //             {breakpoint: 480,settings: {slidesToShow: 2,slidesToScroll: 1}},     
    //             {breakpoint: 320,settings: {slidesToShow: 1,slidesToScroll: 1}}     
    //         ]
    //     });

        

        // var slide_count = "<?php //echo count($get_model_details); ?>";
        // if(slide_count < 4)
        // {   
            
        //     $(".slick-track").addClass('active');
        // }
        // else
        // {   
            
        //     $(".slick-track").removeClass('active');
        // } 
	/* clear form data */
	/*$('#fixed_fare').on('click', function(){
		alert("sds");return false;
		$(this).hasClass('active');
	});*/
	$('#fixedfare').hide();
	$('#edit_fixedfare').hide();

	$('#fixed_fare_select').change(function() {
        if(this.checked) {
            $('#fixedfare').show();        
        }else{
        	$('#fixedfare').hide(); 
        	$('#fixedfare_error').html("");
       }
    });
    $('#edit_fixed_fare_select').change(function() {
        if(this.checked) {
            $('#edit_fixedfare').show();        
        }else{
        	$('#edit_fixedfare').hide();    
        	$('#edit_fixedfareError').html("");    

       }
    });


	$('.add_taxi_arr1').on('click', function(){
		$('#pickup_date').removeAttr('setvalue');
		$(this).hasClass('active');
	});
	
	$("#promocode").bind('keyup', function (e) {
		this.value = this.value.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
		$("#promocode").val(($("#promocode").val()).toUpperCase());
	});
	
	$("#edit_promocode").bind('keyup', function (e) {		
		this.value = this.value.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
		$("#edit_promocode").val(($("#edit_promocode").val()).toUpperCase());
	});

	$("#edit_promocode").bind('blur', function (e) {
		$('#edit_trip_type').focus();
	});

	
	$("#country_code_new, #phone_new, #fixedfare,#edit_fixedfare").keypress(function(event) {
				  
	  var controlKeys = [8, 9, 13, 35, 36, 37, 39];	  
	  var isControlKey = controlKeys.join(",").match(new RegExp(event.which));
	  
	  if (!event.which || (48 <= event.which && event.which <= 57) || isControlKey) { 
		return;
	  } else {
		event.preventDefault();
	  }
	});
	 $("#firstname_new").keypress(function(event){
        var inputValue = event.which;
        // allow letters and whitespaces only.
        var SUBDOMAIN_NAME = "<?php echo SUBDOMAIN_NAME; ?>";
        if(SUBDOMAIN_NAME != 'taxidenis'){
	        	if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 8 && inputValue != 0 && inputValue != 121 && inputValue != 122)) { 
	            event.preventDefault(); 
	        }
        }
        
    });
    
    /*$("#firstname_new").on('blur',function(){
    	if($("#firstname_new").hasClass('error')){
    		$("#name_condition").text("");	
    	}else{
    		$("#name_condition").text("<?php echo __('name_condition')?>");
    	}    	
    });*/
    
	
	
	$("#reset_date").click(function(){
		$("#search_txt, #search_location, #select_taxi_model").val("");
		$("#filter_date").val("<?php echo date('Y-m-d 00:00');?>");
		$("#to_date").val("<?php echo date('Y-m-d 23:59');?>");
		all_booking_manage_list_search();
	});
	
	$("#clearFromDate").on('click',function(){
		$("#filter_date").val("<?php echo date('Y-m-d 00:00');?>");
	});
	
	$("#clearToDate").on('click',function(){
		$("#to_date").val("<?php echo date('Y-m-d 23:59');?>");
	});

	var today = new Date();
	var timeFormat = "hh:ii";
	//var dateFormat = DEFAULT_DATE_FORMAT_SCRIPT;
	var dateFormat = "yyyy-mm-dd";
	var dateFormat = dateFormat+' '+timeFormat;
	$("#filter_date").datetimepicker({
		autoclose:true,
		endDate: today,
		showTimepicker:true,
		showSecond: true,
		format : dateFormat,
		stepHour: 1,
		stepMinute: 1,
		stepSecond: 1
	});

	$("#to_date").datetimepicker( {
		autoclose:true,
		//endDate: today,
		showTimepicker:true,
		showSecond: true,
		format : dateFormat,
		stepHour: 1,
		stepMinute: 1,
		stepSecond: 1
	});

	//$("#taxi_model").val('1');
	/*$('.dispatch_det_slidebar_add').addClass('active');
    	 
    $('.estimate_container').css('display','block');
    $('#add_add_btn').addClass('active');
    if($('#add_add_btn').hasClass('active')){
 		
 		$(".job_filter_bar").css('display','none');
 		$(".jobs_search_bar").css('display','none');
 		
 		$('.job_listing_container').css('display','none');
 		$('.add_job_container').css('display','block');	
 		$('#defaultForm_edit').hide()
		$('#defaultForm').show();			
 	}*/

 	$("#model_close_one_beta").click(function() {
 		$('#myModal_dispatch').modal('hide');
        // window.location = URL_BASE + "taxidispatch/dashboard_beta";
    });

    $("#edit_corporateID").val(0)
});


$(document).ready(function(e) {
	
	
	$("body").click(function(e){
		
		if(e.target.className != "search_outer" && e.target.className.toString().indexOf("search_txt")==-1 && e.target.className != "search_toggle"){
		  $(".search_outer").hide();
		  $('.search_box').removeClass('toggle_down').removeClass('showSearcDiv');	
		  $('.dispatcher_list').removeClass('hight_class');
		   $('.hight_class').css('height','calc(100vh - 115px)');
		}
		if(e.target.className !== "status_dropdown" && e.target.className !== "status_dropdown_in" &&  e.target.className.toString().indexOf("status_dropdown_in")==-1 && e.target.className !== "filter_drop" ){ 
			
		  $(".status_dropdown").hide();
		  $('.filter').removeClass('toggle_down').removeClass('showFilterDiv');
		}
		if($('#search_txt').val() == ''){
			$('#search_result_display').hide();
			$('#search_result_display').removeClass('search_height');
			$('.dispatcher_list ')//.css('height','calc(100vh - 80px)')
		}else{
			$('#search_result_display').show();
			$('#search_result_display').addClass('search_height');
			$('.dispatcher_list ').css('height','calc(100vh - 115px)')
			$('#search_result_display_container').html($('#search_txt').val());
		}
	});	 
	$(document).on('click','.add_taxi_arr, .edit_trip', function(){
		$('li[role="presentation"]').removeClass('active');
		$('#anonymous_id').prop('disabled',false);
			
		if($(this).hasClass('add_taxi_arr')){
			//$('#Anonymous_presentation_id').addClass('disabled');
			$('#defaultForm_edit').hide()
			$('#defaultForm').show()			
			$("#anonymous_id").trigger('click');
		}else{
								
			$('#defaultForm_edit').show();
			$('#defaultForm').hide();
			$("#account_sec_id").trigger('click');
			$('#search_txt_div').hide();
		}
		$('body').addClass('open_popup');
	});
	
	$(document).on('click','.search_toggle', function(){
		
		if($('.search_box.showSearcDiv').length!=0){
			
			$('.search_box').removeClass('toggle_down');
			$('.dispatcher_list').removeClass('hight_class');
			$('.search_outer').hide();			
		
		}else{
			
			$('.search_box').addClass('toggle_down');
			$('.dispatcher_list').addClass('hight_class');
			$('.search_outer').show();
			$('#search_txt').focus();
		}		
		
		$('.search_box' ).toggleClass( "showSearcDiv" );
		
	});
	$(document).on('click','.filter_drop', function(){
				
		if($('.filter.showFilterDiv').length!=0){			
			$('.filter').removeClass('toggle_down');
			$('.status_dropdown').hide();			
		
		}else{			
			$('.filter').addClass('toggle_down');
			$('.status_dropdown').show();
		}		
		$('.filter' ).toggleClass( "showFilterDiv" );		
	});

	$('#close_button').click(function() {
		$('body').removeClass('open_popup');
		$('#Anonymous_presentation_id').removeClass('disabled');
		$('#Anonymous_presentation_id a').attr('data-toggle','tab').attr('href','#Anonymous');
		document.getElementById("country_code_new").style.borderColor = "#ccc";
	});
});
</script>


<?php 
//$company_currency = findcompany_currency($_SESSION['company_id']); 
$company_currency = CURRENCY_SYMB; 
?>

<input type="hidden" name="companyId" id="companyId" value="<?php echo isset($_SESSION['company_id']) ? $_SESSION['company_id']:''; ?>" >
<input type="hidden" name="add_corporateId" id="add_corporateId" value="<?php echo isset($_SESSION['corporate_id']) ? $_SESSION['corporate_id']:0; ?>" >
<!-- Complete trip popup-->
<div id="ros_trip" class="modal fade ros_trip" role="dialog">
  	<div class="modal-dialog">

    	<!-- Modal content-->
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title"><?php echo __('complete_trip'); ?></h4>
		    </div>
	     	<div class="modal-body">
	        	<form class="form" action="<?php echo URL_BASE ?>manage/complete_trip" id="roscompletetrip" method="post" name="roscompletetrip"> 
					<div class="form-group">
						<label><?php echo __('Drop_Location'); ?></label>
						<input type="text" placeholder="<?php echo __('enter_drop_locations') ?>" name="ros_drop_location" class="form-control" id="ros_drop_location" autocomplete="off">	
						<span id="ros_drop_error" class="error"></span>
						<input type="hidden" name="drop_latitude" id="ros_drop_latitude">
						<input type="hidden" name="drop_longitude" id="ros_drop_longitude">
						<input type="hidden" name="beta" value='1'>
						<input type="hidden" name="trip_id" id="ros_trip_id">
						<input type="hidden" name="taxi_id" id="ros_taxi_id">
						<input type="hidden" name="plan_distance" id="plan_distance">
						<input type="hidden" name="promo_type" id="promo_type" value ="">
						<input type="hidden" name="promo_discount" id="promo_discount" value ="">
						<input type="hidden" name="plan_distance_unit" id="plan_distance_unit">
						<input type="hidden" name="bookingtype" id="bookingtype">
						<?php 
							if($site_default_unit == 0)
							{ ?>
								<input type="hidden" name="site_default_unit" id="site_default_unit" value = "km"  >
							<?php 
						     }
						     else 
						     	{ ?>
						     <input type="hidden" name="site_default_unit" id="site_default_unit" value = "miles" >
						        <?php }

						?> 
					    
						<input type="hidden" name="base_fare" id="base_fare">
						<input type="hidden" name="plan_duration" id="plan_duration">
						<input type="hidden" name="additional_fare_per_distance" id="additional_fare_per_distance">
						<input type="hidden" name="additional_fare_per_hour" id="additional_fare_per_hour">
						<input type="hidden" name="rental_outstation" id="rental_outstation" value="0">						
					</div>
					<div class="form-group">
						<label><?php echo __('distance_km'); ?></label>						
						<input type="text" class="tripdistance form-control"  name="ros_distance" id="ros_distance" autocomplete="off" maxlength="6">
						<span id="ros_distance_error" class="error"></span>						
					</div>
					<!-- <div class="form-group">
						<label><?php echo __('trip_duration'); ?></label>
						<input type="time"  name="ros_duration" class="form-control" id="ros_duration" min="00:00" max="24:00">			
						<input type="text"  name="ros_duration" class="form-control" id="os_duration" value="12" readonly="">
						<span id="ros_duration_error" class="error"></span>
					</div> -->

					<div class="form-group">
						<label><?php echo __('trip_duration'); ?></label>
						<div class="stylish_timer">	
							<input type="text" autocomplete="off" class="form-control tripduration" placeholder="HH" maxlength="3" name="new_trip_duration" id="new_trip_duration" >
							<i id="i_tag">:</i>
							<input type="text" autocomplete="off" placeholder="mm" class="form-control tripduration2" maxlength="2" name="new_trip_duration2" id="new_trip_duration2">
						</div>
						<span id="ros_duration_error" class="error"></span>
					</div>

					<div class="form-group">
						<label><?php echo __('base_fare'); ?><span id="time_distance"></span><?php echo $company_currency.' '; ?></label>
						<input type="text" name="base_fare_value" class="form-control" id="base_fare_value" readonly="">
					</div>
					<div class="form-group">
						<label><?php echo __('additional_duration_fare'); ?></label>						
						<?php echo $company_currency.' '; ?><input type="text" name="duration_fare" class="form-control" id="duration_fare" readonly="">						
					</div>
					<div class="form-group">
						<label><?php echo __('additional_distance_fare'); ?></label>
						<?php echo $company_currency.' '; ?><input type="text" name="distance_fare" class="form-control" id="distance_fare" readonly="">
					</div>
					<div class="form-group">
						<label><?php echo __('trip_fare'); ?></label>
						
						<input type="text"  class="form-control" name="ros_fare" id="ros_fare" autocomplete="off" maxlength="10">
						<span id="ros_fare_error" class="error"></span>
						<span class="hint"><?php echo __('distancefare_info'); ?></span>
						
					</div>
					<div class="form-group" id="promo_div1">
					<label><?php echo __('promocode_info'); ?><span id="promocode_type1"></span></label>
						<input type="text" class="form-control" name="promocode_info1" id="promocode_info1" readonly>
						<span id="tripfare_error" class="error"></span>
						<span class="hint"><?php echo __('promo_info'); ?></span>
					</div>
					<div class="form-group" >
					<label><?php echo __('tax_info');  ?><span id="tax_info_val"></span></label>
						<input type="text" class="form-control" id="tax_ros_complete">
						<span id="tripfare_error" class="error"></span>
						<span class="hint"><?php echo __('note:').__('taxinfo'); ?></span>
					</div>
					<div class="form-group">
						<label><?php echo __('complete_fare'); ?></label>
						
						<input type="text"  class="form-control" name="complete_ros_fare" id="complete_ros_fare" autocomplete="off" maxlength="10">
						<span id="ros_fare_error" class="error"></span>
						<span class="hint"><?php echo __('complete_info'); ?></span>
						
					</div>
					<div class="form-group btn-block">
						<input type="submit" disabled class="btn complete_trip_submit" value="<?php echo __('complete_trip'); ?>" />
					</div>
				</form>
	      	</div>
	    </div>

  	</div>
</div>

<div id="normal_trip" class="modal fade ros_trip" role="dialog">
  	<div class="modal-dialog">

    	<!-- Modal content-->
	    <div class="modal-content">
		    <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title"><?php echo __('complete_trip'); ?></h4>
		    </div>
	     	<div class="modal-body">
	        	<form action="<?php echo URL_BASE ?>manage/complete_trip" class="form" id="completeTrip" method="post" name="complete"> 
					<div class="form-group">
						<label><?php echo __('Drop_Location'); ?></label>
						<input type="text" class="form-control" placeholder="<?php echo __('enter_drop_locations') ?>" name="drop_location" id="normal_drop_location" autocomplete="off">	
						<span id="drop_error" class="error"></span>
						<input type="hidden" name="drop_latitude" id="normal_drop_latitude">
						<input type="hidden" name="drop_longitude" id="normal_drop_longitude">
						<input type="hidden" name="trip_id" id="trip_id">
						<input type="hidden" name="taxi_id" id="taxi_id">
						<input type="hidden" name="beta" value='1'>
						<input type="hidden" name="bookingtype" id="bookingtype">
					</div>
					<div class="form-group">
						<label><?php echo __('distance_km'); ?></label>
						<input type="text" class="form-control tripdistance"  name="distance" id="distance" autocomplete="off" maxlength="6">
						<span id="distance_error" class="error"></span>
					</div>
					<div class="form-group">
					<label><?php echo __('trip_time'); ?></label>
						<input type="text" class="form-control" name="trip_fare" id="trip_fare" maxlength="9">
						<span id="tripfare_error" class="error"></span>
						<span class="hint"><?php echo __('distancefare_info'); ?></span>
						<span class="hint"><?php echo __('note:').__('taxinfo'); ?></span>
					</div>
					<div class="form-group" id = "promo_div">
					<label><?php echo __('promocode_info'); ?><span id="promocode_type"></span></label>
						<input type="text" class="form-control" name="promocode_details" id="promocode_details" readonly>
						<span id="tripfare_error" class="error"></span>
						<span class="hint"><?php echo __('promo_info'); ?></span>
					</div>
					<div class="form-group">
					<label><?php echo __('tax_info');  ?><span id="local_tax_info"></span></label>
						<input type="text" class="form-control" value=" " id="tax_local_complete">
						<span id="tripfare_error" class="error"></span>
						<span class="hint"><?php echo __('distancefare_info'); ?></span>
						<span class="hint"><?php echo __('note:').__('taxinfo'); ?></span>
					</div>
					<div class="form-group">
						<label><?php echo __('complete_fare'); ?></label>
						
						<input type="text"  class="form-control" name="complete_local_fare" id="complete_local_fare" autocomplete="off" maxlength="10">
						<span id="ros_fare_error" class="error"></span>
						<span class="hint"><?php echo __('complete_info'); ?></span>
						
					</div>
					<div class="form-group btn-block">
						<input type="submit" disabled class="btn complete_trip_submit" value="<?php echo __('complete_trip'); ?>" />
						<input type="button" class="btn complete_trip_cancel" data-dismiss="modal" value="Cancel" value="<?php echo __('cancel'); ?>" />
					</div>
				</form>
	      	</div>
	    </div>

  	</div>
</div>
<!-- Complete trip popup-->

<div class="container taxi_dispatcher">
    <div class="row">
        <div class="lft_outer" id="container_tot">
        	<?php 
        	if((int)$ENABLE_SHOW_MAP_WITH_ALL_DRIVERS===0)
        	{
        	?>
        	<a href="javascript:;" title="" class="open_dispth_icon"></a>
        	<div  class="notification_container">
        		<a href="javascript:;" class="notification_icon " title="Refresh and see the current status of drivers " onClick="return toggleNotification(event,this);"><i style="" class="notify_count">99</i></a>        		
        	</div>
        	<?php
        	}
        	?>
	    	<div class="dispatch_slidebar">
	    		<div class="dt_top_header">
	    			<h2><?php echo __('job_list');?></h2>
	    			<a href="javascript:;" class="slide_close_icon" title="Close"></a>
	    		</div>
				<section class="tabs">
					<input id="tab-1" type="radio" name="radio-set" class="tab_link tab-selector-1" checked="checked" />
				    <label for="tab-1" class="tab-label-1"><?php echo __('jobs');?></label>		
			        <input id="tab-2" type="radio" name="radio-set" class="tab_link tab-selector-2" />
				    <label for="tab-2" class="tab-label-2"><?php echo __('fleets');?></label>     
				<div class="tab_content">
					<div class="content-1">
						<div class="job_list_detailed_container">
				        	<!--start-->
				        		
							<div class="jobs_search_bar">
								<div class="form_group">
									
									<input type="text" name="" class="form-control job_search_bar" minlength="1" maxlength="9" placeholder="<?php echo __('search_by_job');?>" value="<?php echo $tripId ?>">
								</div>
								<a href="javascript:;" 
								
								class="add_btn add_taxi_arr1 " id="add_btn" title=""><i></i></a>
							</div>
							<div class="job_filter_bar">
								<div class="sort_list">
						            <div class="sort_list_inner">
							            <div class="vehicle_type model_job_list">
							             	 <a id="vehicle_type" class="select_taxi_model model_type active" name="select_taxi_model" data-id="0" value="0" ><?php echo __('allvehicle'); ?></a>
							             	<div class="schedule_list vehicle_list">
							             	   <ul id="vehicle_model_list" class="search_job_list">
							             	   		<li>
							             	   		<a value="0"><?php echo __('all'); ?></a>
							             	   		</li>
							             	   		<?php foreach($model_details as $model){ ?>   
				                                    <li value="<?php echo $model['model_id']; ?>">                              
				                                     <a><?php echo ucfirst($model['model_name']); ?></a>
				                                    </li>
				                                    <?php } ?>
					                            </ul>
							             	</div>
							            </div>
							              
							            <div class="status_type status_job_list">
			                                  <a id="status_type" href="#" title="All" class="filterStatus active" data-val="0,6,7,4,8,10,9,3,2,1,5,8"><?php echo __('allstatus'); ?></a>

												<div class="schedule_list status_list">
												   <ul id="vehicle_status_list" class="search_job_list">
												   		<li class="status_dropdown_in"  value="0,6,7,4,8,10,9,3,2,1,5,8" li-val='0,6,7,4,8,10,9,3,2,1,5,8'>
					                                        <a name="status_color" value="0,6,7,4,8,10,9,3,2,1,5,8"  >
					                                        <?php echo __('all'); ?></a>
					                                    </li>
<?php if(defined('SCHEDULE_TRIP_NOTIFICATION') && 
								(string)SCHEDULE_TRIP_NOTIFICATION==='1'){ ?>					                                    
<li class="status_dropdown_in"  value="100" li-val='100'>
		<a name="status_color" id="status100"  value="100"  >
		<?php echo __('scheduled_trips'); ?></a>
</li>					                                    
<?php  } ?>
<li class="status_dropdown_in"  value="0" li-val='0'>
					                                        <a name="status_color" id="status0"  value="0"  >
					                                        <?php echo __('assign'); ?></a>
</li>
					                                   <!-- Value 6 is removed from this li because it shows trip cancelled by driver -->
					                                  <li class="status_dropdown_in" value="7,10" li-val='7,10'>
					                                        <a name="status_color" id="status6710"  value="7,10"   ><?php echo __('reassign'); ?></a>
					                                  </li>
					                                  <li class="status_dropdown_in" value="9,A" li-val='9,A'>
					                                        <a name="status_color" id="status9"  value="9,A" ><?php echo __('confirmed'); ?></a>
					                                  </li>
					                                  <li class="status_dropdown_in" value="3" li-val='3'>
					                                        <a name="status_color" id="status3"  value="3" ><?php echo __('start_to_pickup'); ?></a>
					                                  </li>
					                                  <li class="status_dropdown_in" value="2" li-val='2'>
					                                        <a name="status_color" id="status2"  value="2" >
					                                        <?php echo __('inprogress'); ?></a>
					                                  </li>
					                                  <li class="status_dropdown_in" value="1" li-val='1'>
					                                        <a name="status_color" id="status1"  value="1" >
					                                       <?php echo __('completed'); ?></a>
					                                  </li>
					                                  <li class="status_dropdown_in" value="5" li-val='5'>
					                                        <a name="status_color" id="status5"  value="5" >
					                                        <?php echo __('waiting_payment'); ?></a>
					                                  </li>
					                                  <li class="status_dropdown_in" value="4,6,8,9" li-val='4,6,8,9'>
					                                     <input type="hidden" name="status_color_cancel" id="status_color_cancel" value="4,6,8,9">
					                                        <a name="status_cancel" id="status_cancel" value="4,6,8,9"  >
					                                        <?php echo __('trip_cancelled'); ?></a>
					                                  </li>
					                                  <!-- <li class="status_dropdown_in" value="C,R" li-val='C,R'>
					                                     <input type="hidden" name="status_color_cancel" id="status_color_cancel" value="8">
					                                        <a name="status_cancel" id="status_cancel" value="C,R"  >
					                                        <?php echo __('trip_cancelled'); ?></a>
					                                  </li> -->					                                  
					                                </ul>
							               		 	
							             	</div>
							            </div>
							            <div class="pagination_filter">
			                                <select id="filterLimit" onChange="return all_booking_manage_list_new_design();">
			                                	<option selected="selected">25</option>
			                                	<option>50</option>
			                                	<option>75</option>
			                                	<option>100</option>
			                                </select>
							            </div>
						            </div>
						        </div>
								<input type="reset" name="" value="<?php echo __('reset');?>" class="reset_btn" title="Reset">
							</div>
							<div class="job_listing_container" >
								<ul>
									
								</ul>
							</div>		
							<div class="add_job_container" >
								<form id="defaultForm" method="post" class="form-horizontal" action="<?php echo URL_BASE; ?>taxidispatch/dashboard_beta" enctype="multipart/form-data" -onSubmit="validateAddJob()">
						<div class="option_block">
							
							<h4><?php echo __('passengers_information'); ?></h4>
						    <!-- <ul class="nav nav-tabs" role="tablist">
							    <li role="presentation"  value = "1" class="active presentation" id="Anonymous_presentation_id">
								<label class="style_check c1" role="tab" data-toggle="tab" id="anonymous_id"  class="anonymous_id">
									<input type="radio" class="package_plan active" name="package_plan" value="1" checked="true">
									<span><?php echo __('anonymous') ?></span>
								</label>
								</li>
								<li role="presentation"   value = "2"  id="Account_sec_presentation_id" class="presentation">
								<label class="style_check c2" aria-controls="account" role="tab" data-toggle="tab" id="account_sec_id" class ="account_sec_id">
									<input type="radio" class="package_plan" name="package_plan" value="1" checked="true">
									<span><?php echo __('account') ?></span>
								</label>
								</li>
							</ul> -->
							<div class="option_search_bar">
								<a href="javascript:;" 
								 class="add_btn add_taxi_arr1 " id="add_add_btn"  title=""><i></i></a>
							</div>
						</div>
						<div class="search passenger_search_blk" style="display:none" id="search_txt_div">
							<div class="passenger_search">
                                <input type="text" name="pass_search_txt" maxlength="55" id="pass_search_txt" value="" title="Search..." class="form_control" placeholder="Search...">
                                 <input type="button" name="submit_search_filter" id="submit_search_filter" class="submit_filter" title="<?php echo __('filter'); ?>" onclick="all_booking_manage_list_new_design()">
								<span id="pass_search_error" class="error" style="display:none;"></span>
                     		</div>
                     	</div>
						<div class="add_job_block">
							
							<div class="form_group mobile_format custom_autocomplete input_details rider_mobile_num">
								<input type="text" class="form-control c_code new_input_style country_code" name="country_code" id="country_code_new"   placeholder="<?php echo TELEPHONECODE;?>" maxlength="5" autocomplete="off" value="<?php echo TELEPHONECODE;?>" readonly=true>
								<div>
									<input type="text"  class="form-control mob_number new_input_style"  name="phone" id="phone_new"  maxlength="15" placeholder="<?php echo __('search_mobile'); ?>" maxlength="15" autocomplete="off">
									<span id="number_condition" class="note_text"><?php echo __('number_condition');?></span>
									<span class="error_field">Required</span>
								</div>
							</div>
					 
							<!-- <h2><?php //echo __('passenger_info') ?></h2> -->
							<div class="form_group custom_autocomplete input_details">
                                <input type="text" class="form-control new_input_style" name="firstname" id="firstname_new" placeholder="<?php echo __('search_by_name'); ?>"  autocomplete="off" maxlength="55" />
	     					<?php if(IS_NAME_MANDATORY != 1){ ?>
                                <span id="name_condition" class="note_text"><?php echo __('name_condition');?></span>
                            <?php } ?>                           
								<!-- <input type="text" name="" class="form-control" placeholder="Name"> -->
								<span class="error_field">Required</span>
                                <input name="passenger_id" id="passenger_id" type="hidden" class="new_input_style">
							</div>
							<div class="form_group input_details">
                                <input type="text" class="form-control new_input_style" name="email" id="email_new" placeholder="<?php echo __('email_id').__('optional_info'); ?>" autocomplete="off" maxlength="85"/>                                 
								<!-- <input type="email" name="" class="form-control" placeholder="Email"> -->
								<span class="error_field">Required</span>
							</div>
							
							
							<h2 class="new_label"><?php echo __('booking_details') ?></h2>
							<div class="form_group input_details">
							    <select name="trip_type" id="trip_type" class="form-control new_input_style" title="<?php echo __('select_trip_type'); ?>" onchange="loadModels(this.value,'add',0)" >
                        			<option value="1" ><?php echo __('normal'); ?></option>
                        			<?php if(RENTAL_AVAILABLE == 1 && $_SESSION['user_type'] != 'CP') { ?>
                        				<option value="2" ><?php echo __('rental'); ?></option>
                					<?php } if(OUTSTATION_AVAILABLE == 1 && $_SESSION['user_type'] != 'CP') { ?>
                    					<option value="3" ><?php echo __('outstation'); ?></option>
                        			<?php } ?>
                    			</select>
                    			<span class="error_field err_valid" id="trip_validation"></span>
							</div>
							<div class="form_group input_details search_icon">
							    <input type="text" class="form-control booking_details new_input_style" id="current_location" name="current_location" autocomplete="off"  placeholder="<?php echo __('enter_currentlocation'); ?>" maxlength="150"/>
								<span class="error_field loc_error"><?php echo __('valid_location'); ?></span>
							</div>
							<div class="form_group input_details search_icon">
							  <input type="text" class="form-control booking_details new_input_style" id="drop_location" name="drop_location" autocomplete="off" placeholder="<?php echo __('enter_droplocation'); ?>" maxlength="150" />
								<!-- <input type="text" name="" class="form-control" placeholder="Drop off location"> -->
								<span class="error_field">Required</span>
							<!--                                   <input type="hidden" value="" class="form-control" id="notes" maxlength="128" name="notes" autocomplete="off"/>-->
							</div>
							<?php if(!empty(SHOW_NOTES) && SHOW_NOTES == 1){ ?>

	 							<div class="form_group ">
								    <input type="text" value="" class="form-control " id="notes" maxlength="128"   name="notes" autocomplete="off" placeholder="<?php echo __('notes'); ?>" maxlength="150"/>
								</div>
 							<?php } else{ ?>
	 							<div class="form_group">
								    <input type="hidden" value="" class="form-control" id="notes" maxlength="128" name="notes" autocomplete="off" />
								</div>
 							<?php } ?>

							
							<div class="form_group input_details search_icon calendar_icon">
								<input type="text"  name="pickup_date" onmouseover="return setPickerCurrentDate(event,this,0)" onmouseleave="return setPickerCurrentDate(event,this,1)" id="pickup_date" autocomplete="off" placeholder="<?php echo __('pickup_time'); ?>" class="form-control  new_input_style" >
								<span class="error_field error" id="timeError">Required</span>			
							</div>

							<div class="form_group col-lg-12 select_box" id="round_one_way_select" style="display: none">
								<select name="os_trip_type" id="os_trip_type" class="form-control booking_details" title="<?php echo __('select_the_taximodel'); ?>" onchange="//loadpackages_model(this.value,'add',0)">
                                    <option value=""><?php echo __('select_os_type'); ?></option>
                                    <option value="1"><?php echo __('one_way'); ?></option>
                                <?php
								if(defined('OUTSTATION_ROUND_TRIP') && 
									(string)OUTSTATION_ROUND_TRIP==='1')
								{
								?>
                                 <option value="2"><?php echo __('round_trip'); ?></option>
                                <?php
								}
								?>
                            	</select>
							</div>

							<div class="form_group col-lg-12 select_box days_count"  style="display: none;">
							  	<span><?php echo __('os_days_count'); ?></span><select name="os_day_count" id="os_days_count" class="form-control" title="<?php echo __('no_of_days'); ?>">
                                	<?php for($i=0; $i <= 15; $i++) { ?>
                                		<option value="<?php echo $i;?>" ><?php echo $i;?></option>
                                	<?php } ?>
                    			</select><span><?php echo __('os_days'); ?></span>
							</div>

							<div class="form_group col-lg-12 select_box days_count_desc" style="display: none;">
							  	<span id="tripDescription"></span>
						  	</div>

							<!-- OnChange="change_minfare(this.value,'');" -->
							<div class="form_group col-lg-12 select_box input_details">
                                <?php $field_type = $aval_models = ''; if(isset($postvalue) && array_key_exists('taxi_model',$postvalue)){ $field_type =  $postvalue['taxi_model']; } ?>
                                <select name="taxi_model" id="taxi_model" class="form-control booking_details new_input_style" title="<?php echo __('select_the_taximodel'); ?>" onchange="loadpackages_model(this.value,'add',0)">
                                        <option value=""><?php echo __('select_vehicle_label'); ?></option>
                                        <?php 
                                        foreach($model_details as $list) { ?>
                                        <option value="<?php echo $list['model_id']; $aval_models.=$list['model_id'].'-'; ?>" <?php if($field_type == $list['model_id']) { echo 'selected=selected'; } ?>><?php echo ucfirst($list['model_name']); ?></option>
                                        <?php } ?>
                                </select>
                                <input type="hidden" name="aval_models" id="aval_models" value="<?php echo trim($aval_models,"-"); ?>">
							</div>
							<!--  fleet model select   -->
							<div class="fleet_details">
                                                <h6 class="new_label">Select the models</h6>
                                                <section class="center_slider slider">
                                                	<!-- <?php foreach($model_details as $list) { ?>
                                                	<div>
                                                       <div class="fleet_models">
                                                           <p><?php echo ucfirst($list['model_name']); ?></p>

                                                           <span class="d-flex justify-content-center"><img src="<?php echo URL_BASE ?>public/taxi10demo/model_image/thumb_<?php echo $list['_id']; ?>.png" alt="tmobility"></span>
                                                       </div>
                                                    </div>

                                                	<?php } ?> -->
                                                  <div>
                                                       <div class="fleet_models active">
                                                           <p>Taxi</p>
                                                           <span class="d-flex justify-content-center fleet_image"><img src="<?php echo URL_BASE ?>public/admin/images/taxi.png" alt="tmobility"></span>
                                                       </div>
                                                    </div>
                                                    <div>
                                                        <div class="fleet_models">
                                                            <p>Lux</p>
                                                            <span class="d-flex justify-content-center fleet_image"><img src="<?php echo URL_BASE ?>public/admin/images/lux.png" alt="tmobility"></span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fleet_models">
                                                            <p>Limo</p>
                                                            <span class="d-flex justify-content-center fleet_image"><img src="<?php echo URL_BASE ?>public/admin/images/limo.png" alt="tmobility"></span>
                                                        </div>
                                                    </div>         
                                                  </section>
											</div>
							<!--  fleet model select   -->
                     <?php if(isset($babyseater_details) && defined("BABY_SEATER") && BABY_SEATER ==1)

                            	{ ?>
                            <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                            	
                                <span id="babyseater1"><?php echo $babyseater_details[0]['babyseater_name'];?> </span>
                                <input type="hidden" name="babyseater1" value="<?php echo $babyseater_details[0]['babyseater_name'];?>"/>
                                </div>
                               <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                                <?php $field_type1 = $aval_models3 = ''; if(isset($postvalue) && array_key_exists('baby_seatercount1',$postvalue)){ $field_type1 =  $postvalue['baby_seatercount1']; } ?>
                                <select name="baby_seatercount1" id="baby_seatercount1" class="form-control booking_details" title="<?php echo __('select'); ?>" onchange='loadpackages_model(document.getElementById("taxi_model").value,"add",0)'>
                                        <option value="0">0</option>
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                </select>
                                <input type="hidden" name="aval_models3" id="aval_models3" value="<?php echo trim($aval_models3,"-"); ?>">
                            </div>

                             <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                            	
                                <span id="babyseater2"><?php echo $babyseater_details[1]['babyseater_name'];?> </span>
                                <input type="hidden" name="babyseater2" value="<?php echo $babyseater_details[1]['babyseater_name'];?>"/>
                                </div>
                               <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                                <?php $field_type2 = $aval_models4 = ''; if(isset($postvalue) && array_key_exists('baby_seatercount2',$postvalue)){ $field_type2 =  $postvalue['baby_seatercount2']; } ?>
                                <select name="baby_seatercount2" id="baby_seatercount2" class="form-control booking_details" title="<?php echo __('select'); ?>" onchange='loadpackages_model(document.getElementById("taxi_model").value,"add",0)' >
                                        <option value="0">0</option>
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                </select>
                                <input type="hidden" name="aval_models4" id="aval_models4" value="<?php echo trim($aval_models4,"-"); ?>">
                            </div>
                             <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                            	
                                <span id="babyseater3"><?php echo $babyseater_details[2]['babyseater_name'];?> </span>
                                <input type="hidden" name="babyseater3" value="<?php echo $babyseater_details[2]['babyseater_name'];?>"/>
                                </div>
                               <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                                <?php $field_type3 = $aval_models5 = ''; if(isset($postvalue) && array_key_exists('baby_seatercount3',$postvalue)){ $field_type3 =  $postvalue['baby_seatercount3']; } ?>
                                <select name="baby_seatercount3" id="baby_seatercount3" class="form-control booking_details" title="<?php echo __('select'); ?>" onchange='loadpackages_model(document.getElementById("taxi_model").value,"add",0)' >
                                        <option value="0">0</option>
                                       <option value="1">1</option>
                                       <option value="2">2</option>
                                       <option value="3">3</option>
                                </select>
                                <input type="hidden" name="aval_models5" id="aval_models5" value="<?php echo trim($aval_models5,"-"); ?>">
                            </div>
                            
								<?php } ?>
				<?php if(isset($submodel_details))
                            	{ ?>
                            <div class="form_group col-lg-12 select_box taxi-sub-model" style="display:none;">
                            	
                                <?php $field_type1 = $aval_models1 = ''; if(isset($postvalue) && array_key_exists('taxi_submodel',$postvalue)){ $field_type1 =  $postvalue['taxi_submodel']; } ?>
                                <select name="taxi_submodel" id="taxi_submodel" class="form-control booking_details" title="<?php echo __('select'); ?>" >
                                        <option value=""><?php echo __('select_vehicle_label'); ?></option>
                                        <?php 
                                        foreach($submodel_details as $list) { ?>
                                        <option value="<?php echo $list['submodel_id'].'.'.$list['submodel_name']; $aval_models1.=$list['submodel_id'].'-'; ?>" <?php if($field_type == $list['submodel_id']) { echo 'selected=selected'; } ?>><?php echo ucfirst($list['submodel_name']); ?></option>
                                        <?php } ?>
                                </select>
                                <input type="hidden" name="aval_models1" id="aval_models1" value="<?php echo trim($aval_models1,"-"); ?>">
                            </div>
                            <div class="form_group fixed_fare" style="display:none;">

									<input type="text" class="form-control" id="fixedfare1" name="fixedfare1" maxlength="6" autocomplete="off" placeholder="<?php echo __('fixedfare'); ?>"/>
	                            	<label for="fixedfare" class="error" id="fixedfare_error"></label>
								</div>
								<?php } ?>

							<div class="form_group trip-packages-div" style="display: none;">
							  	<select name="trip_packages" id="trip_packages" class="form-control" title="<?php echo __('select_the_package'); ?>" onchange="loadPackageDetail(this.value,'add');//loadPackageFleets(this.value, 'add', 0)">
                            		<option value=""><?php echo __('select_the_package'); ?></option>
                    			</select>
                    			<input type="hidden" name="package_base_fare" id="package_base_fare" value="" />
								<input type="hidden" name="package_distance" id="package_distance" value="" />
								<input type="hidden" name="package_plan_duration" id="package_plan_duration" value="" />
								<input type="hidden" name="package_addl_hour_fare" id="package_addl_hour_fare" value="" />
								<input type="hidden" name="package_addl_distance_fare" id="package_addl_distance_fare" value="" />
								<span class="error" id="tripPackagesError"></span>
							</div>

							
							<input type="hidden" name="show_time_secs" id="show_time_secs" value="">
							
							<div class="form_group input_details">
								<!--<input type="text" name="" class="form-control" placeholder="Promo code">
								<span class="error_field">Required</span> -->
								<input type="text" class="form-control booking_details new_input_style" id="promocode" name="promocode" autocomplete="off" placeholder="<?php echo __('promocode'); ?>" maxlength="10" onblur="$('#firstname_new').focus();" />
                            	<span class="error" id="promocodeError"></span>
							</div>
						<a href="javascript:;" class="nearest_driver_dropdown"><?php echo __('nearest_driver') ?><span id="nearest_driver_count"></span> <i>
		        		<span><?php echo __('eta') ?></span></i></a>
	        			<ul class="driver_listing active">
	        				<li><?php echo __('no_driver_found');?></li>
						</ul>
						<!-- new nearest_driver  -->
						<div class="nearest_driver_new input_details">
							<h6 class="new_label">Nearest Driver</h6> 
								<ul class="nearest_driver_content">
									<li class="nearest_driver_list">
										<p class="dri_info"><span>Austin</span><span>LIMO</span></p>
										<p>+148 447 32402</p> 
									</li> 
									<li class="nearest_driver_list">
										<p class="dri_info"><span>Austin</span><span>LIMO</span></p>
										<p>+148 447 32402</p> 
									</li> 
								</ul> 
                        </div>			
						<!-- new nearest_driver  -->
	        			<h2 class="fare_det_blck_title new_label p-0"><?php echo __('fare_estimate') ?></h2>
	        			<div class="fare_det_blck add_normal_fare_calc p-0 fare_details_inner_body">
	        				<div>
								<!-- <span>20 Mins</span> -->
								 <span class="journey_icon"></span>
								<p><?php echo __('journey') ?></p>
								<span id="find_duration"><?php echo __('zero_mins'); ?></span>
	        				</div>
	        				<div>
								<!-- <span>1.5 Miles</span> -->
								<span class="distance_icon"></span>
								<p><?php echo __('distance') ?></p>
								<span id="find_km"><?php echo __('zero_distance'); ?></span>
							</div> 
							<div>
								<span class="tax_icon"></span>
								<p><?php echo __('tax') ?></p>
								<span id="vat_tax"><?php echo $company_tax; ?> %</span>
	        				</div>
	        				<div>
								<!-- <span>$25.00</span> -->
								<span class="approximate_fare_icon"></span>
	        					<p><?php echo __('approx_fare') ?><br></p>
								<p id="tax_inclusive"></p>
	        					<span class=""><?php echo $company_currency; ?> <font id="min_fare"><?php echo '0'; ?></font></span>
							</div> 
						</div>

	        			<ul class="fare_det_blck add_ro_fare_calc" style="display:none;">
                            <li>
                                <span id="ro_find_duration"><?php echo __('base_fare'); ?></span>
                                <small><?php echo __('base_fare'); ?></small>
                            </li>
                            <li>
                                <span id="ro_find_km"><?php echo __('addl_fare_km'); ?></span>
                                <small><?php echo __('addl_fare_km'); ?></small>
                            </li>
                            <li>
                                <span id="ro_find_hr"><?php echo __('addl_fare_hr'); ?></span>
                                <small><?php echo __('addl_fare_hr'); ?></small>
                            </li>
                            <li>
                                <span id="vat_tax"><?php echo $company_tax; ?> %</span>
                                <small>Tax</small>
                            </li>
                            <li>
                                <span id="ro_approx_fare"></span>
                                <small><?php echo __('approx_fare'); ?></small>
                            </li>
                        </ul>

	        			<div class="estimate_arrival_blk">
	        				<div class="estimate_arrival_blk_inner">
		        				<p>
		        					<small><?php echo __('estimated_driver') ?></small>
		        					<span id="estimated_driver_arrival"></span>
		        				</p>
	        				</div>
	        			</div>

							<?php if(!empty(IS_FIXED_FARE) && IS_FIXED_FARE == 1){ ?>

								<div class="form_group">
									<input type="checkbox" name="fixed_fare_select" id="fixed_fare_select" value="1" <?php if(isset($postvalue) && array_key_exists('fixed_fare_select',$postvalue)){ echo 'checked'; }?>/><?php echo __('Fixed fare'); ?>
								</div>

								<div class="form_group fixedfarerror">

									<input type="text" class="form-control fixedfare" id="fixedfare" name="fixedfare" maxlength="6" autocomplete="off" placeholder="<?php echo __('fixedfare'); ?>"/>
	                            	<label for="fixedfare" class="error" id="fixedfare_error"></label>
								</div>
							 <?php }
	                         else 
	                         { ?>
	                         	<input type="hidden" id="fixedfare" maxlength="6" name="fixedfare" value=""/>
	                     		<input type="hidden" id="fixed_fare_select" maxlength="6" name="fixed_fare_select" value="0"/>
	                         <?php } ?>

							

							<input type="hidden" name="payment_type" value=""/>
                            <input type="hidden" name="fixedprice" value=""/>
                            <input type="hidden" name="pickup_time" value="23"/>
                            <input type="hidden" name="pickup_lat" id="pickup_lat" value="">
                            <input type="hidden" name="pickup_lng" id="pickup_lng" value="">
                            <input type="hidden" name="drop_lat" id="drop_lat" value="">
                            <input type="hidden" name="drop_lng" id="drop_lng" value="">
                            <input type="hidden" name="info" id="info" value="">
                            <input type="hidden" name="model_minfare" id="model_minfare" value="0" >
                            <input type="hidden" name="distance_km" id="distance_km" value="0" >
                            <input type="hidden" name="min_fare1" id="min_fare1" value="" >
                            <input type="hidden" name="distance_unit" id="distance_unit" value="<?php echo UNIT_NAME; ?>" >
                            <input type="hidden" name="total_fare" id="total_fare" value="0" >
                            <input type="hidden" name="total_duration" id="total_duration" value="0" >
                            <input type="hidden" name="total_duration_secs" id="total_duration_secs" value="0" >
                            <input type="hidden" name="city_id" id="city_id" value="" >
                            <input type="hidden" name="cityname" id="cityname" value="" >
                            <input type="hidden" name="payment_sec" id="payment_sec" value="" >
                            <input type="hidden" name="company_tax" id="company_tax" value="<?php echo $company_tax; ?>" >
                            <input type="hidden" name="default_company_unit" id="default_company_unit" value="<?php echo UNIT_NAME; ?>" >
                            <input type="hidden" name="recurrent" value="1"/>
                            <input type="hidden" name="luggage" value=""/>
                            <input type="hidden" name="no_passengers" value=""/>
                            <input type="hidden" name="driver_id" id="driver_id" value=""/>
                            <input type="hidden" name="admin_company_id" id="admin_company_id" value=""/>	
                            <!-- Add booking - Update driver id on driver selection-->
                            <input type="hidden" name="direct_driver" id="direct_driver" value=""/>	
                            <input type="hidden" name="fare_splitup_details" id="fare_splitup_details" value="">
                            <input type="hidden" name="subtotal_fare" id="subtotal_fare" value="" >				
                            <input type="hidden" name="tax_amount" id="tax_amount" value="" >				
                            <input type="hidden" name="trip_err_val" id="trip_err_val" value="" >				
	                     </div>


							<input type="hidden" id="dispatch_id" name="dispatch" value="" />
                            <input type="hidden" id="create_id" name="create" value="" />
                            <input type="hidden" id="taxi_modelid" name="taxi_modelid" value="" />


                         <input type="submit" style="display: none" class="btn-medium" name="create" id="create" value="<?php echo __('create'); ?>" > 

                          <input type="submit" style="display: none" class="button dsptch_btn" name="dispatch" id="dispatch" value="<?php echo __('dispatch'); ?>" >



	        			<!--CR-Mychauffeur-->
	        			<?php if(SHOW_MAP !=1 && defined("NEED_DISPATCHER_ROUTE_MAP") && NEED_DISPATCHER_ROUTE_MAP == 1) { ?>
	        			<div class="estimate_arrival_blk">
						  <label><input type="checkbox"  name="need_route_map" class="need_route_map" value="1"><span style="margin-left: 5px;position: absolute;margin-top: 5px;"><?php echo __('need_route_map'); ?></span></label>
						  
					    </div>
					      

					    <?php }?>
					    <!--CR-Mychauffeur-->
	        			<div class="btn_block fixed_bottom text-center"><!-- 
	        				<button type="button" class="button book_later" title="Book Later">book later</button>
	        				<button type="button" class="button dsptch_btn" title="Dispatch">dispatch</button> -->
	        				<?php if($book_later_hide != 1){ ?>
                            	<button type="button" class="button book_later" onclick = "form_submit(1,'create',event)" name="create" id="create" value="<?php echo __('create'); ?>" ><?php echo __('book_later') ?></button>
                            <?php } ?>
                            <?php if($_SESSION['user_type'] != "CP"){ ?>
                            <button type="button" style="<?php echo $company_restrict_style; ?>" class="button dsptch_btn" name="dispatch" onclick = "form_submit(1,'dispatch',event)" id="dispatch" value="<?php echo __('dispatch'); ?>" ><?php echo __('dispatch'); ?></button>
                            <?php } ?>

	        			</div>

	                     </form>
					</div><!--end add job container-->
					<div class="edit_job_container" >
						<form id="defaultForm_edit" name = "defaultForm_edit" style="display:none" method="post" class="form-horizontal" action="<?php echo URL_BASE; ?>taxidispatch/dashboard_beta" enctype="multipart/form-data" onSubmit="validateEditJob()">
						<input type="hidden" name="edit_corporateID" id="edit_corporateID" value="">
							<div class="option_block">
								<h4><?php echo __('passengers_information'); ?></h4>
							    <!-- <ul class="nav nav-tabs" role="tablist">
								    <li role="presentation"  class="presentation" id="Anonymous_presentation_id">
									<label class="style_check c1" role="tab" data-toggle="tab" id="anonymous_id" class="anonymous_id">
										<input type="radio" class="package_plan " name="package_plan" value="1" checked="true">
										<span><?php echo __('anonymous') ?></span>
									</label>
									</li>
									<li role="presentation"  id="Account_sec_presentation_id active" class="presentation">
									<label class="style_check c2" aria-controls="account" role="tab" data-toggle="tab" id="account_sec_id" class="account_sec_id">
										<input type="radio" class="package_plan active" name="package_plan" value="1" checked="true">
										<span><?php echo __('account') ?></span>
									</label>
									</li>
								</ul> -->
								<div class="option_search_bar">
									<a href="javascript:;" class="add_btn add_taxi_arr1 " id="edit_add_btn" title=""><i></i></a>
								</div>
							</div>
							<div class="search" style="display:none" id="search_txt_div">
                                    <input type="text" name="pass_search_txt" maxlength="55" id="pass_search_txt" value="" title="Search..." class="form_control" placeholder="Search...">
                           		    <input type="button" name="submit_search_filter" id="submit_search_filter" class="submit_filter" title="<?php echo __('filter'); ?>" onclick="all_booking_manage_list_new_design()">
									<span id="pass_search_error" class="error" style="display:none;"></span>
                            </div>
							<div class="add_job_block">
								<h2><?php //echo __('passenger_info') ?></h2>
								<div class="form-group input_details">                                    
                                    <input type="text" class="form-control new_input_style " name="edit_firstname" id="edit_firstname" placeholder="<?php echo __('name_label'); ?>" readonly="readonly"  autocomplete="off" maxlength="55" />                              
                                </div>
                                <input name="edit_passenger_id" id="edit_passenger_id" type="hidden" > 

								 <div class="form-group input_details">                                                            
                                    <input type="text" class="form-control new_input_style" name="edit_email" id="edit_email" placeholder="<?php echo __('email_id'); ?>" readonly="readonly" autocomplete="off" maxlength="85"/>                                 
                                </div>
								 
								<div class="form_group mobile_format input_details rider_mobile_num">
									<input type="text" readonly="readonly" class="form-control c_code new_input_style country_code" name="edit_country_code" id="edit_country_code"   placeholder="91<?php //echo TELEPHONECODE;?>" maxlength="4" autocomplete="off">
									<div style="width:100%">
										<input type="text"  class="form-control mob_number new_input_style"  name="edit_phone" id="edit_phone"  readonly="readonly" maxlength="15" placeholder="<?php echo __('mobile'); ?>" maxlength="15" autocomplete="off">
										<span class="error_field">Required</span>
									</div>
								</div>
								<h2 class="new_label"><?php echo __('edit_booking_details')?></h2>
								<div class="form_group input_details">
								    <select name="edit_trip_type_dis" id="edit_trip_type_dis" class="form-control new_input_style" title="<?php echo __('select_trip_type'); ?>" disabled="disabled" onchange="loadModels(this.value, 'edit', 0)">
                            			<option value="1" ><?php echo __('normal'); ?></option>
                            			<?php if(RENTAL_AVAILABLE == 1) { ?>
                            				<option value="2" ><?php echo __('rental'); ?></option>
                    					<?php } if(OUTSTATION_AVAILABLE == 1) { ?>
                        					<option value="3" ><?php echo __('outstation'); ?></option>
                            			<?php } ?>
                        			</select>
                        			<span class="error_field err_valid" id="edit_trip_validation"></span>
                        			<input type="hidden" name="edit_trip_type" id="edit_trip_type" class="form-control" value="">
									<span class="error_field">Required</span>
								</div>
								<div class="form_group input_details search_icon">
								     <input type="text" class="form-control edit_booking_details new_input_style" id="edit_current_location" name="edit_current_location" autocomplete="off"  placeholder="<?php echo __('enter_currentlocation'); ?>" maxlength="150"/>

									<span class="error_field">Required</span>
								</div>
								<div class="form_group input_details search_icon">
									<input type="text" class="form-control edit_booking_details new_input_style" id="edit_drop_location" name="edit_drop_location" autocomplete="off" placeholder="<?php echo __('enter_droplocation'); ?>" maxlength="150" />
									<span class="error_field">Required</span>
									<!-- <input type="hidden" value="" class="form-control" id="edit_notes" maxlength="128" name="edit_notes" autocomplete="off"/> -->							
								</div>
								<?php if(!empty(SHOW_NOTES) && SHOW_NOTES == 1){ ?>

		 							<div class="form_group">
									    <input type="text" value="" class="form-control" id="edit_notes" maxlength="128" name="edit_notes" autocomplete="off" placeholder="<?php echo __('notes'); ?>" maxlength="150"/>
									</div>
								<?php } else{ ?>
		 							<div class="form_group">
									    <input type="hidden" value="" class="form-control" id="edit_notes" maxlength="128" name="edit_notes" autocomplete="off" />
									</div>
								<?php } ?>

								<div class="form_group input_details calendar_icon">
                                    <input  type="hidden"  name="edit_pickup_date_db" id="edit_pickup_date_db" autocomplete="off" placeholder="<?php echo __('pickup_time'); ?>">

										<input type="text" readonly name="edit_pickup_date" id="edit_pickup_date" autocomplete="off" placeholder="<?php echo __('pickup_time'); ?>" class="form-control date_icon new_input_style" >
										<span class="error_field error" id="timeError_edit">Required</span>
									</div>

								<div class="form_group col-lg-12 select_box" id="edit_round_one_way_select" style="display: none">
									<select style="padding:0;" name="edit_os_trip_type" id="edit_os_trip_type" class="form-control booking_details" title="<?php echo __('select_the_taximodel'); ?>" onchange="//loadpackages_model(this.value,'add',0)">
	                                    <option value=""><?php echo __('select_os_type'); ?></option>
	                                    <option value="1"><?php echo __('one_way'); ?></option>
	                             <?php
								if(defined('OUTSTATION_ROUND_TRIP') && 
									(string)OUTSTATION_ROUND_TRIP==='1')
								{
								?>
	                                    <option value="2"><?php echo __('round_trip'); ?></option>
	                            <?php
								}
								?>
	                            	</select>
								</div>

								<div class="form_group col-lg-12 select_box edit_days_count"  style="display: none;">
								  	<span><?php echo __('os_days_count'); ?></span><select name="edit_os_day_count" id="edit_os_day_count" class="form-control" title="<?php echo __('no_of_days'); ?>">
	                                	<?php for($i=0; $i <= 15; $i++) { ?>
	                                		<option value="<?php echo $i;?>" ><?php echo $i;?></option>
	                                	<?php } ?>
	                    			</select><span><?php echo __('os_days'); ?></span>
								</div>

								<div class="form_group col-lg-12 select_box edit_days_count_desc" style="display: none;">
								  	<span id="edit_tripDescription"></span>
							  	</div>

								<div class="form_group input_details">
									<input type="hidden" id="dispatch_id" name="edit_dispatch" value="" />
                                    <input type="hidden" id="create_id" name="edit_create" value="" />
									
									<div class="col-lg-12 select_box ">
									  	<?php $field_type =''; if(isset($postvalue) && array_key_exists('taxi_model',$postvalue)){ $field_type =  $postvalue['taxi_model']; } ?>
                                        <select style="padding:0;" name="edit_taxi_model" id="edit_taxi_model" class="form-control new_input_style" title="<?php echo __('select_the_taximodel'); ?>" OnChange="loadpackages_model(this.value,'edit',0);">
                                            <option value=""><?php echo __('select_vehicle_label'); ?></option>
                                                <?php 
                                            foreach($model_details as $list) {

											            $enable_rental=1;
											            $enable_outstation=1;
											            $enable_local=1;
											            if(isset($list['enable_rental']) && (int)$list['enable_rental']===0)
											            {
											                $enable_rental=0;
											            }
											            if(isset($list['enable_outstation']) && (int)$list['enable_outstation']===0)
											            {
											                $enable_outstation=0;
											            }
											            if(isset($list['enable_local']) && (int)$list['enable_local']===0)
											            {
											                $enable_local=0;
											            }

                                             ?>
                                                <option  enable_rental='<?php echo $enable_rental; ?>'  enable_outstation='<?php echo $enable_outstation; ?>' enable_local='<?php echo $enable_local; ?>' value="<?php echo $list['model_id']; ?>" <?php if($field_type == $list['model_id']) { echo 'selected=selected'; } ?>><?php echo ucfirst($list['model_name']); ?>
                                                </option>
                                                <?php } ?>
                                        </select>
                                	</div>
								</div>
								<!--  fleet model select   -->
							<div class="fleet_details">
                                                <h6 class="new_label">Select the models</h6>
                                                <section class="center_slider slider">
                                                	<!-- <?php foreach($model_details as $list) { ?>
                                                	<div>
                                                       <div class="fleet_models">
                                                           <p><?php echo ucfirst($list['model_name']); ?></p>

                                                           <span class="d-flex justify-content-center"><img src="<?php echo URL_BASE ?>public/taxi10demo/model_image/thumb_<?php echo $list['_id']; ?>.png" alt="tmobility"></span>
                                                       </div>
                                                    </div>

                                                	<?php } ?> -->
                                                  <div>
                                                       <div class="fleet_models active">
                                                           <p>Taxi</p>
                                                           <span class="d-flex justify-content-center fleet_image"><img src="<?php echo URL_BASE ?>public/admin/images/taxi.png" alt="tmobility"></span>
                                                       </div>
                                                    </div>
                                                    <div>
                                                        <div class="fleet_models">
                                                            <p>Lux</p>
                                                            <span class="d-flex justify-content-center fleet_image"><img src="<?php echo URL_BASE ?>public/admin/images/lux.png" alt="tmobility"></span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fleet_models">
                                                            <p>Limo</p>
                                                            <span class="d-flex justify-content-center fleet_image"><img src="<?php echo URL_BASE ?>public/admin/images/limo.png" alt="tmobility"></span>
                                                        </div>
                                                    </div>         
                                                  </section>
											</div>
							<!--  fleet model select   -->
								<?php 
								if(isset($babyseater_details) && defined("BABY_SEATER") && BABY_SEATER ==1){ ?>
							 <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                            	
                                <span id="edit_babyseater1"><?php echo $babyseater_details[0]['babyseater_name'];?> </span>
                                <input type="hidden" name="edit_babyseater1" value="<?php echo $babyseater_details[0]['babyseater_name'];?>"/>
                                </div>
                            <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">

                                <?php $field_type1 =''; if(isset($postvalue) && array_key_exists('edit_baby_seatercount1',$postvalue)){ $field_type1 =  $postvalue['edit_baby_seatercount1']; } ?>
                                <select name="edit_baby_seatercount1" id="edit_baby_seatercount1" class="form-control booking_details" title="<?php echo __('select'); ?>" onchange='loadpackages_model(document.getElementById("edit_taxi_model").value,"edit",0)' >
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                </select>
                                
                            </div>
                             <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                            	
                                <span id="edit_babyseater2"><?php echo $babyseater_details[1]['babyseater_name'];?> </span>
                                <input type="hidden" name="edit_babyseater2" value="<?php echo $babyseater_details[1]['babyseater_name'];?>"/>
                                </div>
                            <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">

                                <?php $field_type1 =''; if(isset($postvalue) && array_key_exists('edit_baby_seatercount2',$postvalue)){ $field_type1 =  $postvalue['edit_baby_seatercount2']; } ?>
                                <select name="edit_baby_seatercount2" id="edit_baby_seatercount2" class="form-control booking_details" title="<?php echo __('select'); ?>" onchange='loadpackages_model(document.getElementById("edit_taxi_model").value,"edit",0)' >
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                </select>
                                
                            </div>
                             <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">
                            	
                                <span id="edit_babyseater3"><?php echo $babyseater_details[2]['babyseater_name'];?> </span>
                                <input type="hidden" name="edit_babyseater3" value="<?php echo $babyseater_details[2]['babyseater_name'];?>"/>
                                </div>
                            <div class="form_group col-lg-12 select_box taxi-baby-seater" style="display:none;">

                                <?php $field_type1 =''; if(isset($postvalue) && array_key_exists('edit_baby_seatercount3',$postvalue)){ $field_type1 =  $postvalue['edit_baby_seatercount3']; } ?>
                                <select name="edit_baby_seatercount3" id="edit_baby_seatercount3" class="form-control booking_details" title="<?php echo __('select'); ?>" onchange='loadpackages_model(document.getElementById("edit_taxi_model").value,"edit",0)' >
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                </select>
                                
                            </div>
                            
								<?php } ?>
									<?php if(isset($submodel_details)) { ?>
								<div class="form_group col-lg-12 select_box taxi-sub-model" style="display:none;">

                                <?php $field_type1 =''; if(isset($postvalue) && array_key_exists('taxi_submodel',$postvalue)){ $field_type1 =  $postvalue['taxi_submodel']; } ?>
                                <select name="edit_taxi_submodel" id="edit_taxi_submodel" class="form-control booking_details" title="<?php echo __('select'); ?>" >
                                        <option value=""><?php echo __('select_vehicle_label'); ?></option>
                                        <?php 
                                        foreach($submodel_details as $list) { ?>
                                        <option value="<?php echo $list['submodel_id'].'.'.$list['submodel_name']; ?>" <?php if($field_type1 == $list['submodel_id']) { echo 'selected=selected'; } ?>><?php echo ucfirst($list['submodel_name']); ?></option>
                                        <?php } ?>
                                </select>
                                
                            </div>
                            <div class="form_group fixed_fare" style="display:none;">

									<input type="text" class="form-control" id="edit_fixedfare1" name="edit_fixedfare1" maxlength="6" autocomplete="off" placeholder="<?php echo __('fixedfare'); ?>" value=""/>
	                            	
								</div>
								<?php } ?>

								<div class="form_group edit-trip-packages-div">
                                    <select name="edit_trip_packages" id="edit_trip_packages" class="form-control" title="<?php echo __('select_the_package'); ?>" onchange="loadPackageDetail(this.value, 'edit')//loadPackageFleets(this.value, 'edit', 0)">
                            			<option value=""><?php echo __('select_the_package'); ?></option>
                        			</select>
                        			<input type="hidden" name="edit_plan_duration" id="edit_plan_duration">
                        			<input type="hidden" name="edit_package_base_fare" id="edit_package_base_fare" value="" />
									<input type="hidden" name="edit_package_distance" id="edit_package_distance" value="" />
									<input type="hidden" name="edit_package_plan_duration" id="edit_package_plan_duration" value="" />
									<input type="hidden" name="edit_package_addl_hour_fare" id="edit_package_addl_hour_fare" value="" />
									<input type="hidden" name="edit_package_addl_distance_fare" id="edit_package_addl_distance_fare" value="" />
									<span class="error" id="edittripPackagesError"></span>
								</div>

								<input type="hidden" name="edit_show_time_secs" id="edit_show_time_secs" value="">
								
								<div class="form_group input_details">
									 <input type="text" class="form-control new_input_style" id="edit_promocode" name="edit_promocode" autocomplete="off" placeholder="<?php echo __('promocode'); ?>" onblur="$('#edit_trip_type').focus();" maxlength="10" />
                                	<span id="editPromocodeError" class="error"></span>
								</div>
								<a href="javascript:;" class="nearest_driver_dropdown"><?php echo __('nearest_driver') ?><i>
		        		<span id="edit_nearest_driver_count"></span></i></a>

	        			<ul class="driver_listing active">
						</ul>
						<!-- new nearest_driver  -->
						<div class="nearest_driver_new input_details">
							<h6 class="new_label">Nearest Driver</h6> 
								<ul class="nearest_driver_content">
									<li class="nearest_driver_list">
										<p class="dri_info"><span>Austin</span><span>LIMO</span></p>
										<p>+148 447 32402</p> 
									</li> 
									<li class="nearest_driver_list">
										<p class="dri_info"><span>Austin</span><span>LIMO</span></p>
										<p>+148 447 32402</p> 
									</li> 
								</ul> 
                        </div>			
						<!-- new nearest_driver  -->
						<!-- <h2 class="fare_det_blck_title new_label p-0"><?php echo __('fare_estimate') ?></h2>
	        			<div class="fare_det_blck add_normal_fare_calc p-0 fare_details_inner_body">
	        				<div>
							 
								 <span class="journey_icon"></span>
								<p><?php echo __('journey') ?></p>
								<span id="edit_find_duration"><?php echo __('zero_mins'); ?></span>
	        				</div>
	        				<div>
								 
								<span class="distance_icon"></span>
								<p><?php echo __('distance') ?></p>
								<span id="edit_find_km"><?php echo __('zero_distance'); ?></span>
							</div> 
							<div>
								<span class="tax_icon"></span>
								<p><?php echo __('tax') ?></p>
								<span id="edit_vat_tax"><?php echo $company_tax; ?> %</span>
	        				</div>
	        				<div>
							 
								<span class="approximate_fare_icon"></span>
	        					<p><?php echo __('approx_fare') ?><br></p>
								<p id="tax_inclusive"></p>
	        					<span class=""><?php echo $company_currency; ?> <font id="min_fare"><?php echo '0'; ?></font></span>
							</div> 
						</div> -->
	        			<h2 class="fare_det_blck_title new_label p-0"><?php echo __('fare_estimate') ?></h2>
	        			<div class="fare_det_blck edit_normal_fare_calc p-0 fare_details_inner_body mb-60px">
	        				<div>
								<!-- <span>20 Mins</span> -->
								<span class="journey_icon"></span>
								<p><?php echo __('journey') ?></p>
								<span id="edit_find_duration"><?php echo __('zero_mins'); ?></span>
	        				</div>
	        				<div>
								<!-- <span>1.5 Miles</span> -->
								<span class="distance_icon"></span>
	        					<p><?php echo __('distance') ?></p>
								<span id="edit_find_km"><?php echo __('zero_distance'); ?></span>
	        				</div>
	        				<div>
								<span class="tax_icon"></span>
								<p><?php echo __('tax') ?></p>
								<span id="edit_vat_tax"><?php echo $company_tax; ?> %</span>
	        				</div>
	        				
                            <div>
								<!-- <span>$25.00</span> -->
								<span class="approximate_fare_icon"></span>
	        					<p><?php echo __('approx_fare') ?></p> 
	        					<span class=""><?php echo $company_currency; ?> <em style="font-style:normal;" id="edit_min_fare"><?php echo '0'; ?></span>
	        				</div>

	        			
						</div>
						<div class="btn_block fixed_bottom text-center ml-15px">
	        					<button type="button" class="button book_later " onclick = "form_submit(2,'update_submit',event)" name="update" id="update_submit" value="<?php echo __('button_update'); ?>" ><?php echo __('button_update'); ?></button>
                            	<button type="button" style="<?php echo $company_restrict_style; ?>" class="button dsptch_btn" name="update_dispatch" onclick = "form_submit(2,'update_dispatch',event)" id="update_dispatch" value="<?php echo __('dispatch'); ?>" ><?php echo __('dispatch'); ?></button>
                            	<input type="hidden" id="update_dispatch_id" name="update_dispatch" value="" />
                            </div>
	        			<ul class="fare_det_blck edit_ro_fare_calc" style="display:none;">
                            <li>
                                <span id="ro_edit_find_duration"><?php echo __('base_fare'); ?></span>
                                <small><?php echo __('base_fare'); ?></small>
                            </li>
                            <li>
                                <span id="ro_edit_find_km"><?php echo __('addl_fare_km'); ?></span>
                                <small><?php echo __('addl_fare_km'); ?></small>
                            </li>
                            <li>
                                <span id="ro_edit_find_hr"><?php echo __('addl_fare_hr'); ?></span>
                                <small><?php echo __('addl_fare_hr'); ?></label>
                            </li>
                            <li>
                                <span id="ro_edit_vat_tax"><?php echo $company_tax; ?> %</span>
                                <small>Tax</small>
                            </li>
                        </ul>

                        
								<?php if(!empty(IS_FIXED_FARE) && IS_FIXED_FARE == 1){ ?>

									<div class="form_group">
									<input type="checkbox" name="edit_fixed_fare_select" id="edit_fixed_fare_select" value="1" <?php if(isset($postvalue) && array_key_exists('edit_fixed_fare_select',$postvalue)){ echo 'checked'; }?>/><?php echo __('Fixed fare'); ?>
									</div>

									<div class="form_group">
										<input type="text" class="form-control edit_fixedfare" id="edit_fixedfare" maxlength="6" name="edit_fixedfare" autocomplete="off" placeholder="<?php echo __('edit_fixedfare'); ?>"/>
		                            	<label for="edit_fixedfare" class="error" id="edit_fixedfareError"></label>
		                            </div>
		                         <?php }
		                         else 
		                         { ?>
		                         	<input type="hidden" id="edit_fixedfare" maxlength="6" name="edit_fixedfare" value=""/>
		                         	<input type="hidden" id="edit_fixed_fare_select" maxlength="6" name="edit_fixed_fare_select" value="0"/>
		                         <?php } ?>
									
								

								<input type="hidden" id="editdrop_placeid" value=""/>
								<input type="hidden" id="editpickup_placeid" value=""/>	
								<input type="hidden" id="current_editdrop_placeid" value=""/>
								<input type="hidden" id="current_editpickup_placeid" value=""/>

								<input type="hidden" name="edit_payment_type" value=""/>
								<input type="hidden" name="edit_fixedprice" value=""/>
								<input type="hidden" name="edit_pickup_time" value=""/>
								<input type="hidden" name="edit_pickup_lat" id="edit_pickup_lat" value="">
								<input type="hidden" name="edit_pickup_lng" id="edit_pickup_lng" value="">
								<input type="hidden" name="edit_drop_lat" id="edit_drop_lat" value="">
								<input type="hidden" name="edit_drop_lng" id="edit_drop_lng" value="">
								<input type="hidden" name="edit_info" id="info" value="">
								<input type="hidden" name="edit_model_minfare" id="edit_model_minfare" value="" >
								<input type="hidden" name="edit_distance_km" id="edit_distance_km" value="" >
								<input type="hidden" name="edit_total_fare" id="edit_total_fare" value="" >
								<input type="hidden" name="edit_total_duration" id="edit_total_duration" value="" >
								<input type="hidden" name="edit_total_duration_secs" id="edit_total_duration_secs" value="" >
								<input type="hidden" name="edit_city_id" id="edit_city_id" value="" >
								<input type="hidden" name="edit_cityname" id="edit_cityname" value="" >
								<input type="hidden" name="edit_payment_sec" id="edit_payment_sec" value="" >
								<input type="hidden" name="edit_company_tax" id="edit_company_tax" value="<?php echo $company_tax; ?>" >
								<input type="hidden" name="edit_default_company_unit" id="edit_default_company_unit" value="<?php echo UNIT_NAME; ?>" >
								<input type="hidden" name="edit_recurrent" value="1"/>
								<input type="hidden" name="edit_luggage" value=""/>
								<input type="hidden" name="edit_no_passengers" value=""/>
								<input type="hidden" name="edit_pass_logid" id="edit_pass_logid" value=""/>
								<input type="hidden" name="edit_admin_company_id" id="edit_admin_company_id" value=""/>
								<input type="hidden" name="edit_distance_unit" id="edit_distance_unit" value="<?php echo UNIT_NAME ?>"/>
									

								</div>
								
	        					<input  type="hidden" class="button book_later" name="update" id="update_submit" value="<?php echo __('button_update'); ?>" >
                            	<input type="hidden" style="<?php echo $company_restrict_style; ?>" class="button dsptch_btn" name="update_dispatch" id="update_dispatch" value="<?php echo __('dispatch'); ?>" >
                            	<input type="hidden" id="update_dispatch_id" name="update_dispatch" value="" />
                            	<input type="hidden" id="update_submit_id" name="update_submit" value="" />
							</div><!--edit job container-->
							
							
							</form>

						</div>
	        		</div>
					<div class="content-2">
						<div class="fleets_block_container"><!--  style="display: none"> -->

				        		<!-- <div class="dt_top_header">
				        			<h2>dispatch</h2>
				        			<a href="javascript" class="slide_close_icon" title="Close"></a>
				        		</div> -->
								<div class="fleet_container">
									<div class="track_filter_blk">
										<span><?php echo __('track_by');?></span>
										<div class="track_type"  style="display: none;">
							             	<a id="track_type" data-id='2'><?php echo __('driver');?></a>
							             	<div class="schedule_list track_list">
							               		<li value="1"><a title="Driver"><?php echo __('fleet');?></a></li>
							             	</div>
							            </div>
									</div>
									<div class="status_filter_block">
										<?php 
										$defaultZero=0;
										?>
									<ul>
									<li class="status_filter_block_li" id="status_filter_all" data-value="all"><a  value="all" href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="" class="status_btn fleet_lists_btn tooltip_ui count_all_point "><?php echo $defaultZero; ?></a></li>

									<li class="status_filter_block_li" data-value="U"><a href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="Not Assigned" class="status_btn fleet_notassigned_btn tooltip_ui count_unassign_point"><?php echo $defaultZero; ?></a></li>
									<li class="status_filter_block_li" data-value="LO"><a href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="Logged Out" class="status_btn fleet_loggedout_btn tooltip_ui count_loggedout_point"><?php echo $defaultZero; ?></a></li>
									<li class="status_filter_block_li" data-value="SO"><a href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="Shift Out" class="status_btn fleet_shiftout_btn tooltip_ui count_shiftout_point"><?php echo $defaultZero; ?></a></li>
									<li class="status_filter_block_li" data-value="I"><a href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="Idle" class="status_btn fleet_idle_btn tooltip_ui count_idle_point"><?php echo $defaultZero; ?></a></li>
									


										<li class="status_filter_block_li" data-value="A"><a  value="A" href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="Active / Busy" class="status_btn fleet_active_btn tooltip_ui count_active_point"><?php echo $defaultZero; ?></a></li>
										<li class="status_filter_block_li" data-value="F"><a href="javascript:;" data-toggle="tooltip" data-placement="bottom" title="Free" class="status_btn fleet_free_btn tooltip_ui count_free_point"><?php echo $defaultZero; ?></a></li>
									</ul>


									</div>
									<div class="fleet_search_bar">
										<div class="form_group">
											<div class="input-group add-on">
											    <input type="text" class="form-control fleet_search" placeholder="Search" name="srch-term" id="srch-term">
											    <div class="input-group-btn">
											       <button  class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search" onClick="return fleet_listing_new_design();"></i></button>
											    </div>
											</div>
											<!-- <input type="text" name="" id="test" class="form-control fleet_search" placeholder="<?php echo __('search_by_name_no');?>"> -->
										</div>
									</div>
									<div class="vehicle_filter_blk">
										<span><?php echo __('vehicle_list');?></span>
																	              

										<div class="vehic_type">
								            <a id="vehicle_type" class="select_taxi_model model_type active " name="select_taxi_model" data-id="0" value="0" ><?php echo __('allvehicle'); ?></a>
							             	<div class="schedule_list fleet_vehicle_list">
							             	   <ul id="fleet_vehicle_model_list">
													<li value="0"><a>All</a></li>						
													<?php foreach($model_details as $model){ ?>   
				                                   <li value="<?php echo $model['model_id']; ?>">                              
				                                   <a><?php echo ucfirst($model['model_name']); ?></a>
				                                    </li>
				                                    <?php } ?>
					                            </ul>
							             	</div>
								        </div>

									</div>
									<div class="fleet_listing">

									</div>
								</div>						   
								<!--dfsfs-->
				        </div>
					</div>
				</div>
			</section>
			<div class="dispatch_det_slidebar" >
				<!-- fleet details slidebar starts -->
				<!-- fleet details slide bar ends -->
			    <!-- job details -->
        		<!-- job details ends here -->	        		
    		</div>
    		 <div class="dispatch_det_slidebar_add" style="display: none;">
					<div class="estimate_container"  style="display: none;">
		        		<div class="dt_top_header">
		        			<h2><?php echo __('location');?></h2>
<!-- 		        			<a href="javascript:;" class="slide_close_icon"  onclick = "close_slidebar('add')" title="Close"></a>
 -->		        		</div>
		        		<a href="javascript:;" class="nearest_driver_dropdown"><?php echo __('nearest_driver') ?><span id="nearest_driver_count"></span> <i>
		        		<span><?php echo __('eta') ?></span></i></a>
	        			<ul class="driver_listing active">
	        				<li><?php echo __('no_driver_found');?></li>
	        			</ul>
	        			<h2 class="fare_det_blck_title"><?php echo __('fare_estimate') ?></h2>
	        			<ul class="fare_det_blck add_normal_fare_calc">
	        				<li>
	        					<!-- <span>20 Mins</span> -->
	        					 <span id="find_duration"><?php echo __('zero_mins'); ?></span>
	        					<small><?php echo __('journey') ?></small>
	        				</li>
	        				<li>
	        					<!-- <span>1.5 Miles</span> -->
	        					<span id="find_km"><?php echo __('zero_distance'); ?></span>
	        					<small><?php echo __('distance') ?></small>
	        				</li>
	        				<li>
	        					<span id="vat_tax"><?php echo $company_tax; ?> %</span>
	        					<small><?php echo __('tax') ?></small>
	        				</li>
	        				<li>
	        					<!-- <span>$25.00</span> -->
	        					<span class=""><?php echo $company_currency; ?> <font id="min_fare"><?php echo '0'; ?></font></span>
	        					<small><?php echo __('approx_fare') ?></small>
	        					<small id="tax_inclusive"></small>
	        				</li>
	        			</ul>

	        			<ul class="fare_det_blck add_ro_fare_calc" style="display:none;">
                            <li>
                                <span id="ro_find_duration"><?php echo __('base_fare'); ?></span>
                                <small><?php echo __('base_fare'); ?></small>
                            </li>
                            <li>
                                <span id="ro_find_km"><?php echo __('addl_fare_km'); ?></span>
                                <small><?php echo __('addl_fare_km'); ?></small>
                            </li>
                            <li>
                                <span id="ro_find_hr"><?php echo __('addl_fare_hr'); ?></span>
                                <small><?php echo __('addl_fare_hr'); ?></small>
                            </li>
                            <li>
                                <span id="vat_tax"><?php echo $company_tax; ?> %</span>
                                <small>Tax</small>
                            </li>
                            <li>
                                <span id="ro_approx_fare"></span>
                                <small><?php echo __('approx_fare'); ?></small>
                            </li>
                        </ul>

	        			<div class="estimate_arrival_blk">
	        				<div class="estimate_arrival_blk_inner">
		        				<p>
		        					<small><?php echo __('estimated_driver') ?></small>
		        					<span id="estimated_driver_arrival"></span>
		        				</p>
	        				</div>
	        			</div>
	        			<!--CR-Mychauffeur-->
	        			<?php if(SHOW_MAP !=1 && defined("NEED_DISPATCHER_ROUTE_MAP") && NEED_DISPATCHER_ROUTE_MAP == 1) { ?>
	        			<div class="estimate_arrival_blk">
						  <label><input type="checkbox"  name="need_route_map" class="need_route_map" value="1"><span style="margin-left: 5px;position: absolute;margin-top: 5px;"><?php echo __('need_route_map'); ?></span></label>
						  
					    </div>
					      

					    <?php }?>
					    <!--CR-Mychauffeur-->
	        			<div class="btn_block fixed_bottom text-center"><!-- 
	        				<button type="button" class="button book_later" title="Book Later">book later</button>
	        				<button type="button" class="button dsptch_btn" title="Dispatch">dispatch</button> -->
	        				<?php if($book_later_hide != 1){ ?>
                            	<button type="button" class="button book_later" onclick = "form_submit(1,'create',event)" name="create" id="create" value="<?php echo __('create'); ?>" ><?php echo __('book_later') ?></button>
                            <?php } ?>
                            <?php if($_SESSION['user_type'] != "CP"){ ?>
                            <button type="button" style="<?php echo $company_restrict_style; ?>" class="button dsptch_btn" name="dispatch" onclick = "form_submit(1,'dispatch',event)" id="dispatch" value="<?php echo __('dispatch'); ?>" ><?php echo __('dispatch'); ?></button>
                            <?php } ?>

	        			</div>
	        		</div><!--estimate container end-->
	        	</div><!--dispatch_det_slidebar end-->

    		<div class="dispatch_det_slidebar_edit" style="display: none;" >
      			<div class="estimate_container" >
	        		<div class="dt_top_header">
		        			<h2><?php echo __('location');?></h2>
<!-- 		        			<a href="javascript:;" class="slide_close_icon" onclick = "close_slidebar('edit')" title="Close"></a>
 -->		        		</div>
		        		<a href="javascript:;" class="nearest_driver_dropdown"><?php echo __('nearest_driver') ?><i>
		        		<span id="edit_nearest_driver_count"></span></i></a>

	        			<ul class="driver_listing active">
	        			</ul>
	        			<h2 class="fare_det_blck_title"><?php echo __('fare_estimate') ?></h2>
	        			<ul class="fare_det_blck edit_normal_fare_calc">
	        				<li>
	        					<!-- <span>20 Mins</span> -->
	        					 <span id="edit_find_duration"><?php echo __('zero_mins'); ?></span>
	        					<small><?php echo __('journey') ?></small>
	        				</li>
	        				<li>
	        					<!-- <span>1.5 Miles</span> -->
	        					<span id="edit_find_km"><?php echo __('zero_distance'); ?></span>
	        					<small><?php echo __('distance') ?></small>
	        				</li>
	        				<li>
	        					<span id="edit_vat_tax"><?php echo $company_tax; ?> %</span>
	        					<small><?php echo __('tax') ?></small>
	        				</li>
	        				
                            <li>
	        					<!-- <span>$25.00</span> -->
	        					<span class=""><?php echo $company_currency; ?> <em style="font-style:normal;" id="edit_min_fare"><?php echo '0'; ?></span>
	        					<small><?php echo __('approx_fare') ?></small>
	        				</li>

	        			
	        			</ul>
	        			<ul class="fare_det_blck edit_ro_fare_calc" style="display:none;">
                            <li>
                                <span id="ro_edit_find_duration"><?php echo __('base_fare'); ?></span>
                                <small><?php echo __('base_fare'); ?></small>
                            </li>
                            <li>
                                <span id="ro_edit_find_km"><?php echo __('addl_fare_km'); ?></span>
                                <small><?php echo __('addl_fare_km'); ?></small>
                            </li>
                            <li>
                                <span id="ro_edit_find_hr"><?php echo __('addl_fare_hr'); ?></span>
                                <small><?php echo __('addl_fare_hr'); ?></label>
                            </li>
                            <li>
                                <span id="ro_edit_vat_tax"><?php echo $company_tax; ?> %</span>
                                <small>Tax</small>
                            </li>
                        </ul>


	        			<div id="map_editbooking" style="display:none;"></div>
                        <div id="map_addbooking" style="display:none;"></div>                                                   

	        			<div class="estimate_arrival_blk">
	        				<div class="estimate_arrival_blk_inner">
		        				<p>
		        					<small><?php echo __('estimated_driver') ?></small>
		        					<span id="edit_estimated_driver_arrival"></span>
		        				</p>
	        				</div>
	        			</div>
	        			<!--CR-Mychauffeur-->
	        			<?php if(SHOW_MAP !=1 && defined("NEED_DISPATCHER_ROUTE_MAP") && NEED_DISPATCHER_ROUTE_MAP == 1) { ?>
	        			<div class="estimate_arrival_blk">
						  <label><input type="checkbox"  name="need_route_map" class="need_route_map" value="1"><span><?php echo __('need_route_map'); ?></span></label>
						  
					    </div>
					      

					    <?php }?>
					    <!--CR-Mychauffeur-->
	        			<div class="btn_block fixed_bottom text-center">
	        				<button type="button" class="button book_later" onclick = "form_submit(2,'update_submit',event)" name="update" id="update_submit" value="<?php echo __('button_update'); ?>" ><?php echo __('button_update'); ?></button>
                            <button type="button" style="<?php echo $company_restrict_style; ?>" class="button dsptch_btn" name="update_dispatch" onclick = "form_submit(2,'update_dispatch',event)" id="update_dispatch" value="<?php echo __('dispatch'); ?>" ><?php echo __('dispatch'); ?></button>
                            <input type="hidden" id="update_dispatch_id" name="update_dispatch" value="" />
                            

	        			</div>
	        		
        		</div>
        		
        	</div>  <!--end of start-->
		</div>
		<input type="hidden" name="ros" id="ros" value="">
		<input type="hidden" name="taxiid" id="taxiid" value="">



		<!---  Table List -->
<?php

	if((int)$ENABLE_SHOW_MAP_WITH_ALL_DRIVERS===1)
	{
?>
<style>
.dispatcher_table table {font-family: arial, sans-serif;border-collapse: collapse;
  width: calc(100vw - 442px);}
.dispatcher_table  table td,.dispatcher_table table th {border: 1px solid #dddddd;
  text-align: left;padding: 8px;}
.dispatcher_table table tr:nth-child(even) {background-color: #dddddd;}
.dispatcher_table table tbody {display:block;height:calc(100vh - 80px);overflow:auto;
}
.dispatcher_table table thead,.dispatcher_table table tbody tr {display:table;
    width:100%;table-layout:fixed;}
.dispatcher_table table thead {width: calc( 100% - 1em )}
.numberCircle { width: 30px;line-height: 15px;text-align: center;
    font-size: 12px;border: 2px solid #999;padding: 6px;background:none;display: inline-block;margin:0 5px 0 0;color:#000; border-radius:100%;}
    .numberCircle1{width: 30px;line-height: 15px;text-align: center;
    font-size: 12px;padding: 6px;border: 2px solid green;background: green;color:#FFF;display: inline-block;margin:0 5px 0 0;}
        .numberCircle2{width: 30px;line-height: 15px;text-align: center;
    font-size: 12px;padding: 6px;border: 2px solid orange;background: orange;color:#FFF;display: inline-block;margin:0 5px 0 0;}
</style>
<div id="trackdialog" style="display: none">
	<div id="trackvMap" style="height: 380px; width: 580px;"></div>
</div>
<div class=" col-md-12 map_manage_booking map_manage_booking_scroll" style="float: right;
    width: auto;">
   <div class="form-control_bott">
      <div id="change_result">
         <div class="widget">
            <div class="overflow-block overflow-block_outer ">
               <div class="dispatcher_table table-wrapper-scroll-y my-custom-scrollbar">
                 <table class="table table-bordered table-striped mb-0">
                 	<thead>
                 		
                 		<tr>
                 			<td style="width:247px;max-width: 247px"><?php echo __('button_search'); ?>&nbsp;&nbsp;&nbsp;<input type="text" onkeyup="return driver_location_list_search(event,this);" name="" style="height: 30px;"></td>
                 			<td colspan="2" style="text-align:left;padding-top: 10px;"><?php echo __('live_users'); ?>&nbsp;&nbsp;<span class="numberCircle1 free_users_count" title="<?php echo __('free_users_tooltip'); ?>">0</span>
                 				<span class="numberCircle2 active_users_count" title="<?php echo __('active_users_tooltip'); ?>">0</span>

                 			</td>
                 			
                 			<td colspan="2" style="text-align:right;padding-top: 10px;"><?php echo __('refresh_in'); ?><span class="numberCircle">1</span>
                 				

                 			</td>
                 			
                 		</tr>
                 	</thead>
				  <thead>
				  <tr>
				    <th><?php echo __('driver_name'); ?></th>
				    <th><?php echo __('driver_status'); ?></th>
				    <th><?php echo __('taxi_info'); ?></th>
				    <th><?php echo __('current_location'); ?></th>
				    <th><?php echo __('live_tracking'); ?></th>
				  </tr>
				  </thead>
				  <tbody id="live_tracking_tbody">
				  
				  </tbody>
				</table>
                  
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php
}
?>
		<!---  Table List -->		


		<!--for map-->
		<div class="manage_booking_bottom_outer">
            <!-- /.panel -->    
                <div class="col-md-8 col-md-8_scroll map_manage_booking driver_status_height_outer_top"  id="map-section">
                  
		            <div class="widget margin-bottom">
        	           <input type="hidden" name="select_driver_status" id="select_driver_status" value="" />
            	        <div id="on_going_trip_map" >
						    <div class="ongoing">
	                            <div id="on_going_trip"></div>
	                            <div id="on_going_place"></div>
	                        </div>
	                        
	                        <?php if(SHOW_MAP !=1 && (int)$ENABLE_SHOW_MAP_WITH_ALL_DRIVERS===0) { ?>
		                        <div style="width:100%;height:100%; ">
								<img src="<?php echo URL_BASE.'/public/common/css/img/ajax-loaders/ajax-loader-1.gif';?>" style="position: absolute;left: 50%;top: 50%;margin-left: 10px; margin-top: 150px; "/> 
									<div id="map-canvas" style="width:100%;height:100%; "></div> 
								</div>
	     				
							<?php } ?>
                    	</div>            
                	</div>                       
                </div>
		</div><!--manage_booking_bottom_outer-end-->
        </div>

    </div>
</div>
<script type="text/javascript" src="<?php echo URL_BASE;?>public/common/js/script.js"></script>
<script type="text/javascript" src="<?php echo URL_BASE;?>public/dispatch/vendor/bootstrap/js/simplebar.js"></script>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {
		fleetTrackingMappingDetails();
		
		//CR-Mychauffeur

		$(".need_route_map").click(function() {
		var $visibleForm = $('form:visible'),
		formId = $visibleForm.attr('id');

		    if($(this).is(":checked")) {
			    $(".route_map").show(300);
			       	$("#route_map_modal").show();
					route_map(formId);
			} else {
		        $(".route_map").hide(200);
		    }
		});
		//CR-Mychauffeur

	});
    var ENABLE_SHOW_MAP_WITH_ALL_DRIVERS='<?php echo $ENABLE_SHOW_MAP_WITH_ALL_DRIVERS; ?>';
	var mapNew;
	var icons;
	var markers=[];
	var markersOld=[];
	var markersnew=[];
	var LOCATION_LATI = "<?php echo LOCATION_LATI;?>";
	var LOCATION_LONG = "<?php echo LOCATION_LONG;?>";
	var markerDetails=[];
	var bounds;
	var autocomplete_pick;
	var autocomplete_drop;
	var NEED_DISPATCHER_ROUTE_MAP = "<?php echo defined('NEED_DISPATCHER_ROUTE_MAP')?NEED_DISPATCHER_ROUTE_MAP:0;?>";
	var SUBDOMAIN_NAME = "<?php echo SUBDOMAIN_NAME;?>";
	var unit = $("#default_company_unit").val();
	var address = "";

		
	//CR-Chauffeur
	function route_map(formid='') {
		if($('#route_map').length)
		{
        var directionsService = new google.maps.DirectionsService;
        var directionsRenderer = new google.maps.DirectionsRenderer;
        var lat = parseFloat(LOCATION_LATI)
        var lng = parseFloat(LOCATION_LONG)
        var route_map = new google.maps.Map(document.getElementById('route_map'), {
          zoom: 12,
          gestureHandling: 'greedy',
            center: {lat: lat, lng: lng}
        });
        directionsRenderer.setMap(route_map);

        
        calculateAndDisplayRoute(directionsService, directionsRenderer,formid);
    	}
      }

      function calculateAndDisplayRoute(directionsService, directionsRenderer,formid) {
        var waypts = [];
      
        if(formid.indexOf('_edit') != -1){
        	var start = document.getElementById('edit_current_location').value;
			var end = document.getElementById('edit_drop_location').value;	
        }else{
        	var start = document.getElementById('current_location').value;
			var end = document.getElementById('drop_location').value;	
        }
        directionsService.route({
          origin: start,
          destination: end,
          waypoints: waypts,
          optimizeWaypoints: true,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            directionsRenderer.setDirections(response);
          
          }
        });
      }




   //CR-Chauffeur
	
	function initMap() {
		var mapsLoaded = {};
		//$('#map-canvas').html('<img src="'+SrcPath+'/public/common/css/img/ajax-loaders/ajax-loader-1.gif" >');
		if(dashboard_beta_map_from == 2)
		{
			mapboxgl.accessToken = mapbox_key;
			if(parseInt(ENABLE_SHOW_MAP_WITH_ALL_DRIVERS)===0)
			{
			 mapNew = new mapboxgl.Map({
				container: 'map-canvas',
				style: 'mapbox://styles/mapbox/streets-v10',
			    center: [LOCATION_LONG, LOCATION_LATI], // starting position
			    zoom: 9 // starting zoom
			});

			mapNew.on('load', function() {
				window.dispatchEvent(new Event('resize'));
				$(window).resize(function(){
			     	mapNew.resize();
				});
			});

			if(SUBDOMAIN_NAME == "prehiretest"){
				$.ajax ({
					url: "<?php echo URL_BASE;?>taxidispatch/getcityname",
					success: function(response) 
					{		
						address = decodeEntities(response);
						jQuery.post("https://maps.googleapis.com/maps/api/geocode/json?address="+address+"&key=" + GOOGLE_MAP_API_KEY, function(success) {
							var latitude = success.results[0].geometry.location.lat;
							var longitude = success.results[0].geometry.location.lng;
						    mapNew.setCenter(new google.maps.LatLng(latitude, longitude));
							mapNew.setZoom(15);
						});			
					}
				});
			}

			}
		} else {
			if(parseInt(ENABLE_SHOW_MAP_WITH_ALL_DRIVERS)===0)
			{
				 mapNew = new google.maps.Map(document.getElementById('map-canvas'), {
				  zoom: 12,
				  center: new google.maps.LatLng(LOCATION_LATI, LOCATION_LONG),
				  mapTypeId: 'roadmap',
				  gestureHandling: 'greedy'

				});

				if(SUBDOMAIN_NAME == "prehiretest"){
					$.ajax ({
						url: "<?php echo URL_BASE;?>taxidispatch/getcityname",
						success: function(response) 
						{	
							address = decodeEntities(response);
							jQuery.post("https://maps.googleapis.com/maps/api/geocode/json?address="+address+"&key=" + GOOGLE_MAP_API_KEY, function(success) {
								var latitude = success.results[0].geometry.location.lat;
								var longitude = success.results[0].geometry.location.lng;
							    mapNew.setCenter(new google.maps.LatLng(latitude, longitude));
								mapNew.setZoom(15);
							});			
						}
					});					
				}
			}
		}
		
		icons = {
          normal: {
            icon: '<?php echo URL_BASE;?>public/common/images/caricons/normal.png'
          },
          free: {
            icon: '<?php echo URL_BASE;?>public/common/images/caricons/free.png'
          },
          active: {
            icon: '<?php echo URL_BASE;?>public/common/images/caricons/active.png'
          },
          busy: {
            icon: '<?php echo URL_BASE;?>public/common/images/caricons/busy.png'
          }
        };              
       
		/*var current_location = document.getElementById('current_location');
        var drop_location = document.getElementById('drop_location');
		
		autocomplete_pick = new google.maps.places.Autocomplete(current_location);
		autocomplete_drop = new google.maps.places.Autocomplete(drop_location);
		
		google.maps.event.addListener(autocomplete_pick, "place_changed", function (){
			var a = autocomplete_pick.getPlace();
			origin_place_id = a.place_id;		
								
			$('#pickup_lat').val(a.geometry.location.lat());			
			$('#pickup_lng').val(a.geometry.location.lng());
			//calculateRouteNew();
			outstation_type_options();
			
		});
		google.maps.event.addListener(autocomplete_drop, "place_changed", function (){
			var b = autocomplete_drop.getPlace();
			destination_place_id = b.place_id;					
			$('#drop_lat').val(b.geometry.location.lat());			
			$('#drop_lng').val(b.geometry.location.lng());	
			//calculateRouteNew()
			outstation_type_options();
		}); 
		bounds  = new google.maps.LatLngBounds();*/
		
		//setTimeout(function(){  google.maps.event.trigger(mapNew, 'resize'); },4000)
		 
		/*google.maps.event.addListener( mapNew, 'idle', function() {
	        mapsLoaded['map-canvas'] = true;
	    });
	    alert(mapsLoaded['map-canvas']);*/
		 //initialize();
	if(parseInt(NEED_DISPATCHER_ROUTE_MAP)===1)
	{
		 route_map();
	}
		
	}
	function decodeEntities(encodedString) {
  var textArea = document.createElement('textarea');
  textArea.innerHTML = encodedString;
  return textArea.value;
}


	function fleetTrackingMappingDetails()
	{	
	
		selectedModel=[];
		$.each($(".model_type.active"), function(){      
			selectedModel.push($(this).data('id'));
		});
		if(selectedModel.length==0){
			//$('#showNotification').html('Kindly choose any one of the vehicle type');
			markerDetails=[];
			clearMarkerNew();
			return false;
		}
		selectedModel=selectedModel.join(',');
		if(NODE_ENVIROMENT == 1){

		// socket.emit('fleetTrackingWeb',{"model_type":selectedModel, "taxi_company":taxi_company_def, "driver_search":$('#driver_search').val()});		
		}
				       
		/*$.ajax ({
			url: URL_NODE+"fleetTrackingMappingDetails",
			type:"POST",
			data:{"model_type":selectedModel, "taxi_company":taxi_company, "driver_search":$('#driver_search').val()},
			cache: false, 
			dataType: 'JSON',
			success: function(response) 
			{		
				markerDetails=response;
				 mapMarker(response);				
			}
		});*/
	}
	var marker=undefined;
	var startLoc = new Array();
	var endLoc = new Array();
	var driver_id_array=[];
	var driver_location_logger={};

	function mapMarker(mapdatas){		
		clearMarkerNew()				
		if(mapdatas.length!=0){			
			$('#showNotification').html('');	
			mapNew.setCenter({lat: mapdatas[0][0], lng: mapdatas[0][1]});
			if(SUBDOMAIN_NAME == "prehiretest"){
				$.ajax ({
					url: "<?php echo URL_BASE;?>taxidispatch/getcityname",
					success: function(response) 
					{		
						address = decodeEntities(response);
						jQuery.post("https://maps.googleapis.com/maps/api/geocode/json?address="+address+"&key=" + GOOGLE_MAP_API_KEY, function(success) {
							var latitude = success.results[0].geometry.location.lat;
							var longitude = success.results[0].geometry.location.lng;
						    mapNew.setCenter(new google.maps.LatLng(latitude, longitude));
							mapNew.setZoom(15);
						});			
					}
				});
			}
			var features=[];
			//~ var status=$(".filterStatus.active").attr('data-value');
			var status = [];					
			
			// $.each($(".filterStatus.active"),function(){
			// 	status.push($(this).data('val'));
			// 	if($(this).data('val')=='free,active,busy')
			// 	status= $(this).data('val').split(',');
				
			// });
							
			mapdatas.forEach(function(data){
				mapIcon=icons['normal'].icon;				
				status=data[3];
				if(status.indexOf(data[3]) != -1){
					mapIcon=icons[data[3]].icon
				}				
									
				var marker = new google.maps.Marker({
					position:  {lat: data[0], lng: data[1]},
					icon:mapIcon,
					map: mapNew
				});
				loc = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
				bounds.extend(loc);
				var infowindow = new google.maps.InfoWindow({
					  content: data[2]
				});
				 marker.addListener('click', function() {
				  infowindow.open(map, marker);
				});
				markers.push(marker);
			});
			// mapNew.panToBounds(bounds);										
		}
		else{
		 	//The below code is to set map location to user's current location
		    jQuery.post("https://www.googleapis.com/geolocation/v1/geolocate?key=" + GOOGLE_MAP_API_KEY, function(success) {
		        map.setCenter(new google.maps.LatLng(success.location.lat, success.location.lng));
		    });
			$('#showNotification').html('No driver found');
		}		
	}
	
	function clearMarkerNew(){

		if(markers.length!=0){
			for (var i = 0; i < markers.length; i++) {
				markers[i].setMap(null);
			}
			markers = [];
		}
	}
	function clearMarkeranimate(driver_id_array){
		
		if(driver_id_array.length!=0){
			for (var i = 0; i < driver_id_array.length; i++) {				
				driver_id=driver_id_array[i][0];				
				markers[driver_id].setMap(null);
				//markers[i].setMap(null);
			}		
			markers=[];
		}
		
	}
	function clearMarkerDriver(marker_driver_array){
		
		if(marker_driver_array.length!=0){
			for (var i = 0; i < marker_driver_array.length; i++) {				
				driver_id=driver_id_array[i][0];				
				markers[driver_id].setMap(null);
				//markers[i].setMap(null);
			}		
			markers=[];
		}
		
	}
    </script>

<script src="https://maps.google.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY; ?>&libraries=places,geometry&callback=initMap" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo URL_BASE;?>public/common/js/markerAnimate.js?<?php echo 'rand='.rand(); ?>"></script>
<script type ="text/javascript" src="<?php echo URL_BASE;?>public/common/js/v3_epoly.js"></script>
<script type="text/javascript" src="<?php echo URL_BASE;?>public/common/js/tdispatch_addbooking_new_design.js?<?php echo 'rand='.rand(); ?>"></script>  


<script>
var NODE_ENVIROMENT='<?php echo NODE_ENVIROMENT;?>';
//assign waiting_payment reassign cancelled confirmed cancel_by_passenger start_to_pickup inprogress completed no_drivers no_data // active free_in busy
var reqLanguageFields={active:'<?php echo __('active');?>',free_in:'<?php echo __('free_in');?>',busy:'<?php echo __('busy');?>',LOCATIONUPDATESECONDS:'<?php echo LOCATIONUPDATESECONDS; ?>', assign:'<?php echo __('assign');?>', waiting_payment:'<?php echo __('waiting_payment');?>', reassign:'<?php echo __('reassign');?>', cancelled:'<?php echo __('cancelled');?>', confirmed:'<?php echo __('confirmed');?>', cancel_by_passenger:'<?php echo __('cancel_by_passenger');?>', start_to_pickup:'<?php echo __('start_to_pickup');?>', inprogress:'<?php echo __('inprogress');?>' , completed:'<?php echo __('completed');?>', no_drivers:'<?php echo __('no_drivers');?>', no_data:'<?php echo __('no_data');?>'};
var z='<?php echo date("Z")*1000;?>';
	var taxi_company_def='<?php echo (isset($_SESSION['company_id']))?$_SESSION['company_id']:0;?>';

</script>

<?php if(NODE_ENVIROMENT==1):?>
<script type="text/javascript">
	
	var URL_NODE='<?php echo URL_NODE;?>';
	var URL_NODE_MOBILE='<?php echo URL_NODE_MOBILE;?>';
	
	var companyId='<?php echo $companyId;?>';
	var SUB_NODE='<?php echo SUBDOMAIN_NAME;?>';
	var BABY_SEATER='<?php echo BABY_SEATER;?>';
	var BABY_SEATER_FARE='<?php echo defined("BABYSEATER_FARE")?BABYSEATER_FARE:0;?>';
	var CHANGE_BOOKING_TYPE='<?php echo $booking_type_cond;?>';
	var TELEPHONECODE = '<?php echo TELEPHONECODE;?>';
</script>
	<script type="text/javascript" src="<?php echo URL_BASE;?>public/common/js/node/dashboard_mobile_socket.js?<?php echo 'rand='.rand(); ?>"></script>
<?php endif;?>
<script>
	RENTAL_AVAILABLE = "<?php echo RENTAL_AVAILABLE; ?>";
	OUTSTATION_AVAILABLE = "<?php echo OUTSTATION_AVAILABLE; ?>";
	
	$(document).ready(function () {

		if(BABY_SEATER == 1)
		{

	      $('.taxi-baby-seater').show();
	      
		}
		
		page_no=1;		
		operation_id='<?php echo $_SESSION['userid']; ?>';
		comp_id='<?php echo $_SESSION['company_id']; ?>';
		city_id='<?php echo $_SESSION['city_id']; ?>';
		//state_id='<?php echo $_SESSION['state_id']; ?>';
		//country_id='<?php echo $_SESSION['country_id']; ?>';
				
		<?php if(isset($show_popup['trip_id'])) { ?>
		edit_booking_from_manage('<?php echo $show_popup['trip_id']; ?>');
		<?php } ?>
		
		searchText="";	
		searchLoc="";
		nextSetOfDisListing=0;
		previousScroll=0;	
		
		$("#search_txt").on('change',function(){		
			
			changepreviousScrollValue();			
			if(searchText!=$(this).val()){
				searchText=$(this).val()
				$('#showLoaderImg').show();
				all_booking_manage_list_new_design();
			}			
		});
		
		$("#search_txt").on('keyup',function(eve){
			if($('#search_txt').val() == ''){
				$('#removeSearch').hide();
			}else{
				$('#removeSearch').show();
			}
			
			if(eve.which==13){
				
				changepreviousScrollValue();			
				if(searchText!=$(this).val()){
					searchText=$(this).val()
					$('#showLoaderImg').show();
					all_booking_manage_list_new_design();
				}
				
			}
			
		});
		$('#removeSearch').on('click',function(){
			$('#search_result_display').hide();
			$('#search_result_display').removeClass('search_height');
			$('.dispatcher_list ').css('height','calc(100vh - 80px)')
			
			$("#search_txt").val('');
			changepreviousScrollValue();		
			if(searchText!=$(this).val()){
				searchText=$(this).val()
				$('#showLoaderImg').show();	
				all_booking_manage_list_new_design();
			}	
		});
		// pickup_date_calender edit_pickup_calen
		
		$('#pickup_date_calender').on('click',function(){			
			$('#pickup_date').trigger('focus');			
		});
		
		$('#edit_pickup_calen').on('click',function(){
			$('#edit_pickup_date').trigger('focus');
		});		
		
		$("#search_location").on('change',function(){
			changepreviousScrollValue();											
			if(searchLoc!=$(this).val()){
				searchLoc=$(this).val()	
				all_booking_manage_list_search();
			}
		});	
		
		$("#select_company").on('change',function(){
			changepreviousScrollValue();			
			if($(this).val()!=0)
				$('.tbl_company_name').hide();
			else
				$('.tbl_company_name').show();	
			
		});
						
		$('#submit_filter').on('click',function(){
		
			all_booking_manage_list_new_design()
		});
		
		$('#submit_filter, #reset_date, #select_taxi_model, .click_on_disable').on('click',function(){
			
			changepreviousScrollValue();	
		})
		
		function changepreviousScrollValue(){
			previousScroll=0;	
		}
		
		//var el = new SimpleBar(document.getElementById('dynamicListing'));
		
							
		$('#dynamicListing').scroll(function () { //scrolll
			
			if(parseInt($(this).prop('scrollHeight'))<1000)
				return false;
			
			var currentScroll = parseInt($(this).scrollTop());		
			
			if (currentScroll <= previousScroll){			
				return false;
			}
			
      		previousScroll = currentScroll;
						
			if (parseInt($(this).prop('scrollHeight')) <= parseInt($(this).scrollTop())+1000) {
				if(nextSetOfDisListing==0){
					nextSetOfDisListing=1;
					page_no++;
					all_booking_manage_list_new_design();
					$('#showLoaderImg').show();									
				}
			}
		 });
		
		$("#firstname_new, #phone_new").typeahead({
			ajax: URL_BASE + "taxidispatch/customer_search"			
		});
		 
		/*$("#pass_search_txt").typeahead({
			ajax: URL_BASE + "taxidispatch/customer_search"
			
		});*/
		
		$('#submit_search_filter').on('click',function(){
			if($("#pass_search_txt").val().length==0){
				$('#pass_no_search_result').remove();				
				$('#pass_search_error').html('Search cannot be empty.').addClass('error').show();
			}
		})
		
		$("#firstname_new").on('change',function(){
			$('#pass_search_error').hide();	
			//change_userdetails_new("firstname", $(this).val())
			var t = URL_BASE + "taxidispatch/get_passengerDetailsByName?field_value=firstname&field_name=" + $(this).val();
			$.post(t, {}, function(u) {
				if (0 != u) {
					$('#pass_no_search_result').remove();
					var myArray = u.split(",");													
					$('#passenger_id').val(myArray[0]);
					$('#firstname_new').val(myArray[1]);
					if(myArray[2] != ''){	
						$('#email_new').val(myArray[2]);
						//$('#email_new').attr('readonly', 'readonly');
					}
					$('#phone_new').val(myArray[3]);
					//$('#phone_new').attr('readonly', 'readonly');
					$('#country_code_new').val(myArray[4]);
					
					$('#edit_country_code_new').val(myArray[4]);					
					$('#edit_firstname_new').val(myArray[1]);
					//$('#edit_email_new').val(myArray[2]);					
					//$('#edit_phone_new').val(myArray[3]);					
					$('#defaultForm').show();					
				}
				else{
					var number = $('#phone_new').val();
					if(number != ''){
						$('#phone_new').val(number);
					}else{
						$('#phone_new').val('');
					}
					$('#passenger_id').val('');
					$('#email_new').removeAttr('readonly');
					//$('#email_new').val('');
					$('#phone_new').removeAttr('readonly');
					$('#pass_no_search_result').remove();
					$('#pass_search_txt').after('<p id="pass_no_search_result" class="error"><?php echo __('no_result_found');?></p>');
				}
			})
		});

		$("#phone_new").on('change',function(){
			$('#pass_search_error').hide();	
			var t = URL_BASE + "taxidispatch/get_passengerDetailsByName?field_value=firstname&field_name=" + $(this).val();
			$.post(t, {}, function(u) {
				if (0 != u) {
					$('#pass_no_search_result').remove();
					var myArray = u.split(",");									
					$('#passenger_id').val(myArray[0]);
					$('#firstname_new').val(myArray[1]);
					if(myArray[2] != ''){	
						$('#email_new').val(myArray[2]);
						//$('#email_new').attr('readonly', 'readonly');
					}
					$('#phone_new').val(myArray[3]);
					$('#country_code_new').val(myArray[4]);
					
					//$('#edit_country_code_new').val(myArray[4]);					
					//$('#edit_firstname_new').val(myArray[1]);
					//$('#edit_email_new').val(myArray[2]);					
					//$('#edit_phone_new').val(myArray[3]);					
					$('#defaultForm').show();					
				}
				else{
					var name = $('#firstname_new').val();
					if(name != ''){
						$('#firstname_new').val(name);
					}else{
						$('#firstname_new').val('');
					}
					$('#passenger_id').val('');
					//$('#email_new').removeAttr('readonly');
					//$('#email_new').val('');
					$('#firstname_new').removeAttr('readonly');
					$('#pass_no_search_result').remove();
					$('#pass_search_txt').after('<p id="pass_no_search_result" class="error"><?php echo __('no_result_found');?></p>');
				}
			})
		});
		
		$('#email_new, #phone_new').on('blur',function(){
			$('#email_error').remove();
			fieldLabel=$("#email_new").attr('id');
			fieldDiv=$("#email_new").closest('div');
			fieldText=$("#email_new");
			phone = $("#phone_new").val();
			email = $("#email_new").val().trim();
			
			if(email != ''){
				var t = URL_BASE + "taxidispatch/checkEmailexists?phone="+phone+"&email=" + email;
				$.post(t, {}, function(u) {
					
					if(u==1){
						console.log(u);
						fieldText.val('');
						labelValue='<span for="email_new" class="error" id="email_error"></span>';
						fieldDiv.append(labelValue);
						$("#email_error").html(email_exists);
						/*setTimeout(function(){
							fieldDiv.find('label').remove();	
						},5000)					*/
					}else{
						fieldDiv.find('label').remove();	
					}				
				})
			}
		});
		
		
		/*For load initial functions end*/

		//to prevent enter 
		$(window).keydown(function(event) {
            if (event.keyCode == 13) {
				return false;
                //event.preventDefault();
            }
        }); 
        
        $('#myModal').modal('show');
        
        
        $("#dispatch").on('click',function(e){
        	var err_value = $("#trip_err_val").val();
        	if(err_value == 1)
        	{
        		valid_adddispatch_submit(false);
        		return false;
        	}
        	e.stopImmediatePropagation();
        	 $(this).prop('disabled',true);
        	$("#timeError").hide().html("");
        	var piclat = $('#pickup_lat').val();
		    var piclng = $('#pickup_lng').val();
		    $(".loc_error").hide();
		    if(piclat == '' || piclng == '')
		    {
		    	$(".loc_error").show();
		    	return false;
		    }
		    //Check enter promocode is valid or not
            var promocode = $("#promocode").val();
            var passenger_id = $("#passenger_id").val();
            var type = 'add';
            var addValid = $("#defaultForm").valid({});
            $("#promocodeError").hide().html("");
            if( promocode != '' )
            {
                var dataS = "promocode="+promocode+"&passenger_id="+passenger_id+"&type="+type;
                $.ajax ({
                    type: "POST",
                    url: SrcPath+"taxidispatch/check_promocode",
                    data: dataS, 
                    cache: false, 
                    dataType: 'html',
                    success: function(response) 
                    {
                        if( response != 1 )
                        {
                            $("#promocodeError").show().html(response);
                            return false;
                        } else {
                            $("#promocodeError").hide().html("");
                            valid_adddispatch_submit(addValid);
                        }
                        $(this).prop('disabled',false);
                    } 
                });
            } else {
            	$("#dispatch").prop('disabled',false);
            	valid_adddispatch_submit(addValid);
            }
		});
		$("#update_dispatch").on('click',function(e){
			var err_value = $("#trip_err_val").val();
        	if(err_value == 1)
        	{
        		valid_update_dispatch_submit(false);
        		return false;
        	}
        	e.stopImmediatePropagation();
        	 $(this).prop('disabled',true);
        	$("#timeError").hide().html("");
		    //Check enter promocode is valid or not
            var promocode = $("#promocode").val();
            var passenger_id = $("#passenger_id").val(); 
            var type = 'update';
            var addValid = $("#defaultForm").valid({});
            $("#promocodeError").hide().html("");
            if( promocode != '' )
            {
                var dataS = "promocode="+promocode+"&passenger_id="+passenger_id+"&type="+type;
                $.ajax ({
                    type: "POST",
                    url: SrcPath+"taxidispatch/check_promocode",
                    data: dataS, 
                    cache: false, 
                    dataType: 'html',
                    success: function(response) 
                    {
                        if( response != 1 )
                        {
                            $("#promocodeError").show().html(response);
                            return false;
                        } else {
                            $("#promocodeError").hide().html("");
                            valid_update_dispatch_submit(addValid);
                        }
                        $(this).prop('disabled',false);
                    } 
                });
            } else {
            	$("#update_dispatch").prop('disabled',false);
            	valid_update_dispatch_submit(addValid);
            }

		}); 

 		function valid_update_dispatch_submit(addValid){ 
			if(addValid) 
			{	
				if($("#country_code_new").val() == '')
				{
					document.getElementById("country_code_new").style.borderColor = "red";					
					return false;			
				}
				var today = new Date();

				var current_date_time = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate() + " " + today.getHours() + ":" + today.getMinutes();

				var current_date="<?php echo date('Y-m-d H:i:s');?>";
			    current_date=current_date.replace("-","");
			    current_date=current_date.replace("-","");
				pick_date=$("#pickup_date").val();
				edit_pick_date=$("#edit_pickup_date").val();

				var new_pickup_date = new Date(edit_pick_date);

				var pickup_date_time = new_pickup_date.getFullYear()+'-'+(new_pickup_date.getMonth()+1)+'-'+new_pickup_date.getDate() + " " + new_pickup_date.getHours() + ":" + new_pickup_date.getMinutes();

				var x=0;
				
				
				if(edit_pick_date == '')
				{ 
					$("#timeError").show().html("<?php echo __('select_time'); ?>").addClass('error');
				return false;
				}

				if(pickup_date_time < current_date_time){
					if (confirm("<?php echo __('areyousuredo_youwantto_dispatch_previousdatetrip'); ?>") == true) {
					 x=1;
					}else{
						return false;
					}
				}else if(pickup_date_time > current_date_time){ 
					if (confirm("<?php echo __('areyousuredo_youwantto_dispatch_futuredatetrip'); ?>") == true) {
					 x=1;
					}else{
						return false;
					}
				}else if(pickup_date_time == current_date_time){
					 x=1;
				}

				$(' .dispatch_det_slidebar_add #dispatch').val("Dispatch");
				

				pendingPayYes_direct();
				//document.getElementById('defaultForm').submit();
			}

			return addValid;
		}

		function valid_adddispatch_submit(addValid){ 
			if(addValid) 
			{	
				if($("#country_code_new").val() == '')
				{
					document.getElementById("country_code_new").style.borderColor = "red";					
					return false;			
				}
				//var today = new Date();
				var user_timezone = '<?php echo defined('TIMEZONE') ? TIMEZONE : ""; ?>';
				
				var actualTime = new Date().toLocaleString("en-US", {timeZone: user_timezone});
				var today = new Date(actualTime);
				var current_date_time = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate() + " " + today.getHours() + ":" + today.getMinutes();

				var current_date="<?php echo date('Y-m-d H:i:s');?>";
			    current_date=current_date.replace("-","");
			    current_date=current_date.replace("-","");
				pick_date=$("#pickup_date").val();
				

			    /*pick_date=pick_date.replace("-","");
			    pick_date=pick_date.replace("-","");*/
				var new_pickup_date = new Date(pick_date);

				var pickup_date_time = new_pickup_date.getFullYear()+'-'+(new_pickup_date.getMonth()+1)+'-'+new_pickup_date.getDate() + " " + new_pickup_date.getHours() + ":" + new_pickup_date.getMinutes();

				var x=0;

				/*if(pick_date < current_date){
					if (confirm("<?php echo __('areyousuredo_youwantto_dispatch_previousdatetrip'); ?>") == true) {
					 x=1;
					}
				}else if(pick_date > current_date){
					if (confirm("<?php echo __('areyousuredo_youwantto_dispatch_futuredatetrip'); ?>") == true) {
					 x=1;
					}else{
						return false;
					}
				}else if(pick_date == current_date){
					 x=1;
				}*/
				if(pick_date == '')
				{
					$("#timeError").show().html("<?php echo __('select_time'); ?>").addClass('error');
				return false;
				}

				if(pickup_date_time < current_date_time){
					if (confirm("<?php echo __('areyousuredo_youwantto_dispatch_previousdatetrip'); ?>") == true) {
					 x=1;
					}else{
						return false;
					}
				}else if(pickup_date_time > current_date_time){
					if (confirm("<?php echo __('areyousuredo_youwantto_dispatch_futuredatetrip'); ?>") == true) {
					 x=1;
					}else{
						return false;
					}
				}else if(pickup_date_time == current_date_time){
					 x=1;
				}

				$(' .dispatch_det_slidebar_add #dispatch').val("Dispatch");
				//$('.dispatch_det_slidebar_add #dispatch').html('Please Wait..');

				//$('.dispatch_det_slidebar_add #create').attr('disabled','disabled');
				//$('.dispatch_det_slidebar_add #dispatch').attr('disabled','disabled');

				pendingPayYes_direct();
				//document.getElementById('defaultForm').submit();
			}
			return addValid;
		}
		
		$("#create").on('click',function(e)
        {
        	var err_value = $("#trip_err_val").val();
        	if(err_value == 1)
        	{
        		return false;
        	}
        	//$('.book_later').prop('disabled',true);
        	//e.stopImmediatePropagation();
        	//Check enter promocode is valid or not
            var promocode = $("#promocode").val();
            var passenger_id = $("#passenger_id").val();
            var type = 'add';
            $("#promocodeError").hide().html("");
            $("#tripPackagesError").hide().html("");
            var piclat = $('#pickup_lat').val();
		    var piclng = $('#pickup_lng').val();
		    $(".loc_error").hide();
		    if(piclat == '' || piclng == '')
		    {
		    	$(".loc_error").show();
		    	return false;
		    }
            var trip_type = $('#trip_type').val();

            if(trip_type != 1)
            {
            	var package_sel = $('#trip_packages').val();
            	if(package_sel == '')
            	{
            		$("#tripPackagesError").show().html("<?php echo __('select_package_value'); ?>");
        	$('.book_later').prop('disabled',false);
                    return false;
            	} else {
                    $("#tripPackagesError").hide().html("");
                }
            }
            
            if( promocode != '' )
            {
                var dataS = "promocode="+promocode+"&passenger_id="+passenger_id+"&type="+type;
                $.ajax ({
                    type: "POST",
                    url: SrcPath+"taxidispatch/check_promocode",
                    data: dataS, 
                    cache: false, 
                    dataType: 'html',
                    success: function(response) 
                    {
                        if( response != 1 )
                        {
                            $("#promocodeError").show().html(response);
                            return false;
                        } else {
                            $("#promocodeError").hide().html("");
                        }
        	$('.book_later').prop('disabled',false);
                    } 
                });
            }
            
            $("#timeError").hide().html("");
			
			var pickup_date = $("#defaultForm input[name='pickup_date']").val();
			var currentdate = customRangeStart(); 
			pickup_date = new Date(pickup_date);
			var diff = pickup_date.getTime() - currentdate.getTime();
			var msec = diff;
			var hh = Math.floor(msec / 1000 / 60 / 60);
			
			msec -= hh * 1000 * 60 * 60;
			var mm = Math.floor(msec / 1000 / 60);
			msec -= mm * 1000 * 60;
			var total_mm = mm + (hh * 60);
			if((diff < 0) || (total_mm < later_booking_interval)) {
				addValid = false;
				$("#timeError").show().html("<?php echo __('later_booking_need_min'); echo 
					$later_booking_interval; echo __('minutes');  ?>").addClass('error');
				$('.book_later').prop('disabled',false);
				return false;
			}
			var addValid = $("#defaultForm").valid({});
            if( promocode != '' )
            {
            	if($("#country_code_new").val() == '')
				{
					document.getElementById("country_code_new").style.borderColor = "red";
					$('.book_later').prop('disabled',false);
					return false;			
				}
                var dataS = "promocode="+promocode+"&passenger_id="+passenger_id+"&type="+type;
                $.ajax ({
                    type: "POST",
                    url: SrcPath+"taxidispatch/check_promocode",
                    data: dataS, 
                    cache: false, 
                    dataType: 'html',
                    success: function(response) 
                    {
                        if( response != 1 )
                        {
                            $("#promocodeError").show().html(response);
                            $('.book_later').prop('disabled',false);
                            return false;
                        }
                        else{
                        	$('.book_later').prop('disabled',false);
                            $("#promocodeError").hide().html("");
                            if(addValid){
                               $(".job_filter_bar,.jobs_search_bar").css('display','block');

								//$('.dispatch_det_slidebar_add #create').html('Please Wait..');
								//$('.dispatch_det_slidebar_add #create').attr('disabled','disabled');
								$('.dispatch_det_slidebar_add #dispatch').attr('disabled','disabled');
				                $('.dispatch_det_slidebar_add #reset').attr('disabled','disabled');
				                //$('#create').prop('disabled',false);
				                $('.book_later').prop('disabled',true);

								document.getElementById('defaultForm').submit();
								e.stopImmediatePropagation();
	
                            }
                           // return false;                                              
                        }
                    } 
                });
            }else{
             	if(addValid){
             		if($("#country_code_new").val() == '')
					{
						document.getElementById("country_code_new").style.borderColor = "red";
						$('.book_later').prop('disabled',false);
						return false;			
					}
					$(".job_filter_bar,.jobs_search_bar").css('display','block');

					//$('.dispatch_det_slidebar_add #create').html('Please Wait..');
					//$('.dispatch_det_slidebar_add #create').attr('disabled','disabled');
					$('.dispatch_det_slidebar_add #dispatch').attr('disabled','disabled');
	                $('.dispatch_det_slidebar_add #reset').attr('disabled','disabled');

	               $('.book_later').prop('disabled',true);

					document.getElementById('defaultForm').submit();
					//$('.book_later').prop('disabled',false);
					e.stopImmediatePropagation();

				}
			
            }
			return false;
		});
		
		
		$("#update_submit").on('click',function(){
			var err_value = $("#trip_err_val").val();
        	if(err_value == 1)
        	{
        		return false;
        	}
			var editValid = $("#defaultForm_edit").valid({});
			var promocode = $("#edit_promocode").val();
            var passenger_id = $("#edit_passenger_id").val();
            var type = 'edit';

			$("#editPromocodeError").hide().html("");
			$("#edittripPackagesError").hide().html("");
			var trip_type = $('#edit_trip_type').val();
			
            if(trip_type != 1)
            {
            	var package_sel = $('#edit_trip_packages').val();
            	if(package_sel == '')
            	{
            		$("#edittripPackagesError").show().html("<?php echo __('select_package_value'); ?>");
                    return false;
            	} else {
                    $("#edittripPackagesError").hide().html("");
                }
            }

            //validating book later time interval
            $("#timeError_edit").hide().html("");

			var edit_pickup_date = $("#defaultForm_edit input[name='edit_pickup_date']").val();

			var currentdate = customRangeStart(); 
			edit_pickup_date = new Date(edit_pickup_date);
			var diff = edit_pickup_date.getTime() - currentdate.getTime();
			var msec = diff;
			var hh = Math.floor(msec / 1000 / 60 / 60);
			
			msec -= hh * 1000 * 60 * 60;
			var mm = Math.floor(msec / 1000 / 60);
			msec -= mm * 1000 * 60;
			var total_mm = mm + (hh * 60);

			if((diff < 0) || (total_mm < later_booking_interval)) {
				
				$("#timeError_edit").show().html("<?php echo __('later_booking_need_min'); echo 
					$later_booking_interval; echo __('minutes');  ?>").addClass('error');
				$('.book_later').prop('disabled',false);
				return false;
			}


            
            if( promocode != '' && passenger_id != '' )
            {
            	var dataS = "promocode="+promocode+"&passenger_id="+passenger_id+"&type="+type;
                $.ajax ({
                    type: "POST",
                    url: SrcPath+"taxidispatch/check_promocode",
                    data: dataS, 
                    cache: false, 
                    dataType: 'html',
                    success: function(response) 
                    {
                    	if( response != 1 )
                        {
                            $("#editPromocodeError").show().html(response);
                            editValid = false;
                            return false;
                        }
                        else
                            $("#editPromocodeError").hide().html("");                                              
                    } 
                });
            }
            
            setTimeout(function(){
	            if(editValid) {
	            	$('#edit_add_btn').attr('disabled','disabled');
	            	$(".dispatch_det_slidebar_edit #update_submit").html("Please Wait...");
	            	$(".dispatch_det_slidebar_edit #update_submit").attr('disabled','disabled');
	            	$(".dispatch_det_slidebar_edit #update_dispatch").attr('disabled','disabled');
	            	$(".job_filter_bar,.jobs_search_bar").css('display','block');
	            	document.getElementById('defaultForm_edit').submit();
	            }
        	}, 1000);
		})
		
		$("#update_dispatch").on('click',function() 
        {
        	var err_value = $("#trip_err_val").val();
        	if(err_value == 1)
        	{
        		return false;
        	}
        	//Check enter promocode is valid or not
            var promocode = $("#edit_promocode").val();
            var passenger_id = $("#edit_passenger_id").val();
            var type = 'add';
            $("#editPromocodeError").hide().html("");
            $("#edittripPackagesError").hide().html("");
			var trip_type = $('#edit_trip_type').val();
			
            if(trip_type != 1)
            {
            	var package_sel = $('#edit_trip_packages').val();
            	if(package_sel == '')
            	{
            		$("#edittripPackagesError").show().html("<?php echo __('select_package_value'); ?>");
                    return false;
            	} else {
                    $("#edittripPackagesError").hide().html("");
                }
            }
            var editValid = $("#defaultForm_edit").valid({});
            if( promocode != '' && passenger_id != '' )
            {
                var dataS = "promocode="+promocode+"&passenger_id="+passenger_id+"&type="+type;
                $.ajax ({
                    type: "POST",
                    url: SrcPath+"taxidispatch/check_promocode",
                    data: dataS, 
                    cache: false, 
                    dataType: 'html',
                    success: function(response) 
                    {
                        if( response != 1 )
                        {
                            $("#editPromocodeError").show().html(response);
                            editValid = false;
                            return false;
                        }
                        else
                            $("#editPromocodeError").hide().html("");                                              
                    } 
                });
            }
			$("#timeEditError").hide().html("");
			//~ var editValid = $("#defaultForm_edit").valid({});
			
			setTimeout(function(){
				if(editValid) {
					//~ $('#update_dispatch').attr('disabled','disabled');
					$('#update_dispatch_id').val("Dispatch");				
					
					var currentdate = customRangeStart(); 
					pickup_date = new Date($('#edit_pickup_date').val());

					var diff = pickup_date.getTime() - currentdate.getTime();
					var msec = diff;
					var hh = Math.floor(msec / 1000 / 60 / 60);			
					
					if(hh<1){					
						$(".dispatch_det_slidebar_edit #update_dispatch").html("Please Wait...");
            			$(".dispatch_det_slidebar_edit #update_dispatch").attr('disabled','disabled');
            			$(".dispatch_det_slidebar_edit #update_submit").attr('disabled','disabled');
						$('#dispatch, #create').prop('disabled', true);	

						document.getElementById('defaultForm_edit').submit()
										
					}
					else{
						
						var r = confirm("This trip has more than one hour to dispatch. Would you like to change pickup time to dispatch this trip now?");
						if (r == true) {
							$('#edit_pickup_date').val(getCurrentTimeDateFormat());
							$('#dispatch, #create').prop('disabled', true);	
							document.getElementById('defaultForm_edit').submit()
							
						} else {
							alert("Kindly click on update button for update this trip");
						}
					}			
					
					
				}
			}, 1000);
			return editValid;
		});
        
        $("#close_button,#reset").on('click',function(){
			//to reset the form fields
			$("#Anonymous_presentation_id").addClass('active');
			//~ $("#anonymous_id").css('color','red');	
			$("#search_txt_div").hide();
			$("#pass_search_txt").val('');
			$("#firstname").val("");
			$("#email").val("");
			$("#country_code").val("");
			$("#phone").val("");
			$("#current_location").val("");
			$("#drop_location").val("");
			$("#notes").val("");
			var today = new Date();
			var Y = today.getFullYear(),
			    month = today.getMonth()+1,
			    dateVal = today.getDate(),
				h = today.getHours(),
				m = today.getMinutes(),
				s = today.getSeconds();
				month = (month < 10) ? "0" + month : month;
				dateVal = (dateVal < 10) ? "0" + dateVal : dateVal;
				h = (h < 10) ? "0" + h : h;
				m = (m < 10) ? "0" + m : m;
				s = (s < 10) ? "0" + s : s;
			var pickupTime = Y + "-" + month + "-" + dateVal + " " + h + ":" + m + ":" + s;
			//$("#pickup_date").val(pickupTime);
			$("#pickup_date").val("");
			$("#taxi_model").val("");
			 $("#email").removeAttr("readonly");
			 $("#firstname").removeAttr("readonly");
			 $("#phone").removeAttr("readonly");
			 $("#country_code").removeAttr("readonly");
			//to reset the distance and fare texts
			$("#find_duration").html("<?php echo __('zero_mins'); ?>");
			$("#find_km").html("<?php echo __('zero_distance'); ?>");
			$("#min_fare").html("0");
			//to hide the error messages
			$("label.error").html("");
			initialize();
		});

        //Reload map on click button
		//$('#refresh_map').on('click','initMap');
		
		

	function getCurrentTimeDateFormat(){
		gmt=new Date();
		time=gmt.getTime() + (gmt.getTimezoneOffset() * 60000);
		var currentTime = new Date((time) +parseInt('<?php echo date("Z")*1000;?>'));    
		var currentHours = currentTime.getHours ( );   
		var currentMinutes = currentTime.getMinutes ( );   
		var currentSeconds = currentTime.getSeconds ( );
		var currentDate = currentTime.getDate();
		var currentMonth = currentTime.getMonth()+1;
		var currentYear = currentTime.getFullYear();			
		currentDate = ( currentDate < 10 ? "0" : "" ) + currentDate;   
		currentMonth = ( currentMonth < 10 ? "0" : "" ) + currentMonth;			
		totDate= currentYear+"-"+currentMonth+"-"+currentDate;
		currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;   
		currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;    
		currentHours = ( currentHours < 10 ? "0" : "" ) + currentHours;    
		   
		var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
		
		return totDate+" "+currentTimeString;
		   
	}

		
		function customRangeStart(){ 
			gmt=new Date();
			time=gmt.getTime() + (gmt.getTimezoneOffset() * 60000);
			var currentTime = new Date((time) +parseInt('<?php echo date("Z")*1000;?>'));			
			return currentTime;
		}
	
		window.timer_resize = setInterval(function()
        {
            //refresh_map();
        },2000);
                
        $('.icon-menu').click(function(){
            window.timer_resize = setInterval(function()
            {
            //alert("here");
            ////refresh_map();
            },2000);
            if($(this).hasClass('active_page') == false)
            {

				$('.driver_status_height').fadeIn();
				$('.manage_booking_bottom').hide();                
				$('#map-section').removeClass('col-md-8');
				$('#map-section').addClass('col-md-12');
				$(this).addClass('active_page');
            }
            else
            {
            $('.driver_status_height').fadeIn();
            $(this).removeClass('active_page');
            $('#map-section').removeClass('col-md-12');
            $('#map-section').addClass('col-md-8');
            $('.manage_booking_bottom').show();
            }
        });
        
		
		
		if(NODE_ENVIROMENT!=1){
			setInterval(function()
			{				
				//driver_list_with_status(),
				//	all_booking_manage_list();
			},5000); // For 5 seconds interval */
		}

		$("#new_trip_duration, #new_trip_duration2").keyup(function() {
	        //to allow left and right arrow key move
	        if (event.which >= 37 && event.which <= 40) {
	            return false;
	        }
	        this.value = this.value.replace(/[`~!@#$%^&*()\s_|+\-=?;:'",.<>\{\}\[\]\\\/A-Z]/gi, '');
    	});
	});
	var locations = {}; //A repository for markers (and the data from which they were contructed).

	$('#drop_location').on('change', function() {
		var a=$('#drop_location').val();
		if(a == ""){
			$('#drop_lat').val('');
			$('#drop_lng').val('');
			$('#distance_km').val('0');
			$('#total_fare').val('0');
			$('#min_fare').html('0');
			$('#find_km').html('0');
			$('#find_duration').html('0');
		}
	});

	$('#edit_drop_location').on('change', function() {
		var a=$('#edit_drop_location').val();
		if(a == ""){
			$('#edit_drop_lat').val('');
			$('#edit_drop_lng').val('');
			$('#edit_distance_km').val('0');
			$('#edit_total_fare').val('0');
			$('#edit_min_fare').html('0');
			
			$('#edit_find_km').html('0');
			$('#edit_find_duration').html('0');
			$('#edit_total_duration').val('0');
		}
	});

	$('#taxi_model').on('change', function() {
		var a=$('#taxi_model').val();
		if(a == ""){
			$('.dispatch_det_slidebar_add').css('display','none');
			$('#total_fare').val('10');
			$('#min_fare').html('0');
		}else{
			$('.dispatch_det_slidebar_add').css('display','block');
		}
		search_nearest_driver_location_new_design(1);//add form flag
	});

	$('#edit_taxi_model').on('change', function() {
		var a=$('#edit_taxi_model').val();
		if(a == ""){
			$('#edit_total_fare').val('0');
			$('#edit_min_fare').html('0');
		}
		search_nearest_driver_location_new_design(2);//edit_form_flag
	});
	
	
	$('#select_taxi_model').on('change', function() {
		var taxi_model=$(this).val();
		//to get the filtered model in taxi model dropdown
		$("#taxi_model").val(taxi_model);
		$("#edit_taxi_model").val(taxi_model);
	});
	
	
	//cancel trip
	$(document).on('click',".cancelBtn, #cancel_button",function(){
		var cancel_Submit = confirm('<?php echo __('sure_want_cancel'); ?>');
		if(cancel_Submit == true)
		{
                    
			if($(this).hasClass('cancelBtn')){
				modalType=true;
				var cancelArr = $(this).attr('id').split("_");
				var pass_logid = cancelArr[1];
				closestDiv=$(this).closest('div');
				 //return false;
				
			}else{
				modalType=false;
				var pass_logid = $('#edit_pass_logid').val();
			}
			
			if(NODE_ENVIROMENT!=1){
					var url_path= URL_BASE+"taxidispatch/cancel_booking/?pass_logid="+pass_logid;
			}else{
					var url_path = "<?php echo URL_NODE;?>cancelDispatcherListing?domain="+SUB_NODE;
			}
			
			$.ajax({
				type: "POST",
				url:url_path,
				data: {"pass_logid":pass_logid,"operation_id":operation_id,"url_base":'<?php echo URL_BASE; ?>'}, 
				async: true,
				success:function(res){
					if(NODE_ENVIROMENT!=1){
						document.location.href=URL_BASE+"taxidispatch/dashboard_beta";
					}
					else
					{
						if( res == 'trip_cancel_passenger')
						{
							var res_msg = "<?php echo __('trip_cancel_passenger');?>";
						}
						else if( res == 'cant_cancel_trip_inprogress_complete')
						{
							var res_msg = "<?php echo __('cant_cancel_trip_inprogress_complete');?>";
						}
						else if( res == 'invalid_trip')
						{
							var res_msg = "<?php echo __('invalid_trip');?>";
						}
						else
						{
							var res_msg = res;
						}
						$('.showResults').html('<div class="alert alert-success alert-dismissable">	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+res_msg+'</div>');
						setTimeout(function(){
							$('.showResults').html('');
							$('#close_button').trigger('click');

						},4000)
					}
				},
				error:function() {
					//alert('failed'); 
				}
			});				
			
		} else {
			<?php if($_SESSION['user_type'] == 'A') { ?>
			//to deselect the selected company
			$("#select_company").val("0");
			//to get the default data - start
			//driver_list_with_status();
			all_booking_manage_list_new_design();
			<?php } ?>
			$("#edit_book_tab").removeClass('edit_book_active');
			$("#eb_tab").removeClass('active');
			//to get the default data - end
			$("#edit_book_tab").hide();
			$("#add_booking_tab").html('Add Booking');
			return false;
		}
	});

	$('.edit_job').on('click', function(){
		edit_icon_new_design(this.val());
	});
	function edit_icon_new_design(findid){
		console.log('edit_icon_new_design');

    	$('.showResults').html('');
    	$('#defaultForm_edit #Anonymous_presentation_id').addClass('disabled');
		$('#defaultForm_edit #Anonymous_presentation_id a').removeAttr('data-toggle').attr('href','javascript:;');

		var default_unit = $('#edit_default_company_unit').val();
			$(".job_filter_bar,.jobs_search_bar").css('display','none');
     	
		var dataS = "passenger_logid="+trim(findid);		
		$.ajax
		({ 			
			type: "GET",
			url: "<?php echo URL_BASE;?>taxidispatch/edit_booking", 
			data: dataS, 
			cache: false, 
			async: true,
			contentType: "application/json; charset=utf-8",
			dataType: "json",			
			success: function(response) 
			{
				$(".job_listing_container").css('display','none');
				$(".edit_job_container").css('display','block');
				$('.dispatch_det_slidebar').removeClass('active');
				$('.dispatch_det_slidebar_edit').addClass('active');
    	 		$('.estimate_container').css('display','block');
    	 		$("#defaultForm_edit").css('display','block');

				$(".add_btn").removeClass('active');
				$("#edit_add_btn").addClass('active');
				$('#update_submit, #update_dispatch').removeAttr('disabled');								
				var data=response;
				var details=data[0];

				$("#show_time_secs").val(details.approx_duration_sec);
				
				if(!details.trip_type)
				{
					details.trip_type = '1';
				}
				if(details.taxi_submodel && details.taxi_submodel!=0)
				{
					$('.taxi-sub-model').show();
      				$('.fixed_fare').show();
				}else{
					$('.taxi-sub-model').hide();
					$('.fixed_fare').hide();
				}
				
				$('#edit_trip_type').val(details.trip_type);
				$('#edit_trip_type_dis').val(details.trip_type);
				if(details.trip_type == 1)
				{
					$('.edit-trip-packages-div').hide();
				} else {
					loadpackages_model(details.taxi_modelid, 'edit', details.rent_out_plan_id);
					loadPackageDetail(details.rent_out_plan_id, 'edit');
				}

				if(details.trip_type == 3) {
					$('#edit_os_trip_type').val(details.os_trip_type);
					$('#edit_round_one_way_select').show();
					$('#edit_os_day_count').val(details.os_day_count);
					$('.edit_days_count').show();
					$('.dsptch_btn').attr('disabled', 'disabled');
				}
				
				$("#timeEditError").hide().html("");
				$("#add_booking").removeClass("in");
				$("#edit_booking").addClass("in");
				//to add id for reset button in edit
				$(".edit_reset_btn").attr('id','reset_'+findid);
				$('#edit_passenger_id').val(details.passengers_id);
				$('#edit_pass_logid').val(details.pass_logid);
				$('#edit_total_fare').val(details.approx_fare);
				var appDistance = (default_unit == "MILES") ? (details.approx_distance*0.621371) : details.approx_distance;
				appDistance = parseFloat(appDistance).toFixed(2);
				$('#edit_distance_km').val(appDistance);
			
				$('#edit_corporateID').val(details.corporate_company_id);
				$('#edit_firstname').val(details.passenger_name);
				$('#edit_email').val(details.passenger_email);
				$('#edit_phone').val(details.passenger_phone);
				$('#edit_country_code').val(details.country_code);
				$('#edit_current_location').val(details.current_location);
				$('#edit_pickup_lat').val(details.pickup_latitude);
				$('#edit_pickup_lng').val(details.pickup_longitude);				
				$('#edit_drop_location').val(details.drop_location);
				$('#edit_drop_lat').val(details.drop_latitude);
				$('#edit_drop_lng').val(details.drop_longitude);
				$('#edit_pickup_date').val(details.pickup_time);
				$('#edit_pickup_date_db').val(details.pickup_time);
				$('#edit_luggage').val(details.luggage);
				$('#edit_no_passengers').val(details.no_passengers);
				$('#edit_notes').val(details.notes_driver);
				$('#edit_taxi_model').val(details.taxi_modelid);
				if(SUB_NODE == 'flightkenya'){
					var edit_submodel = details.taxi_submodel +"."+details.taxi_submodelname;
				$('#edit_taxi_submodel').val(edit_submodel);
				$('#edit_fixedfare1').val(details.fixedfare);
				}
				if(BABY_SEATER == 1){
					
				var edit_seatcount1=details.baby_seatercount1;
				$('#edit_baby_seatercount1').val(edit_seatcount1);
				var edit_seatcount2=details.baby_seatercount2;
				$('#edit_baby_seatercount2').val(edit_seatcount2);
				var edit_seatcount3=details.baby_seatercount3;
				$('#edit_baby_seatercount3').val(edit_seatcount3);
				
				}

				$('#edit_city_id').val(details.search_city);
				$('#edit_cityname').val(details.city_name);
				$('#edit_admin_company_id').val(details.company_id);
				$('#edit_promocode').val(details.promocode);
				$('#tripIdSpan').html(" <?php echo __('trip_id'); ?>: "+details.pass_logid);
				search_nearest_driver_location_new_design(2);
				try {
				var minStrExist = details.approx_duration.indexOf("mins");
				}
				catch(err) {
				var minStrExist = false;
				}				
				if(details.approx_duration != '') {	
					$('#edit_find_duration').html(details.approx_duration);
					$('#edit_total_duration').val(details.approx_duration);
				} else {
					$('#edit_find_duration').html('0 mins');
					$('#edit_total_duration').val('0 mins');
				}
				if(details.fixed_fare_select == 1)
				{
					$("#edit_fixedfare").show();
					$('#edit_fixed_fare_select').attr('checked', true);

					$("#edit_fixedfare").val(details.fixedfare)
				}else{
					$("#edit_fixedfare").hide();
				}
				
				
				if(appDistance != '') {
					$('#edit_find_km').html(appDistance+" "+default_unit);
				} else {
					$('#edit_find_km').html("0 "+default_unit);
				}
				$('#edit_min_fare').html(details.approx_fare);
				
				var durationSecs = details.approx_duration * 60;
				//to get the approximate fare
				if(minStrExist < 0) { //this calculation should be done only for later booking from app
					 calculate_totalfare_flag(details.approx_distance, details.taxi_modelid, '', details.search_city, durationSecs, details.trip_type, 'new');
				 }
				
				//to get the company value as selected in company drop down
				if(details.company_id != 0) {
					$("#select_company").val(details.company_id);
					
					all_booking_manage_list_new_design();
				}

				var travel_status=details.travel_status;
				if(travel_status == 0 || travel_status == 7 || travel_status == 10){
					var dateString = details.pickup_time,
					dateParts = dateString.split(' '),
					timeParts = dateParts[1].split(':'),
					date;
					dateParts = dateParts[0].split('-');
				}else{

				}
				
				//to hide the dispatch button if pickup time is future
				// Set place id for pickup & drop locations start
				var editPickuplat = $("#edit_pickup_lat").val();
				var editPickuplng = $("#edit_pickup_lng").val();
				var editlatlng1 = {lat: parseFloat(editPickuplat), lng: parseFloat(editPickuplng)};
				var geocoder = new google.maps.Geocoder;
				geocoder.geocode({'location': editlatlng1}, function(editresults1, editstatus1) {
					if (editstatus1 === google.maps.GeocoderStatus.OK) {				
						if (editresults1[1]) {
							$("#editpickup_placeid").val(editresults1[1].place_id);
						}
					}
				});	
				
				var editDroplat = $("#edit_drop_lat").val();
				var editDroplng = $("#edit_drop_lng").val();								
				var editlatlng = {lat: parseFloat(editDroplat), lng: parseFloat(editDroplng)};
				var geocoder = new google.maps.Geocoder;
				geocoder.geocode({'location': editlatlng}, function(editresults, editstatus) {
					if (editstatus === google.maps.GeocoderStatus.OK) {				
						if (editresults[1]) {
							$("#editdrop_placeid").val(editresults[1].place_id);
							// Edit booking map showing
							/*setTimeout(function() {
							   	edit_initialize();
							   	edit_outstation_type_options();
							}, 500);*/
						}
					}
					else{
						// Edit booking map showing
						edit_initialize();										
					}
				});												
				// Set place id for pickup & drop locations end
				
				edit_initialize();
				//edit_outstation_type_options();
				if(details.trip_type == 1)
				{
					change_minfare(details.taxi_modelid, 'edit');
				} else {
					$('#edit_min_fare').html(details.approx_fare);
					edit_outstation_type_options();
				}
				
				var trip_type = $('#edit_trip_type_dis').find(":selected").val();

				loadModels(trip_type,'edit',details.taxi_modelid);

				

			} 
		});
    }
	//edit booking in dashboard - end
	//dispatch button click function
	$(document).on('click','.update_dispatch',function() {
		var thisid = this.id;
		//var pass_logid = thisid.split('_').pop();
		var logid = thisid.split('_');				
		
		var current_date="<?php echo date('Y-m-d');?>";
		     current_date=current_date.replace("-","");
		     current_date=current_date.replace("-","");
			 pick_date=logid[4];
		     pick_date=pick_date.replace("-","");
		     pick_date=pick_date.replace("-","");
		     
		var x=0;
		if(pick_date < current_date){
			if (confirm("Are you sure do you want to dispatch previous date trip") == true) {
				x=1;
			}
		}else if(pick_date > current_date){
			if (confirm("Are you sure do you want to dispatch future date trip") == true) {
				x=1;
			}
		}else if(pick_date == current_date){
	 		x=1;
		}

		if(x==1){
			checkPassengerStatus(logid[2],logid[3],thisid);
	    }					
	});

	//Force complete trip from dispatcher
	$(document).on('click','.trip_complete',function() {
		var thisid = this.id;
		var logid = thisid.split('_');
		var amount_discount = "===";
		var Path = "<?php echo URL_BASE; ?>";
		var url_path = Path+"taxidispatch/get_passenger_detail";
		var data = "trip_id="+logid[2];
		$('#normal_trip').find('#normal_drop_location').val('');
		$('#normal_trip').find('#distance').val('');
		$('#normal_trip').find('#trip_fare').val('');
		$('#complete_local_fare').attr('readonly',true);
		$('#complete_ros_fare').attr('readonly',true);
		$('#ros_fare').attr('readonly',true);
		$('#tax_ros_complete').attr('readonly',true);
		$('#tax_local_complete').attr('readonly',true);
		$('#trip_fare').attr('readonly',true);
		$("#tax_ros_complete").val(0);
	    $("#promocode_info1").val(0);
	    $("#complete_ros_fare").val(0);
	    $('#complete_local_fare').val(0);
	    $('#tax_local_complete').val(0);
	    $('#trip_fare').val(0);
	    $('#promocode_details').val(0);
	    $('#distance').val('');
	    $('#ros_distance').val('');

		$.ajax({
			type : "POST",
			url: url_path, 
			data: data, 
			cache: false,
			async: false, 
			dataType: 'json',
			success: function(response){
				var promo_type = response.get_trip_detail.promo_type;
				var bookingtype = response.get_trip_detail.bookingtype;
				var promo_discount_value = response.get_trip_detail.promo_discount;
				var tax_value = response.tax;
				var selected_model = response.get_trip_detail.taxi_modelid;

				$('#taxi_modelid').val(selected_model);
				$('#bookingtype').val(bookingtype);
				$('#tax_info_val').text("<?php echo "("; ?>"+tax_value+"<?php echo "%)"; ?>");
				$('#local_tax_info').text("<?php echo "("; ?>"+tax_value+"<?php echo "%)"; ?>");
				$('#promo_type').val(promo_type);
				$("#promo_discount").val(response.get_trip_detail.promo_discount);
				$("#ros").val(response.get_trip_detail.rental_outstation);
				$("#rental_outstation").val(response.get_trip_detail.rental_outstation);
				$("#taxiid").val(response.get_trip_detail.taxi_id);
				if (promo_type == undefined) {
					$("#promo_div").css('display','none');
					$("#promo_div1").css('display','none');
				}
				if(promo_type == 1)
				{
					amount_discount = "<?php echo "("; ?>"+promo_discount_value+' '+"<?php echo "$company_currency)"; ?>";
				}else{
					amount_discount = "<?php echo "("; ?>"+promo_discount_value+"<?php echo "%)"; ?>";
				}
				$("#promocode_type").text(amount_discount);
				$("#promocode_type1").text(amount_discount);
			},
			error: function(response){
			}
		});

		var ros = $("#ros").val();
		var taxi_id = $("#taxiid").val();
		
		  if(ros != 0)
        {   
            $("#ros_trip_id").val(logid[2]);
            $("#ros_taxi_id").val(taxi_id);
            var data = "trip_id="+logid[2];
            $.ajax({
                type : "POST",
                url : SrcPath+"analytics/get_plan_details",
                data : data,
                dataType : 'json',
                async: false,
                success:function(response)
                {   
                    $("#plan_distance").val(response.plan_details.plan_distance);
                    $("#plan_duration").val(response.plan_details.plan_duration);
                    if(typeof(response.plan_details.plan_duration_minutes) !== 'undefined')
                        $("#plan_duration").val(response.plan_details.plan_duration_minutes);

                    $("#base_fare").val(response.plan_details.base_fare);
                    $("#additional_fare_per_distance").val(response.plan_details.additional_fare_per_distance);
                    $("#additional_fare_per_hour").val(response.plan_details.additional_fare_per_hour);
                    $("#plan_distance_unit").val(response.plan_details.plan_distance_unit);
          			  var site_default_unit = $("#site_default_unit").val();
                    base_time_distance = '('+response.plan_details.plan_distance+' '+site_default_unit+' '+response.plan_details.plan_duration+')';
		            $("#time_distance").text(base_time_distance);
		            $("#base_fare_value").val(response.plan_details.base_fare.toFixed(2));
		            $("#ros_fare").val(response.plan_details.base_fare.toFixed(2));
                },
                failure:function(response)
                {
                    
                }
            });
     
            $('#ros_trip').show();
            $('#fade_screen').show(); 
            if(ros == 1 || ros == 2)
            {
                $("#ros_duration").show();
                $("#new_trip_duration").show();
                $("#new_trip_duration2").show();
                //$("#os_duration").hide();
            }
            
            var plan_distance = $("#plan_distance").val();
            var plan_duration = $("#plan_duration").val();
            var base_fare = $("#base_fare").val(); 
            var additional_fare_per_distance = $("#additional_fare_per_distance").val();
            var additional_fare_per_hour = $("#additional_fare_per_hour").val();
            var plan_distance_unit = $("#plan_distance_unit").val();

            $("#duration_fare").val('0');
            $("#distance_fare").val('0');
        }
        else
        { 
            $("#trip_id").val(logid[2]);
            $("#taxi_id").val(taxi_id);
            //$('.export_me_menu_div').show();
            $('#normaltrip').show();
            $('#fade_screen').show();
        }

	});

	var drop_location = document.getElementById('normal_drop_location');
    var ros_drop_location = document.getElementById('ros_drop_location');
    var options = {types: [] };

   <?php if(!empty(IS_CITY_BASED) && IS_CITY_BASED == 1){ ?>

	    var cityBounds = new google.maps.LatLngBounds(
			 new google.maps.LatLng(44.185087 , 15.253279));
			  //new google.maps.LatLng(11.016844 , 76.955833));
		var options = {
		    bounds: cityBounds,
		  	//strictBounds: true,
		    types: ['geocode'],
		    componentRestrictions: { country: ISO_COUNTRY_CODE }
		};
	<?php } ?>
		
	autocomplete_pick = new google.maps.places.Autocomplete(drop_location, options);
	autocomplete_drop = new google.maps.places.Autocomplete(ros_drop_location, options);

	$(document.body).on('keyup', '#normal_drop_location' ,function(){ 
	    google.maps.event.addListener(autocomplete_pick, 'place_changed', function () { 
	        var pickup = autocomplete_pick.getPlace();//Get a place lat&long
	        document.getElementById('normal_drop_latitude').value = pickup.geometry.location.lat();
	        document.getElementById('normal_drop_longitude').value = pickup.geometry.location.lng();
	    }); 
	});


	$(document.body).on('keyup', '#ros_drop_location' ,function(){  
		google.maps.event.addListener(autocomplete_drop, 'place_changed', function () {

	        var pickup = autocomplete_drop.getPlace();//Get a place lat&long
	        document.getElementById('ros_drop_latitude').value = pickup.geometry.location.lat();
	        document.getElementById('ros_drop_longitude').value = pickup.geometry.location.lng();
	    }); 
	});
	
	$("#distance, #ros_distance").keyup(function(){ 
        
        var distance = this.value;
        var duration1 = $("#new_trip_duration").val();
        var duration2 = $("#new_trip_duration2").val();
        var d_lat = $("#normal_drop_latitude").val();
        var d_long = $("#normal_drop_longitude").val();
        var modelid = $('#taxi_model').val();
        duration1 = isNaN(parseFloat(duration1)) ? 0 : duration1;
        duration2 = isNaN(parseFloat(duration2)) ? 0 : duration2;
        var minutes = (parseFloat(duration1*60)) + parseFloat(duration2);
        var bookingtype = $("#bookingtype").val();
        var modelID = $("#taxi_modelid").val();
        var rental_outstation_trip = $("#ros").val();
       if(rental_outstation_trip == 0){
       	var tripId = $("#trip_id").val();
        var taxiId = $("#taxi_id").val();
        var rental_outstation = 0;
       }
       else
       {
       	var tripId = $("#ros_trip_id").val();
        var taxiId = $("#ros_taxi_id").val();
        var rental_outstation = 1;
       }

        var dataS = "&d_lat="+d_lat+"&d_long="+d_long+"&tripId="+tripId+"&taxiId="+taxiId+"&distance="+distance+"&rental_outstation="+rental_outstation+"&minutes="+minutes+"&current_model_id="+modelID;
        var SrcPath = URL_BASE;
        var response;

        $.ajax
        ({          
            type: "POST",
            //url: SrcPath+"driver/adminpush_notification/1", 
            url: SrcPath+"manage/getdistancefare/1", 
            data: dataS, 
            cache: false, 
            dataType: 'html',
            success: function(response) 
            {  res = JSON.parse(response);
                var fare = res.total_fare_before;
                var complete_fare=res.complete_fare;
                var promo_type = res.promo_type;
                var promo_discount = res.promo_discount;
                var deducted_fare = res.deducted_fare;
                var taxpercent = res.tax_percent;
                var actualfare = res.actual_fare;
                var additional_distance_fare = res.additional_distance_fare;
                var additional_hour_fare = res.additional_hour_fare;
                if(promo_type == 2){					 
					$("#promocode_info1").val(deducted_fare);
					$("#promocode_details").val(deducted_fare);
				}
				else{
					$("#promocode_info1").val(promo_discount);
					$("#promocode_details").val(promo_discount);
				}
				$("#tax_ros_complete").val(taxpercent);
				$("#tax_local_complete").val(taxpercent);
                $("#complete_local_fare").val(complete_fare);
                $("#duration_fare").val(additional_hour_fare);
                $("#distance_fare").val(additional_distance_fare);
                $("#complete_ros_fare").val(complete_fare);
                $("#ros_fare").val(fare);
                $("#trip_fare").val(fare);
				$('.complete_trip_submit').removeAttr("disabled");
				$('.complete_trip_submit').css("background-color", "#ed1c24");
				$('.complete_trip_submit').css("color", "#fff");
            } 
             
        });
    });

    $(".tripduration2 , .tripduration").keyup(function(){ 
        
        var distance = $("#ros_distance").val();
        var duration1 = $("#new_trip_duration").val();
        var duration2 = $("#new_trip_duration2").val();        
        duration1 = isNaN(parseFloat(duration1)) ? 0 : duration1;
        duration2 = isNaN(parseFloat(duration2)) ? 0 : duration2;
        var minutes = (parseFloat(duration1*60)) + parseFloat(duration2);
        var bookingtype = $("#bookingtype").val();
        var rental_outstation_trip = $("#ros").val();
       if(rental_outstation_trip == 0){
       	var tripId = $("#trip_id").val();
        var taxiId = $("#taxi_id").val();
        var rental_outstation = 0;
       }
       else
       {
       	var tripId = $("#ros_trip_id").val();
        var taxiId = $("#ros_taxi_id").val();
        var rental_outstation = 1;
       }
        
        var dataS = "&tripId="+tripId+"&taxiId="+taxiId+"&distance="+distance+"&rental_outstation="+rental_outstation+"&minutes="+minutes;
        var SrcPath = URL_BASE;
        var response;

        $.ajax
        ({          
            type: "POST",
            //url: SrcPath+"driver/adminpush_notification/1", 
            url: SrcPath+"manage/getdistancefare/1", 
            data: dataS, 
            cache: false, 
            dataType: 'html',
            success: function(response) 
            {  res = JSON.parse(response);
                var fare = res.total_fare_before;
                var complete_fare=res.complete_fare;
                var promo_type = res.promo_type;
                var promo_discount = res.promo_discount;
                var deducted_fare = res.deducted_fare;
                var taxpercent = res.tax_percent;
                var actualfare = res.actual_fare;
                var additional_distance_fare = res.additional_distance_fare;
                var additional_hour_fare = res.additional_hour_fare;
                if(promo_type == 2){					 
					$("#promocode_info1").val(deducted_fare);
					$("#promocode_details").val(deducted_fare);
				}
				else{
					$("#promocode_info1").val(promo_discount);
					$("#promocode_details").val(promo_discount);
				}
				$("#tax_ros_complete").val(taxpercent);
				$("#tax_local_complete").val(taxpercent);
                $("#complete_local_fare").val(complete_fare);
                $("#complete_ros_fare").val(complete_fare);
                $("#duration_fare").val(additional_hour_fare);
                $("#distance_fare").val(additional_distance_fare);
                $("#ros_fare").val(fare);
                $("#trip_fare").val(fare);
				$('.complete_trip_submit').removeAttr("disabled");
				$('.complete_trip_submit').css("background-color", "#ed1c24");
				$('.complete_trip_submit').css("color", "#fff");
            } 
             
        });
    });

    /*$("#ros_distance").blur(function(){
    	var promo_type = $("#promo_type").val();
    	var promo_discount = $("#promo_discount").val();
    	var company_tax = $("#company_tax").val();
        var plan_distance = $("#plan_distance").val();
        var plan_duration = $("#plan_duration").val();   
        var additional_fare_per_distance = $("#additional_fare_per_distance").val();
        var additional_fare_per_hour = $("#additional_fare_per_hour").val();
        var base_fare = $("#base_fare_value").val();
        var ros_distance = this.value; 
        var duration1 = $("#new_trip_duration").val();
        var duration2 = $("#new_trip_duration2").val();
        duration1 = isNaN(parseFloat(duration1)) ? 0 : duration1;
        duration2 = isNaN(parseFloat(duration2)) ? 0 : duration2;
        var trip_duration = (parseFloat(duration1*60)) + parseFloat(duration2);
        var total_fare = parseFloat(base_fare);
        $("#distance_fare").val(parseFloat('0'));
        if(parseFloat(ros_distance) > parseFloat(plan_distance))
        {  
            var distance_diff = parseInt(ros_distance) - parseInt(plan_distance); 
            additional_fare_per_distance = distance_diff * parseInt(additional_fare_per_distance);
            $("#distance_fare").val(additional_fare_per_distance.toFixed(2));
            var total_fare = parseFloat(additional_fare_per_distance) + parseFloat(total_fare);
        }
        
        if(parseFloat(trip_duration) > parseFloat(plan_duration))
        {  
            var duration_diff = parseFloat(trip_duration) - parseFloat(plan_duration); 
            duration_diff = parseFloat(duration_diff)/60;
            additional_fare_per_hour = duration_diff * parseFloat(additional_fare_per_hour);
            $("#duration_fare").val(additional_fare_per_hour.toFixed(2));
            var total_fare = parseFloat(additional_fare_per_hour) + parseFloat(total_fare);
        }

        $("#ros_fare").val(total_fare.toFixed(2));
    });
$("#ros_distance").blur(function(){
    	var promo_type = $("#promo_type").val();
    	var promo_discount = $("#promo_discount").val();
    	var company_tax = $("#company_tax").val();
        var plan_distance = $("#plan_distance").val();
        var plan_duration = $("#plan_duration").val();   
        var additional_fare_per_distance = $("#additional_fare_per_distance").val();
        var additional_fare_per_hour = $("#additional_fare_per_hour").val();
        var base_fare = $("#base_fare_value").val();
        var ros_distance = this.value; 
        var duration1 = $("#new_trip_duration").val();
        var duration2 = $("#new_trip_duration2").val();
        duration1 = isNaN(parseFloat(duration1)) ? 0 : duration1;
        duration2 = isNaN(parseFloat(duration2)) ? 0 : duration2;
        var trip_duration = (parseFloat(duration1*60)) + parseFloat(duration2);
        var total_fare = parseFloat(base_fare);
        $("#distance_fare").val(parseFloat('0'));
        if(parseFloat(ros_distance) > parseFloat(plan_distance))
        {  
            var distance_diff = parseInt(ros_distance) - parseInt(plan_distance); 
            additional_fare_per_distance = distance_diff * parseInt(additional_fare_per_distance);
            $("#distance_fare").val(additional_fare_per_distance.toFixed(2));
            var total_fare = parseFloat(additional_fare_per_distance) + parseFloat(total_fare);
        }
        
        if(parseFloat(trip_duration) > parseFloat(plan_duration))
        {  
            var duration_diff = parseFloat(trip_duration) - parseFloat(plan_duration); 
            duration_diff = parseFloat(duration_diff)/60;
            additional_fare_per_hour = duration_diff * parseFloat(additional_fare_per_hour);
            $("#duration_fare").val(additional_fare_per_hour.toFixed(2));
            var total_fare = parseFloat(additional_fare_per_hour) + parseFloat(total_fare);
        }
        if((promo_type !='') && (promo_discount !=''))
        {
	        if(promo_type ==1){
	        	var total_fare = parseFloat(total_fare) - parseFloat(promo_discount);
	        }
	        else
	        {
	        	var total_fare = parseFloat(total_fare) - ((parseFloat(promo_discount)/100)*parseFloat(total_fare));
	        }
	    }
	    var total_fare= parseFloat(total_fare) + ((parseFloat(company_tax)/100)*parseFloat(total_fare));

        //$("#complete_ros_fare").val(total_fare.toFixed(2));
    });

    $(".tripduration2 , .tripduration").blur(function(){
        var plan_distance = $("#plan_distance").val();
        var plan_duration = $("#plan_duration").val();   
        var additional_fare_per_hour = $("#additional_fare_per_hour").val();
        var additional_fare_per_distance = $("#additional_fare_per_distance").val();
        var base_fare = $("#base_fare_value").val();
        var duration1 = $("#new_trip_duration").val();
        var duration2 = $("#new_trip_duration2").val();
        var ros_distance = $("#ros_distance").val();
        duration1 = isNaN(parseFloat(duration1)) ? 0 : duration1;
        duration2 = isNaN(parseFloat(duration2)) ? 0 : duration2;
        var trip_duration = (parseFloat(duration1*60)) + parseFloat(duration2);
        var total_fare = parseFloat(base_fare);
        $("#duration_fare").val(parseFloat('0'));
        if(parseFloat(trip_duration) > parseFloat(plan_duration))
        {  
            var duration_diff = parseFloat(trip_duration) - parseFloat(plan_duration); 
            duration_diff = parseFloat(duration_diff)/60;
            additional_fare_per_hour = parseFloat(duration_diff) * parseFloat(additional_fare_per_hour);
            $("#duration_fare").val(additional_fare_per_hour.toFixed(2));
            total_fare = parseFloat(additional_fare_per_hour) + parseFloat(total_fare);
        }
        
        if(parseFloat(ros_distance) > parseFloat(plan_distance))
        {  
            var distance_diff = parseFloat(ros_distance) - parseFloat(plan_distance); 
            additional_fare_per_distance = distance_diff * parseFloat(additional_fare_per_distance);
            $("#distance_fare").val(additional_fare_per_distance.toFixed(2));
            total_fare = parseFloat(additional_fare_per_distance) + parseFloat(total_fare);
        }
        $("#ros_fare").val(total_fare.toFixed(2));
    });*/
	

	//initial dataset for markers
	var locs = {
		<?php 	$b=1; 
			$a=count($all_company_map_list);
			if(count($all_company_map_list) > 0) { 
			for($i=0;$i<$a;$i++){ ?>
			    <?php echo $b; ?>: {
					<?php
					$book_now="";
					if($all_company_map_list[$i]['driver_status']=="F" && $all_company_map_list[$i]['shift_status']=="IN"){
						$driver_info='<span style="color:green">'.__('free_in').'</span>';
						//$book_now='<button type="button" class="btn btn-outline btn-primary btn-xs" name="bookingnow" onclick="bookingnow_click(this.id);" id="driverid_'.$all_company_map_list[$i]['driver_id'].'" >'.__('booknow').'</button>';
					}elseif($all_company_map_list[$i]['driver_status']=="F" && $all_company_map_list[$i]['shift_status']=="OUT"){
						$driver_info='<span style="color:blue">'.__('free_out').'</span>';
					}elseif($all_company_map_list[$i]['driver_status']=="B"){
						$driver_info='<span style="color:#07841E">'.__('trip_assigned').'</span>';
					}elseif($all_company_map_list[$i]['driver_status']=="A"){
						$driver_info='<span style="color:red">'.__('hired').'</span>';
					}
					$update_date=$all_company_map_list[$i]['update_date'];
					$drv_info='<span class="info-content">'.ucfirst($all_company_map_list[$i]['name']).'</span>';
					$drv_info.='</br>';
					$drv_info.='<span class="info-content">'.$driver_info.'</span>';
					$drv_info.='</br>';
					$drv_info.='<span class="info-content">'.$update_date.'</span>';
					if($book_now !=""){
						$drv_info.='</br>';
						//$drv_info.='<span class="info-content">'.$book_now.'</span>';
					}
					?>
					//info: '<?php echo $all_company_map_list[$i]['name'] ; ?>',
					info: '<?php echo $drv_info; ?>',
					lat: <?php echo $all_company_map_list[$i]['latitude'] ; ?>,
					lng: <?php echo $all_company_map_list[$i]['longitude'] ; ?>,
					status: '<?php echo $all_company_map_list[$i]['driver_status'] ; ?>',
					shift_status: '<?php echo $all_company_map_list[$i]['shift_status'] ; ?>'
			    },
			<?php $b++; } } ?>
	};
	
	/*LOCATION_LATI='<?php echo $current_latitude;?>';
	LOCATION_LONG='<?php echo $current_longitude;?>';*/
	
	var mainMap;
	/*function initMap(){
		mainMap = new google.maps.Map(document.getElementById('map-canvas'), {
			zoom: 15,
			maxZoom: 18,
			minZoom: 6,
			streetViewControl: false,
			center: new google.maps.LatLng(<?php echo $current_latitude;?>,<?php echo $current_longitude;?>),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});
	}*/
        
	function refresh_map()
	{
		return true;
		var resize_map = google.maps.event.trigger(mainMap, 'resize');
		clearInterval(window.timer_resize);
	}
	
	function to_timestamp(date)
	{
		return (new Date(date.split(".").join("-")).getTime())/1000;
	}
	
	//google.maps.event.trigger(initMap, 'resize');

	function change_email_phone_exit()
	{

		event.preventDefault();
		/*alert("asddf");return false;
		var dataS = "pass_email="+pass_email+"&pass_phone="+pass_phone+"&pass_id="+pass_id;
		var url_path = "<?php echo URL_BASE; ?>taxidispatch/check_pass_phone_email_exist";
		$.ajax({
			type: "GET",
			url:url_path,
			data: dataS,
			async: true,
			success:function(data){
				alert(data);return false;
				if(data != 0){
					alert("Email/Phone already exist");
					return false;
				}
			},
			error:function() {
				//alert('failed'); 
			}
		}); */
		
		
	
	}

	//var infowindow = new google.maps.InfoWindow();
	
	//setMarkers(locs,1); // 1 as-Deafult Search Drivers
	
	function map_recur()
	{
		var status = $("#select_driver_status").val();
		if(status !=""){
			var driver_status=$("#select_driver_status").val();
		}else{
			var driver_status="";
		}

		var model = $("#select_taxi_model").val();
		if(model !=""){
			var taxi_model=$("#select_taxi_model").val();
		}else{
			var taxi_model="";
		}

		var company = $("#select_company").val();
		if(company !=""){
			var taxi_company=$("#select_company").val();
		}else{
			var taxi_company="";
		}

		//driver_status_dets();
		//all_booking_manage_list();
		
		$('#admin_company_id').val(taxi_company);
		$('#edit_admin_company_id').val(taxi_company);

		if(driver_status!='')
		{
			//$('#map-canvas').html('<img src="'+SrcPath+'/public/common/css/img/ajax-loaders/ajax-loader-1.gif" >');
			var Path = "<?php echo URL_BASE; ?>";
			
			if(driver_status!=""){
				var dataS = "driver_status="+driver_status+"&taxi_company="+taxi_company;
				var url_path = Path+"taxidispatch/driver_status_details_search_new";
			}
			
			var markers=new Array();
			$.ajax({
				type: "GET",
				url:url_path,
				data: dataS, 
				async: true,
				contentType: "application/json; charset=utf-8",
				dataType: "json",
				success:function(data){
					//For remove old markers
					removeMarkers(locations);
					setMarkers(data); // 2-As Driver status Search
					if(data != "")
					{
						$('#on_going_trip').html('');
					}
					else
					{
						$('#on_going_trip').html('<?php echo __('no_driver_found'); ?>');
					}
				},
				error:function() {
					//alert('failed'); 
				}
			});
		}else{
			var Path = "<?php echo URL_BASE; ?>";
			var url_path = Path+"taxidispatch/view_all_driverss";
			var dataS = "taxi_model="+taxi_model+"&taxi_company="+taxi_company;
			var markers;
			
			$.ajax({
				url:url_path,
				type: "GET",
				data: dataS, 
				async: true,
				contentType: "application/json; charset=utf-8",
				dataType: "json",			
				success:function(response){
					//For remove old markers
					removeMarkers(locations);
					setMarkers(response); // 2-As Driver status Search
					if(response != "")
					{
						$('#on_going_trip').html('');	
					}
					else
					{
						//$('#on_going_trip').html('<?php echo __('no_login_drivers'); ?>');	
						$('#on_going_trip').html('');	
					}
				},
				error:function() { //alert('failed'); 
				},
			});
		}
	}

	function driver_status_dets()
	{
		var company = $("#select_company").val();
		if(company !=""){
			var taxi_company=$("#select_company").val();
		}else{
			var taxi_company="";
		}
		
		var taxi_model = $("#select_taxi_model").val();
		
		var Path = "<?php echo URL_BASE; ?>";
		var all_drivers = "";
		var dataS = "driver_status="+all_drivers+"&taxi_company="+taxi_company+"&taxi_model="+taxi_model;
		var url_path = Path+"taxidispatch/driver_status_search_details";
		$.ajax({
			type: "GET",
			url:url_path,
			data: dataS, 
			async: true,
			success:function(data){
				
				if(data != ""){
					var response = data.split("#");
					$('#all_drivers').html(response[0]);	
					$('#driver_dets_count').html(response[1]);	
				}
			},
			error:function() {
				//alert('failed'); 
			}
		});
	}
	
	function driver_list_with_status()
	{
		
		if(NODE_ENVIROMENT==1)
			return false;
		
		var taxi_company=$("#select_company").val();
		var taxi_model = $("#select_taxi_model").val();
		var driver_status = $("#select_driver_status").val();
		
		var Path = "<?php echo URL_BASE; ?>";
		
		var dataS = "driver_status="+driver_status+"&taxi_company="+taxi_company+"&taxi_model="+taxi_model;
		var url_path = Path+"taxidispatch/driver_list_with_status";
		$.ajax({
			type: "GET",
			url:url_path,
			data: dataS, 
			async: true,
			success:function(data){
				if(data != ""){
					var response = data.split("#");
					$('#all_drivers').html(response[1]);	
					$('#driver_dets_count').html(response[2]);	
					var locations_val = $.parseJSON(response[0]);
					//For remove old markers
					removeMarkers(locations);
					setMarkers(locations_val); // 2-As Driver status Search
					if(locations_val != "")
					{
						$('#on_going_trip').html('');	
					}
					else
					{
						//$('#on_going_trip').html('<?php echo __('no_login_drivers'); ?>');	
						$('#on_going_trip').html('');
					}
				}
			},
			error:function() {
				//alert('failed'); 
			}
		});
	}

	function recent_activity()
	{
		var Path = "<?php echo URL_BASE; ?>";
		var dataS = "";
		var url_path = Path+"taxidispatch/get_recent_activity";
		var response;
		$.ajax({
			type: "GET",
			url: url_path, 
			data: dataS, 
			cache: false, 
			dataType: 'html',
			success: function(response){
				$('#recent_activity_content').html(response);
			}		 
		});	
	}
	
	newPage=true;
	defaultDate="";
			
	function all_booking_manage_list_search()
	{
		page_no=1;
        $('.all_booking_manage_list').html("<div class='nodata'><p>Loading data. Please wait...</p></div>");
        $('.click_on_disable').attr("disabled","disabled");
            var company = $("#select_company").val();
            var scrollEnable = $("#scroll_enabled").val();
          
		//alert(company);
		if(company !=""){
			var taxi_company=$("#select_company").val();
		}else{
			var taxi_company="";
		}
		
		var favorite = [];
		$.each($("input[name='status_color']:checked"), function(){            
			favorite.push($(this).val());
                        $("#scroll_enabled").val("0");
		});
		var status_color_cancel = $('#status_color_cancel').val();
		if($("input[name='status_cancel']:checked").length)
			favorite.push(status_color_cancel);
		
		
		var status_color=favorite.join(", ");

		var status_cancel = [];
		$.each($("input[name='status_cancel']:checked"), function(){            
			status_cancel.push($(this).val());
		});
		
		var search_txt = $('#search_txt').val();
		var search_location = $('#search_location').val();
		var filter_date = $('#filter_date').val();
		var to_date = $('#to_date').val();
		if(filter_date > to_date){			
			alert("From date should not be greater than End date");
			$("#reset_date").click();
			//return false;
		}
		
		var booking_filter = $('#booking_filter').val();			
		var taxi_model = $("#select_taxi_model").val();
		var driver_status = $("#select_driver_status").val();
		
		//alert(status_cancel);
		var Path = "<?php echo URL_BASE; ?>";
		var dataS = "travel_status="+status_color+"&status_cancel="+status_cancel+"&driver_status="+driver_status+"&taxi_company="+taxi_company+"&taxi_model="+taxi_model+"&search_txt="+search_txt+"&search_location="+search_location+"&filter_date="+filter_date+"&to_date="+to_date+"&booking_filter="+booking_filter+"&page="+page_no;
		if(NODE_ENVIROMENT==1){
			if(defaultDate!=""){
				fromDatee=filter_date.split(" ");
				toDatee=to_date.split(" ");
				fromDatee=fromDatee[0];	
				toDatee=toDatee[0];
				if(defaultDate==fromDatee && defaultDate==toDatee)
					newPage=true;	
			}
			if(search_location!="" || search_txt!="" )
					newPage=false;
			if(newPage){							
				// socket.emit('jobDetailsWeb',dataS);
				// if(defaultDate==""){
				// 	defaultDate=filter_date.split(" ");
				// 	defaultDate=defaultDate[0];				
				// }	
				newPage=false;
				return false;
			}	
			
			var url_path = URL_NODE+"operations?domain="+SUB_NODE;
			dataS +="&url_base="+Path;
			var type ="POST";
		}else{
			var url_path = Path+"taxidispatch/all_booking_list_manage";
			var type = "GET";
		}
		
		var response;
		$.ajax({
			type: type,
			url: url_path, 
			data: dataS, 
			cache: false, 
			dataType: 'html',
			success: function(response){
				$('.click_on_disable').removeAttr("disabled");
				var data = response.split("@");
				
				
					$('#all_drivers').html(data[1]);	
					$('#driver_dets_count').html(data[2]);	
					var locations_val = $.parseJSON(data[0]);
					//For remove old markers
					removeMarkers(locations);
					setMarkers(locations_val); // 2-As Driver status Search
					if(locations_val != "")
					{
						$('#on_going_trip').html('');	
					}
					else
					{
						//$('#on_going_trip').html('<?php echo __('no_login_drivers'); ?>');	
						$('#on_going_trip').html('');
					}
				
				
				$('.all_booking_manage_list').html(data[4]);
                                
                              
                                 if(scrollEnable == 0){
                                       
                                         $("#scroll_enabled").val("1");
                                    } 

				//edit booking in dashboard
				$('.oddtr').bind('click', function(){
					var isrdata = this.id;
					var findid = isrdata.split('_').pop();
					var default_unit = $('#edit_default_company_unit').val();
					var editbook=$("#edit_book_tab").attr("class");
					if(editbook=="edit_book_active"){
						$("#edit_book_tab").removeClass('edit_book_active');
						$("#edit_book_tab").removeClass('edit_booking_'+findid);
						$("#edit_book_tab").hide();
						$("#eb_tab").removeClass('active');
						$("#add_booking_tab").html('Add Booking');
					}else{
						$("#add_book_tab").hide();                                
						$("#edit_book_tab").addClass('edit_book_active');
						$("#edit_book_tab").addClass('edit_booking_'+findid);
						$("#edit_book_tab").show();
						//
						$("#eb_tab").addClass('active');
						$("#add_booking_tab").html('Edit Booking');
					}

					var dataS = "passenger_logid="+trim(findid);		
					$.ajax
					({ 			
						type: "GET",
						url: "<?php echo URL_BASE;?>taxidispatch/edit_booking", 
						data: dataS, 
						cache: false, 
						async: true,
						contentType: "application/json; charset=utf-8",
						dataType: "json",			
						success: function(response) 
						{
							var data=response;
							var details=data[0];
							$("#timeEditError").hide().html("");
							$("#add_booking").removeClass("in");
							$("#edit_booking").addClass("in");
							//to add id for reset button in edit
							$(".edit_reset_btn").attr('id','reset_'+findid);
							$('#edit_passenger_id').val(details.passengers_id);
							$('#edit_pass_logid').val(details.pass_logid);
							$('#edit_total_fare').val(details.approx_fare);
							//~ var appDistance = (default_unit == "MILES") ? (details.approx_distance*0.621371) : details.approx_distance;
							var appDistance = details.approx_distance;
							appDistance = parseFloat(appDistance).toFixed(2);
							$('#edit_distance_km').val(appDistance);
							
							$('#edit_firstname').val(details.passenger_name);
							$('#edit_email').val(details.passenger_email);
							$('#edit_phone').val(details.passenger_phone);
							$('#edit_country_code').val(details.country_code);

							$('#edit_current_location').val(details.current_location);
							$('#edit_pickup_lat').val(details.pickup_latitude);
							$('#edit_pickup_lng').val(details.pickup_longitude);
							
							$('#edit_drop_location').val(details.drop_location);
							$('#edit_drop_lat').val(details.drop_latitude);
							$('#edit_drop_lng').val(details.drop_longitude);
							$('#edit_pickup_date').val(details.pickup_time);
							$('#edit_pickup_date_db').val(details.pickup_time);
							$('#edit_luggage').val(details.luggage);
							$('#edit_no_passengers').val(details.no_passengers);
							$('#edit_notes').val(details.notes_driver);
							$('#edit_taxi_model').val(details.taxi_modelid);
							$('#edit_city_id').val(details.search_city);
							$('#edit_cityname').val(details.city_name);
							if(SUB_NODE == 'flightkenya'){
								var edit_submodel = details.taxi_submodel +"."+details.taxi_submodelname;
							$('#edit_taxi_submodel').val(edit_submodel);
							$('#edit_fixedfare1').val(details.fixedfare);
							}
							if(BABY_SEATER == 1){
								var edit_seatcount1=details.baby_seatercount1;
								$('#edit_baby_seatercount1').val(edit_seatcount1);
								var edit_seatcount2=details.baby_seatercount2;
								$('#edit_baby_seatercount2').val(edit_seatcount2);
								var edit_seatcount3=details.baby_seatercount3;
								$('#edit_baby_seatercount3').val(edit_seatcount3);
							
							}
							
							try {
							var minStrExist = details.approx_duration.indexOf("mins");
							}
							catch(err) {
							var minStrExist = false;
							}

							if(details.approx_duration != '') {	
								if(minStrExist < 0) {	//condition to check "mins"	string already exist
									$('#edit_find_duration').html(details.approx_duration+" mins");
									$('#edit_total_duration').val(details.approx_duration+" mins");
								} 
								else {
									$('#edit_find_duration').html(details.approx_duration);
									$('#edit_total_duration').val(details.approx_duration);
								}
							} else {
								$('#edit_find_duration').html('0 mins');
								$('#edit_total_duration').val('0 mins');
							}
							
							
							if(appDistance != '') {
								$('#edit_find_km').html(appDistance+" "+default_unit);
							} else {
								$('#edit_find_km').html("0 "+default_unit);
							}
							// alert('details.approx_fare2---'+details.approx_fare);
							$('#edit_min_fare').html(details.approx_fare);
							
							var durationSecs = details.approx_duration * 60;
							//to get the approximate fare
							if(minStrExist < 0) { //this calculation should be done only for later booking from app
								 calculate_totalfare_flag(details.approx_distance, details.taxi_modelid, '', details.search_city, durationSecs,details.trip_type, 'old');
							 }
							
							//to get the company value as selected in company drop down
							if(details.company_id != 0) {
								$("#select_company").val(details.company_id);
								/*map_recur();
								driver_status_dets();*/
								//driver_list_with_status();
								all_booking_manage_list_new_design();
							}

							var travel_status=details.travel_status;
							if(travel_status == 0 || travel_status == 7 || travel_status == 10){
								//$("#cancel_button").hide();
								$('#update_dispatch').removeAttr('disabled');
								var dateString = details.pickup_time,
								dateParts = dateString.split(' '),
								timeParts = dateParts[1].split(':'),
								date;
								dateParts = dateParts[0].split('-');
							}else{
								
							}				
						} 
					});
									
				});
				//edit booking in dashboard - end
				
				var $table = $('table.scroll'),
				$bodyCells = $table.find('tbody tr:first').children(),
				colWidth;

			 // Get the tbody columns width array
				colWidth = $bodyCells.map(function() {
					return $(this).width();
				}).get();
				
				// Set the width of thead columns
				$table.find('thead tr').children().each(function(i, v) {
					$(v).width(colWidth[i]);
				}); 
			}		 
		});	
	}
	
	function all_booking_manage_list(fnType){	
 
		var company = $("#select_company").val();
		var scrollEnable = $("#scroll_enabled").val();
       
		var taxi_company=taxi_company_def;
		var favorite = [];
		$.each($("input[name='status_color']:checked"), function(){            
			favorite.push($(this).val());
                        $("#scroll_enabled").val("0");
		});
		var status_color_cancel = $('#status_color_cancel').val();		
		if($("input[name='status_cancel']:checked").length)
			favorite.push(status_color_cancel);
		
		var status_color=favorite.join(", ");

		var status_cancel = [];
		$.each($("input[name='status_cancel']:checked"), function(){            
			status_cancel.push($(this).val());
		});
		
		var search_txt = $('#search_txt').val();
		
			
		var taxi_model = [];
		$.each($(".select_taxi_model.active"), function(){            
			taxi_model.push($(this).attr('data-id'));
		});
		taxi_model=taxi_model.join(",");
			
		
		//alert(status_cancel);
		var Path = "<?php echo URL_BASE; ?>";
		var dataS = "travel_status="+status_color+"&taxi_company="+taxi_company+"&taxi_model="+taxi_model+"&search_txt="+search_txt+"&page="+page_no;
		if(NODE_ENVIROMENT==1){
			
			newPage=true;
			if(search_txt!="")
				newPage=false;
			
			if(newPage){							
				//socket.emit('jobDetailsWeb',dataS);
				return false;
			}		
		
			var url_path = URL_NODE+"operations?domain="+SUB_NODE;
			dataS +="&url_base="+Path;
			var type ="POST";
		}else{
			var url_path = Path+"taxidispatch/all_booking_list_manage";
			var type ="GET";
		}
		
		var response;
		$.ajax({
			type: type,
			url: url_path, 
			data: dataS, 
			cache: false, 
			dataType: 'json',
			success: function(response){
				
				
				response=getTripDetails(response);
								
				$('.dispatcher_list ul').html(response);
				$('#showLoaderImg').hide();
				nextSetOfDisListing=0;			
			}		 
		});	
	}
	function convertDataAndMapping(response){
		$('.click_on_disable').removeAttr("disabled");
		$('#showLoaderImg').hide();
		var scrollEnable = $("#scroll_enabled").val();
		var data = response.split("@");
								
		$('#all_drivers').html(data[1]);	
		$('#driver_dets_count').html(data[2]);	
		var locations_val = $.parseJSON(data[0]);				
		//For remove old markers
		removeMarkers(locations);
		setMarkers(locations_val); // 2-As Driver status Search
		if(locations_val != "")
		{
			$('#on_going_trip').html('');	
		}
		else
		{
			//$('#on_going_trip').html('<?php echo __('no_login_drivers'); ?>');	
			$('#on_going_trip').html('');
		}

		$('.all_booking_manage_list').html(data[4]);

				//edit booking in dashboard
				$('.oddtr').bind('click', function(){				
					$("#editdrop_placeid").val('');	
					$("#editpickup_placeid").val('');
					var isrdata = this.id;
					var findid = isrdata.split('_').pop();
					var default_unit = $('#edit_default_company_unit').val();
					var editbook=$("#edit_book_tab").attr("class");
					if(editbook=="edit_book_active"){
						$("#edit_book_tab").removeClass('edit_book_active');
						$("#edit_book_tab").removeClass('edit_booking_'+findid);
						$("#edit_book_tab").hide();
						$("#eb_tab").removeClass('active');
						$("#add_booking_tab").html('Add Booking');
					}else{
						$("#add_book_tab").hide();                                
						$("#edit_book_tab").addClass('edit_book_active');
						$("#edit_book_tab").addClass('edit_booking_'+findid);
						$("#edit_book_tab").show();
						//
						$("#eb_tab").addClass('active');
						$("#add_booking_tab").html('Edit Booking');
					}

		 if(scrollEnable == 0){

			 $("#scroll_enabled").val("1");
		} 
	});

		
		var $table = $('table.scroll'),
		$bodyCells = $table.find('tbody tr:first').children(),
		colWidth;

	 // Get the tbody columns width array
		colWidth = $bodyCells.map(function() {
			return $(this).width();
		}).get();

		// Set the width of thead columns
		$table.find('thead tr').children().each(function(i, v) {
			$(v).width(colWidth[i]);
		});
		nextSetOfDisListing=0;
	}
	
	function checkPassengerStatus(trip_id, company_id,all_data)
	{
		var data = "trip_id="+trip_id+"&company_id="+company_id;
		var url_path = "<?php echo URL_BASE; ?>taxidispatch/checkPassengerStatus";
		$.ajax({
			type: "POST",
			url:url_path,
			data: data, 
			async: true,
			beforeSend : function() {
				$(".pendingCount, .inTrip, .button_1, .button_2, .processLabel").hide();
			},
			success:function(jsonData) {
				$(".logId").val(all_data);
				var data = JSON.parse(jsonData);
				var pending_count = data.pending_payment_count;
				var in_trip = data.in_trip;
				if(data != "") {
					if(pending_count > 0 && in_trip > 0) {
						$("#passengerPendingPayment").modal('show');
						$(".pendingCount, .inTrip, .button_2").show();
						$("#trip_count").text(pending_count);
					} else if(pending_count == 0 && in_trip > 0) {
						$("#passengerPendingPayment").modal('show');
						$(".pendingCount, .button_1").hide(); $(".inTrip, .button_2").show();
						$("#trip_count").text(pending_count);
					} else if(pending_count > 0 && in_trip == 0) {
						$("#passengerPendingPayment").modal('show');
						$(".pendingCount, .processLabel, .button_1").show(); $(".inTrip, .button_2").hide();
						$("#trip_count").text(pending_count);
					} else {
						pendingPayYes();
					}
				} else {
					pendingPayYes();
				}
			},
			error:function() {
				//alert('failed'); 
			}
		});
	}
	 var autoDispatch =function(e,th,val2,val3)
            {   
            	$('.dispatch_sel').prop('disabled',true);
            	e.stopImmediatePropagation();
                var seleVal = $(th).val();
                loadAvailDrivers(val2, val3, seleVal);
            }
	
	function pendingPayYes()
	{ 
		$('.book_later,.dsptch_btn').prop('disabled',true);
		$("#passengerPendingPayment").modal('hide');
		$('.dispatch_sel').prop('disabled',true);
		var logid = $(".logId").val().split('_');
		var data = "company_id="+logid[3];
		var url_path = "<?php echo URL_BASE;?>taxidispatch/checkdispatchsettings";
		$.ajax({
			type: "POST",
			url:url_path,
			data: data, 
			async: true,
			success:function(res){
				$('.book_later,.dsptch_btn').prop('disabled',false);
				var setArr = res.split(',');
				if(setArr == 1 || setArr == 2){
					loadAvailDrivers(logid[2], logid[3], setArr);
					$('.dispatch_sel').prop('disabled',false);
				}else{
					$("#dispatchSetting").modal('show');
					// $(".dispatch_sel").on('click',function(){
					// 	var seleVal = $(this).val();
					// 	loadAvailDrivers(logid[2], logid[3], seleVal);
					// });	
					$(".dispatch_sel").attr('onclick','return autoDispatch(event,this,'+logid[2]+','+logid[3]+');');
					$('.dispatch_sel').prop('disabled',false);
				}
				
				
				/*if(setArr.length > 1) {
					$("#dispatchSetting").modal('show');
					//$("#dispatchSetting").modal({show:true});
					$(".dispatch_sel").on('click',function(){
						var seleVal = $(this).val();
						loadAvailDrivers(logid[2], logid[3], seleVal);
						// window.location.href="<?php echo URL_BASE;?>taxidispatch/dashboard_beta?splid="+logid[2]+"&taxi_company="+logid[3]+"&dispatch_type="+seleVal;
					});
					//
				} else {
					loadAvailDrivers(logid[2], logid[3], setArr[0]);
					// window.location.href="<?php echo URL_BASE;?>taxidispatch/dashboard_beta?splid="+logid[2]+"&taxi_company="+logid[3]+"&dispatch_type="+setArr[0];
				}*/
			},
			error:function() {
				//alert('failed'); 
			}
		});	
	}

	function loadAvailDrivers(splid, taxi_company, dispatch_type)
	{
		$('#dispatchSetting').modal('hide');
		close_slidebar(0);
		$('.dispatch_sel').prop('disabled', true);
		
		if(dispatch_type == 1)
		{
			$(".new_loader").show();
			$.ajax({
				url : "<?php echo URL_BASE;?>taxidispatch/auto_dispatch",
				type : 'POST',
				dataType : 'json',
				data : {'log_id' : splid},
				success : function(data) {
					$('#dispatchSetting').modal('hide');
					if(data.status == 'error')
					{
						$('.dispatch_sel').attr('checked', false);
						$('.dispatch_sel').prop('disabled', false);
						//close_slidebar(0);
						//alert(data.message);
					} else {
						$('.dispatch_sel').attr('checked', false);
						$('.dispatch_sel').prop('disabled', false);
						//$('.status_btn').prop('disabled', false)
						$(".new_loader").hide();
						//close_slidebar(0);
						alert(data.message);
						window.location.href=window.location.href;
					}
				}
			});
		} else {
			$('#passenger_log_id').val(splid);
			$('#admin_companyid').val(taxi_company);
			$("#dispatchSetting").modal('hide');
			$('#myModal_dispatch').modal('show');
			$('.dispatch_sel').prop('disabled', false);
			driver_details_new_ajax();
		}
	}
	
	// Added by april-12-2018
	function pendingPayYes_direct()
	{ 
		$("#passengerPendingPayment").modal('hide');
		var companyId = $("#companyId").val();
		$('.dispatch_sel').prop('disabled',true);
		var data = "company_id="+companyId;
		var url_path = "<?php echo URL_BASE;?>taxidispatch/checkdispatchsettings";
		$.ajax({
			type: "POST",
			url:url_path,
			data: data, 
			async: true,
			success:function(res){				
				var setArr = res.split(',');
				if(setArr == 1 || setArr == 2){
					$('.dispatch_sel').prop('disabled',false);
					loadAvailDrivers_direct(companyId, setArr);
				}else{
					$("#dispatchSetting").modal('show');
					$('.dispatch_sel').prop('disabled',false);
					// $(".dispatch_sel").on('click',function(e){						
					// 	e.stopImmediatePropagation();
					// 	var seleVal = $(this).val();
					// 	loadAvailDrivers_direct(companyId, seleVal);
					// });	
					$(".dispatch_sel").attr('onclick','return loadAvailDrivers_direct_helper('+companyId+',this,event);');

				}
				
			},
			error:function() {
				//alert('failed'); 
			}
		});	
	}
	
	function loadAvailDrivers_direct_helper(companyId,th,e)
	{
		e.stopImmediatePropagation();
		var seleVal = $(th).val();
		loadAvailDrivers_direct(companyId,seleVal);
	}

	function loadAvailDrivers_direct(taxi_company, dispatch_type)
	{
		$('.dispatch_sel').prop('disabled',true);

		if(dispatch_type == 1)
		{						
			$('#create').prop('disabled',true);
			document.getElementById('defaultForm').submit();
			
		} else {
			
			$("#dispatchSetting").modal('hide');
			$('#myModal_dispatch').modal('show');
			
			var pickup_latitude        = $('#pickup_lat').val();
			var pickup_longitude        = $('#pickup_lng').val();
			var no_passengers        = $('#no_passengers').val();
			var min_fare        = $('#model_minfare').val();
			var taxi_modelid        = $('#taxi_model').val();
			var trip_type        = $('#trip_type').val();
			var luggage        = $('#luggage').val();
			var taxi_submodel = 0;
			if(SUB_NODE == 'flightkenya' && taxi_modelid == 10)
			{
                 taxi_submodel =$('#taxi_submodel').val();
			}
			
			$('.dispatch_sel').prop('disabled',false);
			driver_details_new_ajax_direct(pickup_latitude, pickup_longitude, min_fare, taxi_modelid, trip_type,taxi_submodel);
		}
	}
	
	function pendingPayNo()
	{
		$("#passengerPendingPayment").modal('hide');
	}
	
	function changeDriverLocation(driverDetails){
		
		
		allMarkers=[];		
		driverDetails.forEach(function(data){
							
			newMmarkers = {};					
								
			status="";
			book_now="";
			if(data.driverStatus  == 'A'){
				status      = "Active";
				span_class  = "driver_status_active";
				driver_info = '<span style="color:orange"><?php echo __('hired'); ?></span>';
				
			}else if ( data.driverStatus == "F" && data.shiftStatus == "IN") {
				status      = "Free In";
				span_class  = "driver_status_in";
				driver_info = '<span style="color:green"><?php echo __('free_in');?></span>';
				book_now    = '<button type="button" class="btn btn-outline btn-primary btn-xs" name="bookingnow" onclick="bookingnow_click(this.id);" id="driverid_'+ data.driverId + '" > <?php echo __('book_now'); ?></button>';
				
			} else if ( data.shiftStatus == "OUT") {
				status      = "Free Out";
				span_class  = "driver_status_out";
				driver_info = '<span style="color:blue"> <?php echo __('free_out'); ?></span>';
				
			} else if ( data.driverStatus == "B" ) {
				status      = "Busy";
				span_class  = "driver_status_busy";
				driver_info = '<span style="color:red"> <?php echo __('trip_assigned'); ?></span>';
				
			}
								
			driver_page = '<?php echo URL_BASE;?>' + "manage/driverinfo/" + data.driverId ;					
			drv_info = '<div class="info_drivercontent">';
			drv_info += '<span class="info-content">' + ( data.name).charAt(0).toUpperCase()+( data.name).slice(1) + ' - ' + data.modelName + '</span>';
			drv_info += '</br>';
			drv_info += '<span class="info-content">' + (driver_info).charAt(0).toUpperCase()+(driver_info).slice(1) + '</span>';
			drv_info += '</br>';
			drv_info += '<span class="info-content">' +data.updateDate+ '</span>';
			if ( book_now != "" ) {
				drv_info += '</br>';
			}
			drv_info += '</div>';
			newMmarkers['info']         = drv_info;
			newMmarkers['lat']			= data.latitude;
			newMmarkers['lng']			= data.longitude;
			newMmarkers['status']       = data.driverStatus;
			newMmarkers['shift_status'] = data.shiftStatus;
			allMarkers.push(newMmarkers);
		});
				
		removeMarkers(locations);
		setMarkers(allMarkers);
	}
	
	
	function setMarkers(locObj) {
	    $.each(locObj, function (key, loc) {
		
	        if (!locations[key] && loc.lat !== undefined && loc.lng !== undefined) {
	            //Marker has not yet been made (and there's enough data to create one).
				
				//Driver Status icon change when(Active,Free,Busy)
				if(loc.status=="A"){
					var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/orange.png'; ?>"; //RED
					//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/red_car.png'; ?>"; //RED
				}else if(loc.status=="F" && loc.shift_status == 'OUT'){
					var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/blue.png'; ?>"; //BLUE
					//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/blu_car.png'; ?>"; //BLUE
				}else if(loc.status=="B"){
					var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/red.png'; ?>"; // GREEN
					//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/green_car.png'; ?>"; // GREEN
				}else if(loc.status=="F" && loc.shift_status == 'IN'){
					var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/green.png'; ?>"; // YELLOW
					//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/orange_car.png'; ?>"; // YELLOW
				}else{
					var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/orange.png'; ?>"; // YELLOW
					//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/orange_car.png'; ?>"; // YELLOW
				}
				
	            //Create marker 
	            loc.marker = new google.maps.Marker({
					zoom: 15,
					maxZoom: 18,
					minZoom: 6,
	                position: new google.maps.LatLng(loc.lat, loc.lng),
	                map: mainMap,
	                icon: status_icon,
	            }); 
				
	            //Attach click listener to marker
	            google.maps.event.addListener(loc.marker, 'mouseover', (function (key) {
	                return function () {
	                    infowindow.setContent(locations[key].info);
	                    infowindow.open(mainMap, locations[key].marker);
	                }
	            })(key));

	            //Remember loc in the `locations` so its info can be displayed and so its marker can be deleted.
	            locations[key] = loc;
	        } else if (locations[key] && loc.remove) {
	            //Remove marker from map
	            if (locations[key].marker) {
	                locations[key].marker.setMap(null);
	            }
	            //Remove element from `locations`
	            delete locations[key];
	        } else if (locations[key]) {
	            //Update the previous data object with the latest data.
	            $.extend(locations[key], loc);
	            if (loc.lat !== undefined && loc.lng !== undefined) {
	                //Update marker position (maybe not necessary but doesn't hurt).
	                locations[key].marker.setPosition(new google.maps.LatLng(loc.lat, loc.lng));
	            }
	            if(loc.status !== undefined) {
					//Driver Status icon change when(Active,Free,Busy)
					if(loc.status=="A"){
						var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/red.png'; ?>"; //RED
						//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/red_car.png'; ?>"; //RED
					}else if(loc.status=="F" && loc.shift_status == 'OUT'){
						var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/blue.png'; ?>"; //BLUE
						//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/blu_car.png'; ?>"; //BLUE
					}else if(loc.status=="B"){
						var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/green.png'; ?>"; // GREEN
						//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/green_car.png'; ?>"; // GREEN
					}else if(loc.status=="F" && loc.shift_status == 'IN'){
						var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/orange.png'; ?>"; // YELLOW
						//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/orange_car.png'; ?>"; // YELLOW
					}else{
						var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/orange.png'; ?>"; // YELLOW
						//var status_icon="<?php echo BOOTSTRAP_IMGPATH.'/orange_car.png'; ?>"; // YELLOW
					}
	                locations[key].marker.setIcon(status_icon);
	            }
	            //locations[key].info looks after itself.
	        }
	    });
	}
	function removeMarkers(locObj)
	{
		$.each(locObj, function (key, loc) {
			
			if (locations[key]!=undefined && locations[key].marker) {
				locations[key].marker.setMap(null);
			}
			//Remove element from `locations`
			delete locations[key];
		});
	}

	function bookingnow_click(drv_id)
	{
		var driver_id = drv_id.split('_').pop();
		$('#driver_id').val(driver_id);
		
		var addbook=$("#add_book_tab").attr("class");
		if(addbook=="add_book_active"){
			$("#add_book_tab").removeClass('add_book_active');
			$("#add_book_tab").hide();
			$("#ab_tab").removeClass('active');
		}else{
			$("#edit_book_tab").hide();
			$("#edit_book_tab").removeClass('edit_book_active');                                
			$("#add_book_tab").addClass('add_book_active');
			$("#add_book_tab").show();
			$("#ab_tab").addClass('active');
		}
	}

	
	function codeLatLng(lat,lng,id) 
	{	 
		 var latlng = new google.maps.LatLng(lat, lng);
		  geocoder.geocode({'latLng': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				//alert(google.maps.GeocoderStatus);
			  if (results[1]) 
			  {		  
				 $('#'+id).val(results[1].formatted_address); 
				 pickup_drop_location_marker(results[1].formatted_address,id,latlng)
				 $('#'+id+'_lat').val(lat); 
				 $('#'+id+'_lng').val(lng); 
							
			  } else {
				alert('<?php echo __("no_result_found"); ?>');
			  }
			  attempts = 0;
			}
			else if (status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
				  setTimeout(function() {
						codeLatLng(lat,lng,id);
				  }, 200); 
			}
			 else {
			  alert('<?php echo __("gecoder_failed"); ?>' + status);
			  attempts = 0;
			}
		  });
	}

	function pickup_drop_location_marker(place, id, latlng) {
		
		var iconBase = '<?php echo PUBLIC_IMGPATH.' / ' ; ?>';
		if (id == 'drop_location') {
			end = latlng;
		}
		if (id == 'current_location') {
			start = latlng;
		}
		// First, remove any existing markers from the map.
		for (var i = 0; i < markerArray.length; i++) {
			markerArray[i].setMap(null);
		}
		markerArray = [];
		var request = {
			origin: start,
			destination: end,
			travelMode: google.maps.TravelMode.DRIVING
		};
		clearMarkerNews();
		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				//var warnings = document.getElementById('warnings_panel');
				//warnings.innerHTML = '<b>' + response.routes[0].warnings + '</b>';
				directionsDisplay.setDirections(response);
				showSteps(response);
			}
		});
	}

	function showSteps(directionResult) {
	  markerArray = [];
	  var myRoute = directionResult.routes[0].legs[0];
	  for (var i = 0; i < myRoute.steps.length; i++) {
		var marker = new google.maps.Marker({
		  position: myRoute.steps[i].start_location,
		  map: mainMap
		});
		clearMarkerNews();
		attachInstructionText(marker, myRoute.steps[i].instructions);
		markerArray[i] = marker;
	  }
	}

	function attachInstructionText(marker, text) {
	  google.maps.event.addListener(marker, 'click', function() {
		// Open an info window when the marker is clicked on,
		// containing the text of the step.
		stepDisplay.setContent(text);
		stepDisplay.open(mainMap, marker);
	  });
	}
	
	
	
	//function to get edit booking tab open while edit booking from manage booking page
	function edit_booking_from_manage(findid)
	{	
		var default_unit = $('#edit_default_company_unit').val();	
		var dataS = "passenger_logid="+trim(findid);
		$("#eb_tab").addClass('active');
		$("#add_booking_tab").html('Edit Booking');	
		$.ajax
		({ 			
			type: "GET",
			url: "<?php echo URL_BASE;?>taxidispatch/edit_booking", 
			data: dataS, 
			cache: false, 
			async: true,
			contentType: "application/json; charset=utf-8",
			dataType: "json",			
			success: function(response) 
			{
				if(response == '') {
					//redirect to dashboard if unknown trip id passed through url
					window.location.href = 'dashboard_beta';
				}
				$("#edit_book_tab").show();
				var data=response;
				var details=data[0];
				
				$("#add_booking").removeClass("in");
				$("#edit_booking").addClass("in");
				
				$('#edit_passenger_id').val(details.passengers_id);
				$('#edit_pass_logid').val(details.pass_logid);
				$('#edit_total_fare').val(details.approx_fare);
				var appDistance = (default_unit == "MILES") ? (details.approx_distance*0.621371) : details.approx_distance;
				appDistance = parseFloat(appDistance).toFixed(2);
				$('#edit_distance_km').val(appDistance);
				
				$('#edit_firstname').val(details.passenger_name);
				$('#edit_email').val(details.passenger_email);
				$('#edit_phone').val(details.passenger_phone);
				$('#edit_country_code').val(details.country_code);

				$('#edit_current_location').val(details.current_location);
				$('#edit_pickup_lat').val(details.pickup_latitude);
				$('#edit_pickup_lng').val(details.pickup_longitude);
				
				$('#edit_drop_location').val(details.drop_location);
				$('#edit_drop_lat').val(details.drop_latitude);
				$('#edit_drop_lng').val(details.drop_longitude);
				$('#edit_pickup_date').val(details.pickup_time);
				$('#edit_pickup_date_db').val(details.pickup_time);
				$('#edit_luggage').val(details.luggage);
				$('#edit_no_passengers').val(details.no_passengers);
				$('#edit_notes').val(details.notes_driver);
				$('#edit_taxi_model').val(details.taxi_modelid);
				if(SUB_NODE == 'flightkenya'){
					var edit_submodel = details.taxi_submodel +"."+details.taxi_submodelname;
				$('#edit_taxi_submodel').val(edit_submodel);
				$('#edit_fixedfare1').val(details.fixedfare);
				}

				if(BABY_SEATER == 1){
					var edit_seatcount1=details.baby_seatercount1;
				$('#edit_baby_seatercount1').val(edit_seatcount1);
				var edit_seatcount2=details.baby_seatercount2;
				$('#edit_baby_seatercount2').val(edit_seatcount2);
				var edit_seatcount3=details.baby_seatercount3;
				$('#edit_baby_seatercount3').val(edit_seatcount3);
				
				}

				$('#edit_city_id').val(details.search_city);
				try {
				var minStrExist = details.approx_duration.indexOf("mins");
				}
				catch(err) {
				var minStrExist = false;
				}
				if(details.approx_duration != '') {	
					if(minStrExist < 0) {	//condition to check "mins"	string already exist
						$('#edit_find_duration').html(details.approx_duration+" mins");
						$('#edit_total_duration').val(details.approx_duration+" mins");
					} 
					else {
						$('#edit_find_duration').html(details.approx_duration);
						$('#edit_total_duration').val(details.approx_duration);
					}
				} else {
					$('#edit_find_duration').html('0 mins');
					$('#edit_total_duration').val('0 mins');
				}
				
				if(appDistance != '') {
					$('#edit_find_km').html(appDistance+" "+default_unit);
				} else {
					$('#edit_find_km').html("0 "+default_unit);
				}
				// alert('details.approx_fare4---'+details.approx_fare);
				$('#edit_min_fare').html(details.approx_fare);
				
				var durationSecs = details.approx_duration * 60;
				//to get the approximate fare
				if(minStrExist < 0) { //this calculation should be done only for later booking from app
					 calculate_totalfare_flag(details.approx_distance, details.taxi_modelid, '', details.search_city, durationSecs, $("#edit_trip_type").val(), 'third');
				}
				
				//to get the company value as selected in company drop down
				if(details.company_id != 0) {
					$("#select_company").val(details.company_id);
					map_recur();
				}
				
				var travel_status=details.travel_status;
				if(travel_status == 0 || travel_status == 7 || travel_status == 10){
					//$("#cancel_button").hide();
					$('#update_dispatch').removeAttr('disabled');
				}else{
					/*if(travel_status == 9) {
						$("#cancel_button").show();
					} */
					$('#update_dispatch').attr('disabled','disabled');
				}
				
				//to hide the dispatch button if pickup time is future
				var dateString = details.pickup_time,
				dateParts = dateString.split(' '),
				timeParts = dateParts[1].split(':'),
				date;
				dateParts = dateParts[0].split('-');
				/* //script to hide dispatch button if future time is selected as pickuptime
				date = new Date(dateParts[0], parseInt(dateParts[1], 10) - 1, dateParts[2], timeParts[0], timeParts[1], timeParts[2]);
				var today = new Date();
				if(date.getTime() > today.getTime()){
					$('#update_dispatch').attr('disabled','disabled');
				} else {
					$('#update_dispatch').removeAttr('disabled');
				} */
			} 
		});
	}
	
</script>

<?php /** Display passenger pending trip alert start **/ ?>
<input type="hidden" name="logId" class="logId" value=""/>
<div class="modal fade" id="passengerPendingPayment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" ><?php echo __('pending_payment_details_popup'); ?></h4>
			</div>
			<div class="modal-body">
				<p class="inTrip" style="display:none;color:#fc5446"><?php echo __('passenger_already_in_trip'); ?></p>
				<p class="pendingCount" style="display:none;"><?php echo __("not_paid_trip"); ?> <span id="trip_count"></span> <?php echo __("trips_popup"); ?><span class="processLabel"><?php echo __("sure_want_to_process"); ?></span></p>
			</div>
			<div class="modal-footer">
				<p class="button_1" style="display:none;">
					<button type="button" onclick="pendingPayYes();" class="btn btn-default">Yes</button>
					<button type="button" onclick="pendingPayNo();" class="btn btn-default" data-dismiss="modal">No</button>
				</p>
				<p class="button_2" style="display:none;">
					<button type="button" onclick="pendingPayNo();" class="btn btn-default" data-dismiss="modal">Ok</button>
				</p>
			</div>
		</div>
	</div>
</div>
<!--CR-Chauffeur-->
<div class="modal" id="route_map_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="route_map_close" data-dismiss="modal" aria-label="Close" style="float: right;">&times;</button>
		<h4 class="modal-title" ><?php echo __('dispatcher_route_map'); ?></h4>
		</div>
		<div class="modal-body">
		<div id="route_map" style="overflow:auto;height:400px;position:relative;"></div>
		</div>
		<div class="modal-footer">
	       <button type="button" style="margin-right: 15px" class="btn btn-default route_map_close" data-dismiss="modal">Close</button>
	    </div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(".route_map_close").click(function() {
	    	$('#route_map_modal').css('display','none');
	    	$(".need_route_map").removeAttr('checked')
	    });
</script>
<!--CR-Chauffeur-->
<?php /** Display passenger pending trip alert end **/ ?>

<!---Popup on Driver Search-->

<div class="modal fade" id="dispatchSetting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" ><?php echo __('tdispatch_setting'); ?></h4>
      </div>
      <div class="modal-body">
		  <label><input type="radio" name="dispatch_setting" class="  dispatch_sel" value="1"><span><?php echo __('auto_label'); ?></span></label>
		  <label><input type="radio" name="dispatch_setting" class="dispatch_sel dispatch_trigger" value="2"><span><?php echo __('manual_label'); ?></span></label>
		  
      </div>
      <div class="modal-footer">
       <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
      </div>
    </div>
  </div>
</div>

<?php //echo $show_popup['show_pass_logid'];exit;
if(isset($show_popup['show_pass_logid'])) { ?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo __('choose_driver_from_list'); ?></h4>
      </div>
      <div class="modal-body">
			<div class="controls">
				<div class="new_input_field">
				  <span class="add-on"></span>
				  <input type="text" name="search_driver" id="search_driver" value="" onKeyUp="driver_details_new_ajax()">
				</div>
				<input type="hidden" name="passenger_log_id" id="passenger_log_id" value="<?php echo $show_popup['show_pass_logid']; ?>">
			</div>
			<div id="show_process">
			<div id="driver_details"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">    
    $(document).ready(function(){
		driver_details_new();
    });    
 </script>
<?php } ?>


<?php //if(isset($show_popup['splid'])) { ?>
	<!-- Modal -->
	<div class="modal fade dispatch-opt-model" id="myModal_dispatch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="model_close_one_beta"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><?php echo __('choose_driver_from_list'); ?></h4>
	      </div>
	      <div class="modal-body">
				<div class="controls">
					<div class="form-group">
					  <input type="text" name="search_driver" id="search_driver" class="form-control" value="" onKeyUp="driver_details_new()">
					</div>
					<input type="hidden" name="passenger_log_id" id="passenger_log_id" value="">
					<input type="hidden" name="admin_companyid" id="admin_companyid" value="">
				</div>
				<div id="show_process">
				<div id="dispatch_driver_details"><img src="<?php echo URL_BASE; ?>public/admin/images/loader.gif"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default"  id="model_close_two_new_design"><?php echo __('close'); ?></button>
	      </div>
	    </div>
	  </div>
	</div>

	<script type="text/javascript">    
	    $(document).ready(function(){
	    	$('#myModal').modal('hide');
			// driver_details_new_ajax();
	    });

	    $("#model_close_two_new_design").click(function() {
	    	$('.dispatch_sel').attr('checked', false);
	    	$('#myModal_dispatch').modal('hide');
	        // window.location = URL_BASE + "taxidispatch/dashboard_beta";
	    });

		/**************************** Search Driver when the dispatcher going to select the driver *******************************/

		$('#driver_details p').click(function() {
			var detailsid = this.id;
			var findimg = detailsid.split('_');

			var pass_logid = $('#passenger_log_id').val();	
			
			var dataS = "pass_logid="+pass_logid+"&driver_id="+findimg[0]+"&taxi_id="+findimg[1]+"&driver_away_in_km="+findimg[2];	
			
			$("#show_process").html('<img src="<?php echo IMGPATH; ?>loader.gif">');
			$.ajax
			({ 			
				type: "GET",
				url: "<?php echo URL_BASE;?>taxidispatch/updatebooking", 
				data: dataS, 
				cache: false, 
				dataType: 'html',
				success: function(response) 
				{ 		
					$("#show_process").html('');
					//document.location.href="<?php echo URL_BASE;?>tdispatch/managebooking/#stuff";
					window.location="<?php echo URL_BASE;?>taxidispatch/dashboard_beta";
				} 
				 
			});	
		});
	</script> 
<?php //} ?>
	


<script type="text/javascript">
var idleTime = 0;
$(document).ready(function () {
	//~ $("#anonymous_id").css('color','red');
	$('#vehicle_status_list li').click(function(){
		$('#vehicle_status_list li').removeClass('active');
		$(this).addClass('active');
		$('#status_type').removeClass('active');
		//$(".status_list").hide();
		$("#status_type").html($(this).find('a').html());
		$("#status_type").attr('data-val',$(this).attr('li-val'));
		$(".schedule_list.status_list").toggleClass('active');		
		
		/*if($('.model_type.active').length==0){
			$('#showNotification').html('Kindly choose any one of the vehicle type');
			markerDetails=[];
			clearMarkerNew();
			return false;
		}*/			
	});
	$('#vehicle_model_list li').click(function(){
		$('#vehicle_model_list li').removeClass('active');
		$(this).addClass('active');
		$('#vehicle_type').removeClass('active');
		//$(".vehicle_list").hide();
		$(".vehicle_type  #vehicle_type").html($(this).find('a').html());
		$(".vehicle_type #vehicle_type").attr('data-id',$(this).val());
		$(".schedule_list.vehicle_list").toggleClass('active');


	});
	$('#fleet_vehicle_model_list li').click(function(){
		$('.vehic_type #vehicle_type').removeClass('active');
		$('#fleet_vehicle_model_list li').removeClass('active');
		$(this).addClass('active');
		//$(".fleet_vehicle_list").hide();
		$(".vehic_type #vehicle_type").html($(this).find('a').html());
		$(".vehic_type #vehicle_type").attr('value',$(this).attr('value'));
		$(".vehic_type #vehicle_type").attr('data-id',$(this).attr('value'));
		$(".vehic_type #vehicle_type").val($(this).attr('value'));
		$(".schedule_list.fleet_vehicle_list").toggleClass('active');
		fleet_listing_new_design();

	});
	$('.track_list li').click(function(){
		var temp_name = $("#track_type").html();
		var temp_id = $("#track_type").attr('data-id');
		$('#track_type').removeClass('active');
		
		/*$(".track_list").hide();*/
		$(" #track_type").html($(this).find('a').html());
		$("#track_type").attr('data-id',$(this).val());
		$(".track_list li a").html(temp_name);
		$(".track_list li").val(temp_id);
		$(".schedule_list.track_list").toggleClass('active');
		fleet_listing_new_design();

	});
	

	$('#anonymous_id').click(function(){
		$('#search_txt_div').hide();
		if($("#defaultForm_edit").css('display')=='none'){
			$("#defaultForm").show();		
			$("#defaultForm").find('input[type=text], textarea').val('');
			$("#country_code_new").val(<?php echo TELEPHONECODE?>);
			$(".form-control.error").removeClass('error');
			$(".add_job_block").removeClass('active');
			$(".error").html('').removeClass("error");

			$('#firstname_new, #email_new, #country_code_new, #phone_new').prop('readonly', false);
			$('#pickup_date').val(getCurrentTimeDateFormat());
			//radhamani
			$('#defaultForm input[name=package_plan]').removeClass('active');
	    	$('#defaultForm #anonymous_id .package_plan').addClass('active');
	    	//radhamani

		}else{
			//radhamani
			$('#defaultForm_edit input[name=package_plan]').removeClass('active');
	    	$('#defaultForm_edit #anonymous_id .package_plan').addClass('active');
	    	//radhamani			
		}

		// Clear estimate details
		$("#find_duration").html("<?php echo __('zero_mins'); ?>");
		$("#find_km").html("<?php echo __('zero_distance'); ?>");
		$("#min_fare").html("<?php echo '0'; ?>");	
		/*//radhamani
		$('input[name=package_plan]').removeClass('active');
    	$('#anonymous_id .package_plan').addClass('active');
    	//radhamani*/
	});
	
	$('#account_sec_id').click(function(){		
		//$("#defaultForm").show();
		//$("#defaultForm").find('input[type=text], textarea').val('');
		$('#pass_search_txt').val('');
		$('#firstname_new, #email_new, #country_code_new, #phone_new').prop('readonly', true);
		$('#pickup_date').val(getCurrentTimeDateFormat())
		$(".form-control.error").removeClass('error');
		$(".add_job_block").addClass('active');
		$(".error").html('').removeClass("error");
		//$("#defaultForm").hide();
		$('#Anonymous_presentation_id').removeClass('disabled');
		$('#search_txt_div').show();
		if($("#defaultForm_edit").css('display')=='none'){
			//radhamani
			$('#firstname_new, #email_new, #country_code_new, #phone_new').val('');
			$('#defaultForm input[name=package_plan]').removeClass('active');
	    	$('#defaultForm #account_sec_id .package_plan').addClass('active');
	    	//radhamani	
			$('#search_txt_div').show();

		}
		else{
			//radhamani
			$('#defaultForm_edit input[name=package_plan]').removeClass('active');
	    	$('#defaultForm_edit #account_sec_id .package_plan').addClass('active');
	    	//radhamani		

			$('#Anonymous_presentation_id').addClass('disabled');
		
				

		}
		// Clear estimate details
		$("#find_duration").html("<?php echo __('zero_mins'); ?>");
		$("#find_km").html("<?php echo __('zero_distance'); ?>");
		$("#min_fare").html("<?php echo '0'; ?>");
		/*//radhamani
		$('input[name=package_plan]').removeClass('active');
    	$('#account_sec_id .package_plan').addClass('active');
    	//radhamani*/

				
	});

	
	function getCurrentTimeDateFormat(){
		gmt=new Date();
		
		time=gmt.getTime() + (gmt.getTimezoneOffset() * 60000);
		var currentTime = new Date((time) +parseInt('<?php echo date("Z")*1000;?>'));    
		var currentTime1 = new Date((time) +parseInt('<?php echo date("Z")*1000;?>'));    
		var currentHours = currentTime.getHours ( );   
		var currentMinutes = currentTime.getMinutes ( );   
		var currentSeconds = currentTime.getSeconds ( );
		var currentDate = currentTime.getDate();
		var currentMonth = currentTime.getMonth()+1;
		var currentYear = currentTime.getFullYear();			
		currentDate = ( currentDate < 10 ? "0" : "" ) + currentDate;   
		currentMonth = ( currentMonth < 10 ? "0" : "" ) + currentMonth;			
		totDate= currentYear+"-"+currentMonth+"-"+currentDate;
		currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;   
		currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;    
		currentHours = ( currentHours < 10 ? "0" : "" ) + currentHours;    
		   
		var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds;
		
		return totDate+" "+currentTimeString;
		   
	}	
	
    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function timerIncrement() {
	
    idleTime = idleTime + 1;
    if (idleTime > 24) { // 24 minutes		
        window.location.reload();
    }
}
</script>
 
 
<script type="text/javascript">
  var format = '<?php echo DEFAULT_DATE_TIME_FORMAT; ?>';
  var default_date_format = format.split(" ");
  var date_format_search = default_date_format[0];
  var date_format = date_format_search.replace("Y", "yy");
  date_format = date_format.replace("m", "mm");
  date_format = date_format.replace("d", "dd");
  var time_format_search = default_date_format[1];
  var time_format = time_format_search.replace("i","mm");
  var trip_type_err = "<?php echo __('trip_validation_err'); ?>";
  var km_restrict_value = '<?php echo $km_restrict_constant; ?>';
  
  var map;
  var directionDisplay;
  var directionsService;
  var stepDisplay;
 
  var position;
  var marker = [];
  var polyline = [];
  var poly2 = [];
  var poly = null;
  var startLocation = [];
  var endLocation = [];
  var timerHandle = [];
    
  
  var speed = 0.000001, wait = 1;  
  //var infowindow = null;
  
  var myPano;   
  var panoClient;
  var nextPanoId;

  


  var Colors = ["#FF0000", "#00FF00", "#0000FF"];




function createMarker(latlng, label, html,type,driver_id,info,status,active_status) {
// alert("createMarker("+latlng+","+label+","+html+","+color+")");
var i=driver_id;

//clearMarkeranimate();



    var contentString = '<b>'+label+'</b><br>'+html;
  mapIcon=icons['normal'].icon;
  
								
				if(active_status.indexOf(status) != -1){
					mapIcon=icons[status].icon
				}	
  
    var marker = new google.maps.Marker({
        position: latlng,
        map: mapNew,
        icon:mapIcon,
        title: label,
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });
        marker.myname = label;


  /*  google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString); 
        infowindow.open(mapNew,marker);
        });*/
        //obj[driver_id]=marker;
        //markersnew.push({driver_id:marker});
        loc = new google.maps.LatLng(marker.position.lat(), marker.position.lng());
				bounds.extend(loc);
				var infowindow = new google.maps.InfoWindow({
					  //content: data[2]
					  content:info
				});
				marker.addListener('click', function() {
				 	infowindow.open(map, marker);
				});
				//markers.push(marker);
				markers[driver_id]=marker;
				
        //markersnew.push(marker);
    return marker;
}  
  var rendererOptions;
function setRoutes(markersOld,endLoc,driver_id_array){
	//clearMarkerNew();
    var directionsDisplay = new Array();

    for (var i=0; i< driver_id_array.length; i++){

    rendererOptions = {
        map: mapNew,
        suppressMarkers : true,
        preserveViewport: true
    }
    directionsService = new google.maps.DirectionsService();
    

    var travelMode = google.maps.DirectionsTravelMode.DRIVING;  
  
	
	driver_id=driver_id_array[i][0];
	info=driver_id_array[i][1];
	status=driver_id_array[i][2];
	active_status=driver_id_array[i][3];
	
    startLoc_lat=markersOld[driver_id][0];
    startLoc_lng=markersOld[driver_id][1];
    
		var request = {
        origin: {lat:startLoc_lat,lng:startLoc_lng},          
        destination: {lat:endLoc[driver_id][0],lng:endLoc[driver_id][1]},
        travelMode: travelMode
    };
        //directionsService.route(request,makeRouteCallback(i,directionsDisplay[i]));
        directionsService.route(request,makeRouteCallback(i,directionsDisplay[i],driver_id,info,status,active_status));

    }   


    function makeRouteCallback(routeNum,disp,driver_id,info,dr_status,active_status){
		
			
       /*if (polyline[routeNum] && (polyline[routeNum].getMap() != null)) {
			
		
         startAnimation(routeNum);
         return;
        }*/
        return function(response, status){
				
          
          if (status == google.maps.DirectionsStatus.OK){

            var bounds = new google.maps.LatLngBounds();
            var route = response.routes[0];
            startLocation[routeNum] = new Object();
            endLocation[routeNum] = new Object();


            polyline[routeNum] = new google.maps.Polyline({
            path: [],
            /*strokeColor: '#FFFF00',
            strokeWeight: 3*/
            });

            poly2[routeNum] = new google.maps.Polyline({
            path: [],
            /*strokeColor: '#FFFF00',
            strokeWeight: 3*/
            });     

			
			
            // For each route, display summary information.
            var path = response.routes[0].overview_path;
            var legs = response.routes[0].legs;


            disp = new google.maps.DirectionsRenderer(rendererOptions);     
            disp.setMap(mapNew);
            disp.setDirections(response);


            //Markers               
            for (i=0;i<legs.length;i++) {
				
              if (i == 0) { 
				  
                startLocation[routeNum].latlng = legs[i].start_location;
                startLocation[routeNum].address = legs[i].start_address;
                // marker = google.maps.Marker({map:map,position: startLocation.latlng});
                marker[routeNum] = createMarker(legs[i].start_location,"start",legs[i].start_address,"green",driver_id,info,dr_status,active_status);
              }
              endLocation[routeNum].latlng = legs[i].end_location;
              endLocation[routeNum].address = legs[i].end_address;
              
              var steps = legs[i].steps;

              for (j=0;j<steps.length;j++) {
                var nextSegment = steps[j].path;                
                var nextSegment = steps[j].path;

                for (k=0;k<nextSegment.length;k++) {
                    polyline[routeNum].getPath().push(nextSegment[k]);
                    //bounds.extend(nextSegment[k]);
                }

              }
            }

         }       

         //polyline[routeNum].setMap(mapNew);
         //map.fitBounds(bounds);
         polyline[routeNum].setMap(null);
         startAnimation(routeNum);  

    } // else alert("Directions request failed: "+status);

  }

}

    var lastVertex = 1;
    var stepnum=0;
    var step = 50; // 5; // metres
    var tick = 100; // milliseconds
    var eol= [];
//----------------------------------------------------------------------                
 function updatePoly(i,d) {
 // Spawn a new polyline every 20 vertices, because updating a 100-vertex poly is too slow
    if (poly2[i].getPath().getLength() > 20) {
          poly2[i]=new google.maps.Polyline([polyline[i].getPath().getAt(lastVertex-1)]);
          // map.addOverlay(poly2)
        }

    if (polyline[i].GetIndexAtDistance(d) < lastVertex+2) {
        if (poly2[i].getPath().getLength()>1) {
            poly2[i].getPath().removeAt(poly2[i].getPath().getLength()-1)
        }
            poly2[i].getPath().insertAt(poly2[i].getPath().getLength(),polyline[i].GetPointAtDistance(d));
    } else {
        poly2[i].getPath().insertAt(poly2[i].getPath().getLength(),endLocation[i].latlng);
    }
 }
//----------------------------------------------------------------------------

function animate(index,d) {
   if (d>eol[index]) {

      marker[index].setPosition(endLocation[index].latlng);
      return;
   }
    var p = polyline[index].GetPointAtDistance(d);

    //map.panTo(p);
    marker[index].setPosition(p);
    updatePoly(index,d);
    timerHandle[index] = setTimeout("animate("+index+","+(d+step)+")", tick);
}

//-------------------------------------------------------------------------

function startAnimation(index) {
        if (timerHandle[index]) clearTimeout(timerHandle[index]);
        eol[index]=polyline[index].Distance();
        //map.setCenter(polyline[index].getPath().getAt(0));
        mapNew.setCenter(polyline[index].getPath().getAt(0));

        poly2[index] = new google.maps.Polyline({path: [polyline[index].getPath().getAt(0)], strokeColor:"#FFFF00", strokeWeight:3});

        timerHandle[index] = setTimeout("animate("+index+",50)",2000);  // Allow time for the initial map display
}
/* rental / outstations */

function loadModels(current,from,plan)
{
	$('#min_fare').html(0);
	$('#taxi_model').find('[enable_rental]').prop('disabled',false);
	$('#taxi_model').find('[enable_outstation]').prop('disabled',false);
	$("#edit_package_base_fare").val('0');
	$("#edit_package_distance").val('0');
	$("#edit_package_plan_duration").val('0');
	$("#edit_package_addl_hour_fare").val('0');
	$("#edit_package_addl_distance_fare").val('0');
	if(current == 3)
	{
		$('.dsptch_btn').attr('disabled', 'disabled');
	} else {
		$('.dsptch_btn').removeAttr('disabled');
	}
	$('.trip-packages-div').hide();
	$('.edit-trip-packages-div').hide();
	$('#trip_packages').children('option:not(:first)').remove();
	$('#edit_trip_packages').children('option:not(:first)').remove();
	if(current == 1 || current == 2)
	{
		if(current == 1)
		{
			$('.edit-trip-packages-div').hide();
			$('.trip-packages-div').hide();
		}
		$("#edit_round_one_way_select").hide();
		$(".edit_days_count").hide();
		$(".edit_days_count_desc").hide();
		$("#round_one_way_select").hide();
		$(".days_count").hide();
		$(".days_count_desc").hide();
	} else {
		if(from == 'add')
		{
			outstation_type_options();
		} else {
			edit_outstation_type_options();
		}
	}

 	// $('#trip_packages').html('');
 	if(current == 2 || current == 3  || current == 1)
 	{
 		$(".error_field").css('display','none');
        $("#trip_validation").html("");    
        $("#edit_trip_validation").html("");    
        $("#trip_err_val").val(0);
 		if(current != 1)
		$("#tax_inclusive").html(taxExclusive);
		else
		$("#tax_inclusive").html(taxInclusive);

 		$.ajax({
			url : "<?php echo URL_BASE; ?>taxidispatch/get_model_details",
			type : 'POST',
			dataType : 'JSON',
			success : function(data) {
				if(from == 'add')
				{
					var value=$('#trip_type').val();
					$('#taxi_model').children('option:not(:first)').remove();
					$("#taxi_model option:first").after(data);
					if(parseInt(value)===1)
					{
					 	$('#taxi_model').find('[enable_local=0]').prop('disabled',true);
					 }
					if(parseInt(value)===2)
					{
					 	$('#taxi_model').find('[enable_rental=0]').prop('disabled',true);
					}
					if(parseInt(value)===3)
					{
					 	$('#taxi_model').find('[enable_outstation=0]').prop('disabled',true);
					}	
				} else {
					$('#edit_taxi_model').children('option:not(:first)').remove();
					$("#edit_taxi_model option:first").after(data);
					edit_initialize();
					var value=$('#edit_trip_type_dis').val();
					if(parseInt(value)===1)
					{
					 	$('#edit_taxi_model').find('[enable_local=0]').prop('disabled',true);
					 }
					if(parseInt(value)===2)
					{
					 	$('#edit_taxi_model').find('[enable_rental=0]').prop('disabled',true);
					}
					if(parseInt(value)===3)
					{
					 	$('#edit_taxi_model').find('[enable_outstation=0]').prop('disabled',true);
					}
					$('#edit_taxi_model').val(plan);

				}

			
			},
			error : function(data) {
				
			}
		});
 	} else {

		$("#tax_inclusive").html(taxInclusive);
 		change_minfare(current, from);
 	}
}

function loadpackages_model(selected, from, plan)
{
	if(selected == 10 && SUB_NODE == 'flightkenya')
	{
      $('.taxi-sub-model').show();
      $('.fixed_fare').show();
	}else{
		$('.taxi-sub-model').hide();
		$('.fixed_fare').hide();
	}
	if(from == 'add')
	{
		var trip_type = $("#trip_type").val();
	} else {
		var trip_type = $("#edit_trip_type").val();
	}


	var value=$('#edit_trip_type').val();
	if(parseInt(value)===1)
	{
	 	$('#edit_taxi_model').find('[enable_local=0]').prop('disabled',true);
	 }
	if(parseInt(value)===2)
	{
	 	$('#edit_taxi_model').find('[enable_rental=0]').prop('disabled',true);
	}
	if(parseInt(value)===3)
	{
	 	$('#edit_taxi_model').find('[enable_outstation=0]').prop('disabled',true);
	}
	
	// $('#trip_packages').html('');
	if(plan === undefined)
	{
		plan = 0;
	}
	if(trip_type != 1 && trip_type != '')
	{
		$.ajax({
		url : "<?php echo URL_BASE; ?>taxidispatch/get_all_selected_packages_model",
		data : { 'type' : selected,'trip_type':trip_type, plan:plan},
		type : 'POST',
		dataTtype : 'JSON',
		success : function(data) {
			var response = JSON.parse(data);
			if(data != '')
				{	
					if(trip_type == 3)
					{	
						$('.outstation_block').prop('disabled', true);
					} else {
						$('.outstation_block').prop('disabled', false);
					}
					if(from == 'edit' || plan > 0)
					{
						$('.edit-trip-packages-div').show();
						$('#edit_trip_packages').children('option:not(:first)').remove();
						$('#edit_trip_packages').append(response.plans);
						$('#edit_plan_duration').append(response.hour);
						if(response.hour == 24){
							$('#edit_os_day_count').val(1);
							$("#edit_os_day_count option[value=0]").attr("disabled","disabled");
							//$("#edit_tripDescription").html('24 hour(s) oneway trip');
						}else{
							$("#edit_os_day_count option[value=0]").removeAttr('disabled');
							$('#edit_os_day_count').val(0);
							//$("#edit_tripDescription").html('12 hour(s) oneway trip');
						}

						if(trip_type == 3 || trip_type == 2)
						{
							sel_pack = $('#edit_trip_packages').val();
							loadPackageDetail(sel_pack,'edit')
						}
					} else {
						$('.trip-packages-div').show();
						$('#trip_packages').children('option:not(:first)').remove();						
						$('#trip_packages').append(response.plans);
						if(response.hour == 24){
							$('#os_days_count').val(1);
							$("#os_days_count option[value=0]").attr("disabled","disabled");
							$("#tripDescription").html('24 hour(s) oneway trip');
						}else{
							$("#os_days_count option[value=0]").removeAttr('disabled');
							$('#os_days_count').val(0);
							$("#tripDescription").html('12 hour(s) oneway trip');
						}
						if(trip_type == 3 || trip_type == 2)
						{
							// sel_pack = $('#trip_packages').val();
							// loadPackageDetail(sel_pack,'add');
						}
					}
				} else {
					if(from == 'edit' || plan > 0)
					{
						$('#edit_trip_packages').children('option:not(:first)').remove();
						// $('#edit_trip_packages').append('<option value="" >No package</option>');
						$('.edit-trip-packages-div').show();
					} else {
						$('#trip_packages').children('option:not(:first)').remove();
						// $('#trip_packages').append('<option value="" >No package</option>');
						$('.trip-packages-div').show();
					}
				}
		},
		error : function(data) {

		}
		});
	} else { 
		$('.outstation_block').prop('disabled', false);
		if(from == 'edit' || plan > 0)
		{
			$('.edit-trip-packages-div').hide();
			$('#edit_trip_packages').children('option:not(:first)').remove();
			/*$('#edit_taxi_model').children('option:not(:first)').remove();
			$('#edit_taxi_model').append('<option value="1" >Taxi</option><option value="3" >LUX</option><option value="10" >LIMO</option>');*/
		} else {
			$('.trip-packages-div').hide();
			$('#trip_packages').children('option:not(:first)').remove();
			/*$('#taxi_model').children('option:not(:first)').remove();
			$('#taxi_model').append('<option value="1" >Taxi</option><option value="3" >LUX</option><option value="10" >LIMO</option>');*/
		}
		change_minfare(selected, from);
	}
	
}

function loadPackages(selected, from, plan)
{	
	// alert($("#show_time_secs").val());	
	if(selected == 3)
	{
		var current_location = $("#current_location").val();
		var drop_location = $("#drop_location").val();
		if(current_location != '' && drop_location != '')
		{
			var trip_duration = $("#show_time_secs").val();
			$("#round_one_way_select").show();
			if(trip_duration > 28800 || trip_duration == 28800)
			{
				$("#round_trip").prop("checked", true);
				$("#round_trip").prop("readonly", true);
				$("#one_way").prop("disabled", true);
			}
			else
			{	 
				if($("#one_way").prop("disabled", true))
				{
					$("#one_way").prop("disabled", false);
					$("#one_way").prop("checked", true);
				}
				
				$("#one_way").prop("checked", true);
			}
		}
	}
	else
	{
		$("#round_one_way_select").hide();
	}

	if(selected != 1 && selected != '')
	{
		if(selected == 3)
		{	
			$('.outstation_block').prop('disabled', true);
		} else {
			$('.outstation_block').prop('disabled', false);
		}
		$.ajax({
			url : "<?php echo URL_BASE; ?>taxidispatch/get_all_selected_packages",
			data : { 'type' : selected, 'selected_plan' : plan },
			type : 'POST',
			dataTtype : 'JSON',
			success : function(data) {
				/* removed for model to package option */
				// $('#taxi_model').children('option:not(:first)').remove();
				// $('#edit_taxi_model').children('option:not(:first)').remove();
				/* removed for model to package option */
				if(data != '')
				{
					if(from == 'edit' || plan > 0)
					{
						$('#edit_trip_packages').children('option:not(:first)').remove();
						$('#edit_trip_packages').append(data);
						$('.edit-trip-packages-div').show();
						sel_pack = $('#edit_trip_packages').val();
						//loadPackageFleets(sel_pack, 'edit', plan);
					} else {
						$('#trip_packages').children('option:not(:first)').remove();
						$('#trip_packages').append(data);
						$('.trip-packages-div').show();
					}
				} else {
					if(from == 'edit' || plan > 0)
					{
						$('#edit_trip_packages').children('option:not(:first)').remove();
						$('#edit_trip_packages').append('<option value="" >No package</option>');
						$('.edit-trip-packages-div').show();
					} else {
						$('#trip_packages').children('option:not(:first)').remove();
						$('#trip_packages').append('<option value="" >No package</option>');
						$('.trip-packages-div').show();
					}
				}
			},
			error : function() {

			}
		});
	} else {
		$('.outstation_block').prop('disabled', false);
		if(from == 'edit' || plan > 0)
		{
			$('.edit-trip-packages-div').hide();
			$('#edit_trip_packages').children('option:not(:first)').remove();
			$('#edit_taxi_model').children('option:not(:first)').remove();
			$('#edit_taxi_model').append('<option value="1" >Taxi</option><option value="3" >LUX</option><option value="10" >LIMO</option>');
		} else {
			$('.trip-packages-div').hide();
			$('#trip_packages').children('option:not(:first)').remove();
			$('#taxi_model').children('option:not(:first)').remove();
			$('#taxi_model').append('<option value="1" >Taxi</option><option value="3" >LUX</option><option value="10" >LIMO</option>');
		}
	}
}
/* rental / outstations */

/* package based plan */
function loadPackageFleets(selected, from, plan)
{	
	type = $('#trip_type').val();
	if(type == 3)
	{
		$("#days_count").html("");
		var split_this = selected.split("-"); 
		if(split_this[0] == 720)
		{
			var option1 = "<option value='2'>1 day</option><option value='3'>2 days</option><option value='4'>3 days</option>";
			$("#days_count").html(option1);
			$("#days_count").show();
		}
		else
		{
			var option2 = "<option value='1'>24 hours</option><option value='2'>12 loadPackageFleetshours</option><option value='3'>2 days</option><option value='4'>3 days</option>";
			$("#days_count").html(option2);
			$("#days_count").show();
		}
	}
	
	/*if(selected != '')
	{
		if(from== 'edit' || plan > 0)
		{
			type = $('#edit_trip_type').val();
		} else {
			type = $('#trip_type').val();
			if(type == 3)
			{
				$("#days_count").html("");
				var split_this = selected.split("-"); 
				if(split_this[0] == 720)
				{
					var option1 = "<option value='2'>1 day</option><option value='3'>2 days</option><option value='4'>3 days</option>";
					$("#days_count").html(option1);
					$("#days_count").show();
				}
				else
				{
					var option2 = "<option value='1'>24 hours</option><option value='2'>12 hours</option><option value='3'>2 days</option><option value='4'>3 days</option>";
					$("#days_count").html(option2);
					$("#days_count").show();
				}
			}
		}*/

		
	/*	$.ajax({
			url : "<?php//echo URL_BASE; ?>taxidispatch/get_selected_pack_models",
			data : { 'package' : selected, 'type' : type, 'selected_plan' : plan },
			type : 'POST',
			dataTtype : 'JSON',
			success : function(data) {				
				if(data != '')
				{
					if(from == 'edit' || plan > 0)
					{
						$('#edit_taxi_model').children('option:not(:first)').remove();
						$('#edit_taxi_model').append(data);
						var sel_pack_fleet = $('#edit_taxi_model').val();
						change_minfare(sel_pack_fleet, from);
					} else {
						$('#taxi_model').children('option:not(:first)').remove();
						$('#taxi_model').append(data);
					}
				} else {
					if(from == 'edit' || plan > 0)
					{
						$('#edit_taxi_model').children('option:not(:first)').remove();
						$('#edit_taxi_model').append('<option value="" >No model</option>');
					} else {
						$('#taxi_model').children('option:not(:first)').remove();
						$('#taxi_model').append('<option value="" >No model</option>');
					}
				}
			},
			error : function() {

			}
		});*/
	// } else {
	// 	if(from == 'edit' || plan > 0)
	// 	{
	// 		$('#edit_taxi_model').children('option:not(:first)').remove();
	// 		$('#edit_taxi_model').append('<option value="1" >Taxi</option><option value="3" >LUX</option><option value="10" >LIMO</option>');
	// 	} else {
	// 		$('#taxi_model').children('option:not(:first)').remove();
	// 		$('#taxi_model').append('<option value="1" >Taxi</option><option value="3" >LUX</option><option value="10" >LIMO</option>');
	// 	}
	// }
}
/* package based plan */

/* package based plan */
function loadModelFares(selected)
{
	if(selected != '')
	{
		var type = $('#edit_trip_type').val();
		var distance = $('#edit_distance_km').val();
		var durationSecs = $('#edit_total_duration_secs').val();

		$.ajax({
			url : "<?php echo URL_BASE; ?>taxidispatch/get_model_appr_fare",
			data : { 'plan' : selected, 'type' : type, 'distance' : distance, 'durationSecs' : durationSecs },
			type : 'POST',
			dataTtype : 'JSON',
			success : function(data) {		
			},
			error : function() {

			}
		});
	}
}

function taxi_driver_details_job_list(e)
{	
	  e.stopPropagation();

	var driver_id=$('.fleet_tabs').attr('selectedid');
	var dataS = "driver_id="+driver_id+"&type="+$('#track_type').attr('data-id')+"&direct="+0;
	var startDate="";
	var toDate="";
	if($('#filter_from_date').val())
	{
		startDate=$('#filter_from_date').val();
		dataS+='&start_date='+startDate;
	}
	if($('#filter_to_date').val())
	{
		toDate=$('#filter_to_date').val();
		dataS+='&end_date='+toDate;
	}
	$.ajax ({
		type: "POST",
		url: SrcPath+"taxidispatch/taxi_driver_details",
		data: dataS, 
		cache: false, 
		success: function(response) 
		{
			var data=JSON.parse(response);
			$('.job_list_ui_tag').html(data.html);
		}
	});
}


/* package based plan */
function taxi_driver_details(driver_id,$type,$direct,th)
{
	if(th)
	{
		$(th).parents('ul').find('li').removeClass('active');
		$(th).addClass('active');
	}
	var type=$('#track_type').attr('data-id');
	var dataS = "driver_id="+driver_id+"&type="+type+"&direct="+$direct;
	$.ajax ({
		type: "POST",
		url: SrcPath+"taxidispatch/taxi_driver_details",
		data: dataS, 
		cache: false, 
		success: function(response) 
		{

			var data = JSON.parse(response);
			$('#top_header').html(data.driver_taxi_number);
			//$('.fleettab_content_container').html(data.taxi_driver_details);
			$('.dispatch_det_slidebar').addClass('active');
			if(''+type==='2')
			{
				$('.dispatch_det_slidebar').html(data.driver_taxi_number);
			}else{
				$('.dispatch_det_slidebar').html(data.taxi_driver_details);
			}
			
			//$('#listing_fleet_job').html(data.fleet_job);
			
			var month=new Date().getMonth();
			var year=new Date().getFullYear()
			var today = new Date(year+"-"+month+"-01");
			var endday = new Date(year+"-"+month+"-31");
			var dateFormat = "yyyy-mm-dd";
			function daysInMonth (month, year) {
			    return new Date(year, month, 0).getDate();
			}			

		    $("#filter_from_date").datetimepicker({
		        timezone: php_date_0,
		        timeFormat: 'HH:mm:ss',
		        dateFormat: 'yy-mm-dd',
		        showTimepicker:false,
		        startDate: today,
		        minDate :new Date(year+'-'+(month+1)+'-01'),
		        maxDate :new Date(year+'-'+(month+1)+'-'+daysInMonth((month+1),year)),
		        //minDateTime: customRangeStart(),
		        timeInput: false,
		        autoclose: true,
		        todayBtn: true,
		        pickerPosition: "top-right"
		    });

		    $('#filter_from_date').on('change',function(){
		    		taxi_driver_details_job_list(event);
		    });
		    $("#filter_to_date").datetimepicker({
		        timezone: php_date_0,
		        timeFormat: 'HH:mm:ss',
		        dateFormat: 'yy-mm-dd',
		        showTimepicker:false,
		        startDate: today,
		        minDate :new Date(year+'-'+(month+1)+'-01'),
		        maxDate :new Date(year+'-'+(month+1)+'-'+daysInMonth((month+1),year)),
		        //minDateTime: customRangeStart(),
		        timeInput: false,
		        autoclose: true,
		        todayBtn: true,
		        pickerPosition: "top-right"
		    });

		    $('#filter_to_date').on('change',function(){
		    	taxi_driver_details_job_list(event);
		    });

			 setTimeout(function(){
			 		$("#filter_from_date").val(year+'-'+(month+1)+'-01');
			 		$("#filter_to_date").val(year+'-'+(month+1)+'-'+daysInMonth((month+1),year));
			 },3000);
		},
		error: function() {
			alert('<?php echo __("something went wrong"); ?>');
			return false;
		}
	});	
}
$(document).ready(function(){
		$('.add_job_container').css('display','none');
		$('.edit_job_container').css('display','none');
		$('.vehicle_type #vehicle_type,.vehic_type #vehicle_type,#track_type,#status_type').removeClass('active');
	all_booking_manage_list_new_design();
     $('.vehicle_type #vehicle_type').click(function(){
     	$(this).toggleClass('active');
     	$('.vehicle_list').toggleClass('active');
   	});
     $('.vehic_type #vehicle_type').click(function(){
     	$(this).toggleClass('active');
     	$('.fleet_vehicle_list').toggleClass('active');
     });
    $(' #track_type').click(function(){
     	$(this).toggleClass('active');
     	$('.track_list').toggleClass('active');
    });

     $('#status_type').click(function(){
     	$(this).toggleClass('active');
     	$('.status_list').toggleClass('active');
   	});
    
    /*$('.add_btn').click(function(){
 		$('.dispatch_det_slidebar_edit,.dispatch_det_slidebar_add,.dispatch_det_slidebar').removeClass('active');
		$('#anonymous_id').prop('disabled',false);
     	$(this).toggleClass('active');
     	if($('.add_btn').hasClass('active')){
     		$(".job_filter_bar").css('display','none');
     		$(".jobs_search_bar").css('display','none');
     		
     		$('.job_listing_container').css('display','none');
     		$('.add_job_container').css('display','block');	
     		$('#defaultForm_edit').hide()
			$('#defaultForm').show()			

     	}else{

     		$(".job_filter_bar,.jobs_search_bar").css('display','block');
     		
     		$('.job_listing_container').css('display','block');
     		$('.add_job_container').css('display','none');		
     		$('#defaultForm_edit').show();
			$('#defaultForm').hide();
     	}
     	

     	
   	});*/

   	
	$('#add_add_btn').click(function(){
		$("#fixedfare").hide();
		$("#add_btn").trigger('click');
		$("#email_error").remove();		
	});
	$('#edit_add_btn').click(function(){
		$('.dispatch_det_slidebar_edit,.dispatch_det_slidebar_add,.dispatch_det_slidebar').removeClass('active');
		$(".add_btn").removeClass('active');
		$(".job_filter_bar,.jobs_search_bar").css('display','block');		
		$('.job_listing_container').css('display','block');
		$('.edit_job_container').css('display','none');		
		
	});

    $('#fleet_model_list li').click(function(){
    	$('.dispatch_det_slidebar_add').addClass('active');
    	var driver_id = $(this).attr('driverID');
    	taxi_driver_details(driver_id);
    });  

    $(".booking_details").on('change',function(){

    	 $('.dispatch_det_slidebar_add').addClass('active');
    	 
    	 $('.estimate_container').css('display','block');
    
    });

    $(".edit_booking_details").on('change',function(){

    	 $('.dispatch_det_slidebar_edit').addClass('active');
    	 
    	 $('.estimate_container').css('display','block');

    });

	$(".nearest_driver_dropdown").click(function(){
		var x=$(this).find('i').css('background-image');
		if(x.indexOf('dropdown_arrow') !=-1)
		{
			var imageUrl=URL_BASE+"public/dispatch/vendor/bootstrap/images/lower_arrow.png";
			$(this).find('i').css('background-image','url(' + imageUrl + ')');
		}else{
			var imageUrl=URL_BASE+"public/dispatch/vendor/bootstrap/images/dropdown_arrow.png";
			$(this).find('i').css('background-image','url(' + imageUrl + ')');
		}
		$('.driver_listing').toggleClass('active');
	});
    $(".search_job_list").click(function(){
    	all_booking_manage_list_new_design();
	});

 });
toggleActive=function(e,th,word)
{
	if(word==='add_add_btn')
	{
		$('#add_btn').removeClass('active');
		$('#add_add_btn').addClass('active');
	}else{
		$('#add_btn').addClass('active');
		$('#add_add_btn').removeClass('active');
	}
}
</script>
<!-- propogation script - karthi -->

<!-- propogation script - karthi ends here -->

<?php //radhamani code for new design?>
<script type="text/javascript">
	$(".tab2").click(function(){
		$(".job_list_detailed_container").css('display','none');
		$(".fleets_block_container").css('display','block');
		$("#tab-2").attr('checked','checked');
		

	});
	$("#tab-2").click(function(){
		$("#status_filter_all").addClass('active');
		$(".dispatch_det_slidebar,.dispatch_det_slidebar_add,.dispatch_det_slidebar_edit").removeClass('active');

		//N0593
		var fleet_text = "<?php echo __('fleet');?>";
		var driver_text = "<?php echo __('driver');?>";
		$('#track_type').text(driver_text).attr('data-id',2);
		$('.track_list li a').text(fleet_text);
		$('.track_list li').attr('value',2);
		//N0593
		$(".status_filter_block_li ").removeClass('active');
		$(".status_filter_block_li:eq(0)").addClass('active');
		fleet_listing_new_design();
	});

	$("#tab-1").click(function(){
		window.sessionStorage.setItem('FREEZE_MARKER','all');
		all_booking_manage_list_new_design();
		$(".job_list_detailed_container,.job_listing_container").css('display','block');
		$(".add_job_container,.edit_job_container").css('display','none');
		$(".dispatch_det_slidebar,.dispatch_det_slidebar_add,.dispatch_det_slidebar_edit").removeClass('active');
		$("#tab-1").attr('checked','checked');

		$(".job_filter_bar,.jobs_search_bar").css('display','block');
		$(".add_btn").removeClass('active');
		
	});

	$('.fleet_search').on('blur',function(){
		fleet_listing_new_design();
	});

	$(".tab1").click(function(){
		
		$(".fleets_block_container").css('display','none');
		$(".job_list_detailed_container").css('display','block');
		$("#tab-1").attr('checked','checked');
	//	$("#tab-1").trigger('click');
	});/*
	function status_filter_block(){
		alert("click");
		alert($(this).val());
		$(".status_filter_block ul li").removeClass('active');
		$(this).addClass('active');
		fleet_listing_new_design();
	}*/
	var trackingmap;
	var dialogInterVel;
	clearInterval(dialogInterVel);
	var mapCenterLocation=true;
	var liveTrackMarker;
	function driver_location_list_search(e,th)
	{
	    var value = $(th).val().toLowerCase();
	    $("#live_tracking_tbody tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
  	}

  	function showSingleDriverDialog(e,th)
  	{  		
  		var stringify=$(th).attr('driverinfo');
  		stringify=JSON.parse(stringify);
  		var info=[];
  		info.push(stringify);
  		var latitude=(stringify.loc.coordinates && stringify.loc.coordinates[1])?stringify.loc.coordinates[1]:0;
  		var longitude=(stringify.loc.coordinates && stringify.loc.coordinates[0])?stringify.loc.coordinates[0]:0;
  		var footer = '<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" style="text-align:center;">*<?php echo ucfirst(__("google_cost")); ?></div>';
  		$("#trackdialog").dialog({
            modal: true,
            title: "Live Tracking",
            width: 600,
            hright: 450,
            buttons: {
                Close: function () {
                	clearInterval(dialogInterVel);
                    $(this).dialog('close');
                }
            },
            open: function () {            	
                var mapOptions = {
                    center: new google.maps.LatLng(latitude, longitude),
                    zoom: 18,
                    disableDefaultUI: true,
                    mapTypeControl: false,
                    gestureHandling: 'greedy' ,
                    streetViewControl: false,
                    mapTypeControlOptions: {
				      mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID]
				    },
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                trackingmap = new google.maps.Map($("#trackvMap")[0], mapOptions);


                	setTimeout(function(){  
                		var latlng = new google.maps.LatLng(latitude, longitude);
                		var driver_status=stringify.driver_status;  
                		var status='free';
                		if(driver_status==='A')
                		{
                			status='active';
                		}else if(driver_status==='B')
                		{
                			status='busy';
                		}
                		var mapIcon;              		
						if (icons[status]) {
					        mapIcon = icons[status].icon;
					    }
					    if(info.accuracy && parseInt(info.accuracy)>280)
					    {
					    	mapIcon=icons['normal'].icon;
					    }

					    var contentString = '<div>'+				           
				            '<h5>'+stringify.driver_name+'</h5>'+	
				            '<h6>'+stringify.driver_mobile+'</h6>'+	
				            '<h6>'+stringify.taxi_model+'|'+stringify.taxi_no+'</h6>'+	
				            '</div>';

				        var infowindow = new google.maps.InfoWindow({
				          content: contentString
				        });

                		liveTrackMarker = new google.maps.Marker({
					        position: latlng,
					        map: trackingmap,
					        icon:mapIcon					        
					    });
                		trackingmap.setCenter(latlng);
					    liveTrackMarker.addListener('click', function() {
				           infowindow.open(trackingmap, liveTrackMarker);
				        });
	                	dialogInterVel=setInterval(function(){
	                		fleet_listing_new_design(0,1,stringify.driver_id);
	                	},5000)
                	},5000)
               



            },
            create: function() {
			     $("#trackdialog").append(footer);

			      $(this).closest('div.ui-dialog')
                   .find('.ui-dialog-titlebar-close')
                   .click(function(e) {
                       clearInterval(dialogInterVel);
                       e.preventDefault();
                   });
			}
        });
        return false;
  	}


	function TableMarkerAnimate(req,$driverID)
	{
		var html='';		
		$('#live_tracking_tbody').html('');		
		if(req && req.info && parseInt($driverID)===0)
		{
			var request=req.info;
			var count=req.count;
			if(typeof count.freeUsers !='undefined' && typeof count.activeUsers !='undefined')
			{
				$('.free_users_count').html(count.freeUsers);
				$('.active_users_count').html(count.activeUsers);
			}			
			request.forEach(function(val){
				var driver_status='<b style="color:green">Free</b>';
				if(val.driver_status ==='A')
				{
					driver_status='<b style="color:orange">Active</b>';
				}else if(val.driver_status ==='B')
				{
					driver_status='<b style="color:red">Busy</b>';
				}
				val.accuracy=Math.round(val.accuracy);
				var	accuracy='<b style="color:red;" title="'+val.accuracy+'">Bad</b>';
				if(parseInt(val.accuracy)<280)
				{
					 accuracy='<b style="color:green;" title="'+val.accuracy+'">Good</b>';
				}
				var driverUrl='<?php echo URL_BASE; ?>/analytics/analytics_driverinfo/'+val.driver_id;				
				var latitude=(val.loc && val.loc.coordinates && val.loc.coordinates[1])?val.loc.coordinates[1]:0;
				var longitude=(val.loc && val.loc.coordinates && val.loc.coordinates[0])?val.loc.coordinates[0]:0;
				var GUrl='https://maps.google.com?q='+latitude+","+longitude;

var driver_status_html='<span><?php echo __("driver_status"); ?>: '+driver_status+'</span><br/><span><?php echo __("device_accuracy"); ?>: '+accuracy+'</span>';

var taxi_status_html='<span><?php echo __("taxi_no"); ?>: <b>'+val.taxi_no+'</b></span><br/><span><?php echo __("taxi model"); ?>: <b>'+val.taxi_model+'</b></span>';

				html+='<tr>';
				html+='<td><a target="_blank" href="'+driverUrl+'">'+val.driver_name+"</a> ("+val.driver_mobile+")"+'</td>';
				html+='<td>'+driver_status_html+'</td>';
				html+='<td>'+taxi_status_html+'</td>';
				html+='<td><a target="_blank" href="'+GUrl+'">'+latitude+','+longitude+'</a></td>';
				html+="<td><a  driverinfo='"+JSON.stringify(val)+"' href='javascript:void(0);' onClick='return showSingleDriverDialog(event,this);''>Click here</a></td>";
				html+='</tr>';
			});
		}
	
		$('#live_tracking_tbody').html(html);
		return true;
	}

		
	function markerInfoSetLocalStorage(info)
	{		

		$(".gm-style div[title*='info_content']").attr('onmouseover',"this.title=''");
		var localstorage={};
		if(info && info.length)
		{
			$(".gm-style div[title*='info_content']").attr('onmouseover',"this.title=''");
			for(var z=0;z<info.length;z++)
			{
				var current=info[z];
				var op = [];
				if(current.loc && current.loc.coordinates)
				{
				op[0]=current.loc.coordinates[1];
				op[1]=current.loc.coordinates[0];

				if(mapCenterLocation)
				{
					if(mapNew && mapNew.zoom)
					{
					 mapNew.setCenter({
                              lat: parseFloat(op[0]),
                              lng: parseFloat(op[1])
					 });					 
					}
					mapCenterLocation=false;
				}
				
				if(SUBDOMAIN_NAME == "prehiretest"){
					$.ajax ({
						url: "<?php echo URL_BASE;?>taxidispatch/getcityname",
						success: function(response) 
						{		
							address = decodeEntities(response);
							jQuery.post("https://maps.googleapis.com/maps/api/geocode/json?address="+address+"&key=" + GOOGLE_MAP_API_KEY, function(success) {
								var latitude = success.results[0].geometry.location.lat;
								var longitude = success.results[0].geometry.location.lng;
							    mapNew.setCenter(new google.maps.LatLng(latitude, longitude));
								mapNew.setZoom(15);
							});		
						}
					});
				}

				if (current.driver_status == 'A') {
                      status = "active";
                      status_text = reqLanguageFields['active'];
                      $('#marker_id'+current.driver_id).next('p').find('span').text(reqLanguageFields['active']);
                      status_info = '<span style="color:orange">' + reqLanguageFields['active'] + '</span>';

				}else if (current.driver_status == "F") {
                      status = "free";
                      status_text = reqLanguageFields['free_in'];
                      $('#marker_id'+current.driver_id).next('p').find('span').text(reqLanguageFields['free_in']);
                      status_info = '<span style="color:green">' + reqLanguageFields['free_in'] + '</span>';

                } else if (current.driver_status == "B") {
                      status = "busy";
                      status_text = reqLanguageFields['busy'];
                      $('#marker_id'+current.driver_id).next('p').find('span').text(reqLanguageFields['busy']);
                      status_info = '<span style="color:green">' + reqLanguageFields['busy'] + '</span>';
                }
                op[2]='<div class="info_content"><span class="driverName">' + current.driver_name + ' ( ' + status_info + ')</span><br /><span class="taxiNo">' + current.taxi_model + '  ' + current.taxi_no + '</span></div>';
                op[3]=status;
                op[4]=current.driver_id;
                op[5]=current;
                op[5].driver_taxi_model=current.taxi_model;
                op[6]=status_text;
                                

                      var D = window.localStorage.getItem('MARKER_LOCATION');                                                
                      if (D === '' || D === null || (typeof D ==='object' && Object.keys(D).length===0))
                       {
                          var t = {};
                          t[parseInt(current.driver_id)] = [];
                          t[parseInt(current.driver_id)].push(op);

                          // if empty then
                          mapNew.setCenter({
                              lat: parseFloat(op[0]),
                              lng: parseFloat(op[1])
                          });
                          window.localStorage.setItem('MARKER_LOCATION', JSON.stringify(t));
                      } else {
                          var temp = JSON.parse(D);
                          if (temp === null) {
                              window.localStorage.setItem('MARKER_LOCATION', '');
                              temp = window.localStorage.getItem('MARKER_LOCATION');
                          }
                          for (i = 0; i < 10; i++) {
                              if (typeof temp === 'string' && temp != '' && temp != null) {
                                  temp = JSON.parse(temp);
                              }
                          }
                          if (typeof temp === 'string') {
                              temp = {};
                          }
                          if (temp[parseInt(current.driver_id)]) {
                              temp[parseInt(current.driver_id)].push(op);
                              window.localStorage.setItem('MARKER_LOCATION', JSON.stringify(temp));
                          } else {
                              temp[parseInt(current.driver_id)] = [];
                              temp[parseInt(current.driver_id)].push(op);
                              window.localStorage.setItem('MARKER_LOCATION', JSON.stringify(temp));
                          }
                          //console.log('D');
                      }
                }
			}
		}
	}

	var blockTypeing=0;

	$(".status_filter_block_li").click(function(){
		if(blockTypeing)
		{
			blockTypeing=0;
			return false;
		}
		$(".status_filter_block_li ").removeClass('active');

		$(this).addClass('active');
		fleet_listing_new_design();
	});

	var markerRefresh=60;
	setInterval(function(){
		markerRefresh--;
		var COUNT=(markerRefresh<10)?'0'+markerRefresh:markerRefresh;
		$('.notify_count').text(COUNT);
		$('.numberCircle').html(markerRefresh);
		if(markerRefresh===0)
		{
			markerRefresh=60;
			VerifyScheduleBookingStatus()
			fleet_listing_new_design(0,1);
		}
	},1000)

	toggleNotification=function (e,th)
  	{
  		$(th).addClass('rotate_icon');
  		markerRefresh=60;
  		fleet_listing_new_design(0,1);
  		return true;
	}

	setTimeout(function(){
		fleet_listing_new_design(0,1)
	},2000)
	var filterInProgress=false;
	var DialogMapDriverStatus;
	function fleet_listing_new_design($skip=0,$needMakerIcon=0,$driverID=0){	
		
		var track_type = $("#track_type").attr('data-id');
		var status_filter_block = $(".status_filter_block .active").data('value');
		var fleet_search = $(".fleet_search").val();
		var vehic_type = $(".vehic_type #vehicle_type").attr('data-id');
		if(filterInProgress)
		{
			return true;
		}
		filterInProgress=true;

				// Refresh Dispatcher Beta
		var refresh=false;
		if($('[name=radio-set]:checked').attr('id')==='tab-1')
		{
			if(!$('.edit_job_container').is(':visible') && 
				!$('.add_job_container').is(':visible') && 
				!$('.dispatch_det_slidebar').hasClass('active'))
			{
				refresh=true;				
			}
		}
		if(refresh && parseInt($driverID)===0)
		{			
			setTimeout(function(){
			all_booking_manage_list_new_design();
			},2000)
		}
		if(status_filter_block == undefined){
			status_filter_block = 'all';
		}	
//Freeze Marker Movement --Start
		window.sessionStorage.setItem('FREEZE_MARKER',status_filter_block);
		
		//Freeze Marker Movement --End	
		var skip=0;

		if($skip===1)
		{
			$('#load_more').remove();
			skip=$('#fleet_model_list li').length;
		}else{
			if($needMakerIcon===0)
			{
				$('.fleet_listing').html('');
			}
		}
		
		var limit =20;
		var Path = "<?php echo URL_BASE; ?>";
		var dataS = "track_type="+track_type+"&status_filter_block="+status_filter_block+"&fleet_search="+fleet_search+"&vehic_type="+vehic_type+"&skip="+skip+"&limit="+limit+"&needMakerIcon="+$needMakerIcon+'&driver_id='+$driverID;
		blockTypeing=1;
		var url_path = Path+"taxidispatch/fleet_listing_job_list";
			close_slidebar(0);
		
		var response;
		$.ajax({
			url: url_path, 
			data: dataS, 
			cache: false, 
			success: function(response){
				filterInProgress=false;
				blockTypeing=0;
				$('.notification_icon').removeClass('rotate_icon');

				var X=JSON.parse(response);
				
				if($needMakerIcon !=1 && (status_filter_block==='F' || status_filter_block==='A'))
				{
					fleet_listing_new_design(0,1);
				}
				
				if($needMakerIcon && $needMakerIcon===1)
				{
					var X=JSON.parse(response);

					if(parseInt(ENABLE_SHOW_MAP_WITH_ALL_DRIVERS)===1)
					{
						if(parseInt($driverID)===0)
						{
							TableMarkerAnimate(X,$driverID);
							return false;						
						}else{
							if(X.info && X.info[0])
							{
								var markerInfo=X.info[0];
								if(markerInfo.loc && markerInfo.loc.coordinates && markerInfo.loc.coordinates[1])
								{
									var latlng = new google.maps.LatLng(markerInfo.loc.coordinates[1], markerInfo.loc.coordinates[0]);	
			if(DialogMapDriverStatus !=X.info[0].driver_status)
			{	               	
				var driver_status=X.info[0].driver_status;  	
				var status='free';
				if(driver_status==='A')
				{
			    status='active';
			    }else if(driver_status==='B')
			    {
			    status='busy';
			    }
			    var mapIcon;              
				if (icons[status]) {
			       mapIcon = icons[status].icon;
			   	}
			    if(X.info[0].accuracy && parseInt(X.info[0].accuracy)>280)
			   	{
				   	mapIcon=icons['normal'].icon;
			   	}
			   	liveTrackMarker.setIcon(mapIcon);
			}
             DialogMapDriverStatus=X.info[0].driver_status;												
									liveTrackMarker.setPosition(latlng);
									trackingmap.setCenter(latlng);
								}	
							}
							return true;
						}
					}

					if(''+typeof Array.prototype.diff ==="undefined")
					{
						Array.prototype.diff = function(a) {
						    return this.filter(function(i) {return a.indexOf(i) < 0;});
						};	
					}
					
					// Remove Logout Drivers --Start					
					if(X.info)
					{
						var currentDrivers=[];
						for(var i=0;i<Object.keys(X.info).length;i++)
						{
							if(X && X.info && X.info[i] && X.info[i].driver_id)
							{
								currentDrivers.push(parseInt(X.info[i].driver_id));
							}							
						}						
						var DRIVERS_ID=window.localStorage.getItem('DRIVERS_ID');
						if(''+window.localStorage.getItem('DRIVERS_ID')!='null' &&
							''+window.localStorage.getItem('DRIVERS_ID')!='undefined')
						{
							if(typeof DRIVERS_ID ==='string')
							{
								var jsonconvert=JSON.parse(DRIVERS_ID);
								var unavailableDrivers=jsonconvert.diff(currentDrivers);
								if(unavailableDrivers.length>0)
								{
									for(var i=0;i<Object.keys(unavailableDrivers).length;i++)
									{
var driverID=parseInt(unavailableDrivers[i]);
if(animateDriverRouteMarker && animateDriverRouteMarker[driverID])
{
	 animateDriverRouteMarker[driverID].setMap(null);
	 delete animateDriverRouteMarker[driverID];
	 $('#marker_id' + driverID).parents('div:eq(0)').remove();
}
									}
								}
							}							
						}

						if(currentDrivers.length>0)
						{
							window.localStorage.setItem('DRIVERS_ID',JSON.stringify(currentDrivers));
						}
					}
					// Remove Logout Drivers --End

					markerInfoSetLocalStorage(X.info);
					return true;
				}
				if(status_filter_block  ==='A' || status_filter_block==='F')
				{				
					clearAllSocketMarkers();
				}
				var X=JSON.parse(response);
				if($skip===1)
				{
					$('#fleet_model_list').append(X.output);
				}else{
					$('.fleet_listing').html(X.output);
				}
				$('.count_all_point').text(X.count.count_all);
				$('.count_loggedout_point').text(X.count.count_loggedout);
				$('.count_shiftout_point').text(X.count.count_shiftout);
				$('.count_busy_point').text(X.count.count_busy);
				$('.count_free_point').text(X.count.count_free);
				$('.count_idle_point').text(X.count.count_idle);
				$('.count_active_point').text(X.count.count_active);
				$('.count_unassign_point').text(X.count.count_unassign);
						
			}		 
		});	
	}
	function all_booking_manage_list_new_design(){	
 		//$(".dispatch_det_slidebar").removeClass('active');
		var company = $("#select_company").val();
		var scrollEnable = $("#scroll_enabled").val();
       
		var taxi_company=taxi_company_def;
		

		var status_cancel = [];
		$.each($("input[name='status_cancel']:checked"), function(){            
			status_cancel.push($(this).val());
		});
		
		var search_txt = $('#search_txt').val();
		
			/*
		var taxi_model = [];
		$(".model_job_list .select_taxi_model")
		$.each($(".model_job_list .select_taxi_model.active"), function(){            
			taxi_model.push($(this).attr('data-id'));
		});

		taxi_model=taxi_model.join(",");*/
		var status_color = $("#status_type").attr('data-val');
		var taxi_model = $("#vehicle_type").attr('data-id');

		var pass_logid = $(".job_search_bar").val();
		var Path = "<?php echo URL_BASE; ?>";
		var dataS = "travel_status="+status_color+"&taxi_company="+taxi_company+"&taxi_model="+taxi_model+"&search_txt="+search_txt+"&trip_id="+pass_logid+"&filterLimit="+$('#filterLimit').val();;
	
		var url_path = Path+"taxidispatch/all_booking_list_manage_new_design";
		
		var response;
		$.ajax({
			url: url_path, 
			data: dataS, 
			cache: false, 
			success: function(response){
				
											
				$('.job_listing_container').html(response);
				if($(".dispatch_det_slidebar").hasClass('active'))
				{
					
				}else{
					$(".dispatch_det_slidebar").removeClass('active');	
				}
				

				$('#showLoaderImg').hide();
				nextSetOfDisListing=0;			
			}		 
		});	
	}
	function tripdetailed_view(event,pass_logid,th){
		
		$(th).parents('ul').find('li').removeClass('active');
		$(th).addClass('active');
		event.stopPropagation();
		$('.dispatch_det_slidebar').addClass('active');
		var Path = "<?php echo URL_BASE; ?>";
		var url_path = Path+"taxidispatch/get_passenger_logdetail_new_design";
		var dataS = "trip_id="+pass_logid;
		var response;
		$.ajax({
			url: url_path, 
			data: dataS, 
			cache: false, 
			success: function(response){
				$(".dispatch_det_slidebar").addClass('active');
				$('.dispatch_det_slidebar').html(response);
				$('#showLoaderImg').hide();

				var dinfo_selected_driver=$('[dinfo_selected_driver]').attr('dinfo_selected_driver');
				var dinfo_status=$('[dinfo_status]').attr('dinfo_status');
				if(dinfo_status && ''+dinfo_status ==='0')
				{
					if(dinfo_selected_driver && ''+dinfo_selected_driver !='0')
					{
						$('.job_detail_top a').removeAttr('onclick');
						$('.job_detail_top a').removeAttr('id');
						$('.job_detail_top a').text('Progress...');
					}
				}

				nextSetOfDisListing=0;			
			}		 
		});	

	}
    $('.slide_close_icon').click(function(){
    	$(this).removeClass('active');
 	});
	$('.dt_top_header .slide_close_icon').click(function(){
		$('.dispatch_slidebar').removeClass('active');
		$('.dispatch_det_slidebar').removeClass('active');
		$(".add_btn").removeClass('active');
		$('.dispatch_det_slidebar_edit').removeClass('active');
		$('.dispatch_det_slidebar_add').removeClass('active');
	});
    function close_slidebar(divname){
    	$('.dispatch_det_slidebar').removeClass('active');
    	if(divname!=0){
    		$('.dispatch_det_slidebar_'+divname).removeClass('active');			
    	}
    
    	//edit booking in dashboard - start
    }
	function form_submit(formflag,button_id,e){
		if(e)
		{
			e.stopImmediatePropagation();
		}
		$("#"+button_id+"_id").val(button_id);
		//$(".job_filter_bar,.jobs_search_bar").css('display','block');
		$("#"+button_id).trigger('click');
	}

	//edit booking in dashboard - end
	$('.job_search_bar').on('keyup',function(){
			
			all_booking_manage_list_new_design();
		});

	$(".reset_btn").on('click',function(){
		var allvehicle = "<?php echo __('allvehicle'); ?>";
		$(".job_search_bar").val('');
		var allstatus = "<?php echo __('allstatus'); ?>";
		$(".vehicle_list ul li").removeClass('active');
		$("#vehicle_type").html(allvehicle);		
		$("#vehicle_type").attr('data-id','0');
		
		$(".status_list ul li").removeClass('active');
		$("#status_type").html(allstatus);
		$("#status_type").attr('data-id','0');
		$("#status_type").attr('data-val','0,6,7,10,9,3,2,1,5,8');
			all_booking_manage_list_new_design();
		});
	//cancel trip
	function cancel_button_new_design(event,pass_logid){
		event.stopPropagation();
		var cancel_Submit = confirm('<?php echo __('sure_want_cancel'); ?>');
		if(cancel_Submit == true)
		{
            
			
			if(1==1){
					var url_path= URL_BASE+"taxidispatch/cancel_booking/?pass_logid="+pass_logid;
			}else{
					var url_path = "<?php echo URL_NODE;?>cancelDispatcherListing?domain="+SUB_NODE;
			}
			
			$.ajax({
				type: "POST",
				url:url_path,
				data: {"pass_logid":pass_logid,"operation_id":operation_id,"url_base":'<?php echo URL_BASE; ?>'}, 
				async: true,
				beforeSend: function() {
					$(this).attr('disabled','true');
			    },
				success:function(res){
					all_booking_manage_list_new_design();
					$(".dispatch_det_slidebar_add,.dispatch_det_slidebar_edit,.dispatch_det_slidebar").removeClass('active');
					if(1==1){
						

					}
					else
					{
						if( res == 'trip_cancel_passenger')
						{
							var res_msg = "<?php echo __('trip_cancel_passenger');?>";
						}
						else if( res == 'cant_cancel_trip_inprogress_complete')
						{
							var res_msg = "<?php echo __('cant_cancel_trip_inprogress_complete');?>";
						}
						else if( res == 'invalid_trip')
						{
							var res_msg = "<?php echo __('invalid_trip');?>";
						}
						else
						{
							var res_msg = res;
						}
						
						$('.showResults').html('<div class="alert alert-success alert-dismissable">	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'+res_msg+'</div>');
						setTimeout(function(){
							$('.showResults').html('');
							$('#close_button').trigger('click');

						},4000)
					}
				},
				error:function() {
					//alert('failed'); 
				},
				 complete: function() {
				 	$(this).removeAttr('disabled');
				 	//all_booking_list_manage_new_design();
			    },
		});			
			
		} else {
			<?php if($_SESSION['user_type'] == 'A') { ?>
			//to deselect the selected company
			$("#select_company").val("0");
			//to get the default data - start
			//driver_list_with_status();
			all_booking_manage_list();
			<?php } ?>
			$("#edit_book_tab").removeClass('edit_book_active');
			$("#eb_tab").removeClass('active');
			//to get the default data - end
			$("#edit_book_tab").hide();
			$("#add_booking_tab").html('Add Booking');
			return false;
		}
	}

	function update_dispatch_new_design(ddl){
		//var thisid = this.id;
		//alert($(this).attr("id"));
		var thisid = $('.det_status_btn').attr('id');
		//var pass_logid = thisid.split('_').pop();
		var logid = thisid.split('_');				
		var current_date="<?php echo date('Y-m-d');?>";
		     current_date=current_date.replace("-","");
		     current_date=current_date.replace("-","");
			 pick_date=logid[4];
		     pick_date=pick_date.replace("-","");
		     pick_date=pick_date.replace("-","");
		     
	 	var x=0;
		if(pick_date < current_date){
			if (confirm("Are you sure do you want to dispatch previous date trip") == true) {
			 x=1;
			}
		}else if(pick_date > current_date){
			if (confirm("Are you sure do you want to dispatch future date trip") == true) {
			 x=1;
			}
		}else if(pick_date == current_date){
			 x=1;
		}

		if(x==1){
			checkPassengerStatus(logid[2],logid[3],thisid);
	    }	
	}
	function search_nearest_driver_location_new_design(formflag){//1-add,2-edit
		if(formflag == 1){
		var post_param = $("#defaultForm").serializeArray();	
	}else{
		var post_param = $("#defaultForm_edit").serializeArray();
	}
	post_param.push({"name":"formflag","value":formflag});

		var Path = "<?php echo URL_BASE; ?>";
		var url_path = Path+"taxidispatch/search_nearest_driver_location_new_design";
		
		var response;
		$.ajax({
			url: url_path, 
			data: post_param, 
			cache: false, 
			success: function(response){
				$(".driver_listing").html(response);

				var estimated_driver_arrival=$('#driver_current_arrival').val();
				if(response.search('No Driver')>0)
				{
					$("#driver_count").val(0);	
				}
				var driver_count = $("#driver_count").val();
				var driver_count_text = '';
				if(driver_count>0){
					var driver_count_text = ' ('+driver_count+') ';
					$('#estimated_driver_arrival').html('--');
					if(SUB_NODE == "prehiretest"){
						change_minfare_prehire();
					}
				}
				if(formflag == 1){

					$("#nearest_driver_count").html(driver_count_text);				
					$("#estimated_driver_arrival").html($("#driver_current_arrival").val());


					
				}else{
					$("#edit_nearest_driver_count").html(driver_count_text);				
					$("#edit_estimated_driver_arrival").html($("#driver_current_arrival").val());

				}
				
				if (typeof driver_count === 'undefined') {
					$('#estimated_driver_arrival').html('--');
					$('#estimated_driver_arrival').html(estimated_driver_arrival);
				}

					/*if(driver_count>0){
					$('#estimated_driver_arrival').html('--');
					$('#estimated_driver_arrival').html(estimated_driver_arrival);
					}*/

				
			}		 
		});	
	}
	function tabclass(e,form){
		  e.stopPropagation();

		 $('.fleet_tab').removeClass('active');		 
		 $(".fleettab2").addClass('active');
        $(this).addClass('active');
        $('.fleettab_content').removeClass('active');
        $('.fleet_tabcontent2').addClass('active');		 
        if(form===1)
        {
        	$('.fleettab2,.fleet_tabcontent2').removeClass('active');
        	$('.fleettab1,.fleet_tabcontent1').addClass('active');

        }


        if(form===2)
        {
        	taxi_driver_details_job_list(e);
        }
	}

    	
</script>
<script type="text/javascript">
    $(document).ready(function() {
      $('.fleettab1').click(function(){
        $('.fleet_tab').removeClass('active');
        $(this).addClass('active');
        $('.fleettab_content').removeClass('active');
        $('.fleet_tabcontent1').addClass('active');
      });

      $('.fleettab2').click(function(){
        $('.fleet_tab').removeClass('active');
        $(this).addClass('active');
        $('.fleettab_content').removeClass('active');
        $('.fleet_tabcontent2').addClass('active');
      });

      	$("#completeTrip").validate({
      					errorElement: 'span',
        				errorClass: 'error',
				        rules: {
				            drop_location: {
				                required: true
				            },
				            trip_fare: {
				                required: true,
				                number: true
				            },
				            distance: {
				                required: true,
				                number: true
				            }
				        },
				        messages: {
				            drop_location: {
				                required: "<?php echo __('please_drop_location') ?>"
				            },
				            trip_fare: {
				                required: "<?php echo __('please_tripfare') ?>",
				                number: "<?php echo __('please_valid_tripfare') ?>"
				            },
				            distance: {
				                required: "<?php echo __('please_distance') ?>",
				                number: "<?php echo __('please_valid_distance') ?>"
				            }
				        }
   		 });

      		$("#roscompletetrip").validate({
      					errorElement: 'span',
        				errorClass: 'error',
				        rules: {
				            ros_drop_location: {
				                required: true
				            },
				            ros_distance: {
				                required: true,
				                number: true
				            },
				            ros_duration: {
				                required: true
				            },
				            ros_fare: {
				                required: true,
				                number: true
				            }
				        },
				        messages: {
				            ros_drop_location: {
				                required: "<?php echo __('please_drop_location') ?>"
				            },
				            ros_distance: {
				                required: "<?php echo __('please_distance') ?>",
				                number: "<?php echo __('please_valid_distance') ?>"
				            },
				            ros_duration: {
				                required: "<?php echo __('duration_not_empty') ?>"
				            },
				            ros_fare: {
				                required: "<?php echo __('please_tripfare') ?>",
				                number: "<?php echo __('please_valid_tripfare') ?>"
				            }
				        }
    		});
		var validator = $('#defaultForm').validate({ // initialize the plugin
	     	rules: {

	     		<?php if(IS_NAME_MANDATORY != 1){ ?>
					firstname: {
						required: true,
						minlength: 3
					},
				<?php } ?>
				<?php if(!empty(IS_FIXED_FARE) && IS_FIXED_FARE == 1){ ?>

				fixedfare: {
			           required:'#fixed_fare_select:checked',
			    },			    
				<?php } ?>
				<?php if(!empty(SHOW_NOTES) && SHOW_NOTES == 1){ ?>

				notes: {
			           required:true,
			    },			    
				<?php } ?>
				email: {
					//required: true,
					email: true
				},
				phone: {
					required: true,
				},
				country_code: {
					required: function() {
							var countrycode = $("#country_code_new").val();
							if(countrycode == ''){
								document.getElementById("country_code_new").style.borderColor = "red";
								return false;
							}else{
								document.getElementById("country_code_new").style.borderColor = "#ccc";
								return true;
							}
						},
				},
				current_location: {
					required: true,
					
				},
				<?php $assign_inprogress = defined('ASSIGN_TRIP_INPROGRESS') ? ASSIGN_TRIP_INPROGRESS : 0;
 				if($assign_inprogress == 1){ ?>
				drop_location : {
					
					required: true,

				},
				<?php } ?>
				/*drop_location : {
					
					notEqualTo: "#current_location",

				},*/
				taxi_model: {
					required: true,
				},
				pickup_date: {
					required: true,
				},
				trip_packages : {
					required: function() {
						var trip_type = $("#trip_type").val();
						if(trip_type == 1){
							return false;
						}
						return true;
					},
				},
			},
			messages: {
				<?php if(IS_NAME_MANDATORY != 1){ ?>

				firstname: {
					required: "<?php echo __('name_cannot_beempty'); ?>",
					minlength: jQuery.validator.format("<?php echo __('atleast_characters_required'); ?>")
				},
				<?php } ?>
				email: {
				//	required:"<?php echo __('email_cannot_beempty'); ?>",
					//email: "Your email address must be in the format of name@domain.com"
					email: "<?php echo __('please_enter_valid_email'); ?>"
				},
				country_code: {
					required: '',
				},
				<?php if(!empty(IS_FIXED_FARE) && IS_FIXED_FARE == 1){ ?>

				fixedfare: {
					required: "<?php echo __('Fixed fare cannot be empty'); ?>",
				},
				<?php } ?>
				<?php if(!empty(SHOW_NOTES) && SHOW_NOTES == 1){ ?>

				notes: {
					required: "<?php echo __('Notes cannot be empty'); ?>",
				},
				<?php } ?>
				phone: {
					required: "<?php echo __('mobilenumber_cannot_beempty'); ?>",
				},
				current_location: {
					required: "<?php echo __('enter_currentlocation'); ?>",
				},
				<?php $assign_inprogress = defined('ASSIGN_TRIP_INPROGRESS') ? ASSIGN_TRIP_INPROGRESS : 0;
 				if($assign_inprogress == 1){ ?>
					drop_location: {
						required: "<?php echo __('enter_droplocation'); ?>",
					},
				<?php } ?>
				taxi_model: {
					required: "<?php echo __('select_the_vehicle'); ?>",
				},
				pickup_date: {
					required: "<?php echo __('select_the_pickup_date'); ?>",
				},
				trip_packages : {
					required: "<?php echo __('select_package_value'); ?>",
				},
			}/*,
			submitHandler: function(form,event) {
				 console.log(form);   
				 event.stopImmediatePropagation();
			}*/
		});
		validateEditJob();
		$('#add_btn').click(function(){
 		$('.dispatch_det_slidebar_edit,.dispatch_det_slidebar_add,.dispatch_det_slidebar').removeClass('active');
		$('#anonymous_id').prop('disabled',false);
     	$('#add_add_btn').toggleClass('active');
     	$('#add_btn').removeClass('active');
     	if($('#add_add_btn').hasClass('active')){
     		$('.dispatch_det_slidebar_add').addClass('active');
    		$('.estimate_container').css('display','block');
     		$(".job_filter_bar").css('display','none');
     		$(".jobs_search_bar").css('display','none');
     		
     		$('.job_listing_container').css('display','none');
     		$('.add_job_container').css('display','block');	
     		$('#defaultForm_edit').hide()
			$('#defaultForm').show();
			$('#find_duration').html("0"+" "+"mins");
			$('#find_km').html("0"+" "+unitname);
			$('#min_fare').html("0");
		//	$("#anonymous_id").trigger('click');
		//	$("#anonymous_id .package_plan").attr('checked','checked');
			$("#round_one_way_select").hide();
			// $("#days_count").hide();
			$("#ro_find_duration").html(0);
			$("#ro_find_km").html(0);
			$("#ro_find_hr").html(0);
			$(".loc_error").hide();
			//$("#vat_tax").html(0);
			$('#trip_validation').text('');
			$("#ro_approx_fare").html(0);
     	}else{
     		var msg = "<?php echo __("no_driver_found") ?>";
     		$(".job_filter_bar,.jobs_search_bar").css('display','block');
     		$('.job_listing_container').css('display','block');
     		$('.add_job_container').css('display','none');		
     		$('#defaultForm_edit').show();
     		$('#defaultForm')[0].reset();
     		validator.resetForm();
     		document.getElementById("country_code_new").style.borderColor = "#ccc";
     		$('#email_new').attr("readonly", false);
     		$('#phone_new').attr("readonly", false);
			$('#defaultForm').hide();
			$('#promocodeError').text("");
			$('.driver_listing').empty();
			$(".driver_listing").html('<li>' + msg + '</li>');
			$("#nearest_driver_count").html('');
			$("#timeError").hide().html("");
			//$("#account_sec_id").trigger('click');
			//			$("#account_sec_id .package_plan").attr('checked','checked');
			//$('#search_txt_div').hide();
     	}
     	

     	
   	});

    });

    function validateAddJob()
    {
		
	}
	function validateEditJob()
    {
    	var editValidator = $('#defaultForm_edit').validate({ 
			rules: {
				<?php if(!empty(IS_NAME_MANDATORY) && IS_NAME_MANDATORY == 1){ ?>

				edit_firstname: {
					required: true,
					minlength: 3
				},
				<?php } ?>
				/*edit_email: {
					required: true,
					email: true
				},*/
				<?php if(!empty(IS_FIXED_FARE) && IS_FIXED_FARE == 1){ ?>

				edit_fixedfare: {
			           required:'#edit_fixed_fare_select:checked',
			    },
				<?php } ?>
				<?php if(!empty(SHOW_NOTES) && SHOW_NOTES == 1){ ?>

				edit_notes: {
					required: true,
				},
				<?php } ?>
				edit_country_code: {
					required: true,
				},
				edit_phone: {
					required: true,
				},
				edit_current_location: {
					required: true,
				},
				<?php $assign_inprogress = defined('ASSIGN_TRIP_INPROGRESS') ? ASSIGN_TRIP_INPROGRESS : 0;
 				if($assign_inprogress == 1){ ?>
					edit_drop_location: {
						required: true,
					},
				<?php } ?>
				edit_taxi_model: {
					required: true,
				},
				edit_pickup_date: {
					required: true,
				},
				edit_trip_packages : {
					required: function() {
						var trip_type = $("#trip_type").val();
						if(trip_type == 1){
							return false;
						}
						return true;
					},
				},
			},
			messages: {
				<?php if(!empty(IS_NAME_MANDATORY) && IS_NAME_MANDATORY == 1){ ?>

				edit_firstname: {
					required: "<?php echo __('name_cannot_beempty'); ?>",
					minlength: jQuery.validator.format("<?php echo __('atleast_characters_required'); ?>")
				},
				<?php } ?>
				<?php if(!empty(SHOW_NOTES) && SHOW_NOTES == 1){ ?>

				edit_notes: {
					required: "<?php echo __('Notes cannot be empty'); ?>",
				},
				<?php } ?>
				edit_email: {
					//required: "The email cannot be empty",
					//email: "Your email address must be in the format of name@domain.com"
					email: "<?php echo __('please_enter_valid_email'); ?>",
					required: "<?php echo __('email_cannot_beempty'); ?>"
				},
				edit_country_code: {
					required: "<?php echo __('countrycode_cannot_beempty'); ?>",
				},
				edit_fixedfare: {
					required: "<?php echo __('Fixed fare cannot be empty'); ?>",
				},
				edit_phone: {
					required: "<?php echo __('mobilenumber_cannot_beempty'); ?>",
				},
				edit_current_location: {
					required: "<?php echo __('enter_currentlocation'); ?>",
				},
				<?php $assign_inprogress = defined('ASSIGN_TRIP_INPROGRESS') ? ASSIGN_TRIP_INPROGRESS : 0;
 				if($assign_inprogress == 1){ ?>
					edit_drop_location: {
						required: "<?php echo __('enter_droplocation'); ?>",
					},
				<?php } ?>
				edit_taxi_model: {
					required: "<?php echo __('select_the_vehicle'); ?>",
				},
				edit_pickup_date: {
					required: "<?php echo __('select_the_pickup_date'); ?>",
				},
				edit_trip_packages : {
					required: "<?php echo __('select_package_value'); ?>",
				},
			},
			
			submitHandler: function(form) {		
						
				$("#timeEditError").hide().html("");
				editValid = 1;
				var edit_pickup_date_db = $('#edit_pickup_date_db').val();
				var edit_pickup_date = $('#edit_pickup_date').val();
				if(edit_pickup_date_db != edit_pickup_date) {
					var currentdate = customRangeStart(); 
					pickup_date = new Date(edit_pickup_date);

					var diff = pickup_date.getTime() - currentdate.getTime();
					var msec = diff;
					var hh = Math.floor(msec / 1000 / 60 / 60);
					msec -= hh * 1000 * 60 * 60;
					var mm = Math.floor(msec / 1000 / 60);
					msec -= mm * 1000 * 60;
					if(mm < later_booking_interval) {
						editValid = 0;
						$("#timeEditError").addClass('error').show().html("<?php echo __('later_booking_need_min'); echo 
					$later_booking_interval; echo __('minutes');  ?>");
						return false;
					}
				}
				
				//~ if(editValid) {
					//~ $('#update_dispatch').attr('disabled','disabled');
					//~ $('#update_dispatch_id').val("Dispatch");
					
				//~ }
				
				//~ var promovalid = edit_promocode_validation(form,'edit');
				var promocode = $("#edit_promocode").val();	
				var promo_error = 'editPromocodeError';				
				$("#"+promo_error).hide().html("");
				
				var promovalid = true;
				
				if( promocode != '' )
				{
					$.ajax ({
						type: "POST",
						url: SrcPath+"taxidispatch/check_promocode",
						//data: dataS, 
						data: $(form).serialize(),
						cache: false, 
						dataType: 'html',
						timeout: 3000,
						success: function(response) 
						{
							if( response != 1 )
							{
								$("#"+promo_error).show().html(response);
								promovalid = false;
							}
							else{
								promovalid = true;
							}
						},
						error: function() {
							alert('<?php echo __("network_connection_failed"); ?>');
							//~ return false;
							promovalid = false;
						}
					});
				}
			
				
				setTimeout(function(){
				
					if(promovalid == true){
						
						if(NODE_ENVIROMENT!=1){
							
							form.submit();
							
						}else{
							$('#close_button').trigger('click');			
							$.ajax({
													
								url:URL_NODE+"updateDispatcherListing?domain="+SUB_NODE,
								type:"POST",
								data: $('#defaultForm_edit').serialize()+"&operation_id="+operation_id,
								dataType:"json",
								success:function(res){													
									if(res[1]==1){
										
									}
									else{
										all_booking_manage_list("update");
										$('#showLoaderImg').show();
										$('.showResults').html('<div class="alert alert-success" role="alert">'+res[1]+'</div>');
										setTimeout(function(){
											$('.showResults').html('');
											$('#close_button').trigger('click');
																		
										},4000)
										//alert("Updated successfully");							
									}							
								},
								error: function (textStatus, errorThrown) {
													
								}					
							});
						}	
					}
				}, 1000);
				//~ }		
				return false;		
				//~ edit_promocode_validation(form,'edit');	
			}
		});
		
    }
  </script>
   <script>
  	
  	notificationlogger=function()
  	{  	
  		return true;	
  		var Path = "<?php echo URL_BASE; ?>";
  		var post_param={};
  		var url_path = Path+"taxidispatch/notificationlogger";
  		$.ajax({
			url: url_path, 
			data: post_param, 
			cache: false, 
			success: function(response){
				
				var Obj=JSON.parse(response);
				$('.notification_block').html(Obj.html);						
			
			}		 
		});	

  		return false;
  	}  	

  	errorMessage=function(e,th)
  	{
  		var Path = "<?php echo URL_BASE; ?>"+'public/common/images/nodriver.png?q=';
  		$(th).attr('src',Path);
  		return true;
  	}

  	setInterval(function(){
  		//notificationlogger();

  	},30000)
  	notificationlogger();
function customRangeStart() {
		        gmt = new Date();
		        time = gmt.getTime() + (gmt.getTimezoneOffset() * 60000);
		        var currentTime = new Date((time) + parseInt(php_date_Z));
		        return currentTime;
		    };
/*for loader*/
$(window).load(function() {
    $(".new_loader").delay(500).fadeOut();
	$(".dispatch_slidebar").delay(500).addClass('active');
	/*$(".dispatch_slidebar").removeClass('active');*/
	/*$(".dispatch_slidebar").css('display','none');*/
});
//function to delete driver
function d_logout(driver_id, company_id) {
    var answer = confirm(want_to_logout);

    if (answer) {
        $.ajax({
            url: URL_BASE + "manage/driver_logout",
            type: "get",
            data: "driver_id=" + driver_id + "&company_id=" + company_id,
            success: function(data) {
                if (data == 1) {
                    alert(logout_success);
                    //window.location = SrcPath + 'analytics/analytics_driverinfo/' + driver_id;
                    window.location = SrcPath + 'taxidispatch/dashboard_beta';
                } else {
                    alert(driver_in_trip);
                }

            },
            error: function(data) {
                //alert(cid);
            }
        });
    }

    return false;
}

$(document).ready(function(){
	$('.close_onboard').click(function(){
		$('.onboard_container').hide();
	});
	$("#dispatchSetting").on("hidden.bs.modal", function () {
		$('.dispatch_sel').attr('checked', false);
	});
});
	
$(document).click(function(event) {       
    if (!$(event.target).is(".notification_icon") && !$(event.target).closest(".notification_block").length) {
    	$('.notification_block').removeClass('active');
    }
});
$(".notification_block").click(function(e) {          
 e.stopPropagation();         
});

$(document).click(function(event) {       
    if (!$(event.target).is(".vehicle_type.model_job_list .select_taxi_model") && !$(event.target).closest(".vehicle_list").length) {
    	$('.vehicle_list').removeClass('active');
    	$('.vehicle_type.model_job_list .select_taxi_model').removeClass('active');
    }
});
$(".vehicle_list,.fleet_vehicle_list").click(function(e) {          
 e.stopPropagation();         
});

$(document).click(function(event) {       
    if (!$(event.target).is(".filterStatus") && !$(event.target).closest(".status_list").length) {
    	$('.status_list').removeClass('active');
    	$('.filterStatus').removeClass('active');
    }
});
$(".status_list").click(function(e) {          
 e.stopPropagation();         
});

$(document).click(function(event) {       
    if (!$(event.target).is("#track_type") && !$(event.target).closest(".track_list").length) {
    	$('.track_list').removeClass('active');
    	$('#track_type').removeClass('active');
    }
});
$(".track_list").click(function(e) {          
 e.stopPropagation();         
});

$(document).click(function(event) {       
    if (!$(event.target).is(".select_taxi_model.model_type") && !$(event.target).closest(".fleet_vehicle_list").length) {
    	$('.fleet_vehicle_list').removeClass('active');
    	$('.select_taxi_model.model_type').removeClass('active');
    }
});
$(".fleet_vehicle_list").click(function(e) {          
	e.stopPropagation();         
});

$('#os_trip_type').on('change', function() {
	if($(this).val() == 2)
	{
		$('.days_count').show();
		$("#tripDescription").html('1 day round trip');
	} else {
		$('.days_count').hide();
		$('.days_count_desc').hide();
		$("#tripDescription").html('12 hours one-way trip');
	}
	outstation_type_options();
});

$('#edit_os_trip_type').on('change', function() {
	if($(this).val() == 2)
	{
		$('.edit_days_count').show();
		$("#edit_tripDescription").html('1 day round trip');
	} else {
		$('.edit_days_count').hide();
		$('.edit_days_count_desc').hide();
	}
	edit_outstation_type_options();
});

$('#os_days_count').on('change', function(){
	outstation_type_options();
});
$('#edit_os_day_count').on('change', function(){
	edit_outstation_type_options();
});
$(".open_dispth_icon").click(function(e) {          
	$('.dispatch_slidebar').addClass('active');
});

//start of outstation fare calculation
function outstation_type_options()
{
	os_pickup_latitude = $('#pickup_lat').val();
	os_pickup_longitude = $('#pickup_lng').val();
	os_drop_latitude = $('#drop_lat').val();
	os_drop_longitude = $('#drop_lng').val();
		
	var rental_os = $("#trip_type").val();

	if (os_pickup_latitude != '' && os_pickup_longitude != '' && os_drop_latitude != '' && os_drop_longitude != '' && rental_os != '1') {
		// initialize();
		var base_fare = $('#package_base_fare').val();
		var approx_distance = $('#package_distance').val();
		var additional_distance_fare = $('#package_addl_distance_fare').val();
		var approx_duration = $('#package_plan_duration').val();
		var additional_hr_fare = $('#package_addl_hour_fare').val();
		
        var pickup = os_pickup_latitude + "," + os_pickup_longitude;
        var drop_latlng = os_drop_latitude + "," + os_drop_longitude;
        var extra_distance_fare = extra_duration_fare = 0;
        var start = pickup;
        var end = drop_latlng;

        if(dashboard_beta_directions_from == 2)
        {
        	var directionsRequest = 'https://api.mapbox.com/directions/v5/mapbox/driving/'+pickup+';'+drop_latlng+'?access_token='+mapbox_key;
			$.ajax({
				method: 'GET',
				url: directionsRequest,
			}).done(function(data) {
				if(data['code'] == 'Ok')
	        	{
	        		total_duration = data['routes']['duration'];
	        		total_distance = data['routes']['distance'];

	        		travel_duration = parseFloat(total_duration)/60;
	        		total_duration = (parseFloat(total_duration) * 2) / 60; // convert to mins
	        	}
	        	outstation_type_options_remaining(total_distance,travel_duration,total_duration)
			}).error(function() {
				return false;
			});

        } else {

	        var request = {
	            origin: start,
	            destination: end,
	            optimizeWaypoints: true,
	            travelMode: google.maps.TravelMode.DRIVING
	        };

	        var directionsService = new google.maps.DirectionsService();

	        directionsService.route(request, function(response, status) {
	        	if (status === 'OK') {
	            	
	                var route = response.routes[0];
	                var total_distance = total_duration = extra_duration = extra_duration_to_hr = extra_duration_fare = travel_duration = 0;
	                var total_distance_km = show_time = td = 0;
	                
	                for (var i = 0; i < route.legs.length; i++) {
	                    var drop_lat = route.legs[i].end_location.lat();
	                    var drop_lng = route.legs[i].end_location.lng();
	                    var drop_latlng = drop_lat + "," + drop_lng;
	                    //total_distance += (oneway_round == 2) ? (2 * parseFloat(route.legs[i].distance.value)) : parseFloat(route.legs[i].distance.value);
	                    total_distance += parseFloat(route.legs[i].distance.value);
	                    total_duration += parseInt(route.legs[i].duration.value);
	                }
	            }
                
                travel_duration = parseFloat(total_duration)/60;
                total_duration = (parseFloat(total_duration) * 2) / 60; // convert to mins
                outstation_type_options_remaining(total_distance,travel_duration,total_duration);
            });
            //outstation_type_options_remaining(total_distance,travel_duration,total_duration);
        }
    }
    else{
		$("#tax_inclusive").html(taxInclusive);
	}
}
//End of outstation fare calculation

function outstation_type_options_remaining(total_distance,travel_duration,total_duration){
	rental_os = $("#trip_type").val();
	var base_fare = $('#package_base_fare').val();
	var approx_distance = $('#package_distance').val();
	var additional_distance_fare = $('#package_addl_distance_fare').val();
	var approx_duration = $('#package_plan_duration').val();
	var additional_hr_fare = $('#package_addl_hour_fare').val();
	var extra_distance_fare = extra_duration_fare = 0;
	var oneway_duration = travel_duration;
	day = 0;
    //if(total_duration > min_round_trip && $("#trip_type").val() == 3)
    if(oneway_duration > min_round_trip && $("#trip_type").val() == 3)
    {
    	$("#os_trip_type option[value='1']").remove();
        $("#os_trip_type").val('2');
        $("#round_one_way_select").show();
        $(".days_count").show();
        day = $('#os_days_count').val();
        $("#tripDescription").html(day+' day(s) round trip');
        $(".days_count_desc").show();
    } else {
    	var optionExists = ($('#os_trip_type option[value="1"]').length > 0);
		if(!optionExists)
		{
    		$("#os_trip_type option").eq(1).before($("<option></option>").val("1").text("One-way"));
    	}
    	
		if($("#os_trip_type").val() == 2 && $("#trip_type").val() == 3)
        {
        	day = $('#os_days_count').val();
            $(".days_count").show();
            $("#tripDescription").html(day+' day(s) round trip');
            $(".days_count_desc").show();
        } else if($('#trip_type').val() == 3) {
        	$("#round_one_way_select").show();
        	$("#os_trip_type").val('1')
            $(".days_count").hide();
           
            if (!$("#tripDescription").text().trim().length) {
				$("#tripDescription").html('12 hour(s) oneway trip');
			}						
            $(".days_count_desc").show();
        } else {
        	$("#round_one_way_select").hide();
        	$(".days_count").hide();
        	$(".days_count_desc").hide();
        }
    }
    
    var oneway_round = $("#os_trip_type").val();
    
	total_distance = parseFloat(total_distance) / 1000;

	var t = $("#default_company_unit").val();
	if (t == "miles")
	{
	var  total_distance = (total_distance / 1.60934);
	}

    total_distance = (rental_os == 3 && oneway_round == 2) ? (2 * parseFloat(total_distance)) : parseFloat(total_distance);
    travel_duration = (rental_os == 3 && oneway_round == 2) ? (2 * parseFloat(travel_duration)) : parseFloat(travel_duration);

var OUTSTATION_ROUND_DOUBLE_FARE='<?php echo defined("OUTSTATION_ROUND_DOUBLE_FARE")?OUTSTATION_ROUND_DOUBLE_FARE:1 ?>';

    approx_distance =(rental_os == 3 && oneway_round == 2 && parseInt(OUTSTATION_ROUND_DOUBLE_FARE)===1) ? (2 * parseFloat(approx_distance)) : parseFloat(approx_distance);	
	approx_duration = (rental_os == 3 && oneway_round == 2  && parseInt(OUTSTATION_ROUND_DOUBLE_FARE)===1) ? (2 * parseFloat(approx_duration)) : parseFloat(approx_duration);

	

	base_fare = (rental_os == 3 && oneway_round == 2 && parseInt(OUTSTATION_ROUND_DOUBLE_FARE)===1) ? (2 * parseFloat(base_fare)) : parseFloat(base_fare);
	
    if (total_distance > approx_distance) {
    	var extra_distance = total_distance - approx_distance;
        extra_distance_fare = extra_distance * additional_distance_fare;
    }
    
    
    if (parseFloat(travel_duration) > parseFloat(approx_duration)) {
    	var extra_duration = parseFloat(travel_duration) - parseFloat(approx_duration);
        var extra_duration_to_hr = parseFloat(extra_duration) / 60;
        extra_duration_fare = parseFloat(extra_duration_to_hr) * parseFloat(additional_hr_fare);
    }
    
    var approx_trip_fare = parseFloat(base_fare) + parseFloat(extra_duration_fare) + parseFloat(extra_distance_fare);
    approx_trip_fare = parseFloat(approx_trip_fare).toFixed(2);                
    extra_rt_fare = 0;
    
    if(day > 0)
    {
        cal_hr = (day * 24 * 60)-approx_duration;
        if(cal_hr > 0)
        {
            final_cal_hr = cal_hr / 60;
            extra_rt_fare = final_cal_hr * additional_hr_fare;
        }
        approx_trip_fare = parseFloat(approx_trip_fare) - parseFloat(extra_duration_fare);
    }
    
    final_approx_trip_fare = parseFloat(approx_trip_fare) + parseFloat(extra_rt_fare);
    
    if(isNaN(final_approx_trip_fare))
    {
    	final_approx_trip_fare = 0;
    	var subtotal_fare = 0;
    }
    else
    {
    	var subtotal_fare = final_approx_trip_fare;
    	var tax = '<?php echo TAX; ?>';
    	var tax_amount = final_approx_trip_fare * tax / 100;
    	final_approx_trip_fare = tax_amount + final_approx_trip_fare;
    	$("#tax_inclusive").html(taxInclusive);
    }
		
	var round_dis = total_distance.toFixed(2)+" "+unitname;
	
	
	var show_time_secs = (parseFloat(travel_duration)) * 60;	
	
	var show_time = secondsToHms(show_time_secs);	
	$("#find_km").html(round_dis);				
	$("#find_duration").html(show_time);                
    $("#min_fare").html(final_approx_trip_fare.toFixed(2));
    $("#min_fare1").val(final_approx_trip_fare.toFixed(2));
    $("#subtotal_fare").val(subtotal_fare.toFixed(2));
    $("#tax_amount").val(tax_amount);
    
}

//start of outstation fare calculation
function edit_outstation_type_options()
{
	console.log('edit_outstation_type_options');
	var total_distance = 0;
	os_pickup_latitude = $('#edit_pickup_lat').val();
	os_pickup_longitude = $('#edit_pickup_lng').val();
	os_drop_latitude = $('#edit_drop_lat').val();
	os_drop_longitude = $('#edit_drop_lng').val();
	var oneway_round = $("#edit_os_trip_type").val();

	if (os_pickup_latitude != '' && os_pickup_longitude != '' && os_drop_latitude != '' && os_drop_longitude != '') {
		var base_fare = $('#edit_package_base_fare').val();
		var approx_distance = $('#edit_package_distance').val();
		var additional_distance_fare = $('#edit_package_addl_distance_fare').val();
		var approx_duration = $('#edit_package_plan_duration').val();
		var additional_hr_fare = $('#edit_package_addl_hour_fare').val();

        /*var pickup = os_pickup_longitude + "," + os_pickup_latitude;
        var drop_latlng = os_drop_longitude + "," + os_drop_latitude;*/
      	var pickup =   os_pickup_latitude+ "," +os_pickup_longitude;
        var drop_latlng =   os_drop_latitude+ "," +os_drop_longitude;

        var extra_distance_fare = extra_duration_fare = 0;
        var start = pickup;
        var end = drop_latlng;
        if(dashboard_beta_directions_from == 2)
        {
        	var directionsRequest = 'https://api.mapbox.com/directions/v5/mapbox/driving/'+pickup+';'+drop_latlng+'?access_token='+mapbox_key;
        	$.ajax({
				method: 'GET',
				url: directionsRequest,
			}).done(function(data) {
				if(data['code'] == 'Ok')
	        	{
	        		total_duration = data['routes'][0]['duration'];
	        		total_distance = data['routes'][0]['distance'];

	        		travel_duration = parseFloat(total_duration)/60;
	        		total_duration = (parseFloat(total_duration) * 2) / 60; // convert to mins
	        	}
	        	edit_outstation_type_options_remaining((total_distance/1000).toFixed(2), total_duration)
			}).error(function() {
				return false;
			});

        } else {
	        var request = {
	            origin: start,
	            destination: end,
	            optimizeWaypoints: true,
	            travelMode: google.maps.TravelMode.DRIVING
	        };

	        var directionsService = new google.maps.DirectionsService();
	        directionsService.route(request, function(response, status) {
	        	if (status === 'OK') {
	            	
	                var route = response.routes[0];
	                var total_distance = total_duration = extra_duration = extra_duration_to_hr = extra_duration_fare = 0;
	                var total_distance_km = show_time = td = 0;

	                for (var i = 0; i < route.legs.length; i++) {
	                    var drop_lat = route.legs[i].end_location.lat();
	                    var drop_lng = route.legs[i].end_location.lng();
	                    var drop_latlng = drop_lat + "," + drop_lng;

	                    total_distance += (oneway_round == 2) ? (2 * parseFloat(route.legs[i].distance.text)) : parseFloat(route.legs[i].distance.text);
	                    total_duration += parseInt(route.legs[i].duration.value);
	                }
                }
               edit_outstation_type_options_remaining(total_distance, total_duration)
            });
            
            edit_outstation_type_options_remaining(total_distance, total_duration)
        }
    }
}
//End of outstation fare calculation

function edit_outstation_type_options_remaining(total_distance, total_duration)
{
	var oneway_round = $("#edit_os_trip_type").val();
	var rental_os = $("#edit_trip_type_dis").val();
	var base_fare = $('#edit_package_base_fare').val();
	var approx_distance = $('#edit_package_distance').val();
	var additional_distance_fare = $('#edit_package_addl_distance_fare').val();
	var approx_duration = $('#edit_package_plan_duration').val();
	var additional_hr_fare = $('#edit_package_addl_hour_fare').val();
	var extra_distance_fare = extra_duration_fare = 0;

	if (total_distance > approx_distance) {
    	var extra_distance = total_distance - approx_distance;
        extra_distance_fare = extra_distance * additional_distance_fare;
    }
    
    var oneway_duration = (parseFloat(total_duration)) / 60; // convert to mins
    
    total_duration = (parseFloat(total_duration) * 2) / 60; // convert to mins
    day = 0;
    //if(total_duration > min_round_trip && $("#edit_trip_type").val() == 3)
    if(oneway_duration > min_round_trip && $("#edit_trip_type").val() == 3)
    {
    	$("#edit_os_trip_type option[value='1']").remove();
        $("#edit_os_trip_type").val('2');
        $("#edit_round_one_way_select").show();
        $(".edit_days_count").show();
        day = $('#edit_os_day_count').val();
        $("#edit_tripDescription").html(day+' day(s) round trip');
        $(".edit_days_count_desc").show();
    } else {
    	var optionExists = ($('#edit_os_trip_type option[value="1"]').length > 0);
		if(!optionExists)
		{
    		$("#edit_os_trip_type option").eq(1).before($("<option></option>").val("1").text("One-way"));
    	}
    	$(".edit_days_count_desc").show();
		if($("#edit_os_trip_type").val() == 2 && $("#edit_trip_type").val() == 3)
        {
        	day = $('#edit_os_day_count').val();
            $(".edit_days_count").show();
            $("#edit_tripDescription").html(day+' day(s) round trip');
        } else if($("#edit_trip_type").val() == 3) {
        	$("#edit_os_trip_type").val('1');
            $(".edit_days_count").hide();
            var edit_plan = $(".edit_plan_duration").val();
            if(edit_plan == 12){
            	$("#edit_tripDescription").html('12 hour(s) oneway trip');    
            }else{
            	$("#edit_tripDescription").html('24 hour(s) oneway trip');
            }
        } else {
        	$("#edit_round_one_way_select").hide();
        	$(".edit_days_count").hide();
        	$(".edit_days_count_desc").hide();
        }
    }

    if (parseFloat(total_duration) > parseFloat(approx_duration)) {
    	var extra_duration = parseFloat(total_duration) - parseFloat(approx_duration);
        var extra_duration_to_hr = parseFloat(extra_duration) / 60;
        extra_duration_fare = parseFloat(extra_duration_to_hr) * parseFloat(additional_hr_fare);
    }
    
    var approx_trip_fare = parseFloat(base_fare) + parseFloat(extra_duration_fare) + parseFloat(extra_distance_fare);
    approx_trip_fare = parseFloat(approx_trip_fare).toFixed(2);                
    extra_rt_fare = 0;
    
    if(day > 0)
    {
        cal_hr = (day * 24 * 60)-approx_duration;
        if(cal_hr > 0)
        {
            final_cal_hr = cal_hr / 60;
            extra_rt_fare = final_cal_hr * additional_hr_fare;
        }
    }

    final_approx_trip_fare = parseFloat(approx_trip_fare) + parseFloat(extra_rt_fare);
    if(isNaN(final_approx_trip_fare))
    {
    	final_approx_trip_fare = 0;
    }
        
    var round_dis = total_distance+" "+unitname;
	$("#edit_find_km").html(round_dis);	
	var show_time_secs = $("#show_time_secs").val();
	console.log('show_time_secs'+show_time_secs);
	if(rental_os == 3 && oneway_round == 2){
		show_time_secs = show_time_secs * 2;					
	}					
	var show_time = secondsToHms(show_time_secs);
	if(show_time_secs != 0 && show_time_secs != undefined){
		$("#edit_find_duration").html(show_time);
	}				
	$("#edit_min_fare").html(final_approx_trip_fare.toFixed(2));
}

function loadPackageDetail(selected, from)
{
	var val = [];
	if(typeof selected != 'number')
	{
		val = selected.split("-");
	} else {
		val[3] = selected
	}
	
	if(val[3] > 0)
	{
		$.ajax({
			url : "<?php echo URL_BASE; ?>users/get_package_detail",
			data : { 'plan' : val[3] },
			type : 'POST',
			dataTtype : 'JSON',
			success : function(data) {
				op = JSON.parse(data);
				if(op != '')
				{
					if(from == 'add')
					{
						$('#package_base_fare').val(op.base_fare);
						$('#package_distance').val(op.distance);
						$('#package_plan_duration').val(op.plan_duration);
						$('#package_addl_distance_fare').val(op.additional_fare_per_distance);
						$('#package_addl_hour_fare').val(op.additional_fare_per_hour);
						outstation_type_options();
					} else {
						$('#edit_package_base_fare').val(op.base_fare);
						$('#edit_package_distance').val(op.distance);
						$('#edit_package_plan_duration').val(op.plan_duration);
						$('#edit_package_addl_distance_fare').val(op.additional_fare_per_distance);
						$('#edit_package_addl_hour_fare').val(op.additional_fare_per_hour);
						edit_outstation_type_options();
					}
					
				}
			},
			error : function() {

			}
		});
	}
}

function change_minfare_prehire() {
	console.log("change_minfare_prehire");
	var e = $("#taxi_model").val();
	var company_id = $("#driver_company_id").val();
	var r = $(".edit_job_container").css("display");
    if (r=="block") {
    	e = $("#edit_taxi_model").val();
        var edit_pickup_latitude = $('#edit_pickup_lat').val();
        var edit_pickup_longitude = $('#edit_pickup_lng').val();
        var edit_drop_latitude = $('#edit_drop_lat').val();
        var edit_drop_longitude = $('#edit_drop_lng').val();
        
        var type = $('#edit_trip_type').val();
        var t = $("#edit_distance_km").val(),
            a = $("#edit_total_duration_secs").val();
        (isNaN(t) || "" == t) && (t = 0), "" == a && (a = 0);
        var o = $("#edit_cityname").val(),
            n = $("#edit_city_id").val();
        calculate_totalfare_flag_prehire(t, e, o, n, a, type, edit_pickup_latitude, edit_pickup_longitude, edit_drop_latitude, edit_drop_longitude,company_id);
    } else {
        var p_latitude = $('#pickup_lat').val();
        var p_longitude = $('#pickup_lng').val();
        var d_latitude = $('#drop_lat').val();
        var d_longitude = $('#drop_lng').val();
        
        var type = $('#trip_type').val();
        var t = $("#distance_km").val(),
            a = $("#total_duration_secs").val();
        (isNaN(t) || "" == t) && (t = 0), "" == a && (a = 0);
        var o = $("#cityname").val(),
            n = $("#city_id").val();
        calculate_totalfare_prehire(t, e, o, n, a, type, p_latitude, p_longitude, d_latitude, d_longitude,company_id)
    }
}

function calculate_totalfare_prehire(e, r, t, a, o, type, p_latitude, p_longitude, d_latitude, d_longitude,company_id) {
	console.log("calculate_totalfare_prehire");
         if ("" != trim(r) && ("" != trim(t) || "" != trim(a))) {
        if (typeof type === "undefined" || type == "") {
            type = '1';
        }

        var os_trip_type = $('input[name=os_trip_type]:checked').val();
        var os_days_count = $("#days_count").val();
        var approx_distance = $("#distance_km").val();
        var approx_duration = $("#total_duration").val();
        var approx_dis = $("#distance_km").val();
        var parse_dis = parseFloat(approx_dis);
        var parse_km_constant = parseFloat(km_val);
        if((km_val != 0) && (parse_dis >= parse_km_constant))
        {
            $(".err_valid").css('display','block');
            $("#trip_validation").html(trip_type_err_msg);    
            $("#trip_err_val").val(1);
        }else{
            $(".err_valid").css('display','none');
            $("#trip_validation").html("");    
            $("#trip_err_val").val(0);
        }
        var n = SrcPath + "tdispatch/get_citymodel_fare_details/",
            i = "distance_km=" + e + "&model_id=" + r + "&city_name=" + t + "&city_id=" + a + "&total_min=" + o + "&trip_type=" + type + "&os_trip_type=" + os_trip_type + "&os_days_count=" + os_days_count + "&approx_duration=" + approx_duration + "&approx_distance=" + approx_distance + "&pickup_latitude=" + p_latitude + "&pickup_longitude=" + p_longitude + "&drop_latitude=" + d_latitude + "&drop_longitude=" + d_longitude + "&company_id="+company_id;
        $("#min_fare").html('<img alt="ajax-loader" src="' + SrcPath + '/public/common/css/img/ajax-loaders/ajax-loader-1.gif" />'), $.ajax({
            type: "GET",
            url: n,
            data: i,
            cache: !1,
            async: !0,
            dataType: "html",
            success: function(e) {
                if (type > 1) {
                    $('.add_normal_fare_calc').hide();
                    $('.add_ro_fare_calc').show();
                    data = JSON.parse(e);
                    $('#ro_find_duration').text(data.base_fare);
                    $('#ro_find_km').text(data.addl_km_fare);
                    $('#ro_find_hr').text(data.addl_hr_fare);
                    $('#ro_approx_fare').text(data.appr_fare);
                } else {
                    $('.add_normal_fare_calc').show();
                    $('.add_ro_fare_calc').hide();
                    if(CHANGE_BOOKING_TYPE == 1){
                        var res_data = JSON.parse(e),
                        r = res_data.total_fare,
                        check_booking_cond = res_data.inside_city_check;
                        if(check_booking_cond == 0){
                            $(".err_valid").css('display','block');
                            $("#trip_validation").html(trip_type_err_msg);    
                            $("#trip_err_val").val(1);
                        }else{
                            $(".err_valid").css('display','none');
                            $("#trip_validation").html("");    
                            $("#trip_err_val").val(0);
                        }
                    }else{
                        var r = e;
                    }
                    //var r = e,
                    var t = $("#vat_tax").html();
                    var a = (r * t / 100).toFixed(2);
                    var o = r; $("#min_fare").html(o), $("#sub_total").html(o), $("#total_price").html(o), $("#total_fare").val(o), $("#min_fare").removeClass("strike");
                    var n = $("#fixedprice").val();
                    if ("" == n) {
                        $("#min_fare").removeClass("strike");
                        var i = $("#total_fare").val();
                        $("#total_price").html(i)
                    } else {
                        $("#total_price").html(n), $("#min_fare").addClass("strike")
                    }
                }
            }
        })
    }
    
}

function calculate_totalfare_flag_prehire(e, r, t, a, o, type,e_p_latitude, e_p_longitude, e_d_latitude, e_d_longitude,company_id) {
	console.log("calculate_totalfare_flag_prehire")
    if ("" != trim(r) && ("" != trim(t) || "" != trim(a))) {
        var edit_approx_dis = $("#edit_distance_km").val();
        if((km_val != 0) && (edit_approx_dis >= km_val))
        {
            $(".err_valid").css('display','block');
            $("#edit_trip_validation").html(trip_type_err_msg);    
            $("#trip_err_val").val(1);
        }else{
            $(".err_valid").css('display','none');
            $("#edit_trip_validation").html("");    
            $("#trip_err_val").val(0);
        }
        var n = SrcPath + "tdispatch/get_citymodel_fare_details/",
            i = "distance_km=" + e + "&model_id=" + r + "&city_name=" + t + "&city_id=" + a + "&total_min=" + o + "&trip_type=" + type + "&pickup_latitude=" + e_p_latitude + "&pickup_longitude=" + e_p_longitude + "&drop_latitude=" + e_d_latitude + "&drop_longitude=" + e_d_longitude + "&company_id="+company_id;

        $("#edit_min_fare").html('<img alt="ajax-loader" src="' + SrcPath + '/public/common/css/img/ajax-loaders/ajax-loader-1.gif" />'), $.ajax({
            type: "GET",
            url: n,
            data: i,
            cache: !1,
            async: !0,
            dataType: "html",
            success: function(e) {
                if (type > 1) {
                    $('.edit_normal_fare_calc').hide();
                    $('.edit_ro_fare_calc').show();
                    data = JSON.parse(e);
                    $('#ro_edit_find_duration').text(data.base_fare);
                    $('#ro_edit_find_km').text(data.addl_km_fare);
                    $('#ro_edit_find_hr').text(data.addl_hr_fare);
                    $('.edit_normal_fare_calc').show();
                    $('.edit_ro_fare_calc').hide();
                } else {
                    var r = e,
                        t = $("#edit_vat_tax").html(),
                        a = (r * t / 100).toFixed(2);
                    o = r, $("#edit_min_fare").html(o), $("#edit_sub_total").html(o), $("#edit_total_price").html(o), $("#edit_total_fare").val(o), $("#edit_min_fare").removeClass("strike");
                    var n = $("#edit_fixedprice").val();

                    if ("" == n) {
                        $("#edit_min_fare").removeClass("strike");
                        var i = $("#edit_total_fare").val();
                        $("#edit_total_price").html(i)
                    } else {
                        $("#edit_total_price").html(n), $("#edit_min_fare").addClass("strike");
                    }
                }
            }
        })
    }
}

//setInterval(function(){all_booking_manage_list_new_design()},10000)

	// Open edit trip screen 
	$(document).ready(function(){
		if(tripId != ''){
			edit_icon_new_design(tripId);			
		}	
	});

function verifyAssignStatus(tripId)
{
	window.localStorage.setItem('scheduleTrips',tripId);	
}
var scheduleTripID=0;
function VerifyScheduleBookingStatus()
{
	var scheduleTrips=window.localStorage.getItem("scheduleTrips");
	if(typeof scheduleTrips !=undefined && scheduleTrips !='' && parseInt(scheduleTrips)>0 && parseInt(SCHEDULE_TRIP_NOTIFICATION)===1 && scheduleTripID !=scheduleTrips)
	{
		scheduleTripID=scheduleTrips;
		setTimeout(function(){

		$.ajax({
			url : "<?php echo URL_BASE; ?>taxidispatch/schedule_trip_status",
			data : { 'trip_id' : scheduleTripID },
			type : 'POST',
			dataTtype : 'JSON',
			success : function(data) {
				var res=JSON.parse(data);
				if(parseInt(res.verified_status)===0)
				{
					var msg='Trip ID: '+scheduleTripID+' <?php echo __('scheduled_request_rejected') ?>';
					alert(msg);
					window.localStorage.setItem('scheduleTrips',0);
				}else{
					window.localStorage.setItem('scheduleTrips',0);	
				}
			}
		})
		},30000)
	}
}
VerifyScheduleBookingStatus();

	function fn(id)
	{
		//var id = $(this).attr("data-id");
			var select_id = $(this).parent().attr("id");
			// $.ajax({
			// 	url: "pagination.php",
			// 	type: "GET",
			// 	data: {
			// 		page : id
			// 	},
			// 	cache: false,
			// 	success: function(dataResult){
			// 		$("#target-content").html(dataResult);
			// 		$(".pageitem").removeClass("active");
			// 		$("#"+select_id).addClass("active");
					
			// 	}
			// });
			var company = $("#select_company").val();
		var scrollEnable = $("#scroll_enabled").val();
       
		var taxi_company=taxi_company_def;
		

		var status_cancel = [];
		$.each($("input[name='status_cancel']:checked"), function(){            
			status_cancel.push($(this).val());
		});
		
		var search_txt = $('#search_txt').val();
		
			/*
		var taxi_model = [];
		$(".model_job_list .select_taxi_model")
		$.each($(".model_job_list .select_taxi_model.active"), function(){            
			taxi_model.push($(this).attr('data-id'));
		});

		taxi_model=taxi_model.join(",");*/
		var status_color = $("#status_type").attr('data-val');
		var taxi_model = $("#vehicle_type").attr('data-id');

		var pass_logid = $(".job_search_bar").val();
		var Path = "<?php echo URL_BASE; ?>";
		var dataS = "travel_status="+status_color+"&taxi_company="+taxi_company+"&taxi_model="+taxi_model+"&search_txt="+search_txt+"&trip_id="+pass_logid+"&filterLimit="+$('#filterLimit').val()+"&page="+id;
	
		var url_path = Path+"taxidispatch/all_booking_list_manage_new_design";
		
		var response;
		$.ajax({
			url: url_path, 
			data: dataS, 
			cache: false, 
			success: function(response){
				
											
				$('.job_listing_container').html(response);
				if($(".dispatch_det_slidebar").hasClass('active'))
				{
					
				}else{
					$(".dispatch_det_slidebar").removeClass('active');	
				}
				

				$('#showLoaderImg').hide();
				nextSetOfDisListing=0;			
			}		 
		});
	}
 
		
 
</script>
