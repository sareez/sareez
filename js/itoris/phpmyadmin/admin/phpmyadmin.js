if (!Itoris) {
	var Itoris = {};
}

Itoris.PhpMyAdmin = Class.create({
	initialize : function() {
		var curObj = this;
		var phpmyadminTimer  = null;
		/*phpmyadminTimer = new PeriodicalExecuter(function() {
			curObj.phpmyadmin(phpmyadminTimer);
		}, 0.2);*/
		/*Event.observe(window, 'resize', function() {
			curObj.resizeWindow(false);
		});*/
	},
	phpmyadmin : function(t) {
		if ($$('.itoris_phpmyadmin_iframe')[0]) {
			t.stop();
		}
		if ($$('.itoris_phpmyadmin_iframe')[0] && $$('.middle')[0]) {
			$$('.middle')[0].setStyle({minHeight: '0px'});
		}
		if ($$('.itoris_phpmyadmin_iframe')[0] && $$('.footer')[0]) {
			$$('.footer')[0].setStyle({paddingTop: '10px', paddingBottom: '0px'});
		}
		this.resizeWindow(true);
	},
	resizeWindow : function(isLoad) {
		var currentHeight = $$('.itoris_phpmyadmin_iframe')[0].getHeight();
		var iframeHeight = $$('.itoris_phpmyadmin_iframe')[0].getHeight();
		var allWindowHeight = document.documentElement.scrollHeight;
		var viewPartWindowHeight = document.documentElement.clientHeight;

		if (allWindowHeight <= viewPartWindowHeight) {
			if (!isLoad) {
				currentHeight = $('itoris_phpmyadmin_container').getHeight() - 60;
			}
		}

		if (allWindowHeight > viewPartWindowHeight) {
			iframeHeight = currentHeight - (allWindowHeight - viewPartWindowHeight) - 3;
		} else {
			iframeHeight = currentHeight;
		}
		$$('.itoris_phpmyadmin_iframe')[0].setStyle({height: iframeHeight + 'px'});
		$$('.middle')[0].setStyle({height: iframeHeight + 'px'});

		var y = $('itoris_phpmyadmin_container').positionedOffset();
		$('itoris_phpmyadmin_container').setStyle({
			position: 'fixed',
			left: '0px',
			width: '100%',
			top: y.top + 'px',
			bottom: '20px'
		});
	}
});
var itorisPhpMyAdmin = new Itoris.PhpMyAdmin();