/**
 *  Widget Chart class
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
WidgetChart = function (id, url) {
    
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

WidgetChart.prototype = {
    
    init: function() {
        var self = this;
        
        if (self.chartType=='area') {
            self.initAreaChart();            
        } else {
            self.initPieChart();
            var btnGroup = '<div class="widget-chart-btn pull-right">';
            btnGroup += '<a href="javascript: void(0);" onclick="$(\'#'+self.id+'\').toggleClass(\'expand\'); $(\'.widget-chart-btn .btn[data-id='+self.id+']\').toggle();" class="btn btn-dark mb-2" data-id="'+self.id+'"><i class="fa fa-pie-chart"></i> '+langTranslations['mkeep.show_pie_chart']+'</a>';
            btnGroup += '<a href="javascript: void(0);" onclick="$(\'#'+self.id+'\').toggleClass(\'expand\'); $(\'.widget-chart-btn .btn[data-id='+self.id+']\').toggle();" class="btn btn-dark mb-2" data-id="'+self.id+'" style="display: none;"><i class="fa fa-pie-chart"></i> '+langTranslations['mkeep.hide_pie_chart']+'</a>';
            btnGroup += '</div><div class="clearfix"></div>';
            self.container.before(btnGroup);
            self.container.addClass('expandable');
        }
        

        
        self.chart.addListener("dataUpdated", checkEmptyChart);
        function checkEmptyChart() {
            if (self.chart.chartData.length == 0) {
                if (self.chartType=='area') {
                    self.container.hide();
                }
                $('.widget-chart-btn .btn[data-id='+self.id+']').hide();
            } else {
                if ($('.widget-chart-btn .btn[data-id='+self.id+']:visible').length == 0) {
                    $('.widget-chart-btn .btn[data-id='+self.id+']').eq(0).show();
                    if (self.chartType=='area') {
                        self.container.show();
                    }
                }
            }
        }
    },
    
    
    initPieChart: function() {
        var self = this;
        
        self.chart = AmCharts.makeChart( self.id, {
          "type": "pie",
          "dataLoader": {
            "url": self.url,
            "complete": function() {
                var summ = 0;
                for(var i = 0; i < self.chart.dataProvider.length; i++ ) {
                    var dp = self.chart.dataProvider[i];
                    summ += parseFloat(dp.sum);
                }
                self.chart.allLabels = [{
                    "y": "47%",
                    "align": "center",
                    "size": 25,
                    "bold": true,
                    "text": summ,
                    "color": "#555"
                  }];
            }
          },
          "addClassNames": true,
          "legend":{
            "position":"right",
            "marginTop":10,
            "autoMargins":false
          },
          "innerRadius": "50%",
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
          "responsive": {
            "enabled": true,
            "addDefaultRules": false,
            "rules": [
                {
                  "maxWidth": 902,
                  "overrides": {
                    "legend": {
                      "position":"bottom"
                    }
                  }
                }
             ]
          },
          "valueField": "sum",
          "titleField": "name",
          "creditsPosition": "bottom-right"
        } );
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
        
        var format = "MMMM YYYY";
        if ($(self.container).data('chart-format')) {
            format = $(self.container).data('chart-format');
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
                "position": "bottom",
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
            "responsive": {
                "enabled": true
            },
            "dataDateFormat": "YYYY-MM-DD",
            "categoryField": "date",
            "categoryAxis": {
                "minPeriod": period,
                "gridPosition": "start",
                "parseDates": true
            },
             "chartScrollbar": {
                "scrollbarHeight": 80,
                "backgroundAlpha": 0,
                "selectedBackgroundAlpha": 0.1,
                "selectedBackgroundColor": "#888888",
                "graphFillAlpha": 0,
                "graphLineAlpha": 0.5,
                "selectedGraphFillAlpha": 0,
                "selectedGraphLineAlpha": 1,
                "autoGridCount": true,
                "color": "#AAAAAA"
            },
            "chartCursor": {
                "categoryBalloonDateFormat": format,
                "cursorPosition": "mouse"
            },
            "creditsPosition": "bottom-right"
        } );
    },
    
    load: function() {
        var self = this;    
    },
    
    reload: function() {
        this.load();
    }
    
}