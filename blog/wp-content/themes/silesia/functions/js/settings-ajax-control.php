jQuery(document).ready(function(){
      //Tabs 
      jQuery('.tab').hide();
      jQuery('.tab:first').show();
      jQuery('.frame-nav li:first').addClass('current');
      jQuery('.frame-nav li a').click(function(event){				
          jQuery('.frame-nav li').removeClass('current');
          jQuery(this).parent().addClass('current');						
          var clicked_group = jQuery(this).attr('href');		 
          jQuery('.tab').hide();	
          jQuery(clicked_group).fadeIn();
          event.preventDefault();
      });
        
      // Popup Message
      jQuery.fn.center = function () {
          this.animate({"top":( jQuery(window).height() - this.height() - 400 ) / 2+jQuery(window).scrollTop() + "px"},100);
          this.css("left", 250 );
          return this;
       }
       
      // Update options
      jQuery('body').on('click','.natty-options-submit',function(){
        jQuery.ajax({
          'beforeSend':function(){
             jQuery('.ajax-loading-img').fadeIn();
          },          
          'complete': function(){
              var success = jQuery('#natty-popup-save');
              var loading = jQuery('.ajax-loading-img');              
              loading.hide();
              success.center().fadeIn();
              window.setTimeout(function(){
                  success.fadeOut(); 
              }, 1500);
          },
          'type':'POST',
          'url':'options.php',
          'cache':false,
          'data':jQuery(this).parents("form").serialize()
        });
        return false;
      });
      
              
      //AJAX Upload form 	
      jQuery('.image_upload_button').each(function(){
          var clickedObject = jQuery(this);
          var clickedID = jQuery(this).attr('id');
          new AjaxUpload(clickedID, {
            action: '<?php echo admin_url("admin-ajax.php"); ?>',
            name: clickedID, // File upload name
            data: { // Additional data to send
              action: 'natty_ajax_post_action',
              type: 'upload',
              data: clickedID },
            autoSubmit: true, // Submit file after selection
            responseType: false,
            onChange: function(file, extension){},
            onSubmit: function(file, extension){
              if(clickedID == 'nattywp_custom_favicon') {
                if (! (extension && /^(ico|ICO)$/.test(extension))) {
                  jQuery(".upload-error").remove();
                  clickedObject.parent().after('<span class="upload-error">Only supports the .ICO file format</span>');
                  return false;
                }  
              }
              clickedObject.text('Uploading'); // change button text, when user selects file	
              this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
              interval = window.setInterval(function(){
                var text = clickedObject.text();
                if (text.length < 13){	clickedObject.text(text + '.'); }
                else { clickedObject.text('Uploading'); } 
              }, 200);
            },
            
            onComplete: function(file, data) {
              window.clearInterval(interval);
              clickedObject.text('Upload and Replace');	
              this.enable(); // enable upload button
              var response = jQuery.parseJSON(data);              
              
              if(response.error == -1) { // If there was an error
                  var buildReturn = '<span class="upload-error">' + response.message + '</span>';
                  jQuery(".upload-error").remove();
                  clickedObject.parent().after(buildReturn);
              } else {
                  var buildReturn = '<img class="hide custom-logo-image" id="image_'+clickedID+'" src="'+response.file+'" alt="" />';
                  jQuery(".upload-error").remove();
                  jQuery("#image_" + clickedID).remove();	
                  clickedObject.parent().after(buildReturn);
                  jQuery('img#image_'+clickedID).fadeIn();
                  clickedObject.next('span').fadeIn();
                  clickedObject.parent().prev('input').val(response.file);
              }  
            }
          });			
        });
        
        //AJAX Remove (clear option value)
          jQuery('.image_reset_button').click(function(){
            var clickedObject = jQuery(this);
            var clickedID = jQuery(this).attr('id');
            var theID = jQuery(this).attr('title');	
    
            var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
          
            var data = {
              action: 'natty_ajax_post_action',
              type: 'image_reset',
              data: theID
            };
            
            jQuery.post(ajax_url, data, function(response) {
              var image_to_remove = jQuery('#image_' + theID);
              var button_to_hide = jQuery('#reset_' + theID);
              image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
              button_to_hide.fadeOut();
              clickedObject.parent().prev('input').val('');
            });					
            return false; 					
          });
});