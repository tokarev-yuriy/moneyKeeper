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
                    var owlCnt = $(self.container).find('.owl-carousel').length;
                    var owl = $(self.container).find('.owl-carousel');
                    
                    owl.owlCarousel({
                        margin:10,
                        loop: false,
                        center: false,
                        navigation: true,
						autoWidth: true,
                        responsive:{
                            300:{items:1},
                            600:{items:2},
                            900:{items:3},
                            1200:{items:4},
                            1500:{items:5}
                        },
                        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
                    });                    
                }
                
                self.align();
                if ($(self.container).find('.categories-widget.col').length) {
                  $( window ).resize(function() {
                    self.align();
                  });
                }
                    
            }
        });
    },
    
    align: function() {
      /*var self = this;
      if ($(self.container).find('.categories-widget.col').length) {
        $(self.container).find('.w-100').remove();
        var cnt = $(self.container).find('.categories-widget.col').length;
        var lines = Math.floor($(self.container).find('.categories-widget.col').parent().height() / $(self.container).find('.categories-widget.col').eq(0).height());
        var perLine = Math.ceil(cnt / lines);
        if (lines>1) {
          var i;
          for(i=1;i<lines;i++) {
            $(self.container).find('.categories-widget.col').eq(perLine*i - 1).after('<div class="w-100" />');
          }
        }
      }*/
    },
    
    reload: function() {
        this.load();
    }
    
}
