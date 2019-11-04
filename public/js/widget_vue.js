/**
 *  Widget Vue class
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
WidgetVue = function (id, url) {
    
    this.id = id;
    this.url = url;
    this.container = $('#'+this.id);
    this.init();
	this.data = {
		'widget':{
			'spend': 0,
			'plan': 0,
			'income': 0,
			'max': 100
		}
	};
	this.vue = new Vue({
	  el: '#'+id,
	  data: this.data
	});
}

WidgetVue.prototype = {
    
    init: function() {
        var self = this;
        /* code */
    },
    
    load: function() {
        var self = this;
        $.ajax({
            url: self.url,
            dataType: "json",
            success: function(data, textStatus, xhr) {
                if (xhr.status!=200 || data=='') {
                    return;
                }
                self.vue.widget = data;
            }
        });
    },
    
    reload: function() {
        this.load();
    }
    
}
