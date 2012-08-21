<?php $ChartData = "<chart showLabels='0' showYAxisValues='0' animation='0' lineColor='00008B' xAxisNamePadding='0' caption='Performance' xAxisName='Time' yAxisName='Output' showValues= '0'>";

  $ChartData .= "<set label='Jan' value='420'/>";
   $ChartData .= "<set label='Feb' value='910'/>";
   $ChartData .= "<set label='Mar' value='720'/>";
   $ChartData .= "<set label='Apr' value='550'/>";
   $ChartData .= "<set label='May' value='810'/>";
   $ChartData .= "<set label='Jun' value='510'/>";

   $ChartData .= "<trendLines>";
      $ChartData .= "<line startValue='700' color='009933' lineThickness='3' displayvalue='Average' />";
   $ChartData .= "</trendLines>";

$ChartData .= "</chart>";
	         ?>
			 
<script type='text/javascript' src='includes/FusionCharts/FusionCharts.js'></script>	
<script type="text/javascript">
            $(function(){
                $('#slides').slides({
                    preload: true,
                    preloadImage: 'images/ajax-loader.gif',
					pagination: false,
					generatePagination: false,
					slideSpeed: 500,
					effect: 'slide'
                });
            });

function getOptions(action,date)
{
    $.getJSON("ajax.php?module=reports",{report:action, date:date},display);
}

function getWODReport(id,date)
{
    $.getJSON("ajax.php?module=reports",{WODId:id, date:date},display);
}

function getBenchmarkReport(id,date)
{
    $.getJSON("ajax.php?module=reports",{BenchmarkId:id, date:date},display);
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
                    "FirstChartId", "250", "280", "0", "1" );

      myChart.setXMLData('<?php echo $ChartData;?>');

      myChart.render("FirstChartContainer");
	  }
	  
</script>                                                        
                                                    </div>
                                                    <div class="slide">                                                     
 <div id="SecondChartContainer">FusionCharts will load here!</div>   
 <script type="text/javascript">
if(i == 2){
i++;
  	var myChart = new FusionCharts( "includes/FusionCharts/Line.swf", 
                    "SecondChartId", "250", "280", "0", "1" );

      myChart.setXMLData('<?php echo $Display->BaselineOutput();?>');

      myChart.render("SecondChartContainer");
	  }
	  
</script>
                                                        
                                                    </div>
                                                    <div class="slide">
                                                        <?php echo $Display->SkillsOutput();?>
                                                    </div>
													<div class="slide">
                                              <?php echo $Display->WODOutput();?>       
                                                    </div>
                                                </div>
                                                <a href="#" class="prev"><img src="images/arrow-next.png" width="24" height="43" alt="Arrow Prev"></a>
                                                <a href="#" class="next"><img src="images/arrow-prev.png" width="24" height="43" alt="Arrow Next"></a>
                                            </div>

</div>
