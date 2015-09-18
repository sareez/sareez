/*!
 * Infinite Ajax Scroll, a jQuery plugin
 * Version v0.1.5
 * http://webcreate.nl/
 *
 * Copyright (c) 2011 Jeroen Fiege
 * Licensed under the MIT License:
 * http://webcreate.nl/license
 */
(function (b) {
    b.ias = function (d) {
        var m = b.extend({}, b.ias.defaults, d);
        var c = new b.ias.util();
        var j = new b.ias.paging();
        var h = (m.history ? new b.ias.history() : false);
        var f = this;
        r();

        function r() {
            j.onChangePage(function (x, v, w) {
                if (h) {
                    h.setPage(x, w)
                }
                m.onPageChange.call(this, x, w, v)
            });
            initBinding();
            s();
            if (h && h.havePage()) {
                q();
                pageNum = h.getPage();
                c.forceScrollTop(function () {
                    if (pageNum > 1) {
                        l(pageNum);
                        curTreshold = p(true);
                        b("html,body").scrollTop(curTreshold)
                    } else {
                        s()
                    }
                })
            }
            return f
        }

        function s() {
            n();
            b(window).scroll(g)
        }

        function g() {
            scrTop = b(window).scrollTop();
            wndHeight = b(window).height();
            curScrOffset = scrTop + wndHeight;
            if (curScrOffset >= p()) {
                t(curScrOffset)
            }
        }

        function q() {
            b(window).unbind("scroll", g)
        }

        function n() {
            b(m.pagination).hide()
        }

        function p(v) {
            el = b(m.container).find(m.item).last();
            if (el.size() == 0) {
                return 0
            }
            treshold = el.offset().top + el.height();
            if (!v) {
                treshold += m.tresholdMargin
            }
            return treshold
        }

        function t(w, v) {
            urlNextPage = b(m.next).attr("href");
            if (!urlNextPage) {
                return q()
            }
            j.pushPages(w, urlNextPage);
            q();
            o();
            e(urlNextPage, function (y, x) {
                result = m.onLoadItems.call(this, x);
                if (result !== false) {
                    b(x).hide();
                    curLastItem = b(m.container).find(m.item).last();
                    curLastItem.after(x);
                    b(x).fadeIn()
                }
                b(m.pagination).replaceWith(b(m.pagination, y));
                k();
                s();
                m.onRenderComplete.call(this, x);
                if (v) {
                    v.call(this)
                }
                initBinding();
            })
        }

        function e(w, x) {
            var v = [];
            b.get(w, null, function (y) {
                b(m.container, y).find(m.item).each(function () {
                    v.push(this)
                });
                if (x) {
                    x.call(this, y, v)
                }
            }, "html")
        }

        function l(v) {
            curTreshold = p(true);
            if (curTreshold > 0) {
                t(curTreshold, function () {
                    q();
                    if ((j.getCurPageNum(curTreshold) + 1) < v) {
                        l(v);
                        b("html,body").animate({
                            scrollTop: curTreshold
                        }, 400, "swing")
                    } else {
                        b("html,body").animate({
                            scrollTop: curTreshold
                        }, 1000, "swing");
                        s()
                    }
                })
            }
        }

        function u() {
            loader = b(".ias_loader");
            if (loader.size() == 0) {
                loader = b("<div class='ias_loader'>" + m.loader + "</div>");
                loader.hide()
            }
            return loader
        }

        function o(v) {
            loader = u();
            el = b(m.container).find(m.item).last();
            el.after(loader);
            loader.fadeIn()
        }

        function k() {
            loader = u();
            loader.remove()
        }
    };

    function a(c) {
        if (window.console && window.console.log) {
            window.console.log(c)
        }
    }
    b.ias.defaults = {
        container: "#container",
        item: ".item",
        pagination: "#pagination",
        next: ".next",
        loader: '<img src="images/loader.gif"/>',
        tresholdMargin: 0,
        history: true,
        onPageChange: function () {},
        onLoadItems: function () {},
        onRenderComplete: function () {},
    };
    b.ias.util = function () {
        var d = false;
        var f = false;
        var c = this;
        e();

        function e() {
            b(window).load(function () {
                d = true
            })
        }
        this.forceScrollTop = function (g) {
            b("html,body").scrollTop(0);
            if (!f) {
                if (!d) {
                    setTimeout(function () {
                        c.forceScrollTop(g)
                    }, 1)
                } else {
                    g.call();
                    f = true
                }
            }
        }
    };
    b.ias.paging = function () {
        var e = [
            [0, document.location.toString()]
        ];
        var h = function () {};
        var d = 1;
        j();

        function j() {
            b(window).scroll(g)
        }

        function g() {
            scrTop = b(window).scrollTop();
            wndHeight = b(window).height();
            curScrOffset = scrTop + wndHeight;
            curPageNum = c(curScrOffset);
            curPagebreak = f(curScrOffset);
            if (d != curPageNum) {
                h.call(this, curPageNum, curPagebreak[0], curPagebreak[1])
            }
            d = curPageNum
        }

        function c(k) {
            for (i = (e.length - 1); i > 0; i--) {
                if (k > e[i][0]) {
                    return i + 1
                }
            }
            return 1
        }
        this.getCurPageNum = function (k) {
            return c(k)
        };

        function f(k) {
            for (i = (e.length - 1); i >= 0; i--) {
                if (k > e[i][0]) {
                    return e[i]
                }
            }
            return null
        }
        this.onChangePage = function (k) {
            h = k
        };
        this.pushPages = function (k, l) {
            e.push([k, l])
        }
    };
    b.ias.history = function () {
        var d = false;
        var c = false;
        e();

        function e() {
            c = !! (window.history && history.pushState && history.replaceState);
            c = false
        }
        this.setPage = function (g, f) {
            this.updateState({
                page: g
            }, "", f)
        };
        this.havePage = function () {
            return (this.getState() != false)
        };
        this.getPage = function () {
            if (this.havePage()) {
                stateObj = this.getState();
                return stateObj.page
            }
            return 1
        };
        this.getState = function () {
            if (c) {
                stateObj = history.state;
                if (stateObj && stateObj.ias) {
                    return stateObj.ias
                }
            } 
            return false
        };
        this.updateState = function (g, h, f) {
            if (d) {
                this.replaceState(g, h, f)
            } else {
                this.pushState(g, h, f)
            }
        };
        this.pushState = function (g, h, f) {
            if (c) {
                history.pushState({
                    ias: g
                }, h, f)
            } else {
               // alert(g.page);
              //  hash = (g.page > 0 ? "#/page/" + g.page : "");
               // window.location.hash = hash
            }
            d = true
        };
        this.replaceState = function (g, h, f) {
            if (c) {
                history.replaceState({
                    ias: g
                }, h, f)
                initBinding();
            } else {
                this.pushState(g, h, f)
                initBinding();
            }
        }
    }
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