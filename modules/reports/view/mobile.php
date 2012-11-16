<script type='text/javascript' src='includes/FusionCharts/FusionCharts.js'></script>	
<script type="text/javascript">
    $(function(){
        $('#slides').slides({
            preload: true,
            preloadImage: 'images/ajax-loader.gif',
            generatePagination: true,
            slideSpeed: 500,
            effect: 'slide'
        });
    });

function getOptions(action,date)
{
    $.getJSON("ajax.php?module=reports",{report:action, date:date},display);
}

function getWODReport(id)
{
    $.getJSON("ajax.php?module=reports",{WODId:id},function(json) {
       //Storage for XML data document
       var strXML = '';
       var first = true;
       //Add <set> elements
        $.each(json, function() {
            if(first)
            strXML += '<chart caption="' + this.Exercise + '" showLabels="0" showYAxisValues="0" animation="0" lineColor="00008B" xAxisNamePadding="0" xAxisName="Time" yAxisName="Output" showValues="0">';
            if(this.Attribute == 'Reps'){
                strXML += '<set label="' + this.TimeCreated + '" value="' + this.AttributeValue + '"/>';
            }
            first = false;
        });
      //Closing Chart Element
      strXML += '</chart>';
      
        var chartObj = new FusionCharts( "includes/FusionCharts/Line.swf",
                    "ExerciseChartId", "300", "200", "0", "1" );

        chartObj.setXMLData(strXML);

        chartObj.render("ExerciseDetails");
    });
}

function getBenchmarkReport(id)
{
    $.getJSON("ajax.php?module=reports",{BenchmarkId:id},function(json) {
       //Storage for XML data document
       var strXML = '';
       var first = true;
       //Add <set> elements
        $.each(json, function() {
            if(first)
            strXML += '<chart caption="' + this.WorkoutName + '" showLabels="0" showYAxisValues="0" animation="0" lineColor="00008B" xAxisNamePadding="0" xAxisName="Time" yAxisName="Output" showValues="0">';
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
      
        var chartObj = new FusionCharts( "includes/FusionCharts/Line.swf",
                    "BenchmarkChartId", "300", "200", "0", "1" );

        chartObj.setXMLData(strXML);

        chartObj.render("BenchmarkDetails");
    });
}

function getBaselineReport(id,date)
{
    $.getJSON("ajax.php?module=reports",{BaselineId:id, date:date},display);
}

function display(data)
{
document.getElementById("reportdata").innerHTML = data;
}

var i = 1;//prevent double rendering problem
</script>

<br/>
<div id="topselection">

</div>

<div id="reportdata">
    <div id="slides">
        <div class="slides_container">
            <div class="slide">
                <div id="FirstChartContainer">FusionCharts will load here!</div>
<script type="text/javascript">
    if(i == 1){
        i++;
   var myChart = new FusionCharts( "includes/FusionCharts/Line.swf",
                    "FirstChartId", "300", "250", "0", "1" );

        myChart.setXMLData('<?php echo $Display->BaselineOutput();?>');

        myChart.render("FirstChartContainer");
    }
</script>
            </div>
            <div class="slide">
                <?php echo $Display->WODExercises();?>
<div id="ExerciseDetails">FusionCharts will load here!</div>
</div>
<div class="slide">
<?php echo $Display->WODBenchmarks();?>
<div id="BenchmarkDetails">FusionCharts will load here!</div>
</div>
</div>
<a href="#" class="prev"><img src="<?php echo IMAGE_RENDER_PATH;?>/arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>
<a href="#" class="next"><img src="<?php echo IMAGE_RENDER_PATH;?>/arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>
</div>
</div>