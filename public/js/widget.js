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
                    
                    owl.on('initialize.owl.carousel', function(event) {
                      if ($(self.container).find('.owl-carousel .card-stats').length < event.relatedTarget.settings.items) {
                        event.relatedTarget.settings.center = true;
                        event.relatedTarget.options.center = true;
                      }
                    });
                    
                    owl.owlCarousel({
                        margin:3,
                        responsive:{
                            0:{items:2},
                            300:{items:3},
                            450:{items:4},
                            600:{items:5},
                            750:{items:6},
                            900:{items:7},
                            1050:{items:8},
                            1200:{items:9},
                            1350:{items:10},
                            1500:{items:11}
                        },
                        nav: false,
                        dotsEach: 1,
                        center: false,
                        loop:false,
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
      var self = this;
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
      }
    },
    
    reload: function() {
        this.load();
    }
    
}
