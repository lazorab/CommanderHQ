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
        $('#metric_height').html(metricheight.toFixed(2)); 
        $('#imperial_height').html(imperialheight.toFixed(2));
    }else if(cat == 'distance'){
        var metricdistance = document.getElementById("imperial_distance_input").value * 0.62;
        var imperialdistance = document.getElementById("metric_distance_input").value * 1.61;
        $('#metric_distance').html(metricdistance.toFixed(2)); 
        $('#imperial_distance').html(imperialdistance.toFixed(2));    
    }else if(cat == 'volume'){
        var metricvolume = document.getElementById("imperial_volume_input").value * 33.81;
        var imperialvolume = document.getElementById("metric_volume_input").value * 0.03;
        $('#metric_volume').html(metricvolume.toFixed(2)); 
        $('#imperial_volume').html(imperialvolume.toFixed(2));
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
                    <li>Weight</li>
                </ul> 
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="margin:10%;width:80%" type="number" id="metric_weight_input" name="metric_weight" value="" placeholder="Weight in kg"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="imperial_weight" name="metric_weight" value="" placeholder="lbs equivalent" disabled="disabled"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="imperial_weight_input" name="imperial_weight" value="" placeholder="Weight in lbs"/>
               </div>
                    <div class="ui-block-b">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="metric_weight" name="metric_weight" value="" placeholder="kg equivalent" disabled="disabled"/>
                    </div>
                </div>
                <input type="button" name="btnsubmit" value="Convert" onclick="getConversionValues('weight');"/> 
            </div>
            <div class="slide">
				<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li>Height</li>
				</ul>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="margin:10%;width:80%" type="number" id="metric_height_input" name="metric_height" value="" placeholder="Height in cm"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="imperial_height" name="metric_height" value="" placeholder="inch equivalent" disabled="disabled"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="imperial_height_input" name="imperial_height" value="" placeholder="Height in inches"/>
               </div>
                    <div class="ui-block-b">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="metric_height" name="metric_height" value="" placeholder="cm equivalent" disabled="disabled"/>
                    </div>
                </div>				
                <input type="button" name="btnsubmit" value="Convert" onclick="getConversionValues('height');"/>
            </div>
            <div class="slide">
				<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li>Distance</li>
				</ul>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="margin:10%;width:80%" type="number" id="metric_distance_input" name="metric_distance" value="" placeholder="Distance in km"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="imperial_distance" name="metric_distance" value="" placeholder="mile equivalent" disabled="disabled"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="imperial_distance_input" name="imperial_distance" value="" placeholder="Distance in miles"/>
               </div>
                    <div class="ui-block-b">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="metric_distance" name="metric_distance" value="" placeholder="km equivalent" disabled="disabled"/>
                    </div>
                </div>				
                <input type="button" name="btnsubmit" value="Convert" onclick="getConversionValues('distance');"/>
            </div>
            <div class="slide">
				<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
					<li>Volume</li>
				</ul>
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                    <input data-role="none" style="margin:10%;width:80%" type="number" id="metric_volume_input" name="metric_volume" value="" placeholder="Volume in Litres"/>
                    </div>
                    <div class="ui-block-b">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="imperial_volume" name="metric_volume" value="" placeholder="Oz equivalent" disabled="disabled"/>
                    </div>
                    <div class="ui-block-a">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="imperial_volume_input" name="imperial_volume" value="" placeholder="Volume in Oz"/>
               </div>
                    <div class="ui-block-b">
                <input data-role="none" style="margin:10%;width:80%" type="number" id="metric_volume" name="metric_volume" value="" placeholder="Litre equivalent" disabled="disabled"/>
                    </div>
                </div>				
                <input type="button" name="btnsubmit" value="Convert" onclick="getConversionValues('volume');"/>
            </div>
        </div>
        <a href="#" class="prev"><img src="images/arrow-next.png" width="36" height="36" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="images/arrow-prev.png" width="36" height="36" alt="Arrow Next"></a>
    </div>
</div>