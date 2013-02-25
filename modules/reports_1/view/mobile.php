<script type='text/javascript' src='/includes/FusionCharts/FusionCharts.js'></script>	
<link rel="stylesheet" href="/css/slideshow.css">
<script type="text/javascript" src="/js/slides.min.jquery.js"></script>
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

function AttributeExists(obj, val)
{
    for(var i=0;i < obj.length; i++) {
        if (obj[i]['Attribute'] == val) {
            return true;
        }
    }
    return false;
}

function getWODReport(id)
{
    $.ajax({url:'ajax.php?module=reports',data:{WODId:id,encode:'json'},dataType:"json",success:function(json) { 
       //Storage for XML data document
       var strXML = '';
       var data1XML = '';
       var data2XML = '';
       var catXML = '<categories>';
       var first = true;
       //Add <set> elements
        $.each(json, function() {
            if(first)
                strXML += '<chart caption="' + this.Exercise + '" showLabels="0" animation="0" lineColor="00008B" canvasPadding="10" xAxisNamePadding="0" yAxisNamePadding="10" xAxisName="Time" yAxisName="Output" showToolTip="0" showValues="0">';
 
            if(AttributeExists(json, 'Weight') && AttributeExists(json, 'Reps')){
                if(this.Attribute == 'Weight'){
                    if(data1XML == ''){
                        catXML += '<category Label="' + this.Attribute + '"/>';
                        data1XML += '<dataset seriesName="' + this.Attribute + '">';
                    }
                    data1XML += '<set value="' + this.AttributeValue + '"/>';
                }

                if(this.Attribute == 'Reps'){
                    if(data2XML == ''){
                        catXML += '<category Label="' + this.Attribute + '"/>';
                        data2XML += '<dataset seriesName="' + this.Attribute + '">';
                    }   
                    data2XML += '<set value="' + this.AttributeValue + '"/>';
                }    
            }else if(AttributeExists(json, 'Weight')){
                if(this.Attribute == 'Weight'){
                    strXML += '<set label="' + this.Attribute + '" value="' + this.AttributeValue + '"/>';
                }
            }else if(AttributeExists(json, 'Reps')){
                if(this.Attribute == 'Reps'){
                    strXML += '<set label="' + this.Attribute + '" value="' + this.AttributeValue + '"/>';
                }
            }
            else
                strXML += '<set label="' + this.Attribute + '" value="' + this.AttributeValue + '"/>';
            first = false;
        });
         
        if(data1XML != ''){
            strXML += ''+catXML+'</categories>'+data1XML+'</dataset>'+data2XML+'</dataset>'+'</chart>';
            var chartObj = new FusionCharts( "includes/FusionCharts/MSLine.swf",
                    "ExerciseChartId", "300", "200", "0", "1" );
            chartObj.setXMLData(strXML);
            chartObj.render("ExerciseDetails");          
        }else{
            strXML += '</chart>';
             var chartObj = new FusionCharts( "includes/FusionCharts/Line.swf",
                    "ExerciseChartId", "300", "200", "0", "1" );
            chartObj.setXMLData(strXML);
            chartObj.render("ExerciseDetails");           
        }
    }});
}

function getBenchmarkReport(id)
{
    $.ajax({url:'ajax.php?module=reports',data:{BenchmarkId:id,encode:'json'},dataType:"json",success:function(json) { 
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
    }});
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
<div id="ExerciseDetails">Chart will load here once selection is made</div>
</div>
<div class="slide">
<?php echo $Display->WODBenchmarks();?>
<div id="BenchmarkDetails">Chart will load here once selection is made</div>
</div>
</div>
<a href="#" class="prev"><img src="<?php echo IMAGE_RENDER_PATH;?>/arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>
<a href="#" class="next"><img src="<?php echo IMAGE_RENDER_PATH;?>/arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>
</div>
</div>