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


<script src="nvd3/src/models/linePlusBarChart.js"></script>

<script type="text/javascript">

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
    data.forEach(function(d) {
    if(d.Attribute == 'Reps'){
        RepsValues.push(new Array(d.TimeCreated , d.AttributeValue));
    }
    else if(d.Attribute == 'Height'){
        HeightValues.push(new Array(d.TimeCreated , d.AttributeValue));
    }
    else if(d.Attribute == 'Weight'){
        WeightValues.push(new Array(d.TimeCreated , d.AttributeValue));
    }
    else if(d.Attribute == 'Distance'){
        DistanceValues.push(new Array(d.TimeCreated , d.AttributeValue));
    }
  });
    
if(WeightValues.length > 0){
var testdata = [
  {"key" : "Reps" ,"bar": true,"values" : RepsValues},
  {"key" : "Weight" ,"values" : WeightValues}
].map(function(series) {
  series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
  return series;
});
}
else if(HeightValues.length > 0){
var testdata = [
  {"key" : "Reps" ,"bar": true,"values" : RepsValues},
  {"key" : "Height" ,"values" : HeightValues}
].map(function(series) {
  series.values = series.values.map(function(d) { return {x: d[0], y: d[1] } });
  return series;
});
}
else if(DistanceValues.length > 0){
var testdata = [
  {"key" : "Reps" ,"bar": true,"values" : RepsValues},
  {"key" : "Distance" ,"values" : DistanceValues}
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
        .margin({top: 30, right: 60, bottom: 50, left: 70})
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
