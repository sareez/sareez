var Autocomplete = Class.create();
Autocomplete.prototype = {
    search: "",
    initialize : function(){
        this.search = $('search');
    },
    initAutocomplete : function(url, containerElement){

        var autocompleter = new Ajax.Autocompleter(
            this.search,
            containerElement,
            url,
            {
                paramName: this.search.name,
                method: 'post',
                minChars: minCharacters,
                frequency: queryDelay,
                onShow : function(element, update) {

                    var posSC = $('search').cumulativeOffset();
                    posSC.top = posSC.top + parseInt($('search').getHeight()) + 4;
                    if (!Prototype.Browser.IE)
                        posSC.left -= (parseInt($('search').getStyle('padding-left')) + 8);

                    $('searchr-result-containter').setStyle({

                        //left: parseInt(posSC.left+7)+"px",
                        top: posSC.top+"px"

                    });

                    update.show();
                    $('searchr-result-containter').show();
                },
                onHide : function(element, update)
                {
                    $('searchr-result-containter').hide();
                    update.hide();
                    autocompleter.lastHideTime = new Date().getTime();
                },
                updateElement : function(element)
                {
                    return false;
                }
            }
        );
        autocompleter.startIndicator = function(){
            this.element.setStyle({
                backgroundImage: 'url("'+progressImage+'")',
                backgroundRepeat: 'no-repeat',
                backgroundPosition: 'right'
            });
        }
        autocompleter.stopIndicator = function(){
            this.element.style.backgroundImage = 'none';
        }
        autocompleter.onKeyPress = function(event) {
            var e=window.event || event;
            if (e.keyCode == Event.KEY_RETURN){
                var diff = new Date().getTime() - autocompleter.lastHideTime;
                var el = $$('#searchr-result-containter .selected')[0];
               if (diff > 250 || !el || el.hasClassName('autocomplete_hidden')) {
                    searchForm.presubmit();
                    return;
                }
                el.click();
                Event.stop(e);
            }
        };

        autocompleter.customInit = function(element) {
            Event.observe(element, 'keydown', autocompleter.onKeyPress.bindAsEventListener(this));
        }
        autocompleter.customInit(this.search);
    }
}
