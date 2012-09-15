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
        $('#metric_weight').val(metricweight.toFixed(2)); 
        $('#imperial_weight').val(imperialweight.toFixed(2));
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
                <input type="number" size="6" id="metric_weight_input" name="metric_weight" value="" placeholder="Metric Weight"/>kg =
                <input type="number" size="6" id="imperial_weight" name="metric_weight" value="" placeholder="Imperial Weight" disabled="disabled"/>lbs
                <input type="number" size="6" id="imperial_weight_input" name="imperial_weight" value="" placeholder="Imperial Weight"/>lbs =
                <input type="number" size="6" id="metric_weight" name="metric_weight" value="" placeholder="Metric Weight" disabled="disabled"/>kg
                <input type="button" name="btnsubmit" value="Convert" onclick="getConversionValues('weight');"/>
            </div>
            <div class="slide">
<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
    <li>Height</li>
</ul>
                <input type="number" size="10" id="metric_height_input" name="convert" value="" placeholder="Metric Height"/><div id="imperial_height"></div>
                <input type="number" size="10" id="imperial_height_input" name="convert" value="" placeholder="Imperial Height"/><div id="metric_height"></div>
                <input type="button" name="btnsubmit" value="Convert" onclick="getConversionValues('height');"/>
            </div>
            <div class="slide">
<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
    <li>Distance</li>
</ul>
                <input type="number" size="10" id="metric_distance_input" name="convert" value="" placeholder="Metric Distance"/><div id="imperial_distance"></div>
                <input type="number" size="10" id="imperial_distance_input" name="convert" value="" placeholder="Imperial Distance"/><div id="metric_distance"></div>
                <input type="button" name="btnsubmit" value="Convert" onclick="getConversionValues('distance');"/>
            </div>
            <div class="slide">
<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
    <li>Volume</li>
</ul>
                <input type="number" size="10" id="metric_volume_input" name="convert" value="" placeholder="Metric Volume"/><div id="imperial_volume"></div>
                <input type="number" size="10" id="imperial_volume_input" name="convert" value="" placeholder="Imperial Volume"/><div id="metric_volume"></div>
                <input type="button" name="btnsubmit" value="Convert" onclick="getConversionValues('volume');"/>
            </div>
        </div>
        <a href="#" class="prev"><img src="images/arrow-next.png" width="26" height="16" alt="Arrow Prev"></a>
        <a href="#" class="next"><img src="images/arrow-prev.png" width="26" height="16" alt="Arrow Next"></a>
    </div>
</div>