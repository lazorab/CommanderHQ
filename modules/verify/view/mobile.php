<script type="text/javascript">

function verifysubmit()
{
    $.ajax({url:'ajax.php?module=verify&action=formsubmit',data:$("#verifyform").serialize(),dataType:"html",success:messagedisplay});    
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