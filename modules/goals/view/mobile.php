<script type="text/javascript">

function getContent(action)
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=goals\');" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
    $.getJSON("ajax.php?module=goals",{action:action},display);
    $.getJSON("ajax.php?module=goals",{topselection:action},topselectiondisplay);
}

function getActiveGoal(id)
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=goals\');" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
    $.getJSON("ajax.php?module=goals",{id:id},display);
    $.getJSON("ajax.php?module=goals",{topselection:'active'},topselectiondisplay);
}

function getGoal(id)
{
    $('#back').html('<img alt="Back" onclick="OpenThisPage(\'?module=goals\');" <?php echo $RENDER->NewImage('back.png', SCREENWIDTH);?> src="<?php echo ImagePath;?>back.png"/>');
    $.getJSON("ajax.php?module=goals",{id:id},display);
    $.getJSON("ajax.php?module=goals",{topselection:'history'},topselectiondisplay);
}

function getBenchmark(id)
{
    $.getJSON("ajax.php?module=goals",{benchmark:id},display);
}

function topselectiondisplay(data)
{
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
}

</script>
<br/>
<div id="topselection">
<ul id="toplist" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="d">
<?php echo $Display->TopSelection();?>
</ul>
</div>

<div id="AjaxOutput">
<?php echo $Display->Output();?>
</div>