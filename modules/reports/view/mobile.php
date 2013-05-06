<style>
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

#graph svg {
  height: <?php echo SCREENWIDTH;?>px;
  margin: 10px;
  min-width: 100px;
  min-height: 100px;
/*
  Minimum height and width is a good idea to prevent negative SVG dimensions...
  For example width should be =< margin.left + margin.right + 1,
  of course 1 pixel for the entire chart would not be very useful, BUT should not have errors
*/
}

.bar {
  fill: steelblue;
    padding: 3px;
  margin: 1px;
  color: white;
  width:50px;
}

.x.axis path {
  display: none;
}

.line {
  fill: none;
  stroke: steelblue;
  stroke-width: 1.5px;
}

.arc path {
  stroke: #fff;
}

</style>
<script src="http://d3js.org/d3.v3.min.js"></script>

<script src="nvd3/nv.d3.js"></script>

<script type="text/javascript">
nv.models.linePlusBarChart = function() {

  //============================================================
  // Public Variables with Default Settings
  //------------------------------------------------------------

  var lines = nv.models.line()
    , bars = nv.models.historicalBar()
    , xAxis = nv.models.axis()
    , y1Axis = nv.models.axis()
    , y2Axis = nv.models.axis()
    , legend = nv.models.legend()
    ;

  var margin = {top: 30, right: 60, bottom: 50, left: 60}
    , width = null
    , height = null
    , getX = function(d) { return d.x }
    , getY = function(d) { return d.y }
    , color = nv.utils.defaultColor()
    , showLegend = true
    , tooltips = true
    , tooltip = function(key, x, y, e, graph) {
        return '<h3>' + key + '</h3>' +
               '<p>' +  y + ' at ' + x + '</p>';
      }
    , x
    , y1
    , y2
    , state = {}
    , defaultState = null
    , noData = "No Data Available."
    , dispatch = d3.dispatch('tooltipShow', 'tooltipHide', 'stateChange', 'changeState')
    ;

  bars
    .padData(true)
    ;
  lines
    .clipEdge(false)
    .padData(true)
    ;
  xAxis
    .orient('bottom')
    .tickPadding(7)
    .highlightZero(false)
    ;
  y1Axis
    .orient('left')
    ;
  y2Axis
    .orient('right')
    ;

  //============================================================


  //============================================================
  // Private Variables
  //------------------------------------------------------------

  var showTooltip = function(e, offsetElement) {
      var left = e.pos[0] + ( offsetElement.offsetLeft || 0 ),
          top = e.pos[1] + ( offsetElement.offsetTop || 0),
          x = xAxis.tickFormat()(lines.x()(e.point, e.pointIndex)),
          y = (e.series.bar ? y1Axis : y2Axis).tickFormat()(lines.y()(e.point, e.pointIndex)),
          content = tooltip(e.series.key, x, y, e, chart);

      nv.tooltip.show([left, top], content, e.value < 0 ? 'n' : 's', null, offsetElement);
    }
    ;

  //------------------------------------------------------------



  function chart(selection) {
    selection.each(function(data) {
      var container = d3.select(this),
          that = this;

      var availableWidth = (width  || parseInt(container.style('width')) || <?php echo SCREENWIDTH;?>)
                             - margin.left - margin.right,
          availableHeight = (height || parseInt(container.style('height')) || <?php echo SCREENWIDTH;?>)
                             - margin.top - margin.bottom;

      chart.update = function() { chart(selection) };
      chart.container = this;

      //set state.disabled
      state.disabled = data.map(function(d) { return !!d.disabled });

      if (!defaultState) {
        var key;
        defaultState = {};
        for (key in state) {
          if (state[key] instanceof Array)
            defaultState[key] = state[key].slice(0);
          else
            defaultState[key] = state[key];
        }
      }

      //------------------------------------------------------------
      // Display No Data message if there's nothing to show.

      if (!data || !data.length || !data.filter(function(d) { return d.values.length }).length) {
        var noDataText = container.selectAll('.nv-noData').data([noData]);

        noDataText.enter().append('text')
          .attr('class', 'nvd3 nv-noData')
          .attr('dy', '-.7em')
          .style('text-anchor', 'middle');

        noDataText
          .attr('x', margin.left + availableWidth / 2)
          .attr('y', margin.top + availableHeight / 2)
          .text(function(d) { return d });

        return chart;
      } else {
        container.selectAll('.nv-noData').remove();
      }

      //------------------------------------------------------------


      //------------------------------------------------------------
      // Setup Scales

      var dataBars = data.filter(function(d) { return !d.disabled && d.bar });
      var dataLines = data.filter(function(d) { return !d.bar }); // removed the !d.disabled clause here to fix Issue #240

      //x = xAxis.scale();
       x = dataLines.filter(function(d) { return !d.disabled; }).length && dataLines.filter(function(d) { return !d.disabled; })[0].values.length ? lines.xScale() : bars.xScale();
      //x = dataLines.filter(function(d) { return !d.disabled; }).length ? lines.xScale() : bars.xScale(); //old code before change above
      y1 = bars.yScale();
      y2 = lines.yScale();

      //------------------------------------------------------------

      //------------------------------------------------------------
      // Setup containers and skeleton of chart

      var wrap = d3.select(this).selectAll('g.nv-wrap.nv-linePlusBar').data([data]);
      var gEnter = wrap.enter().append('g').attr('class', 'nvd3 nv-wrap nv-linePlusBar').append('g');
      var g = wrap.select('g');

      gEnter.append('g').attr('class', 'nv-x nv-axis');
      gEnter.append('g').attr('class', 'nv-y1 nv-axis');
      gEnter.append('g').attr('class', 'nv-y2 nv-axis');
      gEnter.append('g').attr('class', 'nv-barsWrap');
      gEnter.append('g').attr('class', 'nv-linesWrap');
      gEnter.append('g').attr('class', 'nv-legendWrap');

      //------------------------------------------------------------


      //------------------------------------------------------------
      // Legend

      if (showLegend) {
        legend.width( availableWidth / 2 );

        g.select('.nv-legendWrap')
            .datum(data.map(function(series) {
              series.originalKey = series.originalKey === undefined ? series.key : series.originalKey;
              series.key = series.originalKey + (series.bar ? ' (left axis)' : ' (right axis)');
              return series;
            }))
          .call(legend);

        if ( margin.top != legend.height()) {
          margin.top = legend.height();
          availableHeight = (height || parseInt(container.style('height')) || 400)
                             - margin.top - margin.bottom;
        }

        g.select('.nv-legendWrap')
            .attr('transform', 'translate(' + ( availableWidth / 2 ) + ',' + (-margin.top) +')');
      }

      //------------------------------------------------------------


      wrap.attr('transform', 'translate(' + margin.left + ',' + margin.top + ')');


      //------------------------------------------------------------
      // Main Chart Component(s)


      lines
        .width(availableWidth)
        .height(availableHeight)
        .color(data.map(function(d,i) {
          return d.color || color(d, i);
        }).filter(function(d,i) { return !data[i].disabled && !data[i].bar }))

      bars
        .width(availableWidth)
        .height(availableHeight)
        .color(data.map(function(d,i) {
          return d.color || color(d, i);
        }).filter(function(d,i) { return !data[i].disabled && data[i].bar }))



      var barsWrap = g.select('.nv-barsWrap')
          .datum(dataBars.length ? dataBars : [{values:[]}])

      var linesWrap = g.select('.nv-linesWrap')
          .datum(dataLines[0] && !dataLines[0].disabled ? dataLines : [{values:[]}] );
          //.datum(!dataLines[0].disabled ? dataLines : [{values:dataLines[0].values.map(function(d) { return [d[0], null] }) }] );

      d3.transition(barsWrap).call(bars);
      d3.transition(linesWrap).call(lines);

      //------------------------------------------------------------


      //------------------------------------------------------------
      // Setup Axes

      xAxis
        .scale(x)
        .ticks( availableWidth / 100 )
        .tickSize(-availableHeight, 0);

      g.select('.nv-x.nv-axis')
          .attr('transform', 'translate(0,' + y1.range()[0] + ')');
      d3.transition(g.select('.nv-x.nv-axis'))
          .call(xAxis);


      y1Axis
        .scale(y1)
        .ticks( availableHeight / 36 )
        .tickSize(-availableWidth, 0);

      d3.transition(g.select('.nv-y1.nv-axis'))
          .style('opacity', dataBars.length ? 1 : 0)
          .call(y1Axis);


      y2Axis
        .scale(y2)
        .ticks( availableHeight / 36 )
        .tickSize(dataBars.length ? 0 : -availableWidth, 0); // Show the y2 rules only if y1 has none

      g.select('.nv-y2.nv-axis')
          .style('opacity', dataLines.length ? 1 : 0)
          .attr('transform', 'translate(' + availableWidth + ',0)');
          //.attr('transform', 'translate(' + x.range()[1] + ',0)');

      d3.transition(g.select('.nv-y2.nv-axis'))
          .call(y2Axis);

      //------------------------------------------------------------


      //============================================================
      // Event Handling/Dispatching (in chart's scope)
      //------------------------------------------------------------

      legend.dispatch.on('legendClick', function(d,i) { 
        d.disabled = !d.disabled;

        if (!data.filter(function(d) { return !d.disabled }).length) {
          data.map(function(d) {
            d.disabled = false;
            wrap.selectAll('.nv-series').classed('disabled', false);
            return d;
          });
        }

        state.disabled = data.map(function(d) { return !!d.disabled });
        dispatch.stateChange(state);

        selection.transition().call(chart);
      });

      dispatch.on('tooltipShow', function(e) {
        if (tooltips) showTooltip(e, that.parentNode);
      });


      // Update chart from a state object passed to event handler
      dispatch.on('changeState', function(e) {

        if (typeof e.disabled !== 'undefined') {
          data.forEach(function(series,i) {
            series.disabled = e.disabled[i];
          });

          state.disabled = e.disabled;
        }

        selection.call(chart);
      });

      //============================================================


    });

    return chart;
  }


  //============================================================
  // Event Handling/Dispatching (out of chart's scope)
  //------------------------------------------------------------

  lines.dispatch.on('elementMouseover.tooltip', function(e) {
    e.pos = [e.pos[0] +  margin.left, e.pos[1] + margin.top];
    dispatch.tooltipShow(e);
  });

  lines.dispatch.on('elementMouseout.tooltip', function(e) {
    dispatch.tooltipHide(e);
  });

  bars.dispatch.on('elementMouseover.tooltip', function(e) {
    e.pos = [e.pos[0] +  margin.left, e.pos[1] + margin.top];
    dispatch.tooltipShow(e);
  });

  bars.dispatch.on('elementMouseout.tooltip', function(e) {
    dispatch.tooltipHide(e);
  });

  dispatch.on('tooltipHide', function() {
    if (tooltips) nv.tooltip.cleanup();
  });

  //============================================================


  //============================================================
  // Expose Public Variables
  //------------------------------------------------------------

  // expose chart's sub-components
  chart.dispatch = dispatch;
  chart.legend = legend;
  chart.lines = lines;
  chart.bars = bars;
  chart.xAxis = xAxis;
  chart.y1Axis = y1Axis;
  chart.y2Axis = y2Axis;

  d3.rebind(chart, lines, 'defined', 'size', 'clipVoronoi', 'interpolate');
  //TODO: consider rebinding x, y and some other stuff, and simply do soemthign lile bars.x(lines.x()), etc.
  //d3.rebind(chart, lines, 'x', 'y', 'size', 'xDomain', 'yDomain', 'forceX', 'forceY', 'interactive', 'clipEdge', 'clipVoronoi', 'id');

  chart.x = function(_) {
    if (!arguments.length) return getX;
    getX = _;
    lines.x(_);
    bars.x(_);
    return chart;
  };

  chart.y = function(_) {
    if (!arguments.length) return getY;
    getY = _;
    lines.y(_);
    bars.y(_);
    return chart;
  };

  chart.margin = function(_) {
    if (!arguments.length) return margin;
    margin.top    = typeof _.top    != 'undefined' ? _.top    : margin.top;
    margin.right  = typeof _.right  != 'undefined' ? _.right  : margin.right;
    margin.bottom = typeof _.bottom != 'undefined' ? _.bottom : margin.bottom;
    margin.left   = typeof _.left   != 'undefined' ? _.left   : margin.left;
    return chart;
  };

  chart.width = function(_) {
    if (!arguments.length) return width;
    width = _;
    return chart;
  };

  chart.height = function(_) {
    if (!arguments.length) return height;
    height = _;
    return chart;
  };

  chart.color = function(_) {
    if (!arguments.length) return color;
    color = nv.utils.getColor(_);
    legend.color(color);
    return chart;
  };

  chart.showLegend = function(_) {
    if (!arguments.length) return showLegend;
    showLegend = _;
    return chart;
  };

  chart.tooltips = function(_) {
    if (!arguments.length) return tooltips;
    tooltips = _;
    return chart;
  };

  chart.tooltipContent = function(_) {
    if (!arguments.length) return tooltip;
    tooltip = _;
    return chart;
  };

  chart.state = function(_) {
    if (!arguments.length) return state;
    state = _;
    return chart;
  };

  chart.defaultState = function(_) {
    if (!arguments.length) return defaultState;
    defaultState = _;
    return chart;
  };

  chart.noData = function(_) {
    if (!arguments.length) return noData;
    noData = _;
    return chart;
  };

  //============================================================


  return chart;
}



function getOptions(action,date)
{
    $.getJSON("ajax.php?module=reports",{report:action, date:date},display);
}

function AttributeExists(obj, val)
{
    for(var i=0;i < obj.length; i++) {
        if (obj[i]['Attribute'] == val) {
            return true;
        }
    }
    return false;
}

function getWodsByMonthGraph()
{
d3.select("svg").remove();
var margin = {top: 20, right: 20, bottom: 30, left: 40},
    width = <?php echo SCREENWIDTH;?> - margin.left - margin.right,
    height = <?php echo SCREENWIDTH;?> - margin.top - margin.bottom;

var formatPercent = d3.format(".0%");

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")

var svg = d3.select("#graph").append("svg:svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json("ajax.php?module=reports&Graph=Wods", function(error, data) {
  
data.forEach(function(d) {
   d.NumberCompleted = +d.NumberCompleted;
  });

  x.domain(data.map(function(d) { return d.Month; }));
  y.domain([0, d3.max(data, function(d) { return d.NumberCompleted; })]);

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis);

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
      .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")

  svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.Month); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.NumberCompleted); })
      .attr("height", function(d) { return height - y(d.NumberCompleted); })
.text(function(d) { return d; });
});  

}

function getBenchmarkReport(id)
{
    $('#back').html('<img alt="Back" onclick="getReport(\'Benchmarks\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

    $.ajax({url:'ajax.php?module=reports',data:{BenchmarkId:id},dataType:"json",success:function(json) { 
       //Storage for XML data document
       var strXML = '';
       var first = true;
       //Add <set> elements
        $.each(json, function() {
            if(first)
            strXML += '<chart caption="' + this.WorkoutName + '" showLabels="0" showYAxisValues="0" animation="0" lineColor="00008B" xAxisNamePadding="0" xAxisName="Time" yAxisName="Output" showValues="1">';
            if(this.Attribute == 'TimeToComplete'){
                var str = this.AttributeValue;
                var ExplodedTime = str.split(":");
                var Seconds = (ExplodedTime[0] * 60) + ExplodedTime[1];
                strXML += '<set label="' + this.TimeCreated + '" value="' + Seconds + '"/>';
            }
            first = false;
        });
        //Closing Chart Element
        strXML += '</chart>';
      
        var chartObj = new FusionCharts( "includes/FusionCharts/Line.swf","BenchmarkChartId", "300", "250", "0", "1" );

        chartObj.setXMLData(strXML);

        chartObj.render("graph");
    }});
}

function getWodDetail(timestamp)
{
    $.ajax({url:'ajax.php?module=reports',data:{TimeStamp:timestamp},dataType:"html",success:WodDetailDisplay}); 
}

function WodDetailDisplay(data)
{
    $('#WodDetail').html(data);
    $('#toplist').listview();
    $('#toplist').listview('refresh');
    window.location.hash = '#WodDetail';
}

function getActivitiesGraph()
{
d3.select("svg").remove();
var margin = {top: 20, right: 20, bottom: 100, left: 40},
    width = <?php echo SCREENWIDTH;?> - margin.left - margin.right,
    height = <?php echo SCREENWIDTH;?> - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")

var svg = d3.select("#graph").append("svg:svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json("ajax.php?module=reports&Graph=Activities", function(error, data) {
  
data.forEach(function(d) {
   d.NumberCompleted = +d.NumberCompleted;
  });

  x.domain(data.map(function(d) { return d.Exercise; }));
  y.domain([0, d3.max(data, function(d) { return d.NumberCompleted; })]);

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
      .selectAll("text")  
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", function(d) {
                return "rotate(-65)" 
                });

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
      .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")

  svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.Exercise); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.NumberCompleted); })
      .attr("height", function(d) { return height - y(d.NumberCompleted); })
.text(function(d) { return d; });
});       
}

function getActivityGraph(id)
{
d3.select("svg").remove();
var margin = {top: 20, right: 20, bottom: 100, left: 40},
    width = <?php echo SCREENWIDTH;?> - margin.left - margin.right,
    height = <?php echo SCREENWIDTH;?> - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");

var line = d3.svg.line()
    .x(function(d) { return x(d.TimeCreated); })
    .y(function(d) { return y(d.AttributeValue); });    

var svg = d3.select("#graph").append("svg:svg")
    .attr("id", "amazingViz")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
    .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json("ajax.php?module=reports&ExerciseId="+id+"", function(error, data) {
  
data.forEach(function(d) {
    
  x.domain(data.map(function(d) { if(d.Attribute == 'Reps'){return d.TimeCreated;} }));
  y.domain([0, d3.max(data, function(d) { if(d.Attribute == 'Reps'){return d.AttributeValue;} })]);

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
      .selectAll("text")  
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", function(d) {
                return "rotate(-65)" 
                });

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
      .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")


  svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { if(d.Attribute == 'Reps'){return x(d.TimeCreated);} })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { if(d.Attribute == 'Reps'){return y(d.AttributeValue);} })
      .attr("height", function(d) { if(d.Attribute == 'Reps'){return height - y(d.AttributeValue);} })
.text(function(d) { return d; });

});
});
}

function getActivityBarLineGraph(id)
{
    d3.select("svg").remove();

d3.json("ajax.php?module=reports&ActivityId="+id+"", function(error, data) {
    var RepsValues = new Array();
    var HeightValues = new Array();
    var WeightValues = new Array();
    var DistanceValues = new Array();
    var HeightUOM;
    var WeightUOM;
    var DistanceUOM;
    data.forEach(function(d) {
    if(d.Attribute == 'Reps'){
        RepsValues.push(new Array(d.TimeCreated , d.AttributeValue));
    }
    else if(d.Attribute == 'Height'){
        HeightValues.push(new Array(d.TimeCreated , d.AttributeValue));
        HeightUOM = d.UnitOfMeasure;
    }
    else if(d.Attribute == 'Weight'){
        WeightValues.push(new Array(d.TimeCreated , d.AttributeValue));
        WeightUOM = d.UnitOfMeasure;
    }
    else if(d.Attribute == 'Distance'){
        DistanceValues.push(new Array(d.TimeCreated , d.AttributeValue));
        DistanceUOM = d.UnitOfMeasure;
    }
  });
    
if(WeightValues.length > 0){
var testdata = [
  {"key" : "Reps" ,"bar": true,"values" : RepsValues},
  {"key" : "Weight ("+WeightUOM+")" ,"values" : WeightValues}
].map(function(series) {
  series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
  return series;
});
}
else if(HeightValues.length > 0){
var testdata = [
  {"key" : "Reps" ,"bar": true,"values" : RepsValues},
  {"key" : "Height ("+HeightUOM+")" ,"values" : HeightValues}
].map(function(series) {
  series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
  return series;
});
}
else if(DistanceValues.length > 0){
var testdata = [
  {"key" : "Reps" ,"bar": true,"values" : RepsValues},
  {"key" : "Distance ("+DistanceUOM+")" ,"values" : DistanceValues}
].map(function(series) {
  series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
  return series;
});
}
else{
var testdata = [
  {"key" : "Reps" ,"bar": true,"values" : RepsValues}
].map(function(series) {
  series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
  return series;
});
}
/*
//For testing single data point
var testdata = [
  {
    "key" : "Quantity" ,
    "bar": true,
    "values" : [ [ 1136005200000 , 1271000.0] ]
  } ,
  {
    "key" : "Price" ,
    "values" : [ [ 1136005200000 , 71.89] ]
  }
].map(function(series) {
  series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
  return series;
});
*/

var chart;

nv.addGraph(function() {
    chart = nv.models.linePlusBarChart()
        
        .x(function(d,i) { return i })
        .color(d3.scale.category10().range());

    chart.xAxis.tickFormat(function(d) {
      var dx = testdata[0].values[d] && testdata[0].values[d].x || 0;
      return dx;
    });

    chart.y1Axis
        .tickFormat(function(d) { return d });

    chart.y2Axis
        .tickFormat(function(d) { return d });

    chart.bars.forceY([0]);
    //chart.lines.forceY([0]);


    d3.select("#graph").append("svg:svg")
      .datum(testdata)
      .transition().duration(500).call(chart);

    nv.utils.windowResize(chart.update);

    chart.dispatch.on('stateChange', function(e) { nv.log('New State:', JSON.stringify(e)); });

    return chart;
});
});
}

function getBaselineReport()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

    var chartObj = new FusionCharts( "includes/FusionCharts/Line.swf","FirstChartId", "300", "250", "0", "1" );

    chartObj.setXMLData('<?php echo $Display->BaselineChart();?>');

    chartObj.render("graph");
}

function getDummyLineGraph()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

    var chartObj = new FusionCharts( "includes/FusionCharts/MSLine.swf","FirstChartId", "300", "250", "0", "1" );

    chartObj.setXMLData('<?php echo $Display->DummyLineGraph();?>');

    chartObj.render("AjaxOutput");
}

function getDummyColumnGraph()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

    var chartObj = new FusionCharts( "includes/FusionCharts/Column2D.swf","FirstChartId", "300", "250", "0", "1" );

    chartObj.setXMLData('<?php echo $Display->DummyColumnGraph();?>');

    chartObj.render("AjaxOutput");
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('#listview').listview();
    $('#listview').listview('refresh');
}

function getReport(val)
{
   $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
   $.ajax({url:'ajax.php?module=reports',data:{report:val},dataType:"html",success:display}); 
}

function getCompletedWODs()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    $.ajax({url:'ajax.php?module=reports',data:{report:'wods'},dataType:"html",success:display}); 
    getWodsByMonthGraph();
}

function getCompletedActivities()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');    
    $.ajax({url:'ajax.php?module=reports',data:{report:'activities'},dataType:"html",success:display});
    getActivitiesGraph();
}

function getTimeSpent()
{
    d3.select("svg").remove();
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

var width = <?php echo SCREENWIDTH;?>,
    height = <?php echo SCREENWIDTH;?>,
    radius = (Math.min(width, height) / 2) - 20;

var color = d3.scale.ordinal()
    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

var arc = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.Seconds; });

var svg = d3.select("#graph").append("svg")
    .attr("width", width)
    .attr("height", height)
  .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");
  d3.json("ajax.php?module=reports&report=time", function(error, data) {
data.forEach(function(d) {
    d.Seconds = +d.Seconds;
  });

  var g = svg.selectAll(".arc")
      .data(pie(data))
    .enter().append("g")
      .attr("class", "arc");

  g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return color(d.data.Exercise); });

  g.append("text")
      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .style("text-anchor", "middle")
      .text(function(d) { return d.data.Exercise; }); 
  });
}

function getWeightLifted()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    $.ajax({url:'ajax.php?module=reports',data:{report:'weight'},dataType:"html",success:display}); 
}

function getDistanceCovered()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    $.ajax({url:'ajax.php?module=reports',data:{report:'distance'},dataType:"html",success:display}); 
}

function getCaloriesBurned()
{
    
}

function getStrength()
{
    
}

function getWOD(typeid)
{
    d3.select("svg").remove();
    $('#back').html('<img alt="Back" onclick="getCompletedWODs();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    $.ajax({url:'ajax.php?module=reports',data:{report:'WOD', typeid:typeid},dataType:"html",success:display});    
}

function getActivity(id, source)
{
    d3.select("svg").remove();
    if(source == 'activities'){
        $('#back').html('<img alt="Back" onclick="getCompletedActivities();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    }else if(source == 'weights'){
        $('#back').html('<img alt="Back" onclick="getWeightLifted();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    }else if(source == 'distances'){
        $('#back').html('<img alt="Back" onclick="getDistanceCovered();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    }
    
    $.ajax({url:'ajax.php?module=reports',data:{report:'Activity', id:id},dataType:"html",success:display}); 
    getActivityBarLineGraph(id);
}
var i = 1;//prevent double rendering problem
</script>
<div id="graph"></div>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>
