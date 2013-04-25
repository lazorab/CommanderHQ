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

function getWODReport(id,type)
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

function getWodsByMonthGraph()
{
    $.ajax({url:'ajax.php?module=reports',data:{Graph:'Wods'},dataType:"json",success:function(json) {
        var strXML = '<chart caption="Completed WODs" xAxisName="Month" yAxisName="# of WODs" showValues="0">';
        $.each(json, function() { 
           strXML += '<set label="' + this.Month + '" value="' + this.NumberCompleted + '"/>';
        }); 
        strXML += '</chart>';

        //$("#graph").insertFusionCharts({swfUrl: "includes/FusionCharts/Column2D.swf", dataSource: strXML, dataFormat: "xml", width: "<?php echo SCREENWIDTH - 25;?>", height: "<?php echo SCREENWIDTH - 75;?>", id: "WodChartId"});

        var chartObj = new FusionCharts( "includes/FusionCharts/Column2D.swf","WodChartId", "<?php echo SCREENWIDTH - 25;?>", "<?php echo SCREENWIDTH - 75;?>", "0", "1" );

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
    $.ajax({url:'ajax.php?module=reports',data:{Graph:'Activities'},dataType:"json",success:function(json) {
        var strXML = '<chart caption="Completed Activities" xAxisName="Activity" yAxisName="#" showValues="0">';
        $.each(json, function() { 
           strXML += '<set label="' + this.Exercise + '" value="' + this.NumberCompleted + '"/>';
        }); 
        strXML += '</chart>';

        var chartObj = new FusionCharts( "includes/FusionCharts/Column2D.swf","ActivityChartId", "<?php echo SCREENWIDTH - 25;?>", "<?php echo SCREENWIDTH - 75;?>", "0", "1" );

        chartObj.setXMLData(strXML);

        chartObj.render("graph");    
    }});        
}

function getActivityGraph(id)
{
    $.ajax({url:'ajax.php?module=reports',data:{ExerciseId:id},dataType:"json",success:function(json) { 
       //Storage for XML data document
       var strXML = '';
       var RepsData = '';
       var WeightData = '';
       var HeightData = '';
       var DistanceData = '';
       var Categories='<categories>';
       var first = true;
       //Add <set> elements
        $.each(json, function() {
            if(first)
            strXML += '<chart caption="' + this.Exercise + '" showLabels="0" canvasPadding="10" showYAxisValues="0" animation="0" lineColor="00008B" xAxisNamePadding="0" yAxisNamePadding="0" xAxisName="Time" yAxisName="Output" showToolTip="0" showValues="1">';

                if(this.Attribute == 'Reps'){
                    if(RepsData == ''){
                        Categories+='<category Label="'+this.Attribute+'"/>';
                        RepsData += '<dataset seriesName="'+this.Attribute+'" Color="00008B">';
                    }
                    RepsData += '<set  value="' + this.AttributeValue + '"/>';
                }   
                if(this.Attribute == 'Weight'){
                    if(WeightData == ''){
                        Categories+='<category Label="'+this.Attribute+'"/>';
                        WeightData += '<dataset seriesName="'+this.Attribute+'('+this.UnitOfMeasure+')" Color="FF008B">';
                    }
                    WeightData += '<set  value="' + this.AttributeValue + '"/>';
                }
                 if(this.Attribute == 'Height'){
                    if(HeightData == ''){
                        Categories+='<category Label="'+this.Attribute+'"/>';
                        HeightData += '<dataset seriesName="'+this.Attribute+'('+this.UnitOfMeasure+')" Color="FF008B">';
                    }
                    HeightData += '<set  value="' + this.AttributeValue + '"/>';
                }
                if(this.Attribute == 'Distance'){
                    if(DistanceData == ''){
                        Categories+='<category Label="'+this.Attribute+'"/>';
                        DistanceData += '<dataset seriesName="'+this.Attribute+'('+this.UnitOfMeasure+')" Color="00008B">';
                    }
                    DistanceData += '<set  value="' + this.AttributeValue + '"/>';
                }               
            first = false;
        });
        //Closing Chart Element
        if(RepsData != '')
            RepsData += '</dataset>';
        if(WeightData != '')
            WeightData += '</dataset>';
        if(HeightData != '')
            HeightData += '</dataset>';
        if(DistanceData != '')
            DistanceData += '</dataset>';            
        strXML += ''+Categories+'</categories>'+RepsData+''+WeightData+''+HeightData+''+DistanceData+'</chart>';
      
        var chartObj = new FusionCharts( "includes/FusionCharts/MSLine.swf","ExerciseChartId", "<?php echo SCREENWIDTH - 25;?>", "<?php echo SCREENWIDTH - 75;?>", "0", "1" );

        chartObj.setXMLData(strXML);

        chartObj.render("graph");
    }});
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
    //getWodsByMonthGraph();
}

function getCompletedActivities()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');    
    $.ajax({url:'ajax.php?module=reports',data:{report:'activities'},dataType:"html",success:display});
    //getActivitiesGraph();
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


<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>
