<script type="text/javascript">

function forgotsubmit()
{
    $.getJSON('ajax.php?module=forgot', $("#forgotform").serialize(),display);
}

function display(data)
{

    if(data == 'Success'){
        window.location = 'index.php?module=login';
    }else{
    $('#AjaxOutput').html(data);
    window.location.hash = '#message'; 
    $('.textinput').textinput();
    $('#AjaxLoading').html('');
    }
}
</script>

<br/>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>