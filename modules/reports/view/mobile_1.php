<script type='text/javascript' src='/includes/FusionCharts/FusionCharts.js'></script>	
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

        chartObj.render("AjaxOutput");
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

        chartObj.render("AjaxOutput");
    }});
}

function getExerciseReport(id)
{
    $('#back').html('<img alt="Back" onclick="getReport(\'Exercises\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

    $.ajax({url:'ajax.php?module=reports',data:{ExerciseId:id},dataType:"json",success:function(json) { 
       //Storage for XML data document
       var Attribute = '';
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
            Attribute = this.Attribute;
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
      
        var chartObj = new FusionCharts( "includes/FusionCharts/MSLine.swf","ExerciseChartId", "300", "250", "0", "1" );

        chartObj.setXMLData(strXML);

        chartObj.render("AjaxOutput");
    }});
}

function getBaselineReport()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

    var chartObj = new FusionCharts( "includes/FusionCharts/Line.swf","FirstChartId", "300", "250", "0", "1" );

    chartObj.setXMLData('<?php echo $Display->BaselineChart();?>');

    chartObj.render("AjaxOutput");
}

function getDummyReport()
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=reports\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 

    var chartObj = new FusionCharts( "includes/FusionCharts/MSLine.swf","FirstChartId", "300", "250", "0", "1" );

    chartObj.setXMLData('<?php echo $Display->DummyData();?>');

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

var i = 1;//prevent double rendering problem
</script>

<br/>
<div id="topselection">

</div>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>
