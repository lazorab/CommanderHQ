<script type="text/javascript">
function savedetails()
{
	if(document.form.gymname.value == '')
		alert('Gym Name Required');
	else if(document.form.url.value == '')
		alert('URL Required');	
	else{
		document.form.submit();
	}
}
function gymformsubmit()
{
    $.getJSON('ajax.php?module=registergym', $("#gymform").serialize(),display);
}

function display(data)
{
    if(data == 'Success'){
        window.location = 'index.php?module=wod&wodtype=2';
    }else{
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