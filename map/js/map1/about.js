var map1 = map1 || {}

map1.AboutDialog = $class({
    Extends: map1.gui.Dialog,    
    
    constructor: function(id,id_handle,id_close,id_next,id_prev,id_finish) {
        map1.gui.Dialog.call(this,id,id_handle,id_close,id_next,id_prev,id_finish);
    },

});
