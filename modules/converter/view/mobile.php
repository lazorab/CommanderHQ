<script type="text/javascript">	

function getForm(cat)
{
    $.getJSON("ajax.php?module=converter",{topselection:cat},topselectiondisplay);
}

function getConversionValues(cat)
{
    if(cat == 'weight'){  
        var imperialweight = document.getElementById("metric_weight_input").value * 2.20;
        var metricweight = document.getElementById("imperial_weight_input").value * 0.45; 
        $('#metric_weight').val(metricweight.toFixed(2) + 'kg'); 
        $('#imperial_weight').val(imperialweight.toFixed(2) + 'lbs');
    }else if(cat == 'height'){
        var metricheight = document.getElementById("imperial_height_input").value * 2.54;
        var imperialheight = document.getElementById("metric_height_input").value * 0.39;
        $('#metric_height').val(metricheight.toFixed(2) + 'cm'); 
        $('#imperial_height').val(imperialheight.toFixed(2) + 'in');
    }else if(cat == 'distance'){
        var metricdistance = document.getElementById("imperial_distance_input").value * 0.62;
        var imperialdistance = document.getElementById("metric_distance_input").value * 1.61;
        $('#metric_distance').val(metricdistance.toFixed(2) + 'km'); 
        $('#imperial_distance').val(imperialdistance.toFixed(2) + 'm');    
    }else if(cat == 'volume'){
        var metricvolume = document.getElementById("imperial_volume_input").value * 33.81;
        var imperialvolume = document.getElementById("metric_volume_input").value * 0.03;
        $('#metric_volume').val(metricvolume.toFixed(2) + 'litres'); 
        $('#imperial_volume').val(imperialvolume.toFixed(2) + 'Oz');
    }
}

function getImperialValue(cat,value)
{
    $.getJSON("ajax.php?module=converter",{category:cat,metric:value},display);
}

function topselectiondisplay(data)
{
    $('#topselection').html(data); 
    $('#AjaxOutput').html('');
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('#listview').listview();
    $('#listview').listview('refresh');
    $('#exercise').selectmenu();
    $('#exercise').selectmenu('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();	
}

    $(function(){
        $('#slides').slides({
            preload: true,
            preloadImage: 'images/ajax-loader.gif',
            generatePagination: true,
            slideSpeed: 500,
            effect: 'slide'
        });
    });
</script>


<div id="topselection">

</div> 

<div id="AjaxOutput">
    <div id="slides">
        <div class="slides_container">
            <div class="slide">
                <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
                    <li>Weight Conversion</li>
                </ul> <br/>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="metric_weight_input" name="metric_weight" value="" placeholder="Weight in kg"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="imperial_weight" name="imperial_weight_answer" value="" placeholder="lbs equivalent" readonly="readonly"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="imperial_weight_input" name="imperial_weight" value="" placeholder="Weight in lbs"/>
               </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="metric_weight" name="metric_weight_answer" value="" placeholder="kg equivalent" readonly="readonly"/>
                    </div>
                </div><br/>
                <input class="buttongroup" type="button" name="asubmit" value="Convert" onClick="getConversionValues('weight');"/> 
            </div>
            <div class="slide">
				<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li>Height Conversion</li>
				</ul><br/>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="metric_height_input" name="metric_height" value="" placeholder="Height in cm"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="imperial_height" name="imperial_height_answer" value="" placeholder="inch equivalent" readonly="readonly"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="imperial_height_input" name="imperial_height" value="" placeholder="Height in inches"/>
               </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="metric_height" name="metric_height_answer" value="" placeholder="cm equivalent" readonly="readonly"/>
                    </div>
                </div>	<br/>			
                <input class="buttongroup" type="button" name="bsubmit" value="Convert" onClick="getConversionValues('height');"/>
            </div>
            <div class="slide">
				<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li>Distance Conversion</li>
				</ul><br/>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="metric_distance_input" name="metric_distance" value="" placeholder="Distance in km"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="imperial_distance" name="imperial_distance_answer" value="" placeholder="mile equivalent" readonly="readonly"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="imperial_distance_input" name="imperial_distance" value="" placeholder="Distance in miles"/>
               </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="metric_distance" name="metric_distance_answer" value="" placeholder="km equivalent" readonly="readonly"/>
                    </div>
                </div>	<br/>			
                <input class="buttongroup" type="button" name="csubmit" value="Convert" onClick="getConversionValues('distance');"/>
            </div>
            <div class="slide">
				<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li>Volume Conversion</li>
				</ul><br/>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="metric_volume_input" name="metric_volume" value="" placeholder="Volume in Litres"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="imperial_volume" name="imperial_volume_answer" value="" placeholder="Oz equivalent" readonly="readonly"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="number" id="imperial_volume_input" name="imperial_volume" value="" placeholder="Volume in Oz"/>
               </div>
                    <div class="ui-block-b">
                <input data-role="none" style="padding:5%;margin:5%;width:80%" type="text" id="metric_volume" name="metric_volume_answer" value="" placeholder="Litre equivalent" readonly="readonly"/>
                    </div>
                </div>	<br/>			
                <input class="buttongroup" type="button" name="dsubmit" value="Convert" onClick="getConversionValues('volume');"/>
            </div>
        </div>
        <a href="#" class="prev"><img src="<?php echo IMAGE_RENDER_PATH;?>/arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="<?php echo IMAGE_RENDER_PATH;?>/arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>
    </div>
</div>