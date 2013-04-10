<script type="text/javascript">

function verifysubmit()
{
    $.ajax({url:'ajax.php?module=signup&action=formsubmit',data:$("#verifyform").serialize(),dataType:"html",success:messagedisplay});    
}

function messagedisplay(message)
{
    alert(message);   
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