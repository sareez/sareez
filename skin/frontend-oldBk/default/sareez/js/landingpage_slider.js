$.noConflict();
jQuery( document ).ready(function( $ ) {
	
	
	<!-- Product Combo Slider Added by Anik 14_01_2015 -->
	
	
		$('#product-combo-slider .product-combo-slider-btn-right').click(
		  function(){
			$('#product-combo-slider .product-combo-image-slider').animate({marginLeft:'-372px'});
		  }
		);
	
		$('#product-combo-slider .product-combo-slider-btn-left').click(
				function(){
					$('#product-combo-slider .product-combo-image-slider').animate({marginLeft:'0px'});
				}
		);
	
	<!-- End Product Slider -- >
	
	
	<!-- for new header on 151214-->
	
	
        $('.sareez-nav .nav-new-arrivals-li  ').mouseenter(function(){
            $('.sareez-nav  .nav-new-arrivals-ul').css('display', 'block');
        });
        $('.sareez-nav .nav-new-arrivals-li ').mouseleave(function(){
            $('.sareez-nav  .nav-new-arrivals-ul').css('display', 'none');
        });

        $('.sareez-nav .nav-premium-li  ').mouseenter(function(){
            $('.sareez-nav  .nav-premium-ul').css('display', 'block');
        });
        $('.sareez-nav .nav-premium-li ').mouseleave(function(){
            $('.sareez-nav  .nav-premium-ul').css('display', 'none');
        });


    
	
	
	<!-- end : for new header on 151214-->
	
	<!-- for banner change on 091014-->
	

    $(".feature-accordian .accordian-slide-02").mouseenter(function(){
        $(".feature-accordian .accordian-slide-02").stop().animate({marginLeft:"0px"},200);
        $(".feature-accordian .accordian-slide-02-image2").stop().css("display", "block");
    }) ;

    $(".feature-accordian .accordian-slide-02").mouseleave(function(){
        $(".feature-accordian .accordian-slide-02").stop().animate({marginLeft:"566px"},200);
        $(".feature-accordian .accordian-slide-02-image2").stop().delay(200).queue( function(next){
            $(this).css('display','none');
            next();
        });

    }) ;
		
	<!-- end :for banner change on 091014 -->
	
	
	<!--for home page bottom slider-->
	


    // default values*******************************************************************
    $(".bottom-slider .bottom-sliding-images").mouseenter(function(){
        $(".bottom-slider .bottom-slider-left-button").fadeIn(300);
        $(".bottom-slider .bottom-slider-right-button").fadeIn(300);
    });

    $(".bottom-slider .bottom-sliding-images").mouseleave(function(){
        $(".bottom-slider .bottom-slider-left-button").fadeOut(300);
        $(".bottom-slider .bottom-slider-right-button").fadeOut(300);
    });

// autosliding new product slider ***********************************************

    var bottom_slider_timer = setInterval(changeBottomSlider, 6000);

    $(".bottom-slider .bottom-sliding-images").hover(function(ev){
        clearInterval(bottom_slider_timer);
    }, function(ev){
       bottom_slider_timer = setInterval( changeBottomSlider, 6000);
    });






    // button click functions ***************************************************
    $(".bottom-slider-right-button").click(function(){
        changeBottomSlider();
    })

    $(".bottom-slider-left-button").click(function(){
        changeBottomSliderLeft();
    })


    // slider variables **********************************************************
    var bottomSliderShift = $(".bottom-slider").css("width");
    var bottomSliderNegShift = "-"+parseInt(bottomSliderShift, 10)+"px";

    var bottomSlidercounter = 0;

    var bottomSliderTitleCounter = 0;
    var bottomSliderDaysCounter = 0;

    // Initial Positions **********************************************************
    $(".bottom-slider .bottom-slider-02").css("marginLeft",bottomSliderShift);
    $(".bottom-slider .bottom-slider-03").css("marginLeft",bottomSliderShift);

    bottomSliderFilter();

    function changeBottomSlider(){

        switch(bottomSlidercounter){
            case 0:
                $(".bottom-slider .bottom-slider-03").css("marginLeft",bottomSliderShift);
                $(".bottom-slider .bottom-slider-01").stop().animate({marginLeft:bottomSliderNegShift},500);
                $(".bottom-slider .bottom-slider-02").stop().animate({marginLeft:"0px"},500);
                bottomSlidercounter=1;
                break;

            case 1:
                $(".bottom-slider .bottom-slider-01").css("marginLeft",bottomSliderShift);
                $(".bottom-slider .bottom-slider-02").stop().animate({marginLeft:bottomSliderNegShift},500);
                $(".bottom-slider .bottom-slider-03").stop().animate({marginLeft:"0px"},500);
                bottomSlidercounter=2;
                break;

            case 2:
                $(".bottom-slider .bottom-slider-02").css("marginLeft",bottomSliderShift);
                $(".bottom-slider .bottom-slider-03").stop().animate({marginLeft:bottomSliderNegShift},500);
                $(".bottom-slider .bottom-slider-01").stop().animate({marginLeft:"0px"},500);
                bottomSlidercounter=0;
                break;

        }
    }

    function changeBottomSliderLeft(){

        switch(bottomSlidercounter){
            case 0:
                $(".bottom-slider .bottom-slider-01").stop().animate({marginLeft:bottomSliderShift},500);
                $(".bottom-slider .bottom-slider-02").css("marginLeft",bottomSliderShift);
                $(".bottom-slider .bottom-slider-03").css("marginLeft",bottomSliderNegShift);
                $(".bottom-slider .bottom-slider-03").stop().animate({marginLeft:"0px"},500);
                bottomSlidercounter=2;
                break;

            case 1:

                $(".bottom-slider .bottom-slider-01").css("marginLeft",bottomSliderNegShift);
                $(".bottom-slider .bottom-slider-01").stop().animate({marginLeft:"0px"},500);
                $(".bottom-slider .bottom-slider-02").stop().animate({marginLeft:bottomSliderShift},500);
                $(".bottom-slider .bottom-slider-03").css("marginLeft",bottomSliderNegShift);
                bottomSlidercounter=0;
                break;

            case 2:

                $(".bottom-slider .bottom-slider-01").css("marginLeft",bottomSliderShift);
                $(".bottom-slider .bottom-slider-02").css("marginLeft",bottomSliderNegShift);
                $(".bottom-slider .bottom-slider-02").stop().animate({marginLeft:"0px"},500);
                $(".bottom-slider .bottom-slider-03").stop().animate({marginLeft:bottomSliderShift},500);
                bottomSlidercounter=1;
                break;

        }
    }



    $(".bottom-slider-most-viewed").click(function(){
        bottomSliderTitleCounter = 0;
        bottomSliderFilter();
    });

    $(".bottom-slider-most-purchased").click(function(){
        bottomSliderTitleCounter = 1;
        bottomSliderFilter();
    });

    $(".bottom-slider-7days").click(function(){
        bottomSliderDaysCounter = 0;
        bottomSliderFilter();
    });

    $(".bottom-slider-14days").click(function(){
        bottomSliderDaysCounter = 1;
        bottomSliderFilter();
    });

    $(".bottom-slider-30days").click(function(){
        bottomSliderDaysCounter = 2;
        bottomSliderFilter();
    });


    function bottomSliderFilter(){
        switch(bottomSliderTitleCounter + "|" + bottomSliderDaysCounter) {
            case "0|0":
                $(".most-viewed-7days").stop().fadeIn();
                $(".most-viewed-14days").stop().fadeOut();
                $(".most-viewed-30days").stop().fadeOut();
                $(".most-purchased-7days").stop().fadeOut();
                $(".most-purchased-14days").stop().fadeOut();
                $(".most-purchased-30days").stop().fadeOut();
                $(".bottom-slider-most-viewed").css("color","#e74948");
                $(".bottom-slider-most-viewed").css("border-bottom","2px solid #e74948");
                $(".bottom-slider-most-purchased").css("color","#000");
                $(".bottom-slider-most-purchased").css("border-bottom","2px solid #fff");
                $(".bottom-slider-7days").css("color","#e74948");
                $(".bottom-slider-14days").css("color","#000");
                $(".bottom-slider-30days").css("color","#000");
                break;
            case "0|1":
                $(".most-viewed-7days").stop().fadeOut();
                $(".most-viewed-14days").stop().fadeIn();
                $(".most-viewed-30days").stop().fadeOut();
                $(".most-purchased-7days").stop().fadeOut();
                $(".most-purchased-14days").stop().fadeOut();
                $(".most-purchased-30days").stop().fadeOut();
                $(".bottom-slider-most-viewed").css("color","#e74948");
                $(".bottom-slider-most-viewed").css("border-bottom","2px solid #e74948");
                $(".bottom-slider-most-purchased").css("color","#000");
                $(".bottom-slider-most-purchased").css("border-bottom","2px solid #fff");
                $(".bottom-slider-7days").css("color","#000");
                $(".bottom-slider-14days").css("color","#e74948");
                $(".bottom-slider-30days").css("color","#000");
                break;
            case "0|2":
                $(".most-viewed-7days").stop().fadeOut();
                $(".most-viewed-14days").stop().fadeOut();
                $(".most-viewed-30days").stop().fadeIn();
                $(".most-purchased-7days").stop().fadeOut();
                $(".most-purchased-14days").stop().fadeOut();
                $(".most-purchased-30days").stop().fadeOut();
                $(".bottom-slider-most-viewed").css("color","#e74948");
                $(".bottom-slider-most-viewed").css("border-bottom","2px solid #e74948");
                $(".bottom-slider-most-purchased").css("color","#000");
                $(".bottom-slider-most-purchased").css("border-bottom","2px solid #fff");
                $(".bottom-slider-7days").css("color","#000");
                $(".bottom-slider-14days").css("color","#000");
                $(".bottom-slider-30days").css("color","#e74948");
                break;
            case "1|0":
                $(".most-viewed-7days").stop().fadeOut();
                $(".most-viewed-14days").stop().fadeOut();
                $(".most-viewed-30days").stop().fadeOut();
                $(".most-purchased-7days").stop().fadeIn();
                $(".most-purchased-14days").stop().fadeOut();
                $(".most-purchased-30days").stop().fadeOut();
                $(".bottom-slider-most-viewed").css("color","#000");
                $(".bottom-slider-most-viewed").css("border-bottom","2px solid #fff");
                $(".bottom-slider-most-purchased").css("color","#e74948");
                $(".bottom-slider-most-purchased").css("border-bottom","2px solid #e74948");
                $(".bottom-slider-7days").css("color","#e74948");
                $(".bottom-slider-14days").css("color","#000");
                $(".bottom-slider-30days").css("color","#000");
                break;
            case "1|1":
                $(".most-viewed-7days").stop().fadeOut();
                $(".most-viewed-14days").stop().fadeOut();
                $(".most-viewed-30days").stop().fadeOut();
                $(".most-purchased-7days").stop().fadeOut();
                $(".most-purchased-14days").stop().fadeIn();
                $(".most-purchased-30days").stop().fadeOut();
                $(".bottom-slider-most-viewed").css("color","#000");
                $(".bottom-slider-most-viewed").css("border-bottom","2px solid #fff");
                $(".bottom-slider-most-purchased").css("color","#e74948");
                $(".bottom-slider-most-purchased").css("border-bottom","2px solid #e74948");
                $(".bottom-slider-7days").css("color","#000");
                $(".bottom-slider-14days").css("color","#e74948");
                $(".bottom-slider-30days").css("color","#000");
                break;
            case "1|2":
                $(".most-viewed-7days").stop().fadeOut();
                $(".most-viewed-14days").stop().fadeOut();
                $(".most-viewed-30days").stop().fadeOut();
                $(".most-purchased-7days").stop().fadeOut();
                $(".most-purchased-14days").stop().fadeOut();
                $(".most-purchased-30days").stop().fadeIn();
                $(".bottom-slider-most-viewed").css("color","#000");
                $(".bottom-slider-most-viewed").css("border-bottom","2px solid #fff");
                $(".bottom-slider-most-purchased").css("color","#e74948");
                $(".bottom-slider-most-purchased").css("border-bottom","2px solid #e74948");
                $(".bottom-slider-7days").css("color","#000");
                $(".bottom-slider-14days").css("color","#000");
                $(".bottom-slider-30days").css("color","#e74948");
                break;

        }
    }


	
	<!-- end: -for home page bottom slider-->
	/* for top-bar offer added by sid on 08092014 */
	$(".offer-ques").mouseenter(function(){
        $(".offer-details").css("display","block");
    });

    $(".offer-ques").mouseleave(function(){
        $(".offer-details").css("display","none");
    });


	/* for testimonial sliding added on 300814 by asgar*/
	

    // Default Values***************************************************

    
    $(".testimonials-slider-pointer-01").css("background","#b52034");

    /* autoplay testimonials slider******************************************
    var testimonials_timer = setInterval(testimonialsSlider, 6000);

    $('.new_testimonials').hover(function(ev){
        clearInterval(testimonials_timer);
    }, function(ev){
        testimonials_timer = setInterval(testimonialsSlider, 6000);
    }); */

    // Click pointer actions **********************************************
    $(".testimonials-slider-pointer-01").click(function(){
        testimonials_slider_counter =3;
        testimonialsSlider();
    })
    $(".testimonials-slider-pointer-02").click(function(){
        testimonials_slider_counter =0;
        testimonialsSlider();
    })
    $(".testimonials-slider-pointer-03").click(function(){
        testimonials_slider_counter =1;
        testimonialsSlider();
    })
    $(".testimonials-slider-pointer-04").click(function(){
        testimonials_slider_counter =2;
        testimonialsSlider();
    })

    // slider variables ************************************************************
    var testimonials_slider_counter = 0;

    function testimonialsSlider(){
        switch (testimonials_slider_counter){
            case 0:
                $(".testimonials-slide-01").css("display","none");
                $(".testimonials-slide-02").css("display","block");
                $(".testimonials-slide-03").css("display","none");
                $(".testimonials-slide-04").css("display","none");

                $(".testimonials-slider-pointer-01").css("background","#f06662");
                $(".testimonials-slider-pointer-02").css("background","#b52034");
                $(".testimonials-slider-pointer-03").css("background","#f06662");
                $(".testimonials-slider-pointer-04").css("background","#f06662");
                testimonials_slider_counter = 1;
                break;
            case 1:
                $(".testimonials-slide-01").css("display","none");
                $(".testimonials-slide-02").css("display","none");
                $(".testimonials-slide-03").css("display","block");
                $(".testimonials-slide-04").css("display","none");

                $(".testimonials-slider-pointer-01").css("background","#f06662");
                $(".testimonials-slider-pointer-02").css("background","#f06662");
                $(".testimonials-slider-pointer-03").css("background","#b52034");
                $(".testimonials-slider-pointer-04").css("background","#f06662");
                testimonials_slider_counter = 2;
                break;
            case 2:
                $(".testimonials-slide-01").css("display","none");
                $(".testimonials-slide-02").css("display","none");
                $(".testimonials-slide-03").css("display","none");
                $(".testimonials-slide-04").css("display","block");

                $(".testimonials-slider-pointer-01").css("background","#f06662");
                $(".testimonials-slider-pointer-02").css("background","#f06662");
                $(".testimonials-slider-pointer-03").css("background","#f06662");
                $(".testimonials-slider-pointer-04").css("background","#b52034");
                testimonials_slider_counter = 3;
                break;
            case 3:
                $(".testimonials-slide-01").css("display","block");
                $(".testimonials-slide-02").css("display","none");
                $(".testimonials-slide-03").css("display","none");
                $(".testimonials-slide-04").css("display","none");

                $(".testimonials-slider-pointer-01").css("background","#b52034");
                $(".testimonials-slider-pointer-02").css("background","#f06662");
                $(".testimonials-slider-pointer-03").css("background","#f06662");
                $(".testimonials-slider-pointer-04").css("background","#f06662");
                testimonials_slider_counter = 0;
                break;
        }
    }


	
	/* end :for testimonial sliding added on 300814 by asgar */
	
	/*emi option add at info page*/
	$(".emi_avail_button").mouseenter(function(){
        $(".emi_avail_box").stop().css("display","block");
    });

    $(".emi_avail_button").mouseleave(function(){
        $(".emi_avail_box").stop().css("display","none");
    });

	/*end: emi option add at info page*/

/* right col slider */
 // Default Values***************************************************

    $(".right-col-slide-02").fadeOut();
    $(".right-col-slider .slider-pointer-01").css("background","#ffffff");

    // autoplay right col slider******************************************
    var right_col_slider_timer = setInterval(changeRightColSlider, 7000);

    $('.right-col-slider').hover(function(ev){
        clearInterval(right_col_slider_timer);
    }, function(ev){
        right_col_slider_timer = setInterval(changeRightColSlider, 7000);
    });

    // Click pointer actions **********************************************
    $(".slider-pointer-01").click(function(){
        right_col_slider_counter =1;
        changeRightColSlider();
    })

    $(".slider-pointer-02").click(function(){
        right_col_slider_counter =0;
        changeRightColSlider();
    })

    // slider variables ************************************************************
    var right_col_slider_counter = 0;

    function changeRightColSlider(){
        switch (right_col_slider_counter){
            case 0:
                $(".right-col-slide-01").stop(true,true).fadeOut();
                $(".right-col-slide-02").stop(true,true).fadeIn();
                $(".right-col-slider .slider-pointer-01").css("background","none");
                $(".right-col-slider .slider-pointer-02").css("background","#ffffff");
                right_col_slider_counter = 1;
                break;
            case 1:
                $(".right-col-slide-01").stop(true,true).fadeIn();
                $(".right-col-slide-02").stop(true,true).fadeOut();
                $(".right-col-slider .slider-pointer-01").css("background","#ffffff");
                $(".right-col-slider .slider-pointer-02").css("background","none");
                right_col_slider_counter = 0;
                break;
        }
    }
	
	
	
/* end :right col slider */	
	
	
  // Code that uses jQuery's $ can follow here. 
    $("#feature-banner .feature-tabs .feature-tab-1 .shipping-details-box").hide();
  $("#feature-banner .feature-tabs .feature-tab-1 .shipping-help-icon").mouseenter(function(){
    $("#feature-banner .feature-tabs .feature-tab-1 .shipping-details-box").fadeIn(200);
  });
  $("#feature-banner .feature-tabs .feature-tab-1 .shipping-help-icon").mouseleave(function(){
    $("#feature-banner .feature-tabs .feature-tab-1 .shipping-details-box").fadeOut(200);
  });
  
   //for info page
  $(".shipping-details-box-info").hide();
  $(".shipping-help-icon-info").mouseenter(function(){
    $(".shipping-details-box-info").fadeIn(200);
  });
  $(".shipping-help-icon-info").mouseleave(function(){
    $(".shipping-details-box-info").fadeOut(200);
  });
  
  
  
  // for inner page//
   $("#inner-feature-banner .inner-feature-banner-1 .inner-shipping-details-box").hide();
  $("#inner-feature-banner .inner-feature-banner-1 .inner-shipping-help-icon").mouseenter(function(){
    $("#inner-feature-banner .inner-feature-banner-1 .inner-shipping-details-box").fadeIn(200);
  });
  $("#inner-feature-banner .inner-feature-banner-1 .inner-shipping-help-icon").mouseleave(function(){
    $("#inner-feature-banner .inner-feature-banner-1 .inner-shipping-details-box").fadeOut(200);
  });
  //end//
  
  
  var sliderCounter=1;
  $(".feature-slide-1").fadeIn(250);
  $(".feature-slide-2").fadeOut(250);
  //$(".feature-slide-1").fadeIn(250);

  setInterval(autoChange, 6000);

  function autoChange(){
  	switch(sliderCounter) {
    case 1:
        sliderCounter=2;
        changeOver();
        break;
    case 2:
        sliderCounter=1;
        changeOver();
        break;
   /* case 3:
        sliderCounter=1;
        changeOver();
        break; */
	}
  }
  
  $(".feature-left-btn").click(function(){
    switch(sliderCounter) {
    case 1:
        sliderCounter=2;
        changeOver();
        break;
    case 2:
        sliderCounter=1;
        changeOver();
        break;
   /* case 3:
        sliderCounter=2;
        changeOver();
        break; */
	}

  });

  $(".feature-right-btn").click(function(){
    switch(sliderCounter) {
    case 1:
        sliderCounter=2;
        changeOver();
        break;
    case 2:
        sliderCounter=1;
        changeOver();
        break;
   /* case 3:
        sliderCounter=1;
        changeOver();
        break; */
	}
  });


  function changeOver(){
  	switch(sliderCounter) {
    case 1:
        $(".feature-slide-1").stop(true, true).fadeIn(500);
        $(".feature-slide-2").stop(true, true).fadeOut(500);
       // $(".feature-slide-3").stop(true, true).fadeOut(500);
        break;
    case 2:
        $(".feature-slide-1").stop(true, true).fadeOut(500);
        $(".feature-slide-2").stop(true, true).fadeIn(500);
       // $(".feature-slide-3").stop(true, true).fadeOut(500);
        break;
   /* case 3:
        $(".feature-slide-1").stop(true, true).fadeOut(500);
        $(".feature-slide-2").stop(true, true).fadeOut(500);
        $(".feature-slide-3").stop(true, true).fadeIn(500);
        break;*/
	}
  }
 
 
 // added on 220814 for new product slider //

// Default Values ****************************************************
$(".new-product-slider-tab-02").css("margin-top", "-2000px");
    $(".new-product-slider-tab-03").css("margin-top", "-2000px");

$(".new-product-slider-tab-01 .new-product-slider-01").fadeIn();
$(".new-product-slider-tab-01 .new-product-slider-02").fadeIn();
$(".new-product-slider-tab-01 .new-product-slider-03").fadeIn();

    $(".new-product-slider-tab-02 .new-product-slider-01").fadeOut();
    $(".new-product-slider-tab-02 .new-product-slider-02").fadeOut();
    $(".new-product-slider-tab-02 .new-product-slider-03").fadeOut();

    $(".new-product-slider-tab-03 .new-product-slider-01").fadeOut();
    $(".new-product-slider-tab-03 .new-product-slider-02").fadeOut();
    $(".new-product-slider-tab-03 .new-product-slider-03").fadeOut();

    $(".new-product-tab-01").addClass("active");
    //$(".new-product-tab-01").css("border-right","1px solid #ffdb32");

$(".new-product-slider-buttons").fadeOut(100);

// button hover functions **********************************************************
$(".new-product .new-product-slider").mouseenter(function(){
    $(".new-product-slider-buttons").fadeIn(300);
})

$(".new-product .new-product-slider").mouseleave(function(){
    $(".new-product-slider-buttons").fadeOut(300);
})

// Tabs Click functions ***************************************************
$(".new-product .new-product-tabs .new-product-tab-01").click(function(){
   
    $(".new-product-slider-tab-01").css("margin-top", "0px");

    $(".new-product-slider-tab-01 .new-product-slider-01").fadeIn();
    $(".new-product-slider-tab-01 .new-product-slider-02").fadeIn();
    $(".new-product-slider-tab-01 .new-product-slider-03").fadeIn();

    $(".new-product-slider-tab-02 .new-product-slider-01").fadeOut();
    $(".new-product-slider-tab-02 .new-product-slider-02").fadeOut();
    $(".new-product-slider-tab-02 .new-product-slider-03").fadeOut();

    $(".new-product-slider-tab-03 .new-product-slider-01").fadeOut();
    $(".new-product-slider-tab-03 .new-product-slider-02").fadeOut();
    $(".new-product-slider-tab-03 .new-product-slider-03").fadeOut();

    $(".new-product-slider-tab-02").css("margin-top", "-2000px");
    $(".new-product-slider-tab-03").css("margin-top", "-2000px");

    $(".new-product-tab-01").addClass("active");
    $(".new-product-tab-02").removeClass("active");
    $(".new-product-tab-03").removeClass("active");

  });

$(".new-product .new-product-tabs .new-product-tab-02").click(function(){
    
    $(".new-product-slider-tab-02").css("margin-top", "0px");

    $(".new-product-slider-tab-01 .new-product-slider-01").fadeOut();
    $(".new-product-slider-tab-01 .new-product-slider-02").fadeOut();
    $(".new-product-slider-tab-01 .new-product-slider-03").fadeOut();

    $(".new-product-slider-tab-02 .new-product-slider-01").fadeIn();
    $(".new-product-slider-tab-02 .new-product-slider-02").fadeIn();
    $(".new-product-slider-tab-02 .new-product-slider-03").fadeIn();

    $(".new-product-slider-tab-03 .new-product-slider-01").fadeOut();
    $(".new-product-slider-tab-03 .new-product-slider-02").fadeOut();
    $(".new-product-slider-tab-03 .new-product-slider-03").fadeOut();

    $(".new-product-slider-tab-01").css("margin-top", "-2000px");
    $(".new-product-slider-tab-03").css("margin-top", "-2000px");

    $(".new-product-tab-02").addClass("active");
    $(".new-product-tab-01").removeClass("active");
    $(".new-product-tab-03").removeClass("active");

  });
 
$(".new-product .new-product-tabs .new-product-tab-03").click(function(){
    
    $(".new-product-slider-tab-03").css("margin-top", "0px");

    $(".new-product-slider-tab-01 .new-product-slider-01").fadeOut();
    $(".new-product-slider-tab-01 .new-product-slider-02").fadeOut();
    $(".new-product-slider-tab-01 .new-product-slider-03").fadeOut();

    $(".new-product-slider-tab-02 .new-product-slider-01").fadeOut();
    $(".new-product-slider-tab-02 .new-product-slider-02").fadeOut();
    $(".new-product-slider-tab-02 .new-product-slider-03").fadeOut();

    $(".new-product-slider-tab-03 .new-product-slider-01").fadeIn();
    $(".new-product-slider-tab-03 .new-product-slider-02").fadeIn();
    $(".new-product-slider-tab-03 .new-product-slider-03").fadeIn();

    $(".new-product-slider-tab-01").css("margin-top", "-2000px");
    $(".new-product-slider-tab-02").css("margin-top", "-2000px");

    $(".new-product-tab-03").addClass("active");
    $(".new-product-tab-02").removeClass("active");
    $(".new-product-tab-01").removeClass("active");

  });


/* autosliding new product slider ************************************************/

//setInterval(changeNewProductSlider1, 6000);

var new_product_slider_timer=setInterval(changeNewProductSlider1, 8000);

    $('.new-product .new-product-slider').hover(function(ev){
        clearInterval(new_product_slider_timer);
    }, function(ev){
        new_product_slider_timer = setInterval( changeNewProductSlider1, 8000);
    });


/* button click functions *******************************************************/
$(".new-product-right-slider-button").click(function(){
    changeNewProductSlider1();
})

$(".new-product-left-slider-button").click(function(){
    changeNewProductSlider1Left();
})


/* slider variables **************************************************************/
var NewProductSliderShift = $(".new-product").css("width");
var NewProductSliderNegShift = "-"+parseInt(NewProductSliderShift, 10)+"px";

var NewProductSlidercounter = 0;

/* Initial Positions ***********************************************************/
$(".new-product .new-product-slider .new-product-slider-02").css("marginLeft",NewProductSliderShift);
$(".new-product .new-product-slider .new-product-slider-03").css("marginLeft",NewProductSliderShift);

/* product slider changes ******************************************************/

function changeNewProductSlider1(){

    switch(NewProductSlidercounter){
        case 0:
            $(".new-product .new-product-slider .new-product-slider-03").stop().css("marginLeft",NewProductSliderShift);
            $(".new-product .new-product-slider .new-product-slider-01").stop().animate({marginLeft:NewProductSliderNegShift},500);
            $(".new-product .new-product-slider .new-product-slider-02").stop().animate({marginLeft:"0px"},500);
            NewProductSlidercounter=1;
            break;

        case 1:     
            $(".new-product .new-product-slider .new-product-slider-01").stop().css("marginLeft",NewProductSliderShift);
            $(".new-product .new-product-slider .new-product-slider-02").stop().animate({marginLeft:NewProductSliderNegShift},500);
            $(".new-product .new-product-slider .new-product-slider-03").stop().animate({marginLeft:"0px"},500);
            NewProductSlidercounter=2;
            break;

        case 2:  
            $(".new-product .new-product-slider .new-product-slider-02").stop().css("marginLeft",NewProductSliderShift);
            $(".new-product .new-product-slider .new-product-slider-03").stop().animate({marginLeft:NewProductSliderNegShift},500);
            $(".new-product .new-product-slider .new-product-slider-01").stop().animate({marginLeft:"0px"},500);
            NewProductSlidercounter=0;
            break;

    }
}

function changeNewProductSlider1Left(){

    switch(NewProductSlidercounter){
        case 0:
           $(".new-product .new-product-slider .new-product-slider-01").stop().animate({marginLeft:NewProductSliderShift},500);     
           $(".new-product .new-product-slider .new-product-slider-02").stop().css("marginLeft",NewProductSliderShift);
           $(".new-product .new-product-slider .new-product-slider-03").stop().css("marginLeft",NewProductSliderNegShift);
           $(".new-product .new-product-slider .new-product-slider-03").stop().animate({marginLeft:"0px"},500);

            NewProductSlidercounter=2;
            break;

        case 1:     
            
            $(".new-product .new-product-slider .new-product-slider-01").stop().css("marginLeft",NewProductSliderNegShift);
            $(".new-product .new-product-slider .new-product-slider-01").stop().animate({marginLeft:"0px"},500);
            $(".new-product .new-product-slider .new-product-slider-02").stop().animate({marginLeft:NewProductSliderShift},500);
            $(".new-product .new-product-slider .new-product-slider-03").stop().css("marginLeft",NewProductSliderNegShift);

            NewProductSlidercounter=0;
            break;

        case 2:  
            
            $(".new-product .new-product-slider .new-product-slider-01").stop().css("marginLeft",NewProductSliderShift);
            $(".new-product .new-product-slider .new-product-slider-02").stop().css("marginLeft",NewProductSliderNegShift);
            $(".new-product .new-product-slider .new-product-slider-02").stop().animate({marginLeft:"0px"},500);
            $(".new-product .new-product-slider .new-product-slider-03").stop().animate({marginLeft:NewProductSliderShift},500);

            
            NewProductSlidercounter=1;
            break;

    }
}

// end :added on 220814 for new product slider //
 
 
  
});
// Code that uses other library's $ can follow here.
