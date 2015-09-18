var AdvancedCustomOptions = Class.create();

AdvancedCustomOptions.prototype = {
    items: new Array(),
    initialize: function (removeMsg, editMsg) {
        this.removeMsg = removeMsg;
        this.editMsg = editMsg;
        this.removeLabel = '';
    },
    setItem: function(itemId, showContainerId, editContainerId, removedInputId, buttonsContainerId){
        this.items[itemId] = new Object();
        this.items[itemId].id = itemId;
        this.items[itemId].showContainerId    = showContainerId;
        this.items[itemId].editContainerId    = editContainerId;
        this.items[itemId].removedInputId     = removedInputId;
        this.items[itemId].buttonsContainerId = buttonsContainerId;
        return this;
    },
    getItem: function(itemId){
        return this.items[itemId];
    },
    editOptions: function(itemId){
        var item = this.getItem(itemId);
        if (item) {
            var showContainer = $(item.showContainerId);
            if(showContainer) {
                showContainer.hide();
            }
            var editContainer = $(item.editContainerId);

            if(editContainer) {
                var parent = editContainer.up();
                if (!this.editMessageBox) {
                    this.editMessageBox = new Element('div');
                    $(this.editMessageBox).update(this.editMsg);
                    $(parent).appendChild(this.editMessageBox);
                }
                else {
                    $(this.editMessageBox).show();
                }
                editContainer.show();
            }

            /**
             * Add Button Pressed
             */
            if ($(item.buttonsContainerId).select("a").length==1) {
                var removeLink = new Element('a');
                removeLink.setAttribute('href',"javascript:advancedCustomOptions.removeOptions('"+itemId+"')");
                console.log(removeLink);
                removeLink.update(this.removeLabel);
                $(item.buttonsContainerId).update(removeLink);
            }

        }
    },
    removeOptions: function(itemId){
        var item = this.getItem(itemId);
        if (item) {
            $(item.removedInputId).setValue(1);
            var showContainer = $(item.showContainerId);
            if(showContainer) {
                showContainer.hide();
            }
            var editContainer = $(item.editContainerId);

            if(editContainer) {
                if (this.editMessageBox) {
                    $(this.editMessageBox).hide();
                }
                editContainer.hide();
            }
            $(item.buttonsContainerId).update(this.removeMsg);
        }
    }
}