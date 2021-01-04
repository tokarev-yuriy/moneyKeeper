/**
 *  Widget Manager class
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
WidgetManager = function () {
    this.widgets = new Array();
}

WidgetManager.prototype = {
    
    init: function() {
        var self = this;
        $('.widget').each(function(){
            var id = $(this).attr('id');
            if (!id) {
                console.log('WIDGET MANAGER: Unknown widget id');
                return;
            }
            var url = $(this).attr('data-url');
            if (!url) {
                console.log('WIDGET MANAGER: Unknown widget url');
                return;
            }
            
            if (self.widgets[id]) {
                console.log('WIDGET MANAGER: Duplicated widget id');
                return;
            }
            if ($(this).attr('data-type')=='vue') {
                self.widgets[id] = new WidgetVue(id, url);
            } else if ($(this).attr('data-type')=='chart') {
                self.widgets[id] = new WidgetChart(id, url);
            } else {
                self.widgets[id] = new Widget(id, url);
            }
            
            if (!self.widgets[id]['lazyLoad']) {
                self.widgets[id].load();
            }
            
        });
    },
    
    reload: function(id) {
        var self = this;
        if (self.widgets[id]) {
            self.widgets[id].reload();
        } else {
            console.log('WIDGET MANAGER: Unknown widget id');
        }
    },
    
    reloadAll: function() {
        var self = this;
        for(var x in self.widgets) {
            self.widgets[x].reload();
        }
    }
    
}

var WManager = new WidgetManager();
$(document).ready(function(){
    WManager.init();
});