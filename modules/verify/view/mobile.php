<script type="text/javascript">

function verifysubmit()
{
    $.getJSON('ajax.php?module=signup&action=validateform', $("#verifyform").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    alert(message);
    if(message == 'Successfully Verified!')
        window.location = 'index.php?module=terms';
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