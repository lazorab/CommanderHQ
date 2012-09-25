<script type="text/javascript">

function getWOD()
{    
        $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=wod\');" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
	$('#AjaxLoading').html('<center><img alt="loading" src="/css/images/ajax-loader.gif" /><br />Loading...</center>');
	$.getJSON("ajax.php?module=wod",{wod:'display'},display);	
	$.getJSON("ajax.php?module=wod",{topselection:'mygym'},topdisplay);	
}

function topdisplay(data)
{
    $('#toplist').html(data);
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
    <ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
        <li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage('?module=baseline&origin=wod&baseline=Baseline')"><div style="height:26px;width:1px;float:left"></div>Baseline</a></li>
        <li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage('?module=benchmark&origin=wod')"><div style="height:26px;width:1px;float:left"></div>Benchmarks</a></li>
	<li><a style="font-size:large;margin-top:10px" href="#" onclick="OpenThisPage('?module=custom&origin=wod')"><div style="height:26px;width:1px;float:left"></div>Custom</a></li>
	<li><a style="font-size:large;margin-top:10px" href="#" onclick="getWOD();"><div style="height:26px;width:1px;float:left"></div>My Gym</a></li>                
    </ul>
</div>
<div id="AjaxOutput">
	<?php echo $Display->Output();?>
</div>