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
    $('#toplist').listview();
    $('#toplist').listview('refresh');   
    $('#exercise').selectmenu();
    $('#exercise').selectmenu('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();	
}

function getConverter(val)
{
   $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=converter\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>'); 
   $.ajax({url:'ajax.php?module=converter',data:{converter:val},dataType:"html",success:display}); 
}

</script>


<div id="topselection">

</div> 

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>