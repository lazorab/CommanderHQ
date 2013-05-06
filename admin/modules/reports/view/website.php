<style>
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

#graph svg {
  height: 600px;
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

<script type="text/javascript">

function getMembers()
{
    $.ajax({url:'ajax.php?module=reports',data:{report:'Members'},dataType:"html",success:display});
}

function getMember(id)
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{AthleteId:id},dataType:"html",success:display});
}

function getWods()
{
    getWodsByMonthGraph();
    $.ajax({url:'ajax.php?module=reports',data:{report:'Wods'},dataType:"html",success:display});
}

function getWod(id)
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{WodId:id},dataType:"html",success:display});
}

function getActivities()
{
    getActivitiesGraph();
    $.ajax({url:'ajax.php?module=reports',data:{report:'Activities'},dataType:"html",success:display});
}

function getActivity(id)
{
    $.ajax({url:'ajax.php?module=reports&action=formsubmit',data:{ActivityId:id},dataType:"html",success:display});
}

function display(data)
{
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('#AjaxOutput').html(data);
}

function go(url)
{
    window.location = url;
}

function getActivitiesGraph()
{
d3.select("svg").remove();
var margin = {top: 20, right: 20, bottom: 100, left: 40},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

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

function getWodsByMonthGraph()
{
d3.select("svg").remove();
var margin = {top: 20, right: 20, bottom: 30, left: 40},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

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

</script>
<br/>
<div id="graph"></div>
<div id="AjaxOutput">
<?php echo $Display->Output();?>
</div>