/**
 * @category    Mana
 * @package     ManaPro_FilterAjax
 * @copyright   Copyright (c) http://www.manadev.com
 * @license     http://www.manadev.com/license  Proprietary License
 */
// the following function wraps code block that is executed once this javascript file is parsed. Lierally, this 
// notation says: here we define some anonymous function and call it once during file parsing. THis function has
// one parameter which is initialized with global jQuery object. Why use such complex notation: 
// 		a. 	all variables defined inside of the function belong to function's local scope, that is these variables
//			would not interfere with other global variables.
//		b.	we use jQuery $ notation in not conflicting way (along with prototype, ext, etc.)
;(function($) {
    //region URL interception API

    var _ajaxifiedUrlOptions = {};
    var _lastAjaxActionSource = null;
    var _urlAjaxActions = {};
    $.mInterceptUrls = function(action, options) {
        _ajaxifiedUrlOptions[action] = $.extend({
            exactUrls: {},
            partialUrls: {},
            urlExceptions: {},
            callback: function(url, element, action, selectors) {}
        }, options);
    };
    $.mStopInterceptingUrls = function(action) {
        delete _ajaxifiedUrlOptions[action];
    };

    function _urlAjaxAction(locationUrl) {
        if (_urlAjaxActions[locationUrl] === undefined) {
            var locationAction = false;
            if ($.options('#m-ajax').enabled) {
                for (var action in _ajaxifiedUrlOptions) {
                    var handled = false;
                    $.each(_ajaxifiedUrlOptions[action].exactUrls, function (urlIndex, url) {
                        if (!handled && locationUrl == url) {
                            var isException = false;
                            $.each(_ajaxifiedUrlOptions[action].urlExceptions, function (urlExceptionIndex, urlException) {
                                if (!isException && locationUrl.indexOf(urlException) != -1) {
                                    isException = true;
                                }
                            });
                            if (!isException) {
                                handled = true;
                                locationAction = action;
                            }
                        }
                    });
                    $.each(_ajaxifiedUrlOptions[action].partialUrls, function (urlIndex, url) {
                        if (!handled && locationUrl.indexOf(url) != -1) {
                            var isException = false;
                            $.each(_ajaxifiedUrlOptions[action].urlExceptions, function (urlExceptionIndex, urlException) {
                                if (!isException && locationUrl.indexOf(urlException) != -1) {
                                    isException = true;
                                }
                            });
                            if (!isException) {
                                handled = true;
                                locationAction = action;
                            }
                        }
                    });
                    if (handled) {
                        break;
                    }
                }
            }
            _urlAjaxActions[locationUrl] = locationAction;
        }
        return _urlAjaxActions[locationUrl];
    }

    function _processAjaxifiedUrl(url) {
        var action = _urlAjaxAction(url);
        if (action) {
            var selectors = $.options('#m-ajax').selectors[action];
            _ajaxifiedUrlOptions[action].callback(url, _lastAjaxActionSource, action, selectors);
            return false; // prevent default link click behavior
        }
        return true;
    }

    function setLocation(locationUrl, element) {
        var action = _urlAjaxAction(locationUrl);
        if (action) {
            _lastAjaxActionSource = element;
            locationUrl = window.decodeURIComponent(locationUrl);
            if (window.History && window.History.enabled) {
                window.History.pushState(null, window.title, locationUrl);
            }
            else {
                _processAjaxifiedUrl(locationUrl);
            }
        }
        else {
            oldSetLocation(locationUrl, element);
        }
        return false;
    }

    // the following function is executed when DOM ir ready. If not use this wrapper, code inside could fail if
    // executed when referenced DOM elements are still being loaded.
    $(function () {
        if (window.History && window.History.enabled) {
            $(window).bind('statechange', function () {
                var State = window.History.getState();
                _processAjaxifiedUrl(State.url);
            });
        }

        if (window.setLocation) {
            oldSetLocation = window.setLocation;
            window.setLocation = setLocation;
        }

        $('a').live('click', function() {
            var action = _urlAjaxAction(this.href);
            if (action) {
                return setLocation(this.href, this);
            }
        });
    });

    //endregion

    //region AJAX content get/update API

    $.mGetBlocksHtml = function(url, action, selectors, callback) {
        $(document).trigger('m-ajax-before', [selectors, url, action]);
        $.get(window.encodeURI(url + (url.indexOf('?') == -1 ? '?' : '&') + 'm-ajax=' + action + '&no_cache=1'))
            .done(function (response) {
                try {
                    response = $.parseJSON(response);
                    if (!response) {
                        if ($.options('#m-ajax').debug) {
                            alert('No response.');
                        }
                    }
                    else if (response.error) {
                        if ($.options('#m-ajax').debug) {
                            alert(response.error);
                        }
                    }
                    else {
                        callback(response, selectors, action, url);
                    }
                }
                catch (error) {
                    if ($.options('#m-ajax').debug) {
                        alert(response && typeof(response) == 'string' ? response : error);
                    }
                }
            })
            .fail(function (error) {
                if ($.options('#m-ajax').debug) {
                    alert(error.status + (error.responseText ? ': ' + error.responseText : ''));
                }
            })
            .complete(function () {
                $(document).trigger('m-ajax-after', [selectors, url, action]);
            });
    }
    $.mUpdateBlocksHtml = function(response) {
        $.dynamicReplace(response.update, $.options('#m-ajax').debug, true);
        if (response.options) {
            $.options(response.options);
        }
        if (response.script) {
            $.globalEval(response.script);
        }
        if (response.title) {
            document.title = response.title;
        }
    };

    $.mGetBlockHtml = function (url, action, callback) {
        $(document).trigger('m-ajax-before', [[], url, action]);
        $.get(window.encodeURI(url))
            .done(function (response) {
                try {
                    if (!response) {
                        if ($.options('#m-ajax').debug) {
                            alert('No response.');
                        }
                    }
                    else if (response.isJSON()) {
                        response = $.parseJSON(response);
                        if (response.error) {
                            if ($.options('#m-ajax').debug) {
                                alert(response.error);
                            }
                        }
                    }
                    else {
                        callback(response, url);
                    }
                }
                catch (error) {
                    if ($.options('#m-ajax').debug) {
                        alert(response && typeof(response) == 'string' ? response : error);
                    }
                }
            })
            .fail(function (error) {
                if ($.options('#m-ajax').debug) {
                    alert(error.status + (error.responseText ? ': ' + error.responseText : ''));
                }
            })
            .complete(function () {
                $(document).trigger('m-ajax-after', [[], url, action]);
            });
    }
    //endregion

    //region default progress visualization
    $(document).bind('m-ajax-before', function (e, selectors, url, action) {
        if ($.options('#m-ajax').overlay[action]) {
            if (selectors.length) {
                selectors.each(function (selector, selectorIndex) {
                    var left = 0, top = 0, right = 0, bottom = 0, assigned = false;
                    $(selector).each(function () {
                        var element = $(this);
                        var elOffset = element.offset(), elWidth = element.width(), elHeight = element.height();
                        if (!assigned || left > elOffset.left) {
                            left = elOffset.left;
                        }
                        if (!assigned || top > elOffset.top) {
                            top = elOffset.top;
                        }
                        if (!assigned || right < elOffset.left + elWidth) {
                            right = elOffset.left + elWidth;
                        }
                        if (!assigned || bottom < elOffset.top + elHeight) {
                            bottom = elOffset.top + elHeight;
                        }
                        assigned = true;
                    });
                    if (assigned) {
                        // create overlay
                        var overlay = $('<div class="m-overlay"> </div>');
                        overlay.appendTo(document.body);
                        overlay.css({left:left, top:top}).width(right - left).height(bottom - top);
                    }
                });
            }
            else {
                var overlay = $('<div class="m-overlay"> </div>');
                overlay.appendTo(document.body);
                overlay.css({left:0, top:0}).width($(document).width()).height($(document).height());
            }
        }

        if ($.options('#m-ajax').progress[action]) {
            $('#m-wait').show();
            
        }
    });
    $(document).bind('m-ajax-after', function (e, selectors, url, action) {
        // remove overlays
        if ($.options('#m-ajax').overlay[action]) {
            $('.m-overlay').remove();
        }
        if ($.options('#m-ajax').progress[action]) {
            $('#m-wait').hide();
        }
        initBinding();
    });
    //endregion
})(jQuery);


function initBinding(){


	jQuery(function($) {
	var myhref,qsbtt;

	// base function
	
	//get IE version
	function ieVersion(){
		var rv = -1; // Return value assumes failure.
		if (navigator.appName == 'Microsoft Internet Explorer'){
			var ua = navigator.userAgent;
			var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null)
				rv = parseFloat( RegExp.$1 );
		}
		return rv;
	}

	//read href attr in a tag
	function readHref(){
		var mypath = arguments[0];
		var patt = /\/[^\/]{0,}$/ig;
		if(mypath[mypath.length-1]=="/"){
			mypath = mypath.substring(0,mypath.length-1);
			return (mypath.match(patt)+"/");
		}
		return mypath.match(patt);
	}


	//string trim
	function strTrim(){
		return arguments[0].replace(/^\s+|\s+$/g,"");
	}

	function _qsJnit(){
	

		
		var selectorObj = arguments[0];
			//selector chon tat ca cac li chua san pham tren luoi
		var listprod = $('.products-grid li.item .pro_topadst');
		var qsImg;
		var mypath = 'quickshop/index/view';
		if(EM.QuickShop.BASE_URL.indexOf('index.php') == -1){
			mypath = 'index.php/quickshop/index/view';
		}
		var baseUrl = EM.QuickShop.BASE_URL + mypath;
		
		var _qsHref = "<a id=\"em_quickshop_handler\" href=\"#\" style=\"visibility:hidden;position:absolute;top:0;left:0\"><img  alt=\"quickshop\" src=\""+EM.QuickShop.QS_IMG+"\" /></a>";
		$(document.body).append(_qsHref);
		
		var qsHandlerImg = $('#em_quickshop_handler img');

		$.each(listprod, function(index, value) {
                    
			var reloadurl = baseUrl;
			
			//get reload url
			myhref = $(value).children('a.product-image');
			var prodHref = readHref(myhref.attr('href'))[0];
			prodHref[0] == "\/" ? prodHref = prodHref.substring(1,prodHref.length) : prodHref;
			prodHref=strTrim(prodHref);
			
			reloadurl = baseUrl+"/path/"+prodHref;	
			version = ieVersion();	
			if(version < 8.0 && version > -1){
				reloadurl = baseUrl+"/path"+prodHref;
			}
			//end reload url

			
			$('.product-image img', this).bind('mouseover', function() {
				var o = $(this).offset();
				$('#em_quickshop_handler').attr('href',reloadurl).show()
					.css({
						'top': o.top+($(this).height() - qsHandlerImg.height())/2+'px',
						'left': o.left+($(this).width() - qsHandlerImg.width())/2+'px',
						'visibility': 'visible'
					});
			});
			$(value).bind('mouseout', function() {
				$('#em_quickshop_handler').hide();
			});
		});

		//fix bug image disapper when hover
		$('#em_quickshop_handler')
			.bind('mouseover', function() {
				$(this).show();
			})
			.bind('click', function() {
				$(this).hide();
			});
		//insert quickshop popup
		
		$('#em_quickshop_handler').fancybox({
				'width'				: EM.QuickShop.QS_FRM_WIDTH,
				'height'			: EM.QuickShop.QS_FRM_HEIGHT,
				'autoScale'			: false,
				'padding'			: 0,
				'margin'			: 0,
				//'transitionIn'		: 'none',
				//'transitionOut'		: 'none',
				'type'				: 'iframe',
				onComplete: function() { 
					$.fancybox.showActivity();
					$('#fancybox-frame').unbind('load');
					$('#fancybox-frame').bind('load', function() {
						$.fancybox.hideActivity();
					});
				}
		});


	
	
	}

	//end base function


	_qsJnit({
		itemClass : '.products-grid li.item', //selector for each items in catalog product list,use to insert quickshop image
		aClass : 'a.product-image', //selector for each a tag in product items,give us href for one product
		imgClass: '.product-image img' //class for quickshop href
	});



});
    
}
