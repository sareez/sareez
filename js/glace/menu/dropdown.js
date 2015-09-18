jQuery.noConflict();!function($){"use strict"
var enter='[data-toggle="dropdown"]',leave='[data-toggle="dropdown"]',Dropdown=function(element){}
Dropdown.prototype={constructor:Dropdown,enter:function(e){var $this=$(e.currentTarget)
clearTimeout($this.data('ltimeout'));$this.data('ltimeout',0)
if(($this.data('etimeout')==undefined||$this.data('etimeout')==0)&&$this.parent().find('.open').length==0){var t=setTimeout(function(){Dropdown.prototype.enter(e);},$.fn.dropdown.openTimeout)
$this.data('etimeout',t)}else{$(this).data('etimeout',0)
$('li[data-toggle="dropdown"]').removeClass('open')
$this.addClass('open')
var $dropdown=$this.find('>ul');if($dropdown.length>0){var navLeft=$this.parent().offset().left;var navWidth=$this.parent().width();var dropLeft=$dropdown.offset().left;var dropWidth=$dropdown.width();if(dropLeft-navLeft+dropWidth>navWidth){$dropdown.css('left','auto');$dropdown.css('right','0px');}}}},leave:function(e){var $this=$(e.currentTarget)
clearTimeout($this.data('etimeout'));$this.data('etimeout',0)
if(($this.data('ltimeout')==undefined||$this.data('ltimeout')==0)){var t=setTimeout(function(){Dropdown.prototype.leave(e);},$.fn.dropdown.closeTimeout)
$this.data('ltimeout',t)}else{$(this).data('ltimeout',0)
var isActive
isActive=$this.hasClass('open')
isActive&&$this.removeClass('open')}}}
$.fn.dropdown=function(option){return this.each(function(){var $this=$(this),data=$this.data('dropdown')
if(!data)
$this.data('dropdown',(data=new Dropdown(this)))
if(typeof option=='string')
data[option].call($this)})}
$.fn.dropdown.Constructor=Dropdown
$.fn.dropdown.openTimeout=0;$.fn.dropdown.closeTimeout=100;$(function(){$('body').on('mouseenter.dropdown.data-api',enter,Dropdown.prototype.enter)
$('body').on('mouseleave.dropdown.data-api',leave,Dropdown.prototype.leave)})}(window.jQuery);