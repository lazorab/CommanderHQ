<script type="text/javascript">

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