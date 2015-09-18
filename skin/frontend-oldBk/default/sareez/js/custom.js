// JavaScript Document

// Slider
jQuery(document).ready(function(){
						   
	jQuery('#slider').cycle({ 
		fx:     'scrollHorz', 
		timeout: 4000, 
		pager:  '#snav',
		pause:   1 
	});


	jQuery('#slider2').cycle({ 
		fx:     'scrollHorz', 
		timeout: 4000, 
		pager:  '#snav'
	});
	
	
	jQuery('#powerSlider').cycle({ 
		fx:     'fade', 
		timeout: 4000, 
		pager:  '#pnav'
	});
	
	jQuery('#testi-slider').cycle({
		fx: 'fade', 
		timeout: 4000, 
								  });
	
	
	
    var closeNotification = function(e) {
       if(jQuery(e.target).closest('.callFormPan').length > 0) {
          // notification or child of notification was clicked; ignore
          return;
       }

       jQuery('.callFormPan').fadeOut();
       jQuery(document).unbind('click', closeNotification);
    };

    jQuery('.callPan .number').click(function(){
        jQuery('.callFormPan').fadeIn(function() {
            jQuery(document).bind('click', closeNotification);
        });
    });
	
	jQuery(function() {
		jQuery('#timePicker').datetimepicker({
			timeFormat: "hh:mm tt"
		});
	});
	
});
	



$(document).ready(function(){
	
	

	$(".switchHeader .link1").click(function(){
		$('.switchHeader li a').removeClass("active");
		$(this).addClass("active");
		$(".switchFormContainer .switchForm").stop().animate({left: "0px"});
		return false;
	});
	$(".switchHeader .link2").click(function(){
		$('.switchHeader li a').removeClass("active");
		$(this).addClass("active");
		$(".switchFormContainer .switchForm").stop().animate({left: "-887px"});
		return false;
	});
	$(".switchHeader .link3").click(function(){
		$('.switchHeader li a').removeClass("active");
		$(this).addClass("active");
		$(".switchFormContainer .switchForm").stop().animate({left: "-1764px"});
		return false;
	});
	
	
	// Bio Panel Show/hide
	jQuery('.show').show();
	jQuery('.bioPan h3').click(function(){
		jQuery('.bioContent').slideUp();
		jQuery(this).next('.bioContent').slideDown();
	});
	
	// Bio Panel Show/hide
	jQuery('.show').show();
	jQuery('.faqPan h3').click(function(){
		jQuery('.faqPan .roundBox').slideUp();
		jQuery(this).next('.faqPan .roundBox').slideDown();
	});
	
	
//$(function() {
//    $(".bioPan h3").click(function() {
//      $(this).next(".bioContent").slideToggle()
//       .parent().siblings().find(".bioContent").hide(); //hide others
//    });
//});
	
	
	
	//Tab Show Hide
//	$('.tabContent1').show();
//	$('.tabNav li:first-child').addClass('activeTab');
//	$('.tabNav li').click(function(){
//		var divId = "." + $(this).attr('rel');
//			$(this).parent().siblings('div.tabContent').hide();
//			$(this).parent().siblings(divId).fadeIn('fast');
//			$(this).siblings().removeClass('activeTab');
//			$(this).addClass('activeTab');
//			return false;
//	});
	
//	$('.bioPan h3').click(function() {
//		var tabDivId = this.hash;							   
//		
//		$('.leftBlock li a').removeClass('active');
//		$(this).addClass('active');
//		//console.log(tabDivId);
//		$('.switchgroup1').hide();
//		$(tabDivId).fadeIn();
//		return false;
//	});
	

});
	
	
//$('#pnav a')
//	.css( {backgroundPosition: "0 0"} )
//	.mouseover(function(){
//		$(this).stop().animate({backgroundPosition:"(0 -20px)"}, {duration:500})
//		})
//	.mouseout(function(){
//		$(this).stop().animate(
//			{backgroundPosition:"(0 0)"}, 
//			{duration:500})
//		})
	


//	$("#pnav a").css({backgroundPosition: "0px -20px"});
	
//	$("#pnav a").hover(function(){
//		if( $(this).hasClass("active") ){
//			//do nothing
//		} else {
//			$(this).stop().animate({backgroundPosition: "0px -20px"}, 200);
//		};
//	}, function(){
//		if( $(this).hasClass("active") ){
//			//do nothing
//		} else {
//			$(this).stop().animate({backgroundPosition: "0px 0px"}, 200);
//		};
//	});
//	
//	$("#pnav a").click(function(){
//		$("#pnav a").removeClass("active").stop().animate({backgroundPosition: "0px 0px;"}, 200);
//		$(this).addClass("active");
//		
//		
//	});
	

