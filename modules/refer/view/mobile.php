<script type="text/javascript">

function refersubmit()
{
    $.getJSON('ajax.php?module=refer&action=validateform', $("#referform").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    alert(message);
    if(message == 'Friend Successfully Referred!'){
        $.getJSON('ajax.php?module=refer', {},display);
    }   
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('.buttongroup').button();
    $('.buttongroup').button('refresh');
    $('.textinput').textinput();
    $('#AjaxLoading').html('');
}
</script>

<br/>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>