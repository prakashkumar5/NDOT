<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="<?php echo URL_BASE; ?>public/chart_new/css/bootstrap.min.css"/>
</head>
<body>
	<div class="expiry_outter">
		<div class="expiry_content">
			 <div class="row">
			 	<div class="top_heading col-md-12 text-center">23 days remaining</div>
				<div class="top_heading_bottom col-md-12 text-center">Lowest industry price and the best value for money</div>
			 </div>
			 <div class="row mt50">
				<div class="col-md-12">
					<ul class="expiry_option_body box_shadow_common">
						<li>
							<div class="expiry_option col-md-12 text-center">
								<p>Basic</p>
								<h1>Free</h1>
								<span>Its for basic business users</span>
							</div>
							<ul>
								<li>Auto-dispatching</li>
								<li>Scheduled / Advanced Booking</li>
								<li>Real-time Tracking</li>
								<li>Online Payment</li>
								<li>Promo Code Option</li>
								<li>Split fare</li>
								<li>Manage Drivers</li>
								<li>Manage Dispatchers</li>
							</ul>
							<div class="expiry_option_more">
								<a href="javascript:;" title="See all Features">See all Features</a>
								<a href="javascript:;" title="Try it for free" class="stroke-button">Try it for free</a>
							</div>
						</li>
						<li>
							<div class="expiry_option col-md-12 text-center">
								<p>Startup</p>
								<h1>$1000</h1>
								<span>Its for customers starting with 20-100 fleet</span>
							</div>
							<ul>
								<li>Auto-dispatching</li>
								<li>Scheduled / Advanced Booking</li>
								<li>Real-time Tracking</li>
								<li>Online Payment</li>
								<li>Promo Code Option</li>
								<li>Split fare</li>
								<li>Manage Drivers</li>
								<li>Manage Dispatchers</li>
							</ul>
							<div class="expiry_option_more">
								<a href="javascript:;" title="See all Features">See all Features</a>
								<a href="javascript:;" title="Try it for free" class="fill-button addons_butt">Get Started</a>
							</div>
						</li>
						<li>
							<div class="expiry_option col-md-12 text-center">
								<p>Enterprise</p> 
								<p class="mt50"><span>For large and business account running greater than 100 fleets</span></p>
							</div>
							<ul>
								<li>Auto-dispatching</li>
								<li>Scheduled / Advanced Booking</li>
								<li>Real-time Tracking</li>
								<li>Online Payment</li>
								<li>Promo Code Option</li>
								<li>Split fare</li>
								<li>Manage Drivers</li>
								<li>Manage Dispatchers</li>
							</ul>
							<div class="expiry_option_more">
								<a href="javascript:;" title="See all Features">See all Features</a>
								<a href="javascript:;" title="Try it for free" class="stroke-button">Contact Us</a>
							</div>
						</li>
					</ul>	
				</div>		
			 </div>
			 <div class="row mt50 addons" style="display:none;">
			 	<div class="top_heading_sub col-md-12 text-center">Addons</div>
				<div class="pack_option col-md-12 d-flex justify-content-center mt30">
					<div class="option_price">
						<div class="option_select">
							<label class="option_select_label">
                   				<input type="checkbox" name=" " value=" " id="choose_plan">
                   				<span class="checkmark"></span>
                   		 	</label>
						</div>
						<div class="option_price_li d-flex justify-content-between">
							<div class="option_pri_inner d-flex">
								<p class="d-grid">	
									<span>White Label</span>
									<span>Your Business, Your Brand</span>
									<span style="visibility:hidden">Your Business</span>
								</p>
							</div>
							<div class="option_pri_inner d-flex">    
								<p class="d-grid">	
									<span>Android</span>
									<span>Passenger App</span>
									<span>Driver App</span>
								</p>
							</div>
							<div class="option_pri_inner d-flex">
								<p class="d-grid">	
									<span>iOS</span>
									<span>Passenger App</span>
									<span>Driver App</span>
								</p>
							</div>
						</div>
					</div>
				</div>
			 
				 <div class="top_heading_sub col-md-12 text-center mt50">
					 <div class="deals_sel">
						<div class="toggle_button">
							<div class="button_cover">
								<!-- <div class="button">
									<input type="checkbox" class="checkbox" id="plan_choose">
									<div class="knobs"></div>
									<div class="knobs extra_need"></div>
								</div> -->
								<a href="javascript:;" title="Monthly" class="monthly active">Monthly</a>
								<a href="javascript:;" title="Annual" class="annual">Annual</a>
							</div>
						</div>
					 </div>
					 <div class="dri_sel">
						 <div class="cost_li d-flex justify-content-between align-items-end mt30">
							 <p><span>Plan:</span>&nbsp;up to&nbsp;<span id="res">10</span>&nbsp;Drivers</p>
							 <p class="d-grid text-right">
								 <span class="show_label_cost option_price">White labeling&nbsp;&nbsp;<span>$3000</span></span>
								 <span class="mt10">From&nbsp;&nbsp;<span>$10&nbsp;</span><span>/ Driver</span></span>
							 </p>
						 </div> 
						 <div class="dri_count_body mt40"> 
						 	<div id="dri_count"></div>
						 </div>
						 <div class="prices_li mt40">
							<p class="text-right"><span>Total:</span><span>$3450</span></p>
							<p class="text-right"><a href="javascript:;" title="Pay Now" class="fill-button">Pay Now</a></span></p>
						</div>
					 </div>
				 </div>
			 </div>
		</div>
	</div>
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
	<script src="<?php echo URL_BASE; ?>public/common/js/r-slider.js?v=<?php echo time(); ?>"></script> 
	<script>
			$(document).ready(function(){
				$("#plan_choose").on('change', function() {
				if ($("#plan_choose").is(':checked'))
					$(".knobs").addClass("active");
				else {
					$(".knobs").removeClass("active");
				}
				});

				$("#choose_plan").on('change', function() {
				if ($("#choose_plan").is(':checked')) 
					$(".option_price").addClass("active");
				else { 
					$(".option_price").removeClass("active");

				}
				});
				
				$(".button_cover a").click(function(){
					$(".button_cover a").removeClass('active');
					$(this).addClass('active');
				});

				var a11 = new slider({
					container: "#dri_count",
					start: 0,
					end: 100,
					step: 5,
					value: 10,
					showValue: false,
					ondrag: change,
					pinStep: 10,
					labelStep: 20
				});
		 
				function change(obj) { 
					$('#res').html(obj.values.toString())  
				}
				
				$('.addons_butt').click(function(){
					$('.addons').show();
				});
				
				 
    		});
			
	</script>
</html>




