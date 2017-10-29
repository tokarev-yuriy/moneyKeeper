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
    this.chartType = $(this.container).attr('data-chart-type');
    
    if ($('.filter form').length>0) {
        this.url += '?'+$('.filter form').serialize();
    }
    
    this.init();
}

ChartWidget.prototype = {
    
    init: function() {
        var self = this;
        
        if (self.chartType=='area') {
            self.initAreaChart();
            self.container.before('<a href="javascript: void(0);" onclick="$(\'#'+self.id+'\').toggle();" class="pull-right btn btn-dark mb-2"><i class="fa fa-area-chart fa-2x"></i></a><div class="clearfix"></div>');
        } else {
            self.initPieChart();
            self.container.before('<a href="javascript: void(0);" onclick="$(\'#'+self.id+'\').toggle();" class="pull-right btn btn-dark mb-2"><i class="fa fa-pie-chart fa-2x"></i></a><div class="clearfix"></div>');
        }
    },
    
    
    initPieChart: function() {
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
    
    initAreaChart: function() {
        var self = this;
        
        var graphs = [];
        $(self.container).find('.graph').each(function(){
            var graph = {
                "type": "line",
                "balloonText": "[[value]]",
                "fillAlphas": 0.6,
                "lineAlpha": 0,
                "title": $(this).data('name'),
                "valueField": $(this).data('field')
            };
            
            if ($(this).data('color')) {
                graph['fillColors'] = $(this).data('color');
                graph['legendColor'] = $(this).data('color');
                graph['lineColor'] = $(this).data('color');
            }
            
            graphs.push(graph);
        });
        
        var period = "MM";
        if ($(self.container).data('chart-period')) {
            period = $(self.container).data('chart-period');
        }
        
        var stackType = "regular";
        if ($(self.container).data('chart-stacktype')) {
            stackType = $(self.container).data('chart-stacktype');
        }
        
        
        self.chart = AmCharts.makeChart( self.id, {
            "type": "serial",
            "dataLoader": {
                "url": self.url,
                "format": "json"
            },
            "legend": {
                "equalWidths": true,
                "periodValueText": "[[value.sum]]",
                "position": "top",
                "valueAlign": "left",
                "valueWidth": 100
            },
            "graphs": graphs,
            "valueAxes": [{
                "stackType": stackType,
                "gridAlpha": 0.07,
                "position": "left",
                "title": "Money"
            }],
            "plotAreaBorderAlpha": 0,
            "marginTop": 10,
            "marginLeft": 0,
            "marginBottom": 0,
            "chartScrollbar": {},
            "chartCursor": {
                "cursorAlpha": 0
            },
            "dataDateFormat": "YYYY-MM-DD",
            "categoryField": "date",
            "categoryAxis": {
                "minPeriod": period,
                "gridPosition": "start",
                "parseDates": true
            }
        } );
        
        
    },
    
    load: function() {
        var self = this;    
    },
    
    reload: function() {
        this.load();
    }
    
}