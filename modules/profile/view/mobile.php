<script type="text/javascript">
$(document).ready(function () {
    var curr = new Date().getFullYear();
    var opt = {}
    opt.select = {preset : 'select'};
	opt.datetime = { preset : 'datetime', dateOrder: 'ddMMyy', timeWheels: '', dateFormat: 'dd-mm-yy', timeFormat: ''  };

    $('#DOB').scroller($.extend(opt['datetime'], { theme: 'default', mode: 'scroller', display: 'model' }));
    $('#system').scroller($.extend(opt['select'], { theme: 'default', mode: 'scroller', display: 'model' }));
});

function getSystem(val)
{
    if(val == 'Metric'){
        document.getElementById("heightlabel").innerHTML = 'Height(cm)';
        document.getElementById("height").value = '<?php echo $Display->Height();?>';
        document.getElementById("weightlabel").innerHTML = 'Weight(kg)';
        document.getElementById("weight").value = '<?php echo $Display->Weight();?>';
    }
    else if(val == 'Imperial'){
        document.getElementById("heightlabel").innerHTML = 'Height(inches)';
        document.getElementById("height").value = Math.ceil(<?php echo $Display->Height();?> * 0.39);
        document.getElementById("weightlabel").innerHTML = 'Weight(lbs)';
        document.getElementById("weight").value = Math.ceil(<?php echo $Display->Weight();?> * 2.22);     
    }
}
</script>

<?php echo $Display->Message;?>
<br/>

<?php echo $Display->Output();?>