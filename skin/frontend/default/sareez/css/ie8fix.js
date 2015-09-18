/****************************************
	Version: 0.0.1
****************************************/
var pr = jQuery.noConflict();
pr(document).ready(function(){
	pr('body').append('<div id="ie8n" style="position:fixed; z-index:1001; top:4px; left:0; right:5px; padding:10px; background: #f2dede; color: #fff; border: 3px solid #ebccd1; "><strong style="font-size: 18px; display: block; padding: 5px; color: #B9AFAF; position:absolute; right: 0; top:0; cursor:pointer;">X</strong><div style="text-align: center; font-size: 14px; color: #a94442;">Your browser version is outdated. Switch to any updated browser <b>(IE 9+, Firefox, Safari, Chrome)</b> for better experience.</div></div>');
	
	pr('body').css('padding-top', '40px');

	pr('#ie8n strong').click(function(){
		pr(this).parents('#ie8n').fadeOut(400, function(){
			pr('body').css('padding-top', '');
			pr(this).remove();
		});
	});
});
