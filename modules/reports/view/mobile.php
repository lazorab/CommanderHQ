<style>
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
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

</style>
<script src="http://d3js.org/d3.v3.min.js"></script>	
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

function _getWODReport(id,type)
{
    $('#back').html('<img alt="Back" onclick="getReport(\'WOD\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

    $.ajax({url:'ajax.php?module=reports',data:{WodId:id, WodTypeId:type},dataType:"json",success:function(json) { 
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
      
        var chartObj = new FusionCharts( "includes/FusionCharts/Line.swf","WODChartId", "300", "250", "0", "1" );

        chartObj.setXMLData(strXML);

        chartObj.render("graph");
    }});
}

function getWodsByMonthGraph()
{
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

var svg = d3.select("#graph").append("svg")
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

var svg = d3.select("#graph").append("svg")
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

var svg = d3.select("#graph").append("svg")
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

  

  x.domain(d3.extent(data, function(d) { return d.TimeCreated; }));
  y.domain(d3.extent(data, function(d) { return d.AttributeValue; }));

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
      .text("Price ($)");

  svg.append("path")
      .datum(data)
      .attr("class", "line")
      .attr("d", line);
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

function displayTimeGraph(data)
{
    var chartObj = new FusionCharts( "includes/FusionCharts/Pie2D.swf","FirstChartId", "300", "250", "0", "1" );

    chartObj.setXMLData(''+data+'');

    chartObj.render("graph");
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
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    $.ajax({url:'ajax.php?module=reports',data:{report:'time'},dataType:"html",success:displayTimeGraph}); 
    
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
    $('#back').html('<img alt="Back" onclick="getCompletedWODs();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    $.ajax({url:'ajax.php?module=reports',data:{report:'WOD', typeid:typeid},dataType:"html",success:display});    
}

function getActivity(id, source)
{
    if(source == 'activities'){
        $('#back').html('<img alt="Back" onclick="getCompletedActivities();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    }else if(source == 'weights'){
        $('#back').html('<img alt="Back" onclick="getWeightLifted();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    }else if(source == 'distances'){
        $('#back').html('<img alt="Back" onclick="getDistanceCovered();" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
    }
    $.ajax({url:'ajax.php?module=reports',data:{report:'Activity', id:id},dataType:"html",success:display}); 
    getActivityGraph(id);
}
var i = 1;//prevent double rendering problem
</script>
<div id="graph"></div>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>
