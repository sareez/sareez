jQuery(document).ready(function(){
  var flagClosed = true;
  
  jQuery("#control").click(function(e){
  
    if(flagClosed){ // closed
      jQuery('#main-nav').animate({marginLeft: 0}, 300, function() {
        jQuery('#control').html('-');
      });
      if(!(navigator.userAgent.indexOf('iPad') != -1)){
				jQuery('#main-wrapper').animate({marginLeft: 200}, 300);
			}
      flagClosed = false;
		} else {
      jQuery('#main-nav').animate({marginLeft: -200}, 200, function() {
        jQuery('#control').html('+');
      });
      if(!(navigator.userAgent.indexOf('iPad') != -1)){
				jQuery('#main-wrapper').animate({marginLeft: 0}, 200);
			}
      flagClosed = true;
		}		
		e.preventDefault();	
  });
});