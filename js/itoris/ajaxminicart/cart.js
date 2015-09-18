AjaxMiniCart = Class.create();
AjaxMiniCart.prototype = {
	loadedProductsOptions : [],
	itemsCount : 0,
	maxProductsBlockHeight : 400,
	currentProductImage : null,
	hideMessageTimer : null,
	popupPositionExecuter: null,
	dynamicOptionObjs: [],
	initialize : function(config) {
		this.config = config;
		this.cart = $('ajax_mini_cart');
		this.cartMask = $('ajax_mini_cart_loading_mask');
		this.cartTotal = this.cart.select('.grand-total')[0];
		this.initCartLink();
		if (this.cartLink) {
			this.productsBlock = this.cart.select('.ajax-mini-cart-products')[0];
			this.messageBlock = $('ajax_mini_cart_message');
			this.optionsForm = $('ajax_mini_cart_product_options_form');
			$$('body')[0].appendChild(this.messageBlock);
			this.cart.show();
			this.productsBlock.setStyle({height: this.productsBlock.getHeight() + 'px'});
			var parentBlockWidth = this.cart.up().getWidth();
			var cartWidth = this.cart.getWidth();
			this.cart.setStyle({marginLeft: ((parentBlockWidth - cartWidth) / 2) + 'px'});
			this.cart.hide();

			this.initOptionsPopup();
			this.initEvents();
			this.initButtons();
			setInterval(this.initButtons.bind(this), 1000);
			this.initCartItems();
			this.initFormOnProductViewPage();
		}
	},
	initCartLink : function() {
		if ($('header-cart')) {
			this.cartLink = $('header-cart').up().select('a')[0];
			if (this.cartLink) {
				$('header-cart').remove();
				this.cartLink.insert({after: this.cart});
				var cartLinkLabel = this.cartLink.select('.label')[0];
				if (cartLinkLabel) {
					cartLinkLabel.addClassName('minicart-cart-link-content');
				} else {
					this.cartLink.addClassName('minicart-cart-link-content');
				}

				var blockPosition = this.cartLink.up().getStyle('position');
				if (!(blockPosition == 'relative' || blockPosition == 'absolute')) {
					this.cart.setStyle({
						right: this.cartLink.getStyle('right'),
						top: (parseNumber(this.cartLink.getStyle('right')) + this.cartLink.getHeight()) + 'px',
						left: 'auto'
					});
				}
			}
		} else {
			this.cartLink = $$('.top-link-cart')[0];
			if (this.cartLink) {
				this.cartLink.up().appendChild(this.cart);
				var container = document.createElement('span');
				container.className = 'minicart-cart-link-content';
				container.innerHTML = this.cartLink.innerHTML;
				this.cartLink.update();
				this.cartLink.appendChild(container);
				this.cartLink.insert({top: $('ajax_mini_cart_icon').show()});
				var blockPosition = this.cartLink.up().getStyle('position');
				if (!(blockPosition == 'relative' || blockPosition == 'absolute')) {
					this.cartLink.up().setStyle({position:'relative'});
				}
			}
		}
	},
	initEvents : function() {
		this.cart.canHide = true;
		this.canUpdateCartAjax = true;
		Event.observe(this.cartLink, 'mouseover', function(){
			this.cart.canHide = false;
			this.updateCartAjax();
			this.show(false);
		}.bind(this));
		Event.observe(this.cartLink, 'mouseout', function(){
			this.cart.canHide = true;
			this.hideWithTimeout();
		}.bind(this));
		Event.observe(this.cart, 'mouseover', function(){
			this.cart.canHide = false;
		}.bind(this));
		Event.observe(this.cart, 'mouseout', function() {
			this.cart.canHide = true;
			this.hideWithTimeout();
		}.bind(this));
		Event.observe(this.cart.select('button.remove-all-button')[0], 'click', this.removeAllItems.bind(this));
	},
	initButtons : function() {
		var buttons = $$('button.btn-cart');
		var productsForLoading = [];
		buttons.each(function(elm){
			if (!elm.hasMiniCartAction) {
				var onclickAttr = elm.getAttribute('onclick');
				if (onclickAttr) {
					var matches = onclickAttr.match(/\/product\/([0-9]*)/);
					elm.product_id = matches ? matches[1] : null;
					var matches = onclickAttr.match(/\/([0-9a-zA-Z-]*\.html)/);
					elm.request_path = matches ? matches[1] : null;
					if (elm.product_id || elm.request_path) {
						elm.callback = elm.onclick;
						elm.onclick = null;
						Event.observe(elm, 'click', this.addToCartByElement.bind(this, elm));
						elm.hasMiniCartAction = true;

						productsForLoading.push(elm.product_id || elm.request_path);
					}
				}
			}
		}.bind(this));
		//this.loadProductsOptions(productsForLoading);
	},
	initCartItems : function() {
		var products = this.cart.select('.ajax-mini-cart-product');
		this.itemsCount = products.length;
		for (var i = 0; i < products.length; i++) {
			if (!products[i].skipInit) {
				var matches = products[i].className.match(/item-([0-9]*)/);
				products[i].item_id = matches[1];
				Event.observe(products[i].select('.ajax-mini-cart-product-actions .delete')[0], 'click', this.removeItem.bind(this, products[i]));
				Event.observe(products[i].select('.ajax-mini-cart-product-actions .edit')[0], 'click', this.editItem.bind(this, products[i]));
				products[i].skipInit = true;
			}
		}
	},
	initOptionsPopup : function() {
		var obj = this;
		this.optionsPopup = $('ajax_mini_cart_product_options');
		this.pageMask = $('ajax_mini_cart_mask');
		$$('body')[0].appendChild(this.optionsPopup);
		$$('body')[0].appendChild(this.pageMask);
		Event.observe(this.optionsPopup.select('.ajax-mini-cart-options-footer button.cancel')[0], 'click', this.closeOptionsPopup.bind(this));
		Event.observe($('ajax_mini_cart_product_options_close_icon'), 'click', this.closeOptionsPopup.bind(this));
		Event.observe(this.optionsPopup.select('#ajax_mini_cart_popup_qty')[0], 'keypress', function(ev){
			if (ev.keyCode == 13) {
				obj.confirmOptionsPopup(false);
				ev.stop();
			}
		});
		Event.observe(this.optionsPopup.select('.ajax-mini-cart-options-footer button.add-to-cart')[0], 'click', this.confirmOptionsPopup.bind(this, false));
		Event.observe(this.optionsPopup.select('.ajax-mini-cart-options-footer button.update-cart')[0], 'click', this.confirmOptionsPopup.bind(this, true));
	},
	initFormOnProductViewPage : function() {
		var form = $('product_addtocart_form');
		if (form) {
			form.action = this.config.add_current_product_url;
			this.createAddProductIFrame($$('body')[0], form, true);
			if (form.select('button.btn-cart')[0]) {
				this.currentFormButton = form.select('button.btn-cart')[0];
				var obj = this;
				this.currentFormButton.ajaxAddToCart = function(){
					if (form.select('.product-img-box img')[0]) {
						if (('undefined' != typeof productAddToCartFormOld) && productAddToCartFormOld && !productAddToCartFormOld.validator.validate()) {
							return false;
						}
						obj.currentProductImage = form.select('.product-img-box img')[0];
						if (productAddToCartForm.validator.validate()) {
							obj.showButtonLoader(obj.currentFormButton);
							obj.currentImageEffect();
						}
					}
				}				
				Event.observe(form.select('button.btn-cart')[0], 'click', this.currentFormButton.ajaxAddToCart);
				form.select('.qty').each(function(qty){
					Event.observe(qty, 'keypress', function(ev){						
						if (ev.keyCode == 13) {
							obj.currentFormButton.ajaxAddToCart();
						}
					});
				});
			}
		}
	},
	updateItemIdForFormOnProductViewPage : function(itemId) {
		var form = $('product_addtocart_form');
		if (form) {
			form.action = form.action.replace(/\/id\/[0-9]*/, '/id/' + itemId);
		}
	},
	addToCartByElement : function(elm) {
		if (elm.product_id) {
			this.showProductOptions(elm.product_id, elm);
		} else if (elm.request_path) {
			this.showProductOptions(elm.request_path, elm);
		}
	},
	showProductOptions : function(requestPath, elm) {
		this.currentLoading = requestPath;
		if (this.loadedProductsOptions[requestPath]) {
			this.showOptionsPopup(this.loadedProductsOptions[requestPath]);
			this.prepareCurrentProductImage(elm);
		} else {
			this.showButtonLoader(elm);
			new Ajax.Request(this.config.load_options_url, {
				parameters: {request_path: requestPath},
				onComplete: function(res) {
					this.hideButtonLoader(elm);
					var resObj = res.responseText.evalJSON();
					resObj.content = resObj.content.replace('var opConfig', 'opConfig').replace(/opConfig/g, 'miniCartOpConfig');
					this.loadedProductsOptions[requestPath] = resObj;
					if (this.currentLoading == requestPath) {
						this.showOptionsPopup(resObj);
						this.prepareCurrentProductImage(elm);
					}
				}.bind(this)
			});
		}
	},
	loadProductsOptions : function(products) {
		var parameters = {};
		var num = 0;
		for (var i = 0; i < products.length; i++) {
			if (this.loadedProductsOptions[products[i]])
				continue;
			parameters['products[' + num + ']'] = products[i];
			num++;
		}
		if (num) {
			new Ajax.Request(this.config.load_all_products_options_url, {
				parameters: parameters,
				onComplete: function(res) {
					var resObj = res.responseText.evalJSON();
					for (var i = 0; i < resObj.products.length; i++) {
						resObj.products[i].content = resObj.products[i].content.replace('var opConfig', 'opConfig').replace(/opConfig/g, 'miniCartOpConfig');
						this.loadedProductsOptions[resObj.products[i].request_path] = resObj.products[i];
					}
				}.bind(this)
			});
		}
	},
	showButtonLoader : function(button) {
		var loader = document.createElement('div');
		loader.className = 'ajax-mini-cart-button-loader';
		button.insert({after:loader});
		button.loaderElm = loader;
		button.hide();
	},
	hideButtonLoader : function(button) {
		button.loaderElm.remove();
		button.show();
	},
	prepareCurrentProductImage : function(button) {
		this.currentProductImage = null;
		var i = 0;
		var parent = button.parentNode;
		var i = 0;
		while (i < 5) {
			if (parent.select('img')[0]) {
				this.currentProductImage = parent.select('img')[0];
				break;
			}
			parent = parent.parentNode;
			i++;
		}
	},
	currentImageEffect : function() {
		if (this.currentProductImage) {
			if (this.canUseAnimation()) {
				var img = this.currentProductImage.cloneNode();
				$$('body')[0].appendChild(img);
				img.setStyle({
					position:'absolute',
					left: (this.currentProductImage.viewportOffset().left + document.viewport.getScrollOffsets().left) + 'px',
					top: (this.currentProductImage.viewportOffset().top + document.viewport.getScrollOffsets().top) + 'px'
				});
				this.cart.show();
				var top = this.cart.viewportOffset().top + document.viewport.getScrollOffsets().top;
				var left = this.cart.viewportOffset().left + (this.cart.getWidth() / 2) + document.viewport.getScrollOffsets().left;
				this.cart.hide();
				new Effect.ScrollTo(this.cart, {duration: 0.5});
				new Effect.Morph(img, {
					style: 'top:' + top + 'px;left:' + left + 'px;opacity:0.1;height:20px;width:20px;',
					duration: 0.5,
					afterFinishInternal : function(effect) {
						effect.element.remove();
					}
				});
			}
			this.currentProductImage = null;
		}
	},
	editItem : function(block) {
		this.showOptionsPopup();
		new Ajax.Request(this.config.load_options_url, {
			parameters: {item_id: block.item_id},
			onComplete: function(res) {
				var resObj = res.responseText.evalJSON();
				resObj.content = resObj.content.replace('var opConfig', 'opConfig').replace(/opConfig/g, 'opConf');
				this.showOptionsPopup(resObj, true, block.item_id);
			}.bind(this)
		});
	},
	showOptionsPopup : function(config, isUpdateAction, itemId) {
		this.currentProductImage = null;
		this.pageMask.show();
		this.optionsPopup.show();

		var currentWidth = this.optionsPopup.getWidth();
		var currentHeight = this.optionsPopup.getHeight();

		var optionsLoader = $('ajax_mini_cart_product_options_loader');
		var optionsForm = this.optionsForm;
		if (isUpdateAction) {
			optionsForm.action = this.config.update_cart_url;
			this.optionsPopup.select('.ajax-mini-cart-options-footer .add-to-cart-box button.add-to-cart')[0].hide();
			this.optionsPopup.select('.ajax-mini-cart-options-footer .add-to-cart-box button.update-cart')[0].show();
			$('ajax_mini_cart_product_options_form_item_id').value = itemId;
		} else {
			optionsForm.action = this.config.add_to_cart_url;
			this.optionsPopup.select('.ajax-mini-cart-options-footer .add-to-cart-box button.add-to-cart')[0].show();
			this.optionsPopup.select('.ajax-mini-cart-options-footer .add-to-cart-box button.update-cart')[0].hide();
			$('ajax_mini_cart_product_options_form_item_id').value = '';
		}
		var optionsBody = this.optionsPopup.select('.ajax-mini-cart-options-body')[0];
		optionsBody.setStyle({height:'auto'});
		var setAutoWidthAfterEffect = false;
		if (config) {
			$('ajax_mini_cart_product_options_close_icon').show();
			optionsLoader.hide();
			optionsForm.show();
			var priceBlock = this.optionsPopup.select('.ajax-mini-cart-options-footer .regular-price')[0];
			priceBlock.id = 'minicart-product-price-' + config.product_id;
			priceBlock.update(config.price);
			$('ajax_mini_cart_popup_qty').value = config.qty;
			$('ajax_mini_cart_popup_product_id').value = config.product_id;
			this.updateOptionsPopupHeader(this.config.translates.configure.replace('%s', config.product_name));
			this.updateOptionsPopupContent(config.content);
			if (config.product_type == 'grouped') {
				if (this.optionsPopup.select('p.availability')[0]) {
					this.optionsPopup.select('p.availability')[0].remove();
				}
				$('ajax_mini_cart_popup_qty').hide();
				this.optionsPopup.select('.ajax-mini-cart-options-footer .add-to-cart-box label')[0].hide();
				priceBlock.hide();
			} else {
				$('ajax_mini_cart_popup_qty').show();
				this.optionsPopup.select('.ajax-mini-cart-options-footer .add-to-cart-box label')[0].show();
				priceBlock.show();
			}
			this.optionsPopup.setStyle({width:'auto', height:'auto'});
			var targetWidth = this.optionsPopup.getWidth();
			var heightCorrection = parseNumber(this.optionsPopup.getStyle('paddingTop')) + parseNumber(this.optionsPopup.getStyle('paddingBottom')) + parseNumber(this.optionsPopup.getStyle('borderTopWidth')) * 2;
			var targetHeight = this.optionsPopup.getHeight() - heightCorrection;
		} else {
			$('ajax_mini_cart_product_options_close_icon').hide();
			optionsLoader.show();
			optionsForm.hide();
			targetHeight = optionsLoader.getHeight();
			targetWidth = optionsLoader.getWidth();
			var heightCorrection = 0;
			setAutoWidthAfterEffect = true;
		}
		if (targetHeight + heightCorrection > document.viewport.getHeight()) {
			var maxHeight = document.viewport.getHeight() - 100;
			var heightDiff = targetHeight + heightCorrection - maxHeight;
			targetHeight = maxHeight - heightCorrection;
			optionsBody.setStyle({height: (optionsBody.getHeight() - heightDiff) + 'px', overflow: 'auto'});
		}
		if (this.canUseAnimation()) {
			this.optionsPopup.setStyle({width:0, height:currentHeight + 'px', marginTop: 0, marginLeft:0, overflow:'hidden'});
			new Effect.Morph(this.optionsPopup, {
				style: 'width:' + targetWidth + 'px;height:' + targetHeight + 'px;margin-left:-' + (targetWidth / 2) + 'px;margin-top:-' + ((targetHeight + heightCorrection) / 2) + 'px;',
				duration: 0.5,
				afterFinishInternal: function(effect) {
					var afterStyles = {height:'auto',overflow:'visible'};
					if (setAutoWidthAfterEffect) {
						afterStyles.width = 'auto';
					}
					effect.element.setStyle(afterStyles);
					if (config) {
						effect.element.prevWidth = targetWidth;
						effect.element.prevHeight = targetHeight;
						this.fixPopupPosition();
					}
					if (config && config.alert_error) {
						alert(config.alert_error);
					}
				}.bind(this)
			});
		} else {
			this.optionsPopup.setStyle({
				width: setAutoWidthAfterEffect ? 'auto' : (targetWidth + 'px'),
				height:setAutoWidthAfterEffect ? 'auto' : (targetHeight + 'px'),
				marginLeft: - (targetWidth / 2) + 'px',
				marginTop: - ((targetHeight + heightCorrection) / 2) + 'px',
				overflow:'visible',
				opacity: 0
			});

			new Effect.Appear(this.optionsPopup, {
				duration: 0.5,
				afterFinishInternal: function(effect) {
					if (config) {
						effect.element.prevWidth = targetWidth;
						effect.element.prevHeight = targetHeight;
						this.fixPopupPosition();
					}
					if (config && config.alert_error) {
						alert(config.alert_error);
					}
				}.bind(this)
			});
		}
	},
	fixPopupPosition: function() {
		var optionsBody = this.optionsPopup.select('.ajax-mini-cart-options-body')[0];
		var currentHeight = this.optionsPopup.prevHeight;
		var currentWidth = this.optionsPopup.prevWidth;
		this.optionsPopup.setStyle({width:'auto', height: 'auto'});
		var targetWidth = this.optionsPopup.getWidth();
		var heightCorrection = parseNumber(this.optionsPopup.getStyle('paddingTop')) + parseNumber(this.optionsPopup.getStyle('paddingBottom')) + parseNumber(this.optionsPopup.getStyle('borderTopWidth')) * 2;
		var targetHeight = this.optionsPopup.getHeight() - heightCorrection;
		if (targetHeight + heightCorrection > document.viewport.getHeight()) {
			optionsBody.setStyle({height:'auto'});
			var maxHeight = document.viewport.getHeight() - 100;
			var heightDiff = targetHeight + heightCorrection - maxHeight;
			targetHeight = maxHeight - heightCorrection;
			optionsBody.setStyle({height: (optionsBody.getHeight() - heightDiff) + 'px', overflow:'auto'});
		}
		if (this.optionsPopup.prevHeight != targetHeight || this.optionsPopup.prevWidth != targetWidth) {
			this.optionsPopup.prevWidth = targetWidth;
			this.optionsPopup.prevHeight = targetHeight;
			if (this.canUseAnimation()) {
				this.optionsPopup.setStyle({width:currentWidth + 'px', height:currentHeight + 'px'});
				new Effect.Morph(this.optionsPopup, {
					style: 'width:' + targetWidth + 'px;height:' + targetHeight + 'px;margin-left:-' + (targetWidth / 2) + 'px;margin-top:-' + ((targetHeight + heightCorrection) / 2) + 'px;',
					duration: 0.5,
					afterFinishInternal: function(effect){
						effect.element.setStyle({height:'auto'});
					}
				});
			} else {
				this.optionsPopup.setStyle({
					width:targetWidth + 'px',
					height:targetHeight + 'px',
					marginLeft: - (targetWidth / 2) + 'px',
					marginTop:- ((targetHeight + heightCorrection) / 2) + 'px',
					overflow:'visible'
				});
			}
		} else {
			this.optionsPopup.setStyle({width:currentWidth + 'px'});
		}
		if (this.popupPositionExecuter) {
			return;
		}
		this.popupPositionExecuter = new PeriodicalExecuter(this.fixPopupPosition.bind(this), 1);
	},
	closeOptionsPopup : function() {
		if (this.popupPositionExecuter) {
			this.popupPositionExecuter.stop();
			this.popupPositionExecuter = null;
		}
		this.optionsPopup.hide();
		this.pageMask.hide();
		this.updateOptionsPopupHeader('');
		this.updateOptionsPopupContent('');
		this.optionsPopup.writeAttribute('style', '');
		this.optionsPopup.setStyle({width:0, height:0, overflow:'hidden', display: 'none'});
	},
	confirmOptionsPopup : function(useEffect) {
		var form = this.optionsForm;
		var validator = new Validation(form);
		this.dynamicOptionObjs.each(function(obj){
			obj.beforeAddToCart();
		});
		if (validator.validate()) {
			this.createAddProductIFrame(this.optionsPopup, form, false);
			form.submit();
			if (useEffect) {
				this.cart.show();
				var top = this.cart.viewportOffset().top;
				var left = this.cart.viewportOffset().left + (this.cart.getWidth() / 2);
				this.cart.hide();
				new Effect.ScrollTo(this.cart, {duration: 0.5});
				this.optionsPopup.setStyle({overflow:'hidden'});
				new Effect.Morph(this.optionsPopup, {
					style: 'top:' + top + 'px;left:' + left + 'px;opacity:0.1;height:0;width:0;margin:0;',
					duration: 0.5,
					afterFinishInternal : function(effect) {
						this.closeOptionsPopup();
					}.bind(this)
				});
			} else {
				this.closeOptionsPopup();
			}
			this.currentImageEffect();
		}
		this.dynamicOptionObjs.each(function(obj){
			obj.afterAddToCart();
		});
	},
	createAddProductIFrame : function(appendToElm, form, recreateFlag) {
		var iframeName = 'minicart_' + Math.random();
		if (this.isIE7) {
			var iframe = document.createElement('<iframe name="' + iframeName + '"></iframe>');
		} else {
			var iframe = document.createElement('iframe');
			iframe.name = iframeName;
		}
		Element.extend(iframe);
		iframe.setStyle({'width':'0','height':'0','border':'0px solid #fff', display:'none'});
		appendToElm.appendChild(iframe);

		form.target = iframeName;

		Event.observe(iframe, 'load', function() {
			var iframeDocument = iframe.contentDocument ? iframe.contentDocument : iframe.contentWindow.document;
			if (iframeDocument.getElementById('response')) {
				if (typeof this.currentFormButton != 'undefined') {
					this.hideButtonLoader(this.currentFormButton);
				}
				var resObj = iframeDocument.getElementById('response').innerHTML.evalJSON();
				if (resObj.error) {
					this.showMessage(resObj.error, true);
				} else {
					if (resObj.item_config) {
						if (this.canUseAnimation()) {
							this.show();
						}
						this.showMessage(this.config.translates.update_message.replace('%s', resObj.item_config.product_name));
					} else {
						setTimeout(function(){
							this.showMessage(this.config.translates.add_message.replace('%s', resObj.product_name));
							if (this.canUseAnimation()) {
								this.show();
							}
						}.bind(this), 400);
					}
					this.updateCart(resObj);
				}
				iframe.remove();
				if (recreateFlag) {
					this.createAddProductIFrame(appendToElm, form, true);
				}
				this.enableAddToCartButtons(form);
			}
		}.bind(this));
		return iframe;
	},
	updateCartAjax : function() {
		if (this.canUpdateCartAjax) {
			this.canUpdateCartAjax = false;
			new Ajax.Request(this.config.load_cart_url, {
				onComplete:function(response) {
					var resObj = response.responseText.evalJSON();
					if (resObj.ok) {
						this.updateCart(resObj);
					}
				}.bind(this)
			});
			setTimeout(function(){this.canUpdateCartAjax = true;}.bind(this), 20000);
		}
	},
	enableAddToCartButtons : function(form) {
		form.select('button.btn-cart').each(function(elm) {elm.disabled = false;});
	},
	updateOptionsPopupContent : function(content) {
		this.optionsPopup.select('.ajax-mini-cart-options-body')[0].update(content);
	},
	updateOptionsPopupHeader : function(content) {
		this.optionsPopup.select('.ajax-mini-cart-options-header span')[0].update(content);
	},
	addToCart : function(params) {
		new Effect.ScrollTo($$('body')[0], {duration: 1});
		this.show(true);
		this.showMask();
		new Ajax.Request(this.config.add_to_cart_url, {
			parameters: params,
			onComplete: function(res) {
				var resObj = res.responseText.evalJSON();
				if (resObj.error) {
					alert(resObj.error);
				} else {
					if (resObj.content) {
						resObj.content = resObj.content.replace('var opConfig', 'opConfig').replace(/opConfig/g, 'opConf');
						this.showOptionsPopup(resObj);
					} else {
						this.showMessage(this.config.translates.add_message.replace('%s', resObj.product_name));
						this.updateCart(resObj);
					}
				}
				this.hideMask();
			}.bind(this)
		});
	},
	removeItem : function(block) {
		this.lock();
		this.showProductLoadingMask(block);
		new Ajax.Request(this.config.remove_item_url, {
			parameters: {id: block.item_id},
			onComplete: function(res) {
				var resObj = res.responseText.evalJSON();
				if (resObj.error) {
					this.hideProductLoadingMask(block);
					alert(resObj.error);
				} else {
					block.select('.ajax-mini-cart-product-loader')[0].hide();
					this.showMessage(this.config.translates.delete_message.replace('%s', resObj.product_name));
					this._removeItem(block);
					this.updateCart(resObj);
				}

			}.bind(this)
		});
		this.unlock();
	},
	showProductLoadingMask : function(block) {
		block.select('.ajax-mini-cart-product-loader')[0].show();
		block.select('.ajax-mini-cart-product-options')[0].hide();
		block.select('.ajax-mini-cart-product-totals')[0].hide();
		block.select('.ajax-mini-cart-product-actions')[0].hide();
	},
	hideProductLoadingMask : function(block) {
		block.select('.ajax-mini-cart-product-loader')[0].hide();
		block.select('.ajax-mini-cart-product-options')[0].show();
		block.select('.ajax-mini-cart-product-totals')[0].show();
		block.select('.ajax-mini-cart-product-actions')[0].show();
	},
	_removeItem : function(block) {
		this.cart.setStyle({height:'auto'});
		this.correctProductsBlockHeight();
		var obj = this;
		new Effect.Morph(block, {
			style: 'height:0',
			duration: 0.5,
			afterFinishInternal: function(effect) {
				effect.element.remove();
				if (!obj.cart.select('.ajax-mini-cart-product').length) {
					obj._hideContent();
				}
				obj.correctProductsBlockHeight();
			}
		});
	},
	removeAllItems : function() {
		this.lock();
		this.cart.canHide = false;
		this.cart.select('.ajax-mini-cart-product-actions').each(function(elm){elm.hide()});
		this.cart.select('.ajax-mini-cart-button-loader')[0].show();
		this.cart.select('.remove-all-button')[0].hide();
		new Ajax.Request(this.config.remove_all_items_url, {
			onComplete: function(res) {
				var resObj = res.responseText.evalJSON();
				if (resObj.error) {
					this.cart.select('.ajax-mini-cart-product-actions').each(function(elm){elm.show()});
					alert(resObj.error);
				} else {
					this.showMessage(this.config.translates.delete_all_message);
					this._removeAllItems();
					this.updateCart(resObj);
				}
				this.cart.canHide = true;
				this.cart.select('.ajax-mini-cart-button-loader')[0].hide();
				this.cart.select('.remove-all-button')[0].show();
			}.bind(this)
		});
		this.unlock();
	},
	_removeAllItems : function() {
		this.cart.setStyle({height:'auto'});
		this.correctProductsBlockHeight();
		var obj = this;
		var blocks = this.cart.select('.ajax-mini-cart-product');
		for (var i = blocks.length - 1; i >= 0; i--) {
			new Effect.Morph(blocks[i], {
				style: 'height:0',
				duration: 0.5 ,
				afterFinishInternal: function(effect) {
					effect.element.remove();
					if (!obj.cart.select('.ajax-mini-cart-product').length) {
						obj._hideContent();
						obj.correctProductsBlockHeight();
					}
				}
			});
		}
	},
	correctProductsBlockHeight : function() {
		this.productsBlock.setStyle({height:'auto'});
		if (this.productsBlock.getHeight() > this.maxProductsBlockHeight) {
			this.productsBlock.setStyle({height: this.maxProductsBlockHeight + 'px'});
		}
	},
	updateCart : function(config) {
		this.updateCartLink(config.link_text, config.items_count);
		this.cartTotal.update(config.grand_total);
		var addedNewItems = false;
		if (config.items) {
			for (var i = 0; i < config.items.length; i++) {
				var item = config.items[i];
				if (this.cart.select('.item-' + item.id)[0]) {
					this.cart.select('.item-' + item.id)[0].select('.ajax-mini-cart-product-totals .qty')[0].update(item.qty);
				} else {
					this.addItem(item);
					addedNewItems = true;
				}
			}
		}
		if (config.item_config) {
			this.updateItemBlock(config.item_config);
			addedNewItems = true;
		}
		if (config.items) {
			var itemsBlocks = this.cart.select('.ajax-mini-cart-product');
			for (var i = 0; i < itemsBlocks.length; i++) {
				var itemId = itemsBlocks[i].className.match(/item-([0-9]*)/)[1];
				var isExists = false;
				for (var j = 0; j < config.items.length; j++) {
					if (config.items[j].id == itemId) {
						isExists = true;
						break;
					}
				}
				if (!isExists) {
					this._removeItem(itemsBlocks[i]);
				}
			}
		}
		if (addedNewItems) {
			this.initCartItems();
			this.resizeProductsBlock();
		}
	},
	updateItemBlock : function(config) {
		if (config.old_id == config.id) {
			var itemBlock = this.cart.select('.item-' + config.id)[0];
			itemBlock.select('.ajax-mini-cart-product-totals .qty')[0].update(config.qty);
			itemBlock.select('.ajax-mini-cart-product-totals .price')[0].update(config.price);
			itemBlock.select('.ajax-mini-cart-product-options')[0].update(config.options_html.unescapeHTML());
		} else {
			var itemBlock = this.cart.select('.item-' + config.old_id)[0];
			this._removeItem(itemBlock);
			this.addItem(config);
			this.updateItemIdForFormOnProductViewPage(config.id);
		}
	},
	addItem : function(config) {
		if (!this.cart.select('.ajax-mini-cart-product').length) {
			this.cart.select('.ajax-mini-cart-message')[0].hide();
			this.cart.select('.ajax-mini-cart-content-box')[0].show();
		}
		this.productsBlock.setStyle({height: this.productsBlock.getHeight()});
		var block = document.createElement('div');
		Element.extend(block);
		var blockContent = new Template(ajaxMiniCartProductTemplate);
		if (config.options_html) {
			config.options_html = config.options_html.unescapeHTML();
		}
		if (config.is_visible) {
			config.edit_link_begin = '<a href="' + config.edit_url + '">';
			config.edit_link_end = '</a>';
		}
		block.update(blockContent.evaluate(config));
		block.addClassName('ajax-mini-cart-product item-' + config.id);
		this.cart.select('.ajax-mini-cart-products')[0].appendChild(block);
	},
	showMask : function() {
		this.cartMask.show();
		this.cart.canHide = false;
	},
	hideMask : function() {
		this.cartMask.hide();
		this.cart.canHide = true;
		this.hideWithTimeout();
	},
	show : function(isPermanent) {
		if (!this.cart.visible()) {
			var useShakeEffect = true;
			if (this.cart.select('.ajax-mini-cart-product').length) {
				this._showContent();
				var effectDuration = 0.3;
			} else {
				this._hideContent();
				var effectDuration = 0.05;
			//	useShakeEffect = true;
			}
			this.cart.setStyle({height:'auto'});
			this.cart.show();
			this.correctProductsBlockHeight();
			var height = this.cart.getHeight() - parseNumber(this.cart.getStyle('borderTopWidth')) - parseNumber(this.cart.getStyle('borderBottomWidth'));
			if (this.canUseAnimation()) {
				this.cart.setStyle({height:0, overflow:'hidden'});
				new Effect.Morph(this.cart, {
					style: 'height:' + height + 'px;',
					duration: effectDuration,
					afterFinishInternal : function(effect) {
						effect.element.setStyle({overflow:'visible'});
						if (useShakeEffect) {
							this.effectShake(effect.element, height);
						}
					}.bind(this)
				});
			} else {
				this.cart.setStyle({height:height + 'px', overflow: 'visible', opacity: 0});
				new Effect.Appear(this.cart, {duration:0.5});
			}
			if (!isPermanent) {
				this.hideWithTimeout();
			}
		}
	},
	_showContent : function() {
		this.cart.select('.ajax-mini-cart-message')[0].hide();
		this.cart.select('.ajax-mini-cart-content-box')[0].show();
	},
	_hideContent : function() {
		this.cart.select('.ajax-mini-cart-message')[0].show();
		this.cart.select('.ajax-mini-cart-content-box')[0].hide();
	},
	hide : function() {
		if (this.cart.isLocked) {
			return;
		}
		if (this.cart.visible() && this.cart.canHide) {
			if (this.canUseAnimation()) {
				this.cart.setStyle({overflow:'hidden'});
				new Effect.Morph(this.cart, {
					style: 'height:0',
					duration: 0.5,
					afterFinishInternal: function(effect) {
						effect.element.hide();
					}
				});
			} else {
				new Effect.Fade(this.cart, {duration:0.5});
			}
		}
	},
	hideWithTimeout : function() {
		setTimeout(function(){
			this.hide();
		}.bind(this), 2000);
	},
	lock : function() {
		this.cart.isLocked = true;
	},
	unlock : function() {
		this.cart.isLocked = false;
	},
	resizeProductsBlock : function() {
		this.cart.setStyle({height: 'auto'});
		var currentHeight = this.productsBlock.getHeight();
		this.productsBlock.setStyle({height: 'auto'});
		var newHeight = this.productsBlock.getHeight();
		if (newHeight > this.maxProductsBlockHeight) {
			newHeight = this.maxProductsBlockHeight;
		}
		this.productsBlock.setStyle({height: currentHeight + 'px'});
		var cart = this.cart;
		new Effect.Morph(this.productsBlock, {
			style: 'height:' + newHeight + 'px;',
			duration: 0.5,
			afterFinishInternal:function(effect) {
				cart.setStyle({height:'auto'});
			}
		});
	},
	showMessage : function(message, isError) {
		if (this.messageBlock.hasClassName('error-message')) {
			if (!isError) {
				this.messageBlock.removeClassName('error-message')
			}
		} else {
			if (isError) {
				this.messageBlock.addClassName('error-message')
			}
		}
		this.messageBlock.select('span')[0].update(message);
		this.messageBlock.show();
		this.messageBlock.setStyle({top:0,left:0});
		if (this.hideMessageTimer) {
			clearTimeout(this.hideMessageTimer);
		}
		this.messageBlock.setStyle({
			marginLeft: (-this.messageBlock.getWidth() / 2) + 'px',
			marginTop: (-this.messageBlock.getHeight() / 2) + 'px'
		});
		this.messageBlock.setStyle({left:document.viewport.getWidth() + 'px', opacity: 0});
		if (this.canUseAnimation()) {
			new Effect.Morph(this.messageBlock, {
				style: 'top:' + (document.viewport.getHeight() / 2) + 'px;left:' + (document.viewport.getWidth() / 2) + 'px;opacity:1',
				duration: 0.5
			});
		} else {
			this.messageBlock.setStyle({
				top: (document.viewport.getHeight() / 2) + 'px',
				left: (document.viewport.getWidth() / 2) + 'px'
			});
			this.messageBlock.appear();
		}
		this.hideMessageTimer = setTimeout(this.hideMessage.bind(this), 2500);
	},
	hideMessage : function() {
		if (this.canUseAnimation()) {
			new Effect.Morph(this.messageBlock, {
				style: 'top:0;left:' + (document.viewport.getWidth()) + 'px;opacity:0',
				duration: 0.5
			});
		} else {
			this.messageBlock.fade();
		}
	},
	canUseAnimation: function() {
		return this.config.enable_animation;
	},
	updateCartLink : function(text, qty) {
		var cartHeader = $('cartHeader');
		if (cartHeader && cartHeader.select('span').length) {
			cartHeader.select('span')[0].update(qty);
		} else {
			var cartLinkCount = this.cartLink.select('.count')[0];
			if (cartLinkCount) {
				cartLinkCount.update(qty || '');
				if (qty) {
					if (this.cartLink.hasClassName('no-count')) {
						this.cartLink.removeClassName('no-count')
					}
				} else {
					if (!this.cartLink.hasClassName('no-count')) {
						this.cartLink.addClassName('no-count')
					}
				}
			} else {
			//	var cartLink = $$('.header a[href|=' + this.quickbuy.config.checkoutLinkUrl + ']');
				var cartLink = this.cartLink.select('.minicart-cart-link-content')[0];
				//if (cartLink.length) {
					if (cartLink.select('span').length) {
						cartLink.select('span')[0].update(qty);
					} else {
						cartLink.update(text);
					}
				//}
			}
		}
	},
	effectShake : function(element, origHeight) {
		if (this.canUseAnimation()) {
			element = $(element);
			var options = Object.extend({
				distance: 7,
				duration: 0.6
			}, arguments[1] || {});
			var distance = parseFloat(options.distance);
			var split = parseFloat(options.duration) / 10.0;

			var effectHeight = origHeight - distance;
			return new Effect.Morph(element,
				{ style:  'height:' + effectHeight + 'px', duration: split, afterFinishInternal: function(effect) {
					new Effect.Morph(effect.element,
						{ style:  'height:' + origHeight + 'px', duration: split*2,  afterFinishInternal: function(effect) {
							new Effect.Morph(effect.element,
								{ style:  'height:' + effectHeight + 'px', duration: split*2,  afterFinishInternal: function(effect) {
									new Effect.Morph(effect.element,
										{ style:  'height:' + origHeight + 'px', duration: split*2,  afterFinishInternal: function(effect) {
													effect.element.undoPositioned();//.setStyle(oldStyle);
										 }}); }}); }}); }});
		}
	},
	getElementStyleNumberValue : function(elm, styleCode) {
		return isNaN(parseNumber(elm.getStyle(styleCode))) ? 0 : parseNumber(elm.getStyle(styleCode));
	}
}

MiniCartProductOptionsPrice = Class.create(Product.OptionsPrice, {
	initPrices: function() {
		this.containers[0] = 'minicart-product-price-' + this.productId;
		this.containers[1] = 'minicart-bundle-price-' + this.productId;
		this.containers[2] = 'minicart-price-including-tax-' + this.productId;
		this.containers[3] = 'minicart-price-excluding-tax-' + this.productId;
		this.containers[4] = 'minicart-old-price-' + this.productId;
	}
});