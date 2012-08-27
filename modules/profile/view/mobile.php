<script type="text/javascript">

function getSystem(val)
{
    var thisheight = document.getElementById("height").value;
    var thisweight = document.getElementById("weight").value;
    
    if(val == 'Metric'){
        var newheight = thisheight * 2.54;
        var newweight = thisweight * 0.45;
        document.getElementById("heightlabel").innerHTML = 'Height(cm)';
        document.getElementById("height").value = newheight.toFixed(2);
        document.getElementById("weightlabel").innerHTML = 'Weight(kg)';
        document.getElementById("weight").value = newweight.toFixed(2);
    }
    else if(val == 'Imperial'){
        var newheight = thisheight * 0.39;
        var newweight = thisweight * 2.20;
        document.getElementById("heightlabel").innerHTML = 'Height(inches)';
        document.getElementById("height").value = newheight.toFixed(2);
        document.getElementById("weightlabel").innerHTML = 'Weight(lbs)';
        document.getElementById("weight").value = newweight.toFixed(2);     
    }
}

function profilesubmit()
{
    $.getJSON('ajax.php?module=profile', $("#profileform").serialize(),display);
}

function display(data)
{
    if(data == 'Success')
        window.location = 'index.php?module=memberhome';
    else{
    $('#AjaxOutput').html(data);
    window.location.hash = '#message';
    $('#listview').listview();
    $('#listview').listview('refresh');
    $('.controlbutton').button();
    $('.controlbutton').button('refresh');
    $('.buttongroup').button();
    $('.buttongroup').button('refresh'); 
    $('.radioinput').checkboxradio();
    $('.radioinput').checkboxradio('refresh');
    $('.textinput').textinput();
    $('#AjaxLoading').html('');
    }
}
</script>

<br/>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>