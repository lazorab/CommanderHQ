<script type="text/javascript">

function gymformsubmit()
{  
    $.getJSON('ajax.php?module=registergym&action=validateform', $("#gymform").serialize(),messagedisplay);
}

function messagedisplay(message)
{
    if(message == 'Success'){
        window.location = 'index.php?module=memberhome&message=2';
    }else{
        alert(message);
        //$.getJSON('ajax.php?module=registergym', $("#profileform").serialize(),display);
    }
}

function display(data)
{
    $('#AjaxOutput').html(data);
    $('.select').selectmenu();
    $('.select').selectmenu('refresh');
    $('#AjaxLoading').html('');
}
</script>

<br/>

<div id="AjaxOutput">
    <?php echo $Display->Output();?>
</div>