<script type="text/javascript">	

function getForm(cat)
{
    $.getJSON("ajax.php?module=converter",{topselection:cat},topselectiondisplay);
}

function getConversionValues(cat)
{
    var intRegex = /^\d+$/;
    var imperialvalue = 0;
    var metricvalue = 0;   
    if(cat == 'weight'){
        if($('#metric_weight_input').val() != ''){
            if(intRegex.test($('#metric_weight_input').val())){
                imperialvalue = $('#metric_weight_input').val() * 2.20;
                $('#imperial_weight').val(imperialvalue.toFixed(2) + 'lbs');
            }else{
                alert('Invalid Value!');
                return false;
            }
        }
        if($('#imperial_weight_input').val() != ''){
            if(intRegex.test($('#imperial_weight_input').val())){
                metricvalue = $('#imperial_weight_input').val() * 0.45;
                $('#metric_weight').val(metricvalue.toFixed(2) + 'kg'); 
            }else{
                alert('Invalid Value!');
                return false;
            }
        }
    }else if(cat == 'height'){
        if($('#metric_height_input').val() != ''){
            if(intRegex.test($('#metric_height_input').val())){
                imperialvalue = $('#metric_height_input').val() * 0.39;
                $('#imperial_height').val(imperialvalue.toFixed(2) + 'in');
            }else{
                alert('Invalid Value!');
                return false;
            }
        }
        if($('#imperial_height_input').val() != ''){
            if(intRegex.test($('#imperial_height_input').val())){
                metricvalue = $('#imperial_height_input').val() * 2.54;
                $('#metric_height').val(metricvalue.toFixed(2) + 'cm'); 
            }else{
                alert('Invalid Value!');
                return false;
            }
        }        
    }else if(cat == 'distance'){
        if($('#metric_distance_input').val() != ''){
            if(intRegex.test($('#metric_distance_input').val())){
                imperialvalue = $('#metric_distance_input').val() * 1.61;
                $('#imperial_distance').val(imperialvalue.toFixed(2) + 'm');
            }else{
                alert('Invalid Value!');
                return false;
            }
        }
        if($('#imperial_distance_input').val() != ''){
            if(intRegex.test($('#imperial_distance_input').val())){
                metricvalue = $('#imperial_distance_input').val() * 0.62;
                $('#metric_distance').val(metricvalue.toFixed(2) + 'km'); 
            }else{
                alert('Invalid Value!');
                return false;
            }
        }            
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