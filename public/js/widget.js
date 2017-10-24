/**
 *  Widget class
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
Widget = function (id, url) {
    
    this.id = id;
    this.url = url;
    this.container = $('#'+this.id);
    this.init();
}

Widget.prototype = {
    
    init: function() {
        var self = this;
        /* code */
    },
    
    load: function() {
        var self = this;
        $.ajax({
            'url': self.url,
            'success': function(result, textStatus, xhr) {
                if (xhr.status!=200 || result=='') {
                    return;
                }
                
                $(self.container).html(result);
                if ($(self.container).find('.owl-carousel').length) {
                    $(self.container).find('.owl-carousel').owlCarousel({
                        margin:3,
                        responsive:{
                            0:{items:3},
                            768:{items:3},
                            992:{items:5},
                            1200:{items:7}
                        },
                        nav     : true,
                        dots    : false,
                        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
                    });
                }
                    
            }
        });
    },
    
    reload: function() {
        this.load();
    }
    
}