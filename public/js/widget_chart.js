/**
 *  Widget Chart class
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
ChartWidget = function (id, url) {
    
    this.id = id;
    this.url = url;
    this.chart = false;
    this.container = $('#'+this.id);
    
    if ($('.filter form').length>0) {
        this.url += '?'+$('.filter form').serialize();
    }
    
    this.init();
}

ChartWidget.prototype = {
    
    init: function() {
        var self = this;
        
        self.chart = AmCharts.makeChart( self.id, {
          "type": "pie",
          "dataLoader": {
            "url": self.url
          },
          "addClassNames": true,
          "legend":{
            "position":"bottom",
            "marginTop":10,
            "autoMargins":false
          },
          "innerRadius": "30%",
          "defs": {
            "filter": [{
              "id": "shadow",
              "width": "200%",
              "height": "200%",
              "feOffset": {
                "result": "offOut",
                "in": "SourceAlpha",
                "dx": 0,
                "dy": 0
              },
              "feGaussianBlur": {
                "result": "blurOut",
                "in": "offOut",
                "stdDeviation": 5
              },
              "feBlend": {
                "in": "SourceGraphic",
                "in2": "blurOut",
                "mode": "normal"
              }
            }]
          },
          "valueField": "sum",
          "titleField": "name",
        } );
        
        self.chart.addListener("init", handleInit);

        self.chart.addListener("rollOverSlice", function(e) {
          handleRollOver(e);
        });

        function handleInit(){
          self.chart.legend.addListener("rollOverItem", handleRollOver);
        }

        function handleRollOver(e){
          var wedge = e.dataItem.wedge.node;
          wedge.parentNode.appendChild(wedge);
        }
        
    },
    
    load: function() {
        var self = this;    
    },
    
    reload: function() {
        this.load();
    }
    
}