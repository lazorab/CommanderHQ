<script type="text/javascript">

function getWOD(wodtype)
{    
	$('#AjaxLoading').html('<center><img alt="loading" src="/css/images/ajax-loader.gif" /><br />Loading...</center>');
	$.getJSON("ajax.php?module=wod",{wodtype:wodtype},display);	
	$.getJSON("ajax.php?module=wod",{selection:wodtype},topdisplay);	
}

function topdisplay(data)
{
	$('#topselection').html(data);
	$('#toplist').listview();
	$('#toplist').listview('refresh');
}

function display(data)
{
	$('#AjaxOutput').html(data);
	$('#listview').listview();
	$('#listview').listview('refresh');
	$("input").checkboxradio ();
	$("input").closest ("div:jqmData(role=controlgroup)").controlgroup ();
	$('#AjaxLoading').html('');
}
</script>
<br/>
<div id="topselection">
	<?php echo $Display->TopSelection();?>
</div>
<div id="AjaxOutput">
	<?php echo $Display->Output();?>
</div>