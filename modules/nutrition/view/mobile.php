<script type="text/javascript">
function getContent(selection)
{    
    $('#AjaxLoading').html('<img <?php echo $RENDER->NewImage("ajax-loader.gif");?> src="/css/images/ajax-loader.gif" />');
        $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=nutrition\');" <?php echo $RENDER->NewImage('back.png');?> src="<?php echo IMAGE_RENDER_PATH;?>back.png"/>');
        $.ajax({url:'ajax.php?module=nutrition',data:{content:selection},dataType:"html",success:display});	
	$.getJSON("ajax.php?module=nutrition",{topselection:selection},topdisplay);	
}   
    
function goBack()
{
	$('#AjaxLoading').html('<img <?php echo $RENDER->NewImage("ajax-loader.gif");?> src="/css/images/ajax-loader.gif" />');
}    

function topdisplay(data)
{
    $('#toplist').listview();
    $('#toplist').html(data);
    $('#toplist').listview('refresh');
}
    
function display(data)
{
        $('#AjaxOutput').html(data);
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
</script>
<br/>

<div id="AjaxOutput">
<?php echo $Display->Output();?>
</div>